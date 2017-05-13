<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.05.2017
 * Time: 17:50
 */

namespace Controllers;


use Utils\HTMLGenerator;

class LogOutController implements Controller
{

    public function get()
    {
        ob_start();
        session_destroy();
        HTMLGenerator::row(5, 5, 5);
        HTMLGenerator::tag("p", "Logged out, redirecting to home page in 5 seconds");
        HTMLGenerator::closeRow();

        //Wait 5 seconds then redirect to home page
        header("Refresh: 5; URL=index");
        die();
    }

    public function post()
    {

    }
}