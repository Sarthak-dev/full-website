<!DOCTYPE html>
<html>
<head>
  <title>My Blog</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    .hide {
      display: none;
    }
  </style>
  <script>
    // Function to hide the error message after a delay
    function hideErrorMessage() {
      var errorMessage = document.querySelector('.error-message');
      if (errorMessage) {
        errorMessage.classList.add('hide');
      }
    }

    // Set the delay time (in milliseconds) for hiding the error message
    var delayTime = 2000; // 3 seconds

    // Hide the error message after the specified delay
    setTimeout(hideErrorMessage, delayTime);
  </script>
</head>
<body>
  <div class="header">
    <div class="logo">
      <img src="logo.jpg" alt="Logo">
    </div>
    <div class="title">Welcome to my Blog</div>
  </div>
  
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

  // Check if form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate the user
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Authentication successful
      $title = $_POST['title'];
      $content = $_POST['content'];
      $date = date('Y-m-d'); // Get the current date

      // Insert new post into the database
      $sql = "INSERT INTO posts (title, content, date) VALUES ('$title', '$content', '$date')";
      if ($conn->query($sql) === TRUE) {
        header("Location: content.php");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      // Authentication failed
      echo "<p class='error-message'>Invalid username or password</p>";
    }
  }

  // Close the connection
  $conn->close();
  ?>
  
  <form action="" method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <label for="title">Title</label>
    <input type="text" id="title" name="title" required>

    <label for="content">Paragraph</label>
    <textarea id="content" name="content" required></textarea>

    <button type="submit">Submit</button>
  </form>
</body>
</html>
