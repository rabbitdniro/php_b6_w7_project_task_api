<?php

namespace Config;

use mysqli;

class Database
{

    private $host = "localhost";
    private $db = "task_api";
    private $user = "root";
    private $password = "";
    private $conn;


    public function __construct()
    {

        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db);
        //print_r(($this->conn));
        if ($this->conn->connect_error) {

            die(json_encode(

                [

                    "error" => "Connection failed"

                ]

            ));

        }

    }



    public function getConnection()
    {

        return $this->conn;

    }



}




