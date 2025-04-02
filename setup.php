<?php
try {
    // Create (or open) the database in a file named 'habits.db'
    $pdo = new PDO('sqlite:habits.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create a table for habits if it doesn't exist, with auto-incrementing id
    $pdo->exec("CREATE TABLE IF NOT EXISTS habits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        description TEXT,
        frequency TEXT,
        startDate TEXT
    )");

    echo "Database and table created successfully!";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
