<?php


class Topics extends Controller
{
    protected $model;

    protected $data = array(
        "topic_name" => "",
        "topic_description" => "",
        "topic_name_err" => "",
        "topic_description_err" => ""
    );

    public function __construct()
    {
        $this->model = $this->loadModel("Topic");
    }

    //===========================
    /*create a new topic
    1. If request method is get, load view
    2. If request method is post, start process of creating a topic
    3. Delete all stuff from $_POST that should not be there and set $data to $_POST
    4. Validate user inputs. If they are not valid, fill respective error message in $data
    5. Proceed only if validation did not lead to the error messages being filled
    6. Call createTopic function from Topic Model, which stores the values in the DB
    7. If 6. returns true, call a method from the topic model that fetches all topics that a user is subscribed to
    8. Load the dashboard view and pass the data from 7.
    9. If anything goes wrong along the way from 5.-8. reload view and display error message to the user
    */
    //===========================
    public function createTopic()
    {

        //1:
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("topics/create-topic", $this->data);
        }

        //2:
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //3:
            $_POST["topic_name"] = filter_var($_POST["topic_name"], FILTER_SANITIZE_STRING);
            $_POST["topic_description"] = filter_var($_POST["topic_description"], FILTER_SANITIZE_STRING);
            $this->data = array(
                "topic_name" => $_POST["topic_name"],
                "topic_description" => $_POST["topic_description"],
                "topic_name_err" => "",
                "topic_description_err" => ""
            );

            //4:

            //topic name
            if ($this->data["topic_name"] == "") {
                $this->data["topic_name_err"] = "Please enter a name";
            }

            //Check if topic name is already used
            //method comes from the Topic model, which is instantiated in the constructor method
            if ($this->model->findTopicByName($this->data["topic_name"])) {
                $this->data["topic_name_err"] = "Sorry, this name is already taken";
            }

            //validate length of topic description
            if (strlen($this->data["topic_description"]) > 255) {
                $this->data["topic_description_err"] = "Please enter not less than 255 characters";
            }

            //validate that description isn't empty
            if ($this->data["topic_description"] == "") {
                $this->data["topic_description_err"] = "Please enter a description";
            }

            //5:
            if ($this->data["topic_description_err"] == "" && $this->data["topic_name_err"] == "") {

                //6:
                if ($this->model->createTopic($this->data["topic_name"], $this->data["topic_description"], $_SESSION["user_id"])) {

                    //7:
                    $data["subscribed_topics"] = $this->model->findAllSubscriptionsByUserId($_SESSION["user_id"]);

                    //8:
                    $this->loadView("pages/dashboards", $data);
                } else {
                    $this->data["topic_name_err"] = "Sorry, something went wrong. Try again later.";
                    $this->data["topic_description_err"] = "Sorry, something went wrong. Try again later.";
                    $this->loadView("topics/create-topic", $this->data);
                }
            } else {
                //9:
                $this->data["topic_name_err"] = "Sorry, something went wrong";
                $this->data["topic_description_err"] = "Sorry, something went wrong";
                $this->loadView("topics/create-topic", $this->data);
            }
        }
    }

    //=============================
    /* fetch a single topic from the DB by id
    1. create $data variable
    2. call method from model that fetches a single topic
    3. put the relevant data from the fetch into $data
    4. call method from model that counts the number of subsriptions to that topic
    5. Put subscription info into $data    
    6. Load the single view and send $data
    */
    //=============================
    public function single($topic_id, $errorCode = 0)
    {
        //1:
        $data = [
            "error-code" => $errorCode
        ];

        //2:
        $topic = $this->model->find_topic_by_id($topic_id);

        //3:
        $data["topic_id"] = $topic->id;
        $data["topic_name"] = $topic->name;
        $data["topic_description"] = $topic->description;

        $data["user_is_subscribed"] = $this->model->findOeSubscriptionsByUserId($_SESSION["user_id"], $data["topic_id"]);

        //4:
        $subscribers_count = $this->model->find_subscriber_number_by_id($topic_id);

        //5.
        $data["subscribers_count"] = $subscribers_count;

        //6:
        $this->loadView("topics/single", $data);
    }

    //================================
    /* Get all topics from database */
    //================================
    public function all()
    {
        $data = $this->model->find_all_topics();

        $this->loadView("topics/all", $data);
    }

    //===========================
    /*Subscribe user to topic */
    //===========================
    public function subscribe()
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if ($this->model->findOeSubscriptionsByUserId($_SESSION["user_id"], $_POST["topic_id"])) {

                //error code 1
                redirect("topics/single/" . $_POST["topic_id"] . "/1");
            } else {
                if ($this->model->subscribe($_SESSION["user_id"], $_POST["topic_id"])) {
                    //error code 3 (stands for success)
                    redirect("topics/single/" . $_POST["topic_id"] . "/3");
                } else {
                    //error code 2
                    redirect("topics/single/" . $_POST["topic_id"] . "/2");
                }
            }
        } else {
            redirect("pages/dashboards");
        }
    }
}