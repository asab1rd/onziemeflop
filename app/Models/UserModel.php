<?php

namespace App\Models;

use App\Models\Model;
use PDOException;
use PDO;

class UserModel extends Model
{

    public function __construct()
    {
        parent::__construct("user");
    }

    public function loginByEmail($credentials)
    {
    }

    public function findOneByUsername(string $username)
    {
        if (!$this->tableName || !$username) {
            return false;
        }

        $sql = "SELECT * from $this->tableName
        where username = :username";

        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(":username", $username, PDO::PARAM_STR);

            $statement->execute();
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function findOneByEmail(string $email)
    {
        if (!$this->tableName || !$email) {
            return false;
        }


        $sql = "SELECT * from $this->tableName
        where email = :email";

        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);

            $statement->execute();
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createUser(array $user)
    {
        if (!$this->tableName || !$user) {
            return false;
        }

        $sql = "INSERT INTO $this->tableName (username,password,name,role,email)
        VALUES ( :username,:password,:name,:role,:email)";



        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(":email", $user["email"], PDO::PARAM_STR);
            $statement->bindParam(":password", $user["password"], PDO::PARAM_STR);
            $statement->bindParam(":name", $user["name"], PDO::PARAM_STR);
            $statement->bindParam(":role", $user["role"], PDO::PARAM_STR);
            $statement->bindParam(":username", $user["username"], PDO::PARAM_STR);

            $statement->execute();

            return $this->findOneByUsername($user["username"]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
