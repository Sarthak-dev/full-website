<?php
$host = "localhost"; // Replace with your database host
$dbname = "blog"; // Replace with your database name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $_GET['query'];

    $stmt = $conn->prepare("SELECT id, title FROM posts WHERE title LIKE :query OR content LIKE :query");
    $stmt->bindValue(':query', '%' . $query . '%');
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
