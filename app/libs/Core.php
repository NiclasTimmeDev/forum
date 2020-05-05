<?php
/*
 * Manages URL redirections
 * According to the url parameters, the Core Class loads the corresponding model & controller
 * These will then handle all necessary db interactions and views
 * */

/*
=============
FUNCTIONALITY
=============
1. extract url parameters
2. create array from url, divided by "/"
3. Load the controller according to the first entry in array
4. If there is a second property given, call the corresponding function in that array
 * */

class Core
{
    protected $currentController = "Pages"; //controller that is currently active. Will be equal to first URL parameter. Defaults to pages
    protected $currentMethod = "index"; //the currently active method in the controller. Will be the second parameter in URL, if given. Defaults to index
    protected $params = []; //all other url parameters

    public function __construct()
    {
        //get url parameters
        $url = $this->getURL();

        //if given, set $currentController to first param in $url. Then unset it.
        if (isset($url[0]) && file_exists("../app/controllers/" .
                ucwords($url[0]) . ".php")) {
            $this->currentController = $url[0];
            unset($url[0]);
        }

        require_once("../app/controllers/" . $this->currentController . ".php");

        $this->currentController = new $this->currentController();

        if (isset($url[1]) && method_exists($this->currentController, $url[1])) {
            $this->currentMethod = $url[1];
            unset($url[1]);
        }

        $url ? $this->params = $url : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }

    private function getURL()
    {

        if (isset($_GET["url"])) {
            $url = rtrim($_GET["url"], "/"); //get everything after the 1. "/"
            $url = filter_var($url, FILTER_SANITIZE_URL); //remove characters that should not be in a URL
            $url = explode("/", $url); //create associative array that is divided by "/"
            return $url;
        }
    }
}