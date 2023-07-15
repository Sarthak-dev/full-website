<?php
session_start(); // Start the session

$host = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "blog"; // Replace with your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postId = $_POST["postId"];

    // Check if the user has already liked the post
    if (hasUserLikedPost($postId, $conn)) {
        $response = [
            "success" => false,
            "message" => "You have already liked this post!"
        ];
        echo json_encode($response);
        exit;
    }

    // Insert a new like for the post
    $sessionId = session_id();
    $sql = "INSERT INTO likes (post_id, user_id) VALUES ('$postId', '$sessionId')";
    if ($conn->query($sql) === TRUE) {
        // Retrieve the updated like count
        $likes = getPostLikes($postId, $conn);

        // Prepare the response as JSON
        $response = [
            "success" => true,
            "likes" => $likes
        ];
        echo json_encode($response);
    } else {
        // Error occurred while inserting the like
        $response = [
            "success" => false,
            "message" => "Failed to like the post."
        ];
        echo json_encode($response);
    }
}

// Close the connection
$conn->close();

function hasUserLikedPost($postId, $conn) {
    $sessionId = session_id();
    $sql = "SELECT * FROM likes WHERE post_id = '$postId' AND user_id = '$sessionId'";
    $result = $conn->query($sql);
    return ($result->num_rows > 0);
}

function getPostLikes($postId, $conn) {
    $sql = "SELECT COUNT(*) AS likes FROM likes WHERE post_id = '$postId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['likes'];
    } else {
        return 0;
    }
}
?>
