<?php

/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 09.04.2017
 * Time: 19:15
 */
class Router
{
    private $path;
    private $class = "";
    private $classPath = "";

    public function __construct(string $path)
    {
        $this->path = $path;

        //Uppercase every word, and word that are after "_"
        $this->path = ucwords($this->path, "_");

        //Remove "_" from the string and replace with nothing
        $this->path = str_replace("_", "", $this->path);

        //Split the path by "/"
        $words = explode("/", $this->path);

        foreach ($words as $word) {
            $this->class .= $word;
        }

        //At the end, $this->class will be something like: OperatingSystemControlller
        $this->class .= "Controller";

        $this->classPath = $this->class . ".php";

        echo $this->class;

    }

}