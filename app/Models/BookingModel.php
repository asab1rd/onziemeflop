<?php

namespace App\Models;

use App\Models\Model;
use PDOException;
use PDO;
use DateTime;

class BookingModel extends Model
{
    public function __construct()
    {
        parent::__construct("appointments");
    }

    public function bookAppointment(array $appointmentInformations)
    {
        if (!$this->tableName || !$appointmentInformations) {

            return false;
        }

        $sql = "INSERT INTO $this->tableName (clientId,freelanceId,date)
        VALUES(:clientId,:freelanceId,:date)";
        $idLoggedUser = $this->getIdUser($appointmentInformations["loggedUser"]);
        $idBookedUser = $this->getIdUser($appointmentInformations["bookedUser"]);
        $date = $appointmentInformations["date"];

        try {
            //code...
            $statement = $this->db->prepare($sql);
            $statement->bindParam(":clientId", $idLoggedUser["id"]);
            $statement->bindParam(":freelanceId", $idBookedUser["id"]);
            $statement->bindParam(":date", $date);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function getIdUser($username)
    {
        if (!$username) {
            return false;
        }
        $sql = "SELECT id from user where username = :username";
        try {
            //code...
            $statement = $this->db->prepare($sql);
            $statement->bindParam(":username", $username);
            $statement->execute();
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
