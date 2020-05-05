<?php
//enable strict mode. Thus, failing on type declaration will throw an error:
declare(strict_types=1);


//load config file which stores global variables
require_once("config/config.php");

//load helper files
require_once("helpers/url_helper.php");
require_once("helpers/session_helper.php");

spl_autoload_register(function ($className) {
    $filepath = "../app/libs/" . $className . ".php";
    if (!file_exists($filepath)) {
        echo $className . ".php not found";
        return false;
    } else {
        require_once($filepath);
    }
});