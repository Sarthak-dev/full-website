<!DOCTYPE html>
<html>
<head>
    <title>Blog Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #ff7c7c;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $host = "localhost"; // Replace with your database host
        $dbname = "blog"; // Replace with your database name
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $postId = $_GET['id'];

            $stmt = $conn->prepare("SELECT title, content FROM posts WHERE id = :postId");
            $stmt->bindParam(':postId', $postId);
            $stmt->execute();

            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($post) {
                echo "<h2>" . $post['title'] . "</h2>";
                echo "<p>" . $post['content'] . "</p>";
            } else {
                echo "<p>Post not found.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
