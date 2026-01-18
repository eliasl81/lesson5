<?php
// edit.php

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

$employee = null;
$id = $_GET['id'] ?? null;

// التحقق من وجود ID
if (!$id) {
    header("Location: index.php");
    exit();
}

// --- معالجة حفظ التعديلات (عندما يضغط المستخدم على زر الحفظ) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $salary = $_POST['salary'];
    $type = $_POST['type'];
    $extra_info = !empty($_POST['extra_info']) ? $_POST['extra_info'] : null;

    try {
        $sql = "UPDATE employees SET name = ?, email = ?, salary = ?, type = ?, extra_info = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $salary, $type, $extra_info, $id]);

       // بعد التحديث، ضع رسالة نجاح في الـ Session وأعد التوجيه
session_start(); // ابدأ الجلسة
$_SESSION['message'] = "تم تعديل بيانات الموظف بنجاح!"; // ضع الرسالة
header("Location: index.php");
exit();
    } catch (PDOException $e) {
        die("خطأ في تحديث الموظف: " . $e->getMessage());
    }
}

// --- جلب بيانات الموظف الحالية لعرضها في النموذج ---
try {
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->execute([$id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        // إذا لم يتم العثور على الموظف، عد للصفحة الرئيسية
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    die("خطأ في جلب بيانات الموظف: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل بيانات الموظف</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>تعديل بيانات: <?php echo htmlspecialchars($employee['name']); ?></h1>

        <!-- النموذج يرسل البيانات إلى نفس الصفحة (edit.php) مع الـ ID -->
        <form action="edit.php?id=<?php echo $employee['id']; ?>" method="POST">
            <div class="form-group">
                <label for="name">الاسم الكامل:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="salary">الراتب:</label>
                <input type="number" id="salary" name="salary" step="0.01" value="<?php echo htmlspecialchars($employee['salary']); ?>" required>
            </div>
            <div class="form-group">
                <label for="type">نوع الموظف:</label>
                <select id="type" name="type">
                    <option value="Permanent" <?php if ($employee['type'] == 'Permanent') echo 'selected'; ?>>دائم</option>
                    <option value="Contract" <?php if ($employee['type'] == 'Contract') echo 'selected'; ?>>عقد</option>
                    <option value="Manager" <?php if ($employee['type'] == 'Manager') echo 'selected'; ?>>مدير</option>
                </select>
            </div>
            <div class="form-group">
                <label for="extra_info">معلومات إضافية (بصيغة JSON):</label>
                <textarea id="extra_info" name="extra_info" rows="3"><?php echo htmlspecialchars($employee['extra_info']); ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            <a href="index.php" class="btn btn-delete">إلغاء</a>
        </form>
    </div>
</body>
</html>