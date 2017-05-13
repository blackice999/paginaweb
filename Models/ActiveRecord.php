<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.05.2017
 * Time: 13:46
 */

namespace Models;


abstract class ActiveRecord
{

    private $data = [];

    /**
     * This will be called when we return a new self instance with the result from loadById
     * @param array $data
     */
    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Dynamically get object properties  based on the name sent,
     * for example UserModel->id will return the id
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

}