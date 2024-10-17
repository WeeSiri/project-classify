<?php
    session_start();
    include('server.php');
    $errors = array();

    // ตรวจสอบว่าผู้ใช้ logout หรือไม่
    if (isset($_GET['logout'])) {
        session_destroy(); // ทำลาย session
        unset($_SESSION['username']); // ลบข้อมูล session
        header('location: home.php'); // ลบข้อมูล session
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> home </title>
    <link rel="stylesheet" href="style.css">
    <style>
        html {
            scroll-behavior: smooth; /* CSS เพื่อการเลื่อนที่นุ่มนวล (ไม่บังคับ) */
        }
</style>
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

    <div class="title-home">
        <div class="click-to-view">
            <a href="#tree-section" class="btn"> ต้นไม้ตัดสินใจ (Decision Tree) </a>
            <a href="#result-section" class="btn"> การสร้างแบบจำลองต้นไม้ตัดสินใจ </a>
            <a href="#rule-section" class="btn"> แปลความหมายของต้นไม้ตัดสินใจจากการสร้างแบบจำลอง </a>
        </div>
    </div>

    <div class="welcome-message <?php echo isset($_SESSION['username']) ? 'show-welcome' : ''; ?>">
        <?php if (isset($_SESSION['username'])) : ?> ยินดีต้อนรับ คุณ <strong><?php echo $_SESSION['username']; ?></strong><?php endif; ?>
    </div>

    <h3> วิธีใช้งานระบบ </h3>
    
    <div class="container">
        <div class="system">
            <section>
                <h4> ภาพรวมของระบบ </h4>
                <p> ระบบนี้เป็นการประยุกต์ใช้ต้นไม้ตัดสินใจเพื่อจำแนกกลุ่มผู้เรียนตามผลสัมฤทธิ์การเรียนรู้ โดยใช้ข้อมูลผลการเรียนในแต่ละวิชาวิเคราะห์และจัดกลุ่มเป็น กลุ่มที่เก่ง ปานกลาง และอ่อน เพื่อสร้างแบบจำลองที่สามารถช่วยในการวิเคราะห์ผลการเรียนและนำผลวิเคราะห์ที่ได้มาให้เป็นแนวทางในการจัดแบ่งหรือแยกกลุ่มนักเรียนตามความถนัดหรือความสามารถเพื่อส่งเสริมในการทักษะของนักเรียน </p>
                <p><strong> จำนวนต้นไม้ตัดสินใจ: </strong> มีทั้งหมด 37 ใบหรือ 37 กฎในการจัดประเภทข้อมูล ซึ่งได้จากการวิเคราะห์ข้อมูลผลการเรียน </p>
                <p><strong> ค่าความแม่นยำในการจำแนก: </strong> 81.78% ซึ่งแสดงให้เห็นถึงความน่าเชื่อถือในการจำแนก </p>
            </section>
        </div>

        <div class="step">
            <section>
                <h4> ขั้นตอนและฟังก์ชันการใช้งานระบบ </h4>
                <p><strong> สำหรับครู: </strong></p>
                <p> - สมัครสมาชิก </p>
                <p> - เข้าสู่ระบบใช้งาน </p>
                <p> - กรอกผลการเรียนของนักเรียนเพื่อให้ระบบ <a href="index.php"> วิเคราะห์ </a> และให้ข้อเสนอแนะ </p>
                <p> - เพิ่ม, ลบ, แก้ไขคำแนะนำสำหรับให้นักเรียน </p>
                <p> หมายเหตุ: การให้คำแนะนำหรือเพิ่ม, ลบ, แก้ไขคำแนะนำ จะต้องเป็นสมาชิกหรือสมัครสมาชิกและเข้าสู่ระบบก่อน </p>

                <p><strong> สำหรับนักเรียน: </strong></p>
                <p> - กรอกผลการเรียนเพื่อให้ระบบ <a href="index.php"> วิเคราะห์ </a> พร้อมดูข้อเสนอแนะ </p>
            </section>
        </div>
    </div>
    
    <div class="decision-tree" id="tree-section">
        <section>
            <h4> ต้นไม้ตัดสินใจ (Decision Tree) </h4>
            <p> ต้นไม้ตัดสินใจ (Decision Tree) เป็นโมเดลที่ใช้สำหรับการตัดสินใจและการจำแนกกลุ่ม โดยอาศัยโครงสร้างต้นไม้ซึ่งแต่ละโหนด (Node) แทนการตัดสินใจหรือเงื่อนไข และกิ่ง (Branch) แทนผลลัพธ์ที่เป็นไปได้จากเงื่อนไขนั้นๆ </p>

            <p><strong> ส่วนประกอบหลักของต้นไม้ตัดสินใจ </strong> ซึ่งประกอบด้วย </p>
            <p> 1. โหนดราก (Root Node): คือจุดเริ่มต้นของต้นไม้ซึ่งเป็นที่มาของการตัดสินใจเริ่มต้น หรือคุณสมบัติที่สำคัญที่สุดที่ใช้ในการจำแนกประเภทข้อมูล </p>
            <p> 2. โหนดภายใน (Internal Nodes): คือโหนดที่ใช้เกณฑ์หรือเงื่อนไขในการแบ่งข้อมูล โดยมีหลายกิ่ง (branches) ที่แสดงถึงการตัดสินใจต่อไป </p>
            <p> 3. ใบ (Leaf Nodes): คือจุดสิ้นสุดของต้นไม้ซึ่งเป็นการตัดสินใจหรือผลลัพธ์สุดท้ายของการตัดสินใจทั้งหมด </p>

            <p><strong> กระบวนการทำงานของต้นไม้ตัดสินใจ </strong></p>
            <p> - ต้นไม้ตัดสินใจจะเลือกคุณสมบัติที่สำคัญที่สุดเพื่อใช้ในการตัดสินใจในแต่ละโหนด โดยการพิจารณาจากเงื่อนไขเพื่อแบ่งข้อมูลออกเป็นชุดย่อยๆ จนกว่าจะถึงจุดสิ้นสุดของต้นไม้ </p>
            <p> - การตัดสินใจแต่ละขั้นตอน ขึ้นอยู่กับการคำนวณค่าข้อมูลเชิงสถิติ เช่น <a href="https://th.wikipedia.org/wiki/%E0%B8%95%E0%B9%89%E0%B8%99%E0%B9%84%E0%B8%A1%E0%B9%89%E0%B8%95%E0%B8%B1%E0%B8%94%E0%B8%AA%E0%B8%B4%E0%B8%99%E0%B9%83%E0%B8%88"> Entropy หรือ Gini Index </a> เพื่อช่วยให้ต้นไม้สามารถเลือกคุณสมบัติที่ดีที่สุดสำหรับการแบ่งข้อมูล </p>

            <img src="EXdecision-tree.png">
            <p class="photo"> ภาพตัวอย่างต้นไม้ตัดสินใจ </p>
        </section>
    </div>
    
    <div class="analys-result" id="result-section">
        <section>
            <h4> ผลการสร้างแบบจำลองต้นไม้ตัดสินใจ </h4>
            <p> การสร้างแบบจำลองต้นไม้ตัดสินใจ ซึ่งใช้โปรแกรม Weka อัลกอริทึม J48 กำหนด Cross-Validation Folds = 10 โดยการวิเคราะห์จะแบ่งผลการเรียน ได้แก่ (เกรด 1 หรือ 1.5 และ 2 = D_D+_C), (เกรด 2.5 หรือ 3 = C+_B), (เกรด 3.5 หรือ 4 = B+_A) </p>
            <p> โดยใช้ผลการเรียนเฉลี่ยสะสม เป็น ผลลัพธ์ในการวิเคราะห์ ได้แก่ (1.00-2.49 = Low (กลุ่มอ่อน)), (2.50-3.00 = Medium (กลุ่มปานกลาง)), (3.01-4.00 = High (กลุ่มเก่ง)) </p>
            <p> และใช้รายวิชาจำนวน 13 รายวิชา ได้แก่ (ภาษาไทย), (คณิตศาสตร์), (วิทยาศาสตร์), (วิทยาศาสตร์คำนวณ), (สังคมศึกษา), (ประวัติศาสตร์), (พลศึกษา), (ศิลปะ), (การงานอาชีพ), (คอมพิวเตอร์เพิ่มเติม), (การงานอาชีพเพิ่มเติม), (ภาษาอังกฤษ), (ภาษาอังกฤษเพิ่มเติม) </p>
            <p> ซึ่งผลลัพธ์จากการสร้างแบบจำลองนั้นได้ "ค่าความแม่นยำ 81.78%" และจำนวนใบหรือจำนวนกฎได้ทั้งหมด "37 จำนวน" ดังนี้ </p>

            <img src="decision-tree.png">
            <p class="photo"> ภาพต้นไม้ตัดสินใจจากการสร้างแบบจำลอง </p>
        </section>
    </div>
    
    <div class="translate-rule" id="rule-section">
        <h4> การแปลความหมายของกฎ </h4>
        <table id="rule">
            <thead>
                <tr>
                    <th> # </th>
                    <th> กฎที่ได้จากโปรแกรม Weka </th>
                    <th> แปลความหมายของกฎ </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> 1 </td>
                    <td> IF ENG = C+_B AND PE = D_D+_C AND social = C+_B THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 1, 1.5 หรือ 2 และ วิชาสังคมศึกษาได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 2 </td>
                    <td> IF ENG = C+_B AND PE = D_D+_C AND social = D_D+_C THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 1, 1.5 หรือ 2 และ วิชาสังคมศึกษาได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 3 </td>
                    <td> IF ENG = C+_B AND PE = D_D+_C AND social = B+_A THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ พลศึกษาได้เกรด 1, 1.5 หรือ 2 และ สังคมศึกษาได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 4 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = D _D+_C THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 5 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = C+_B AND work = C+_B TNEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 6 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = C+_B AND work = B+_A AND ENG_add = B+_A THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 3.5 หรือ 4 และ วิชาภาษาอังกฤษเพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 7 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = C+_B AND work = B+_A AND ENG_add = C+_B THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 3.5 หรือ 4 และ วิชาภาษาอังกฤษเพิ่มเติมได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 8 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = C+_B AND work = B+_A AND ENG_add = D_D+_C THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 3.5 หรือ 4 และ วิชาภาษาอังกฤษเพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 9 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = C+_B AND work = D_D+_C THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 10 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = B+_A AND sci_calculate = C+_B THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 11 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = B+_A AND sci_calculate = B+_A THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 12 </td>
                    <td> IF ENG = C+_B AND PE = B+_A AND history = B+_A AND sci_calculate = D_D+_C THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 13 </td>
                    <td> IF ENG = C+_B AND PE = C+_B AND sci_calculate = C+_B AND computer = D_D+_C THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 14 </td>
                    <td> IF ENG = C+_B AND PE = C+_B AND sci_calculate = C+_B AND computer = C+_B THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 15 </td>
                    <td> IF ENG = C+_B AND PE = C+_B AND sci_calculate = C+_B AND computer = B+_A THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 16 </td>
                    <td> IF ENG = C+_B AND PE = C+_B AND sci_calculate = B+_A AND sci = D_D+_C THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 17 </td>
                    <td> IF ENG = C+_B AND PE = C+_B AND sci_calculate = B+_A AND sci = C+_B THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์ได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 18 </td>
                    <td> IF ENG = C+_B AND PE = C+_B AND sci_calculate = B+_A AND sci = B+_A THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์ได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 19 </td>
                    <td> IF ENG = C+_B AND PE = C+_B AND sci_calculate = D_D+_C THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 20 </td>
                    <td> IF ENG = B+_A AND TH = C+_B THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 21 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = D_D+_C THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 22 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = C+_B AND sci_calculate = C+_B THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 23 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = C+_B AND sci_calculate = B+_A AND computer = D_D+_C THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 24 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = C+_B AND sci_calculate = B+_A AND computer = C+_B THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้แกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 25 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = C+_B AND sci_calculate = B+_A AND computer = B+_A THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 26 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = C+_B AND sci_calculate = D_D+_C THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 27 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = B+_A AND computer = D_D+_C THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 28 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = B+_A AND computer = C+_B THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 29 </td>
                    <td> IF ENG = B+_A AND TH = B+_A AND math = B+_A AND computer = B+_A THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 30 </td>
                    <td> IF ENG = B+_A AND TH = D_D+_C THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 31 </td>
                    <td> IF ENG = D_D+_C AND sci_calculate = C+_B THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 32 </td>
                    <td> IF ENG = D_D+_C AND sci_calculate = B+_A THEN High </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง </td>
                </tr>
                <tr>
                    <td> 33 </td>
                    <td> IF ENG = D_D+_C AND sci_calculate = D_D+_C AND work_add = B+_A THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 34 </td>
                    <td> IF ENG = D_D+_C AND sci_calculate = D_D+_C AND work_add = C+_B AND history = D_D+_C THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 2.5 หรือ 3 และ วิชาประวัติศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 35 </td>
                    <td> IF ENG = D_D+_C AND sci_calculate = D_D+_C AND work_add = C+_B AND history = C+_B THEN Medium </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 2.5 หรือ 3 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง </td>
                </tr>
                <tr>
                    <td> 36 </td>
                    <td> IF ENG = D_D+_C AND sci_calculate = D_D+_C AND work_add = C+_B AND history = B+_A THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 2.5 หรือ 3 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
                <tr>
                    <td> 37 </td>
                    <td> IF ENG = D_D+_C AND sci_calculate = D_D+_C AND work_add = D_D+_C THEN Low </td>
                    <td> ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer-bottom py-4">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="address">
                    <I4> 191 หมู่ที่ 3 ตำบลหนองนกทา อำเภอเขมราฐ </I4>
                    <I4> สพป.อุบลราชธานี เขต 2 </I4>
                </div>
                
                <div class="copy">
                    <ul><li> &copy; 2024 | โรงเรียนบ้านนายูง </li></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript สำหรับเลื่อนหน้า -->
    <script>
        document.getElementById('scroll-to-tree').addEventListener('click', function(event) {
            event.preventDefault(); // ป้องกันการทำงานปกติของลิงก์
            document.getElementById('tree-section').scrollIntoView({ behavior: 'smooth' }); // ให้การเลื่อนเป็นไปอย่างราบรื่น
        });
    </script>
</body>
</html>