<?php
// Include the database file
require_once 'db.php';

// Get the request URI and HTTP method
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// GET /habits: Retrieve all habits from the database
if ($request === '/habits' && $method === 'GET') {
    header('Content-Type: application/json');
    try {
        $habits = getAllHabits();
        echo json_encode(["habits" => $habits]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit;
}

// GET /habits/{id}: Retrieve a specific habit from the database
if (preg_match('/\/habits\/([^\/]+)$/', $request, $matches)) {
    $id = $matches[1];
    if ($method === 'GET') {
        header('Content-Type: application/json');
        try {
            $habit = getHabitById($id);
            if ($habit) {
                echo json_encode(["habit" => $habit]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Habit not found."]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
        exit;
    }
}

// POST /habits: Insert a new habit into the database
if ($request === '/habits' && $method === 'POST') {
    header('Content-Type: application/json');
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    // Validate required fields (remove 'id' because it's auto-generated)
    if (!isset($data['name'], $data['description'], $data['frequency'], $data['startDate'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields."]);
        exit;
    }

    try {
        $newId = createHabit($data);
        http_response_code(201);
        echo json_encode(["message" => "Habit created successfully.", "id" => $newId]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit;
}

// Fallback for unknown endpoints
http_response_code(404);
echo json_encode(["error" => "Endpoint not found"]);