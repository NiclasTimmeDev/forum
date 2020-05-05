<?php


class Topics extends Controller
{
    protected $userModel;

    protected $data = array(
        "topic_name" => "",
        "topic_description" => "",
        "topic_name_err" => "",
        "topic_description_err" => ""
    );

    public function __construct()
    {
        //TODO: load Topics Model
        $this->userModel = $this->loadModel("Topic");
    }

    public function createTopic()
    {

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("topics/create-topic", $this->data);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //sanitize user inputs
            $_POST["topic_name"] = filter_var($_POST["topic_name"], FILTER_SANITIZE_STRING);
            $_POST["topic_description"] = filter_var($_POST["topic_description"], FILTER_SANITIZE_STRING);

            $this->data = array(
                "topic_name" => $_POST["topic_name"],
                "topic_description" => $_POST["topic_description"],
                "topic_name_err" => "",
                "topic_description_err" => ""
            );

            //validate topic name
            if ($this->data["topic_name"] == "") {
                $this->data["topic_name_err"] = "Please enter a name";
            }

            //Check if topic name already exists
            //method comes from the Topic model, which is instantiated in the constructor method
            if ($this->userModel->findTopicByName($this->data["topic_name"])) {
                $this->data["topic_name_err"] = "Sorry, this name is already taken";
            }

            //verify that description is not longer than 255 characters
            if (strlen($this->data["topic_description"]) > 255) {
                $this->data["topic_description_err"] = "Please enter not less than 255 characters";
            }

            //check if description is given
            if ($this->data["topic_description"] == "") {
                $this->data["topic_description_err"] = "Please enter a description";
            }


            if ($this->data["topic_description_err"] == "" && $this->data["topic_name_err"] == "") {
                if ($this->userModel->createTopic($this->data["topic_name"], $this->data["topic_description"], $_SESSION["user_id"])) {
                    redirect("pages/dashboards");
                } else {
                    $this->data["topic_name_err"] = "Sorry, something went wrong. Try again later.";
                    $this->data["topic_description_err"] = "Sorry, something went wrong. Try again later.";
                    $this->loadView("topics/create-topic", $this->data);
                }
            } else {

                $this->loadView("topics/create-topic", $this->data);
            }
        }
    }
}