<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<blockquote>
    <a href="index.php"><img src="image/logo.png" alt="Logo"></a>
</blockquote>
</header>

<div class="container">
<center><h1>Results</h1></center>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if search query is provided
if(isset($_GET['search_query'])) {
    // Simulating vulnerability with direct user input in SQL query
    $search_query = $_GET['search_query'];

    // Database connection setup (replace with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "BookStore";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Simulated SQL Injection vulnerability (DO NOT use in production!)
    $sql = "SELECT * FROM Book WHERE BookTitle LIKE '$search_query'";

    $result = mysqli_query($conn, $sql);

        // Check for SQL error
        if (!$result) {
            echo "<h2>Error executing query:</h2>";
            echo "<p>"  . mysqli_error($conn) .  "</p>";
        } else {
            // Display search results
            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Search Results:</h2>";
                echo "<table style='width:80%;'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<table>";
                    echo "<tr><td><br></br>Title: " . $row["BookTitle"] . "</td></tr>";
                    echo "<tr><td>Price: $" . $row["Price"] . "</td></tr>";
                    echo "<tr><td>";
                    echo "<form action='books_details.php' method='get'>";
                    echo "<input type='hidden' name='id' value='" . $row['BookID'] . "'/>";
                    echo "<input class='button' type='submit' value='Details'/>";
                    echo "</form>";
                    echo "</td></tr>";
                    echo "</table>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
		echo "<h2>Error executing query:</h2>";
            echo "<p>"  . mysqli_error($conn) . "</p>";
                echo "No books found matching your search.";
            }
        }

        // Close database connection
        $conn->close();
    } else {
        echo "No search query provided.";
    }
    ?>
	  <div style="margin-top: 20px;">
        <a href="index.php" class="button">Back to Home</a>
    </div>
</div>
</body>
</html>
