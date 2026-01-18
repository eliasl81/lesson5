<?php
// delete.php

// التأكد من وجود ID في الرابط
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // --- الاتصال بقاعدة البيانات ---
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

    // --- حذف الموظف الذي يطابق الـ ID ---
    try {
        $sql = "DELETE FROM employees WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
// --- بعد الحذف، ضع رسالة نجاح في الـ Session وأعد التوجيه ---
session_start(); // ابدأ الجلسة
$_SESSION['message'] = "تم حذف الموظف بنجاح!"; // ضع الرسالة
header("Location: index.php");
exit();

    } catch (PDOException $e) {
        die("خطأ في حذف الموظف: " . $e->getMessage());
    }

} else {
    // إذا لم يتم إرسال ID، أعد المستخدم للصفحة الرئيسية
    header("Location: index.php");
    exit();
}
?>