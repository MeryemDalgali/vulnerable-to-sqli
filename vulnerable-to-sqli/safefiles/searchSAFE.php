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
ini_set('display_errors', 0); // Üretim ortamında hata mesajlarını kapatın

// Check if search query is provided
if(isset($_GET['search_query'])) {
    // Veritabanı bağlantısı için güvenli ayarlar
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "BookStore";

    try {
        // PDO ile veritabanı bağlantısı oluşturma
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Kullanıcı girdisini güvenli hale getirme
        $search_query = $_GET['search_query'];
        $search_query_safe = '%' . $search_query . '%';

        // Parametreli sorgu hazırlama
        $sql = "SELECT * FROM Book WHERE BookTitle LIKE :search_query";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':search_query', $search_query_safe);
        $stmt->execute();

        // Sorgu sonuçlarını kontrol etme
        if ($stmt->rowCount() > 0) {
            echo "<h2>Search Results:</h2>";
            echo "<table style='width:80%;'>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>";
                echo "<table>";
                echo "<tr><td><br></br>Title: " . htmlspecialchars($row["BookTitle"]) . "</td></tr>";
                echo "<tr><td>Price: $" . htmlspecialchars($row["Price"]) . "</td></tr>";
                echo "<tr><td>";
                echo "<form action='books_details.php' method='get'>";
                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['BookID']) . "'/>";
                echo "<input class='button' type='submit' value='Details'/>";
                echo "</form>";
                echo "</td></tr>";
                echo "</table>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h2>No books found matching your search.</h2>";
        }

    } catch (PDOException $e) {
        echo "<h2>Error executing query:</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
    }

    // Veritabanı bağlantısını kapat
    $pdo = null;

} else {
    echo "<h2>No search query provided.</h2>";
}
?>
<div style="margin-top: 20px;">
    <a href="index.php" class="button">Back to Home</a>
</div>
</div>
</body>
</html>
