<?php
    session_start();
    include('server.php');
    $errors = array();

    // ตรวจสอบว่าผู้ใช้ logout หรือไม่
    if (isset($_GET['logout'])) {
        session_destroy(); // ทำลาย session
        unset($_SESSION['username']); // ลบข้อมูล session
        header('location: index.php'); // ลบข้อมูล session
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> analyze </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="content">
            <div class="header-logo">
                <img src="logo.png" alt="Logo" class="logo">
            </div>

            <div class="header-text">
                <h1> ระบบวิเคราะห์ผลการเรียนจากต้นไม้ตัดสินใจเพื่อจำแนกกลุ่มผู้เรียน </h1>
                <h2> โรงเรียนบ้านนายูง </h2>
            </div>
        </div>
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
    
    <div class="title-main">
        <I3> วิเคราะห์ผลการเรียน </I3>
    </div>
    
    <form class="form-main" action="result.php" method="post">
        <label> *ไม่จำเป็นต้องกรอกทุกวิชา <a href="home.php"> คลิกเพื่อดูต้นไม้ตัดสินใจก่อนวิเคราะห์ </a></p></label>
        <div class="input-main">
            <div class="input-subject">
                <label> วิชาภาษาไทย </label>
                <select name="TH">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาคณิตศาสตร์ </label>
                <select name="math">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาวิทยาศาสตร์ </label>
                <select name="sci">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาวิทยาศาสตร์คำนวณ </label>
                <select name="sci_calculate">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาสังคมศึกษา </label>
                <select name="social">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาประวัติศาสตร์ </label>
                <select name="history">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาพลศึกษา </label>
                <select name="PE">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาการงานอาชีพ </label>
                <select name="work">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาคอมพิวเตอร์เพิ่มเติม </label>
                <select name="computer">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาการงานอาชีพเพิ่มเติม </label>
                <select name="work_add">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาภาษาอังกฤษ </label>
                <select name="ENG">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input-subject">
                <label> วิชาภาษาอังกฤษเพิ่มเติม </label>
                <select name="ENG_add">
                    <option value="" selected hidden> -- เลือกเกรด -- </option>
                    <option value="null"></option>
                    <option value="1"> 1 </option>
                    <option value="1.5"> 1.5 </option>
                    <option value="2"> 2 </option>
                    <option value="2.5"> 2.5 </option>
                    <option value="3"> 3 </option>
                    <option value="3.5"> 3.5 </option>
                    <option value="4"> 4 </option>
                </select>
            </div>

            <div class="input">
                <button type="submit" name="result" class="btn"> วิเคราะห์ผล </button>
            </div>
        </div>
    </form>
</body>
</html>