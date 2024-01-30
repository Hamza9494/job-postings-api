<?php 
 
spl_autoload_register(function($class) {
    require __DIR__ . "/src/$class.php";
});

$url = $_SERVER["REQUEST_URI"];
$parts = explode("/" , $url);

if($parts[3] !== "jobs.php") {
 die("nothing for u here my dude");
}

 
$id = $parts[4] ?? null;

$process = new Process_requests();

$process->process_all_request($id);

try {
    $mysqli =  new Database("localhost" , "root" , "job_postings" , "");
} catch (Exception $e) {
    echo $e->getMessage();
}


 ?>