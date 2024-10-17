<?php
    session_start();
    include('server.php');
    $errors = array();

    // ฟังก์ชันสำหรับลบคำแนะนำ
    function deleteSuggest($suggest_id) {
        global $conn;
        $sql = "DELETE FROM suggest WHERE suggest_id = '$suggest_id'";
        return mysqli_query($conn, $sql);
    }

    if (isset($_POST['delete'])) {
        // ใช้ตัวแปรที่ส่งมาจากฟอร์ม
        $suggest_id = $_POST['suggest_id'] ?? null; // กำหนดเป็น null หากไม่พบ

        // ตัวแปรสำหรับจัดเก็บข้อความแสดงผล
        $message = '';

        // ตรวจสอบว่ามีการส่ง rule_id หรือ suggest_id หรือไม่
        if ($suggest_id) {
            if (deleteSuggest($suggest_id)) {
                $message .= "ลบคำแนะนำสำเร็จ!";
            } else {
                $message .= "เกิดข้อผิดพลาดในการลบคำแนะนำ: " . mysqli_error($conn) . "<br>";
            }
        }

        // แสดงข้อความผลลัพธ์
        echo "<script>alert('$message');</script>";
        // เปลี่ยนเส้นทางไปยังหน้า data_manage
        echo "<script>window.location.href = 'data_manage.php';</script>";
        exit;
    }

    // ตรวจสอบการรับค่าจาก URL
    if (isset($_GET['rule_id']) || isset($_GET['suggest_id'])) {
        $suggest_id = $_GET['suggest_id'] ?? null; // กำหนดเป็น null หากไม่พบ
    } else {
        echo "ไม่พบข้อมูลสำหรับการลบ!";
        exit;
    }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> delete </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        h1 {
            font-size: 30px;
            margin-bottom: 10px;
            color: #000000;
        } p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #000000;
        }

        .btn-danger, .btn-primary {
            width: 120px;
            margin: 10px;
            padding: 10px 20px;
            border-radius: 10px;
        } .btn-danger:hover {
            background-color: #c82333;
        } .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5"> ยืนยันการลบข้อมูล </h1>
        <p> คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูล? </p>
        
        <div>
            <form action="delete.php" method="post">
                <input type="hidden" name="rule_id" value="<?php echo htmlspecialchars($rule_id); ?>">
                <input type="hidden" name="suggest_id" value="<?php echo htmlspecialchars($suggest_id); ?>">
                <button type="submit" name="delete" class="btn btn-danger"> ลบ </button>
                <a href="data_manage.php" class="btn btn-primary"> ยกเลิก </a>
            </form>
        </div>
    </div>
</body>
</html>