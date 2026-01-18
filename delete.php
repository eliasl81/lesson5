<?php
// delete.php


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $db_host = 'localhost';
    $db_name = 'my_company';
    $db_user = 'root';
    $db_pass = '';

    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("فشل الاتصال: " . $e->getMessage());
    }

   
    try {
        $sql = "DELETE FROM employees WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

session_start(); // ابدأ الجلسة
$_SESSION['message'] = "تم حذف الموظف بنجاح!"; // ضع الرسالة
header("Location: index.php");
exit();

    } catch (PDOException $e) {
        die("خطأ في حذف الموظف: " . $e->getMessage());
    }

} else {
  
    header("Location: index.php");
    exit();
}

?>
