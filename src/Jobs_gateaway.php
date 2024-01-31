<?php
class Jobs_gateaway
{
    private $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->connect();
    }

    public function create($user_id)
    {
        $sql = 'INSERT INTO  jobs (user_id , author , title , body) VALUES ( :user_id , :author , :title , :body)';
    }
}
