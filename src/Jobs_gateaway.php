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
        return $this->conn->insert_id;
    }

    public function get_all($user_id,  $client, $type = "client")
    {
        $jobs = "";

        if ($type === "freelancer") {
            $sql = "SELECT * FROM jobs";
            $mysqli = $this->conn;
            $result = $mysqli->query($sql);
            $jobs = [$result->fetch_all(MYSQLI_ASSOC)];
        } else {
            $sql = "SELECT * from jobs WHERE client = ?";
            $mysqli = $this->conn;
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $client);
            $stmt->execute();
            $result = $stmt->get_result();
            $jobs = [$result->fetch_all(MYSQLI_ASSOC)];
        }

        return $jobs;
    }


    public function get($id)
    {
        $sql = "SELECT * FROM jobs WHERE id = ?";
        $mysqli = $this->conn;
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $job = $result->fetch_assoc();
        return $job;
    }

    public function delete($id)
    {
        $sql = "DELETE from jobs WHERE id = ?";
        $mysqli = $this->conn;
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->execute()) {
            return $mysqli->affected_rows;
        }
    }

    public function update($old_job, $new_job, $id)
    {
        $client = $new_job["client"] ?? $old_job["client"];
        $title = $new_job["title"] ?? $old_job["title"];
        $description = $new_job["description"] ?? $old_job["description"];
        $technologies = $new_job["technologies"] ?? $old_job["technologies"];
        $experience = $new_job["experience"] ?? $old_job["experience"];
        $price = $new_job["price"] ?? $old_job["price"];

        $sql = "UPDATE jobs SET client = ?  , title = ? , description = ? , technologies = ? , experience = ? , price = ? WHERE id = ?";
        $mysqli = $this->conn;
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssssii", $client, $title, $description, $technologies, $experience, $price, $id);
        $stmt->execute();
        return $mysqli->affected_rows;
    }
}
