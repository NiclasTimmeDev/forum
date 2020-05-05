<?php

//redirect to view:
function redirect($page)
{
    header("location:" . URLROOT . "/" . $page);
}