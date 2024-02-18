<?php
class Database {
    private $db;

    public function __construct() {
        $this->db = new PDO('sqlite:/path/to/database.db');
    }

    public function getDb() {
        return $this->db;
    }
}
