<?php


class Dashboards extends Controller
{
    protected $data = [];

    public function __construct()
    {
        //load topic model in order to fetch info in subscribed topics of the user when he/she logs in
        require_once("../app/models/Topic.php");
        $this->topic_model = new Topic();
    }

    public function index()
    {

        $data["subscribed_topics"] = $this->topic_model->findAllSubscriptionsByUserId($_SESSION["user_id"]);
        $this->loadView("pages/dashboards", $data);
    }
}