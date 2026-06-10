<?php

require_once(__DIR__ . '/db.php');

class ProfileModel
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT id, last_name, first_name, email
             FROM Users
             WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        return $user;
    }
}
