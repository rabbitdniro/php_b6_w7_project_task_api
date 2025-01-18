<?php


class Task {
     private $connection;

    // Creating database connection
     public function __construct($dbConnection) {
        $this->connection = $dbConnection;
     }

    // Get all tasks
    public function getAllTasks() {
        $sql = "SELECT * FROM tasks";
        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get a single task by ID
    public function getSingleTask($id) {
        $id = intval($id);
        $sql = "SELECT * FROM tasks WHERE id = $id";
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    // Create  a task
    public function createTask($data) {
        $title = $data['title'];
        $description = $data['description'] ?? "";
        $priority = $data['priority'] ?? "low";

        $sql = "INSERT INTO tasks (title, description, priority) VALUES ('$title', '$description', '$priority')";

        if ($this->connection->query($sql)) {
            return json_encode(["message" => "Task added successfully."]);
        }

        return json_encode(["error" => "Failed to add your task."]);
    }

    // Update a task
    public function updateTask($id, $data) {
        $id = intval($id);
        $result = $this->connection->query("SELECT * FROM tasks WHERE id = $id");

        if ($result->num_rows === 0) {
            http_response_code(404);
            return ["error" => "Task ID not found"];
        }

        $originalTask = $result->fetch_assoc();

        $title = isset($data['title']) ? $data['title'] : $originalTask["title"];
        $description = isset($data['description']) ? $data['description'] : $originalTask["description"];
        $priority = isset($data['priority']) ? $data['priority'] : $originalTask["priority"];
        $is_completed = isset($data['is_completed']) ? $data['is_completed'] : $originalTask["is_completed"];

        $sql = "UPDATE tasks SET
                    title = '$title',
                    description = '$description',
                    priority = '$priority',
                    is_completed = '$is_completed'
                WHERE id = $id";

        if ($this->connection->query($sql)) {
            return ["message" => "Task updated successfully."];
        }

        return ["error" => "Failed to update your task."];

    }

    // Delete a task
    public function deleteTask($id) {
        $id = intval($id);
        $sql = "DELETE FROM tasks WHERE id = $id";

        if ($this->connection->query($sql)) {
            http_response_code(200);
            return ["message" => "Task deleted successfully."];
        }

        return ["error" => "Task deletion failed."];
    }
}





?>