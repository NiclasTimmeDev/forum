<?php

class Threads extends Controller
{
    protected $model;


    protected $data = array(
        "topic_id" => "",
        "thread_name" => "",
        "thread_description" => "",
        "thread_name_err" => "",
        "thread_description_err" => ""
    );

    public function __construct()
    {
        $this->model = $this->loadModel("Thread");
    }

    public function index()
    {
        redirect("threads/all");
    }



    public function create($topic_id)
    {
        $this->data["topic_id"] = $topic_id;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("threads/create", $this->data);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Sanitize inputs
            $this->data["thread_name"] = filter_var($_POST["thread_name"], FILTER_SANITIZE_STRING);
            $this->data["thread_description"] = filter_var($_POST{
                "thread_description"}, FILTER_SANITIZE_STRING);

            //check validity
            if ($this->data["thread_name"] == "") {
                $this->data["thread_name_err"] = "Please enter a name";
            }

            //Check if thread name is already taken
            if ($this->model->findThreadNameByTopicId($this->data["thread_name"], $this->data["topic_id"])) {
                $this->data["thread_name_err"] = "Sorry, this name is already taken";
            }

            if ($this->data["thread_description"] == "") {
                $this->data["thread_description_err"] = "Please enter a description";
            }

            if (strlen($this->data["thread_description"]) > 255) {
                $this->data["thread_description_err"] = "Please don't enter more than 255 characters.";
            }

            if ($this->data["thread_name_err"] == "" && $this->data["thread_desctiption_err"] == "") {

                if ($this->model->create_thread($this->data["thread_name"], $this->data["thread_description"], $this->data["topic_id"], $_SESSION["user_id"])) {
                    redirect("topics/single/" . $this->data["topic_id"]);
                } else {
                    $this->data["thread_name_err"] = "Sorry, something went wrong";
                    $this->data["thread_description_err"] = "Sorry, something went wrong";

                    redirect("topics/single/" . $this->data["topic_id"]);
                }
            } else {
                $this->loadView("threads/create", $this->data);
            }

            //TODO: Send error message or call method from model that saves new thread to DB

        }
    }

    //===============================
    /* Show a single thread */
    //===============================
    public function single($topic_id, $thread_id)
    {
        $data = [];
        $data["thread"] = $this->model->get_thread_by_topic_id_and_thread_id($topic_id, $thread_id);
        $this->loadView("threads/single", $data);
    }
}