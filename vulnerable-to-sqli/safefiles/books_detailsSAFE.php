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
        ini_set('display_errors', 0); // Üretim ortamında hata mesajlarını kapatın

        // Veritabanı bağlantısı
        $servername = "localhost";
        $username = "root";
        $password = "1234";
        $dbname = "BookStore";

        // Veritabanı bağlantısını oluşturun
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Bağlantıyı kontrol et
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // BookID parametresini alın ve güvenli hale getirin
        if(isset($_GET['id'])) {
            $bookID = $_GET['id'];

            // Parametreli sorgu hazırlayın
            $sql = "SELECT * FROM Book WHERE BookID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $bookID);
            $stmt->execute();
            $result = $stmt->get_result();

            // Sorgu sonuçlarını kontrol edin
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "Title: " . htmlspecialchars($row["BookTitle"]) . "<br>"; // XSS saldırılarına karşı htmlspecialchars kullanın
                    echo "Author: " . htmlspecialchars($row["Author"]) . "<br>";
                    echo "ISBN: " . htmlspecialchars($row["ISBN"]) . "<br>";
                    echo "Price: $" . htmlspecialchars($row["Price"]) . "<br>";
                    echo "Type: " . htmlspecialchars($row["Type"]) . "<br>";
                }
            } else {
                echo "No book found with provided ID!";
            }

            // Statement ve bağlantıyı kapat
            $stmt->close();
        } else {
            echo "No book ID provided!";
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
        ?>
    </div>

</body>
</html>
