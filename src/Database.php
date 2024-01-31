<?php
class Database
{
    public function __construct(private $host, private $user, private $password, private $dbname)
    {
    }

    public function connect()
    {
        return new mysqli($this->host, $this->user, $this->password, $this->dbname);
    }
}
