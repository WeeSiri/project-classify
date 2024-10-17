<?php
    session_start();
    include('server.php');
    $errors = array();

    // ดึงคำนำหน้าจากฐานข้อมูล
    $nametitles_query = "SELECT * FROM users";
    $nametitles_result = mysqli_query($conn, $nametitles_query);

    // ดึงค่าจากฟอร์ม
    if (isset($_POST['register_db'])) {
        var_dump($_POST);
        $nametitle = mysqli_real_escape_string($conn, $_POST['nametitle']);
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

        // ตรวจสอบความถูกต้องของข้อมูล
        if (empty($nametitle)) {
            array_push($errors, "กรุณากรอกคำนำหน้า");
        }

        if (empty($firstname)) {
            array_push($errors, "กรุณากรอกชื่อ");
        }

        if (empty($lastname)) {
            array_push($errors, "กรุณากรอกนามสกุล");
        }

        if (empty($username)) {
            array_push($errors, "กรุณากรอกชื่อผู้ใช้งาน");
        }

        if (empty($email)) {
            array_push($errors, "กรุณากรอกอีเมล");
        }

        if (empty($password_1)) {
            array_push($errors, "กรุณากรอกรหัสผ่าน");
        }

        if ($password_1 !== $password_2) { // ตรวจสอบว่ารหัสผ่านทั้งสองตรงกันหรือไม่
            $_SESSION['error'] = "รหัสผ่านทั้งสองไม่ตรงกัน";
            header('location: register.php');
            exit();
        }

        // ตรวจสอบผู้ใช้ซ้ำ
        $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // ถ้ามีผู้ใช้งานอยู่ในระบบ
            if ($result['username'] === $username && $result['email'] === $email) {
                $_SESSION['error'] = "ชื่อผู้ใช้งานหรืออีเมลมีอยู่แล้ว";
            } else if ($result['username'] === $username) {
                array_push($errors, "ชื่อผู้ใช้งานมีอยู่แล้ว");
                $_SESSION['error'] = "ชื่อผู้ใช้งานมีอยู่แล้ว";
            } else if ($result['email'] === $email) {
                array_push($errors, "อีเมลมีอยู่แล้ว");
                $_SESSION['error'] = "อีเมลมีอยู่แล้ว";
            }
            
            header('location: register.php');
            exit();
        }

        // ถ้าไม่มีข้อผิดพลาด
        if (count($errors) == 0) {
            $password = md5($password_1);
            $sql = "INSERT INTO users (nametitle, firstname, lastname, username, email, password) VALUES ('$nametitle', '$firstname', '$lastname', '$username', '$email', '$password')";

            // ตรวจสอบการบันทึกข้อมูล
            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "สมัครสมาชิกสำเร็จ";
                header('location: login.php'); // เปลี่ยนเส้นทางไปหน้า login หลังจากลงทะเบียนเสร็จสิ้น
                exit(); // เพื่อหยุดการทำงานหลังจาก redirect
            } else {
                echo "Error: " . mysqli_error($conn); // แสดงข้อผิดพลาด
            }
        } else {
            // แสดงข้อผิดพลาด
            $_SESSION['error'] = implode(", ", $errors);
            header('location: register.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> register </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="member">
        <nav>
            <ul>
                <li><a href="home.php" class="link"> หน้าแรก </a></li>
                <li><a href="index.php" class="link"> วิเคราะห์ผลการเรียนจากต้นไม้ตัดสินใจ </a></li>
                <?php if (isset($_SESSION['username'])) : ?>
                    <li><a href="data_manage.php"> จัดการคำแนะนำ </a></li>
                    <li><a href="home.php?logout='1'"> ออกจากระบบ </a></li>
                <?php else : ?>
                    <li>
                        <a href="login.php"> เข้าสู่ระบบ </a>
                        <div class="small-text"> (ครูเท่านั้น) </div>
                    </li>
                    <li>
                        <a href="register.php"> สมัครสมาชิก </a>
                        <div class="small-text"> (ครูเท่านั้น) </div>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <form class="form-member" action="register.php" method="post" autocomplete="off">
        <div class="title-member">
            <R> สมัครสมาชิก </R>
        </div>

        <?php include('errors.php'); ?>
        <!-- ข้อความแจ้งเตือน -->
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <E>
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']); // ลบ session หลังจากแสดงผลเพื่อไม่ให้ข้อความแสดงซ้ำ
                    ?>
                </E>
            </div>
        <?php endif ?>
        
        <div class="input-data">
            <label for="nametitle"> คำนำหน้า </label>
            <select name="nametitle" id="nametitle" required>
                <option value=""> -- เลือกคำนำหน้า -- </option>
                <option value="Mr."> นาย </option>
                <option value="Mrs."> นาง </option>
                <option value="Miss"> นางสาว </option>
            </select>
        </div>
        
        <div class="name-row">
            <div class="input-name">
                <label for="firstname"> ชื่อ </label>
                <input type="text" name="firstname" placeholder="ชื่อจริง" required>
            </div>

            <div class="input-name">
                <label for="lastname"> นามสกุล </label>
                <input type="text" name="lastname" placeholder="นามสกุล" required>
            </div>
        </div>

        <div class="input-data">
            <label for="username"> ชื่อผู้ใช้งาน </label>
            <input type="text" name="username" placeholder="ชื่อผู้ใช้งานระบบ" required>
        </div>

        <div class="input-data">
            <label for="email"> อีเมล </label>
            <input type="email" name="email" placeholder="123@example.com" required>
        </div>

        <div class="input-data">
            <label for="password_1"> รหัสผ่าน </label>
            <input type="password" name="password_1" placeholder="รหัสผ่าน" required autocomplete="off">
        </div>

        <div class="input-data">
            <label for="password_2"> ยืนยันรหัสผ่าน </label>
            <input type="password" name="password_2" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required autocomplete="off">
        </div>

        <div class="input">
            <button type="submit" name="register_db" class="btn"> สมัคร </button>
        </div>

        <div class="link-container">
            <a href="login.php"> มีบัญชีแล้วใช่ไหม </a>
        </div>
    </form>
</body>
</html>