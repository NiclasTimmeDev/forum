<?php


class Pages extends Controller
{
    public function index()
    {
        $this->loadView("pages/index");
    }

    public function about()
    {
        $this->loadView("pages/about");
    }

    public function dashboards()
    {
        $this->loadView("pages/dashboard");
    }
}