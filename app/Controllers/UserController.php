<?php

namespace App\Controllers;


use App\Controllers\Controller;
use App\Models\UserModel;

class UserController extends Controller
{

    public function handleLogin(array $credentials)
    {
        if (!isset($credentials["username"]) || !isset($credentials["password"])) {
            # code...
            echo $this->jsonFailureReponse("No credentials provided");
            return;
        }

        $user = $this->isUserExistsInDatabase($credentials["username"]);


        if (empty($user)) {
            echo $this->jsonFailureReponse("No user found with provided email/username");
            return;
        }

        //Here you may check for the hash for the password
        if ($user["password"] === $credentials["password"]) {
            # code...
            unset($user['password']);

            $_SESSION["auth"] = $user;
            $_SESSION["loggedin"] = true;

            echo $this->jsonSuccessReponse($user);
        } else {
            echo $this->jsonFailureReponse("Incorrect password");
            return;
        }
    }

    public function handleRegister(array $credentials)
    {
        if (!isset($credentials["email"]) || !isset($credentials["username"]) || !isset($credentials["password"]) || !isset($credentials["name"]) || !isset($credentials["role"])) {
            # code...
            echo $this->jsonFailureReponse("Une ou plusieurs des informations de connection n'ont pas été fournis");
            return;
        }


        $userByUsername = $this->isUserExistsInDatabase($credentials["username"]);

        if ($userByUsername) {
            echo $this->jsonFailureReponse("Le nom d'utilisateur existe déjà dans la base de donnée");
            return;
        }

        $userByEmail = $this->isUserExistsInDatabase($credentials["email"]);

        if ($userByEmail) {
            echo $this->jsonFailureReponse("Le mail existe déjà dans la base de donnée");
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->createUser($credentials);

        unset($user['password']);

        $_SESSION["auth"] = $user;
        $_SESSION["loggedin"] = true;

        echo $this->jsonSuccessReponse($user);

        /**
         * Verify if all values are normalized
         */
    }

    public function isUserExistsInDatabase($username)
    {
        $userModel = new UserModel();

        //If the username is a mail
        if (preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $username)) {
            # code...
            return $userModel->findOneByEmail($username);
        }

        return $userModel->findOneByUsername($username);
    }

    static function handleLogout()
    {
        unset($_SESSION["auth"]);
        unset($_SESSION["loggedin"]);

        Controller::Redirect("/login");
    }

    public function getAllUsers()
    {
        $userModel = new UserModel();
        return $userModel-> find();

    }

    static function isUserLoggedin()
    {
        return isset($_SESSION["loggedin"]) ? $_SESSION["loggedin"] : false;
    }

    static function getCurrentUser()
    {
        return UserController::isUserLoggedin() ? $_SESSION["auth"] : null;
    }
}
