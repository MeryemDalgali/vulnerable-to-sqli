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
        ini_set('display_errors', 0); // Üretim ortamında hata mesajlarını kapatın

        if(isset($_SESSION['id'])) {
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

// PDO ile veritabanı bağlantısı oluşturma
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL sorgusu
    $sql = "SELECT * FROM Book";
    $stmt = $pdo->query($sql);

    // Sonuçları ekrana yazdırma
    echo '<div class="book-container">';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="book">';
        echo '<h2>Title: ' . htmlspecialchars($row["BookTitle"]) . '</h2>';
        echo '<p>Price: $' . htmlspecialchars($row["Price"]) . '</p>';
        echo '<form action="books_details.php" method="get">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($row['BookID']) . '"/>';
        echo '<input class="button" type="submit" value="Details"/>';
        echo '</form>';
        echo '</div>';
    }
    echo '</div>';

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
</div>

</body>
</html>
