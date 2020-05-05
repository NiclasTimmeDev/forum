<?php
session_start();

/*
 * Used to display a success alert box when a user is newly registered and then redirected to the dashboard
 */
function alert_session_start($sessionName)
{
    if (!isset($_SESSION[$sessionName])) {
        $_SESSION[$sessionName] = true;
    }
}

function alert_session_end($sessionName)
{
    if (isset($_SESSION[$sessionName])) {
        unset($_SESSION[$sessionName]);
    }
}