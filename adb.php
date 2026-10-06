<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "campoboy"
);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Database connected successfully!";

?>