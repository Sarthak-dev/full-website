<!DOCTYPE html>
<html>
<head>
  <title>My Blog - Content</title>
  <link rel="stylesheet" type="text/css" href="content.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="content.js"></script>
</head>
<body>
  <div class="header">
    <div class="logo">
      <img src="logo.jpg" alt="Logo">
    </div>
    <h1>Blog</h1>
    <div class="search-tab">
      <a href="search.php">Search</a>
    </div>
  </div>

  <div class="container">
    <?php
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

    // Retrieve and display all posts or search results
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR date LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM posts";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $postId = $row['id']; // Assuming the 'id' column is present in the posts table
        $likes = getPostLikes($postId, $conn);
        $alreadyLiked = hasLikedPost($postId, $conn);

        echo '<div class="post">';
        echo '<div class="post-header">';
        echo '<h2 class="post-title">' . $row['title'] . '</h2>';
        echo '<p class="post-date">' . $row['date'] . '</p>';
        echo '</div>';
        echo '<p class="post-content">' . $row['content'] . '</p>';
        echo '<div class="like-btn">';
        echo '<span class="heart' . ($alreadyLiked ? ' clicked' : '') . '" data-post-id="' . $postId . '"></span>';
        echo '<span class="like-count">' . $likes . '</span>';
        echo '</div>';
        echo '</div>';
      }
    } else {
      echo "<p>No posts found</p>";
    }

    // Close the connection
    $conn->close();

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

    function hasLikedPost($postId, $conn) {
      $sessionId = session_id();
      $sql = "SELECT * FROM likes WHERE post_id = '$postId' AND user_id = '$sessionId'";
      $result = $conn->query($sql);
      return ($result->num_rows > 0);
    }
    ?>
  </div>
</body>
</html>
