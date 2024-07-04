<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <blockquote>
            <a href="index.php"><img src="image/logo.png" alt="Logo"></a>
        </blockquote>
    </header>

    <div class="container">
        <center><h1>Book Details</h1></center>

        <?php
        // Hata raporlama
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Veritabanı bağlantısı
        $servername = "localhost";
        $username = "root";
        $password = "1234";
        $dbname = "BookStore";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Bağlantıyı kontrol et
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // BookID parametresini al
        if(isset($_GET['id'])) {
            $bookID = $_GET['id'];

            // SQL sorgusu
            $sql = "SELECT * FROM Book WHERE BookID ='$bookID'";
            $result = $conn->query($sql);

            // Sorgu sonuçlarını kontrol et
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "Title: " . $row["BookTitle"] . "<br>";
                    echo "Author: " . $row["Author"] . "<br>";
                    echo "ISBN: " . $row["ISBN"] . "<br>";
                    echo "Price: $" . $row["Price"] . "<br>";
                    echo "Type: " . $row["Type"] . "<br>";
                }
            } else {
                echo "No book found with provided ID!";
            }
        } else {
            echo "No book ID provided!";
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
        ?>
    </div>

</body>
</html>
