<?php

require_once "config/Database.php";
require_once "api/TaskApi/Router.php";
require_once "api/TaskApi/Task.php";


// Initialize database
$db = new Database();
// Database connection
$connection = $db->getDbConnection();
// Create task object
$task = new Task($connection);
// Create router object
$router = new Router($task);
// Checking HTTP requests
$router->checkHttpRequests();



// Close connection
$connection->close();


?>