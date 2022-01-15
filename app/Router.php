<?php


namespace App;

use App\Controllers\Controller;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Controllers\UserController;
use App\Controllers\BookingController;

class Router
{
    public $loader;
    public $twig;
    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/Views');
        $this->twig = new Environment($this->loader);
    }
    public function route(string $uri)
    {


        $varsForView = [
            "loggedin" => isset($_SESSION["loggedin"]) ? $_SESSION["loggedin"] : false,
        ];
        $varsForView["logoHazelText"] = "HAZEL.co";


        if (preg_match('/api\/([A-Za-z]+)/', $uri, $apiRouteMatch)) {
            return $this->APIRoutes($uri);
        }

        $userController = new UserController();
        switch ($uri) {
            case '/':
                # code...
                $varsForView["navLinkActive"] = 'home';
                echo $this->twig->render('home.html.twig', $varsForView);
                break;

            case '/members':
                # code...
                $varsForView["navLinkActive"] = 'members';

                $users = $userController->getAllUsers();
                $varsForView["members"] = $users;
                echo $this->twig->render('members.html.twig', $varsForView);
                break;

            case preg_match('/members\/([A-Za-z]+)/', $uri, $regResult) ? true : false:

                $username = $regResult[1];
                $user = $userController->isUserExistsInDatabase($username);
                $varsForView["navLinkActive"] = 'members';
                if (!$user) {
                    echo "Cet utilisateur n'existe pas";
                    return;
                }

                $varsForView["user"] = $user;
                echo $this->twig->render('member.html.twig', $varsForView);
                break;

                /** ACCOUNT ROUTES */

            case '/login':
                # code...
                if (UserController::isUserLoggedIn()) {
                    # code...
                    Controller::Redirect("/");
                }

                $varsForView["navLinkActive"] = 'login';
                echo $this->twig->render('login.html.twig', $varsForView);
                break;

            case "/register":
                # code...
                if (UserController::isUserLoggedIn()) {
                    # code...
                    Controller::Redirect("/");
                }

                $varsForView["navLinkActive"] = 'register';
                echo $this->twig->render('register.html.twig', $varsForView);
                break;
            case '/logout':
                # code...
                UserController::handleLogout();
                break;

            default:
                # code...
                echo $uri;

                break;
        }
    }

    private function APIRoutes(string $uri)
    {
        switch ($uri) {
            case '/api/register':
                # code...
                if (isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["role"])) {
                    # code...
                    $userController = new UserController;

                    $userController->handleRegister($_POST);
                } else {
                    echo "Register Values NOT Valid";
                }

                break;
            case '/api/login':
                # code...
                if (isset($_POST["username"]) && isset($_POST["password"])) {
                    # code...
                    $userController = new UserController;

                    $userController->handleLogin($_POST);
                } else {
                    $_POST["username"] = "justezach";
                    $_POST["password"] = "justezach";
                    $userController = new UserController;

                    $userController->handleLogin($_POST);
                }
                break;
            case '/api/booking':
                if (isset($_POST["date"]) && isset($_POST["username"])) {
                    $bookingController = new BookingController();

                    $bookingInformations = array('loggedUser' => $_SESSION["auth"]["username"], 'bookedUser' => $_POST["username"], 'date' => $_POST["date"]);

                    $bookingController->handleBooking($bookingInformations);
                } else {
                    # code...
                    echo "La date n'est pas valide";
                }
                break;
            default:
                # code...
                echo "API ROUTE DOES NOT EXIST";
                break;
        }
        return;
    }
}
