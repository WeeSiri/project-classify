<?php
    session_start();
    include('server.php');
    $errors = array();

    if (isset($_POST['login_db'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($username)) {
            array_push($errors, "จำเป็นต้องมีชื่อผู้ใช้");
        }

        if (empty($password)) {
            array_push($errors, "จำเป็นต้องมีรหัสผ่าน");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "ตอนนี้คุณได้เข้าสู่ระบบแล้ว";
                header('location: home.php');
                exit();
            } else {
                array_push($errors, "ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง");
                $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง ลองใหม่อีกครั้ง";
                header('location: login.php');
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> login </title>
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

    <form class="form-member" action="login.php" method="post" autocomplete="off">
        <div class="title-member">
            <L> เข้าสู่ระบบ </L>
        </div>

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
            <label for="username"> ชื่อผู้ใช้งาน </label>
            <input type="text" name="username" placeholder="ชื่อผู้ใช้งานระบบ" required>
        </div>

        <div class="input-data">
            <label for="password"> รหัสผ่าน </label>
            <input type="password" name="password" placeholder="รหัสผ่าน" required>
        </div>

        <div class="input-data">
            <button type="submit" name="login_db" class="btn"> เข้าสู่ระบบ </button>
        </div>

        <div class="link-container">
            <a href="register.php"> สมัครสมาชิก </a>
        </div>
    </form>
</body>
</html>