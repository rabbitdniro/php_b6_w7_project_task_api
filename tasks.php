<?php

use Api\TaskApi\Task;
use Api\TaskApi\Router;
use Config\Database;

require_once "./vendor/autoload.php";

header("content-type: application/json");

// Initialize database
$db = new Database();
// Database connection
$connection = $db->getConnection();
// Create task object
$task = new Task($connection);
// Create router object
$router = new Router($task);
// Checking HTTP requests
$router->checkHttpRequests();



// Close connection
$connection->close();


?>