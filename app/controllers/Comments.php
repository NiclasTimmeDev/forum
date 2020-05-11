<?php


class Comments extends Controller
{
    protected $model;
    protected $threadModel;
    protected $topicModel;

    public function index()
    {
        redirect("pages/dashboards");
    }

    public function __construct()
    {
        $this->model = $this->loadModel("Comment");
        $this->threadModel = $this->loadModel("Thread");
        $this->topicModel = $this->loadModel("Topic");
    }


    public function create($topic_id, $thread_id)
    {
        $data = [
            "topic_id" => $topic_id,
            "thread_id" => $thread_id,
            "comment_text" => "",
            "comment_err" => ""
        ];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("comments/create", $data);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data["comment_text"] = filter_var($_POST["comment_text"], FILTER_SANITIZE_STRING);


            if ($data["comment_text"] == "") {
                $data["comment_err"] = "Please enter a text";
            }

            //Check if topic exists
            if (!$this->topicModel->find_topic_by_id($topic_id)) {
                $data["comment_err"] = "Sorry, something went wrong. Try again later.";
            }

            //Check if thread exists
            if (!$this->threadModel->get_thread_by_topic_id_and_thread_id($topic_id, $thread_id)) {

            }

            if ($data["comment_err"] == "") {
                //TODO: Insert into database
                if ($this->model->create_comment($data["thread_id"], $_SESSION["user_id"], $data["comment_text"], $_SESSION["user_username"])) {
                    redirect("threads/single/" . $topic_id . "/" . $thread_id);
                } else {
                    $data["comment_err"] = "Sorry, something went wrong. Try again later.";
                    $this->loadView("comments/create", $data);
                }

            } else {
                $this->loadView("comments/create", $data);
            }

        }
        //TODO: reload thread
    }
}