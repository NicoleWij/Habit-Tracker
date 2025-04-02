<?php

function getPDO() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO('sqlite:habits.db');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // If the connection fails, we can't proceed.
            http_response_code(500);
            echo json_encode(["error" => "Database connection error: " . $e->getMessage()]);
            exit;
        }
    }
    return $pdo;
}

function getAllHabits() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM habits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHabitById($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM habits WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createHabit($data) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO habits (name, description, frequency, startDate) VALUES (:name, :description, :frequency, :startDate)");
    $stmt->execute([
        ':name' => $data['name'],
        ':description' => $data['description'],
        ':frequency' => $data['frequency'],
        ':startDate' => $data['startDate'],
    ]);
    return $pdo->lastInsertId();
}

function updateHabit($id, $data) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("UPDATE habits SET name = :name, description = :description, frequency = :frequency, startDate = :startDate WHERE id = :id");
    return $stmt->execute([
        ':name' => $data['name'],
        ':description' => $data['description'],
        ':frequency' => $data['frequency'],
        ':startDate' => $data['startDate'],
        ':id' => $id
    ]);
}

function deleteHabit($id) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM habits WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
?>