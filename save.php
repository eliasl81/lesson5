<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

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

   
    $name = $_POST['name'];
    $email = $_POST['email'];
    $salary = $_POST['salary'];
    $type = $_POST['type'];
    $extra_info = !empty($_POST['extra_info']) ? $_POST['extra_info'] : null;


    try {
        $sql = "INSERT INTO employees (name, email, salary, type, extra_info) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $salary, $type, $extra_info]);

  
          session_start(); 
              $_SESSION['message'] = "تمت إضافة الموظف بنجاح!"; // ضع الرسالة
             header("Location: index.php");
             exit();

    } catch (PDOException $e) {
        die("خطأ في حفظ الموظف: " . $e->getMessage());
    }

} else {

    header("Location: index.php");
    exit();
}

?>
