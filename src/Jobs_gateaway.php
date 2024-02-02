<?php
class Jobs_gateaway
{
    private $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->connect();
    }

    public function create($job, $user_id)
    {
        $sql = 'INSERT INTO  jobs (user_id , client , title ,technologies , description , experience , price) VALUES (  ? , ? , ? , ? , ?, ?, ?) ';

        $mysqli = $this->conn;
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("isssssi", $user_id, $job["client"], $job["title"], $job["technologies"], $job["description"], $job["experience"], $job["price"]);
        $stmt->execute();
    }
}
