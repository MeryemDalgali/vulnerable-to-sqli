<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <blockquote>
        <a href="index.php"><img src="image/logo.png"></a>
        <?php
        session_start();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if(isset($_SESSION['id'])){
            echo '<form class="hf" action="logout.php"><input class="hi" type="submit" name="submitButton" value="Logout"></form>';
            echo '<form class="hf" action="add_book.php"><input class="hi" type="submit" name="submitButton" value="Add Book"></form>';
        } else {
            echo '<form class="hf" action="login.php"><input class="hi" type="submit" name="submitButton" value="Login"></form>';
        }
        ?>
    </blockquote>
</header>

<form action="search.php" method="get" style="display: inline-block; margin-top: 20px; margin-left: 20px;">
    <label for="search">Search Book:</label>
    <input type="text" id="search" name="search_query" placeholder="Enter book title or author">
    <input class="button" type="submit" value="Search">
</form>


<div class="container">
<center><h1>Books</h1></center>

<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "BookStore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Book";
$result = $conn->query($sql);
?>

<div class="book-container">
    <?php
    while($row = $result->fetch_assoc()) {
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
                    echo "</tr>";    }
    ?>
</div>

</body>
</html>
