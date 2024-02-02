<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require __DIR__ . "/vendor/autoload.php";

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

$url = $_SERVER["REQUEST_URI"];
$parts = explode("/", $url);

if ($parts[3] !== "jobs.php") {
    die("nothing for u here my dude");
}


$id = $parts[4] ?? null;


$headers = getallheaders();

$token = explode("Bearer ", $headers["Authorization"]);

$token = $token[1];


$decoded_token = JWT::decode($token, new Key("mykey2014", "HS256"));

$decoded_token = (array) $decoded_token;

$user_email = $decoded_token["user_email"];


if ($user_email) {
    try {

        $database = new Database("localhost", "root", "", "job_postings");
        $mysqli = $database->connect();
        $sql = "SELECT * from users WHERE email = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        //class objects
        $gateaway = new Jobs_gateaway($database);
        $controller = new Process_requests($gateaway, $user["id"]);
        $controller->process_all_request($_SERVER["REQUEST_METHOD"], $user["id"]);
    } catch (Exception $e) {
        echo $e->getMessage();
    };
}
