<?php


class Users extends Controller
{
    protected $userModel;

    protected $topic_model;

    public function __construct()
    {
        //instantiate new User Object from User Class:
        //loadModel() comes from the Controller Class, which this class extends
        $this->userModel = $this->loadModel("User");
    }

    //========================
    /*Login for users
    
    */
    //========================
    public function login()
    {
        $data = array(
            "email" => "",
            "password" => "",
            "email_err" => "",
            "password_err" => "",
        );

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("users/login", $data);
        } elseif (($_SERVER["REQUEST_METHOD"] == "POST")) {

            //delete unwanted stuff from $_POST:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //set relevant fields of $data to the incoming Post data:
            $data["email"] = $_POST["email"];
            $data["password"] = $_POST["password"];


            if (filter_var($data["email"], FILTER_VALIDATE_EMAIL) && !empty($data["password"])) {
                $data["email_err"] = "";
                $data["password_err"] = "";

                $user = $this->userModel->findUserByEmail($data["email"]);


                if (password_verify($data["password"], $user->password)) {
                    $this->createUserSession($user);
                    redirect("dashboards");
                } else {
                    $data["email_err"] = "Please check your credentials";
                    $data["password_err"] = "Please check your credentials";
                    $this->loadView("users/login", $data);
                }
            } else {
                $data["email_err"] = "Please check your credentials";
                $data["password_err"] = "Please check your credentials";
                $this->loadView("users/login", $data);
            }
        }
    }

    public function register()
    {
        $data = array(
            "name" => "",
            "email" => "",
            "password" => "",
            "confirm_password" => "",
            "name_err" => "",
            "email_err" => "",
            "password_err" => "",
            "confirm_password_err" => "",
        );
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("users/register", $data);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

            //delete unwanted stuff from $_POST:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //set $data to user input:
            $data["name"] = $_POST["name"];
            $data["email"] = $_POST["email"];
            $data["password"] = $_POST["password"];
            $data["confirm_password"] = $_POST["confirm_password"];

            if (empty($data["name"])) {
                $data["name_err"] = "Please enter a name";
            }

            if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                $data["email_err"] = "Please enter a valid E-Mail-Address";
            }

            //validate password password:
            switch ($data["password"]) {
                case "":
                    $data["password_err"] = "Please enter a password";
                    break;
                case "123456":
                    $data["password_err"] = "Your password may not contain '123456'";
                    break;
                case "password":
                    $data["password_err"] = "Your password may not contain 'password'";
                    break;
                default:
                    $data["password_err"] = "";
            }

            //validate confirmation password:
            if ($data["password"] != $data["confirm_password"]) {
                $data["confirm_password_err"] = "Passwords must match";
            }

            //check if email is already taken:
            if ($this->userModel->findUserByEmail($data["email"])) {
                $data["email_err"] = "Sorry, this E-Mail-Address is already taken";
            }

            //proceed only if error messages are empty
            if ($data["name_err"] == "" && $data["password_err"] == "" && $data["confirm_password_err"] == "" && $data["email_err"] == "") {

                if ($this->userModel->registerUser($data["name"], $data["email"], $data["password"])) {
                    alert_session_start("newly_registered");

                    //fetch newly create user from database in order to also get his id. Then store it in the session variable
                    $user = $this->userModel->findUserByEmail($data["email"]);
                    $this->createUserSession($user);

                    redirect("pages/dashboards");
                } else {
                    $data["name_err"] = "Please enter a name";
                    $this->loadView("users/register", $data);
                }
            } else {
                $this->loadView("users/register", $data);
            }
        }
    }

    //store user info in session so it can be accessed later after login / registration
    public function createUserSession($user)
    {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["user_username"] = $user->username;
        $_SESSION["user_mail"] = $user->email;
    }

    //unset all user-related session variables
    public function logout()
    {
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_username"]);
        unset($_SESSION["user_mail"]);
        session_destroy();
        redirect("pages/index");
    }
}