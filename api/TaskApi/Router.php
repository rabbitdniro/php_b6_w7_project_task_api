<?php

namespace Api\TaskApi;

class Router {
    private $task;

    public function __construct($task) {
        $this->task = $task;
    }

    // Check and route HTTP requests
    public function checkHttpRequests() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = isset($_GET['id']) ? intval($_GET['id']) : null;

        switch($method) {
            case "GET" :
                $this->handleGetRequest($path);
                break;
            case "POST" :
                $this->handlePostRequest();
                break;
            case "PUT" :
                $this->handlePutRequest($path);
                break;
            case "DELETE" :
                $this->handleDeleteRequest($path);
                break;
            default :
                http_response_code(405);
                echo json_encode(["error" => "Method not allowed."]);
        }
    }

    // Handle GET request
    private function handleGetRequest($id) {
        if ($id) {
            // Single task by ID using GET request
            $task = $this->task->getSingleTask($id);

            if ($task) {
                http_response_code(200);
                echo json_encode($task);
            }else {
                http_response_code(404);
                echo json_encode(["error" => "Task not found."]);
            }
        }else {
            // All tasks using GET request
            $tasks = $this->task->getAllTasks();
            //print_r($tasks);
            if (!empty($tasks)) {
                http_response_code(200);
                echo json_encode($tasks);
            }else {
                http_response_code(404);
                echo json_encode(["error" => "Task not found."]);
            }
        }
    }

    // Handle POST request
    private function handlePostRequest() {
        $data = json_decode(file_get_contents("php://input"), true);
        //print_r($data);
        // Validate data
        if (!isset($data['title']) || trim($data['title']) === "") {
            http_response_code(400);
            echo json_encode(["error" => "Title cannot be empty."]);
            return;
        }

        // Validate priority
        $priorities = ["low", "medium", "high"];
        if (isset($data['priority']) && !in_array($data['priority'], $priorities)) {
            http_response_code(404);
            echo json_encode(["error" => "Valid priorities: low, medium, high"]);
            return;
        }

        // Add task
        $response = $this->task->createTask($data);
        http_response_code(200);
        echo json_encode($response);
    }

    // Handle PUT request
    private function handlePutRequest($id) {
        if(!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Task ID required."]);
        }

        $data = json_decode(file_get_contents("php://input"), true);
        // Update task
        $response = $this->task->updateTask($id, $data);
        http_response_code(200);
        echo json_encode($response);
    }

    // Handle DELETE request
    private function handleDeleteRequest($id) {
        if(!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Task ID required."]);
        }

        // Delete task
        $response = $this->task->deleteTask($id);
        http_response_code(200);
        echo json_encode($response);
    }
}



?>