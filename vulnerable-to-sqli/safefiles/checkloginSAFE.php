<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0); //  hata mesajlarını kapat

if(isset($_POST['username']) && isset($_POST['pwd'])) {
    $username = $_POST['username'];
    $password = $_POST['pwd'];

    // Veritabanına bağlanma işlemleri
    require_once "connectDB.php"; // Veritabanı bağlantı dosyası

    // Şifre hashleme 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Parametreli sorgu hazırlama
    $sql = "SELECT * FROM Users WHERE UserName = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Kullanıcı adı doğrulaması ve şifre kontrolü
        if (password_verify($password, $user['Password'])) {
            $_SESSION['id'] = $user['UserID'];
            header("Location: index.php");
            exit;
        } else {
            echo '<span style="color: red;">Login Fail</span>';
            header("Location: login.php?errcode=1");
            exit;
        }
    } else {
        echo '<span style="color: red;">Login Fail</span>';
        header("Location: login.php?errcode=1");
        exit;
    }
}
?>
