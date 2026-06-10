<?php

require_once(__DIR__ . '/db.php');

class RegisterModel
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function emailExists($email)
    {
        $stmt = $this->db->prepare("
            SELECT id
            FROM Users
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;

        $stmt->close();

        return $exists;
    }

    public function createUser(string $lastName, string $firstName, string $email, string $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
            INSERT INTO Users
            (last_name, first_name, email, password)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssss",
            $lastName,
            $firstName,
            $email,
            $hash
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }
}
