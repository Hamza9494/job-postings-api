<?php
echo "hello world from test.php";

$job = json_decode(file_get_contents("php://input"), true);
var_dump($job);
