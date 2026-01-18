<?php

$db_host = 'localhost';
$db_name = 'my_company';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT * FROM employees ORDER BY id DESC");
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام إدارة الموظفين</title>
    <!-- هذا السطر يربط ملف التصميم بهذه الصفحة -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start(); // ابدأ الجلسة لتتمكن من قراءة الرسائل
// تحقق مما إذا كانت هناك رسالة في الـ Session
if (isset($_SESSION['message'])): 
?>
   
    <div class="alert">
        <?php 
            echo $_SESSION['message']; 
            // احذف الرسالة بعد عرضها حتى لا تظهر مرة أخرى
            unset($_SESSION['message']);
        ?>
    </div>
<?php endif; ?>
    <div class="container">
        <h1>لوحة تحكم الموظفين</h1>
   
        <a href="add.php" class="btn btn-primary">إضافة موظف جديد</a>

   
        <table class="employee-table">
            <thead>
                <tr>
                    <th>الرقم</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الراتب</th>
                    <th>النوع</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['id']); ?></td>
                    <td><?php echo htmlspecialchars($employee['name']); ?></td>
                    <td><?php echo htmlspecialchars($employee['email']); ?></td>
                    <td>$<?php echo number_format($employee['salary'], 2); ?></td>
                    <td><?php echo htmlspecialchars($employee['type']); ?></td>
                    <td>
                    <td>
                       <a href="edit.php?id=<?php echo $employee['id']; ?>" class="btn btn-edit">تعديل</a>
                        <a href="delete.php?id=<?php echo $employee['id']; ?>" class="btn btn-delete" onclick="return confirm('هل أنت متأكد من أنك تريد حذف هذا الموظف؟');">حذف</a>
                    </td>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
</body>

</html>
