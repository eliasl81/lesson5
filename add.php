<?php

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة موظف جديد</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>نموذج إضافة موظف جديد</h1>

       
        <form action="save.php" method="POST">
            <div class="form-group">
                <label for="name">الاسم الكامل:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="salary">الراتب:</label>
                <input type="number" id="salary" name="salary" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="type">نوع الموظف:</label>
                <select id="type" name="type">
                    <option value="Permanent">دائم</option>
                    <option value="Contract">عقد</option>
                    <option value="Manager">مدير</option>
                </select>
            </div>
            <div class="form-group">
                <label for="extra_info">معلومات إضافية (بصيغة JSON):</label>
                <textarea id="extra_info" name="extra_info" rows="3" placeholder='مثال: {"benefits": "Health"}'></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">حفظ الموظف</button>
            <a href="index.php" class="btn btn-delete">إلغاء</a>
        </form>
    </div>
</body>

</html>
