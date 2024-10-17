<?php
    session_start();
    include('server.php');
    $errors = array();

    // กำหนดจำนวนข้อมูลต่อหน้า
    $results_per_page = 10;

    // ค้นหาจำนวนข้อมูลทั้งหมด
    $sql_total = "SELECT COUNT(*) AS total FROM suggest";
    $result_total = mysqli_query($conn, $sql_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total_records = $row_total['total'];

    // คำนวณจำนวนหน้าทั้งหมด
    $total_pages = ceil($total_records / $results_per_page);

    // ตรวจสอบว่าผู้ใช้เลือกหน้าไหน (เริ่มต้นที่หน้า 1)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // คำนวณตำแหน่งเริ่มต้นของข้อมูลในแต่ละหน้า
    $start_from = ($page - 1) * $results_per_page;

    // ดึงข้อมูลคำแนะนำจากฐานข้อมูล
    $sql = "SELECT suggest_text, suggest_id FROM suggest LIMIT $start_from, $results_per_page";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> data manage </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-size: 100%;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* ส่วนตัวของเว็บ */
        header.manage {
            background-color: #212529;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky; /* ทำให้ส่วนหัว "ติด" อยู่ที่ด้านบนของหน้าจอเมื่อเลื่อนลงมา */
            top: 0; /* ปรับค่าตรงนี้ให้ตรงกับความสูงของ header */
            z-index: 1000; /* ทำให้ส่วนหัวอยู่ด้านบนสุดเมื่อเลื่อน */
        } .content {
            display: flex;
            align-items: center;
        } .header-logo {
            margin-right: 20px;
        } .logo {
            width: 40px;
            height: auto;
            border: none;
            box-shadow: none;
        } .header-text-manage {
            display: flex;
            flex-direction: column;
            text-align: left;
        } .header-text-manage h1 {
            font-size: 1.2em;
            margin: 0;
            color: #ffffff;
        } .header-text-manage h2 {
            font-size: 0.9em;
            margin: 0;
            color: #ffffff;
        } .small-text {
            font-size: 0.8em;
            color: #bbbbbb;
            margin-top: 5px;
            text-align: center;
        } nav.manage {
            display: flex;
        } nav.manage ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        } nav.manage ul li {
            margin-left: 20px;
        } nav.manage ul li a {
            text-decoration: none;
            color: #ffffff;
            padding: 10px 15px;
            border-radius: 10px;
            transition: background-color 0.3s;
        } nav.manage ul li a:hover {
            background-color: #495057;
        }

        .table {
            --bs-table-bg: #ffffff;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            --bs-table-bg: #ffffff;
            --bs-table-striped-bg: #ffffff;
            border-color: #ced4da;
        }

        table { /* CSS สำหรับการจัดการตาราง */ /* กำหนดให้ตารางมีการจัดเรียงที่แน่นอน */
            table-layout: fixed; /* ใช้การจัดเรียงที่แน่นอน */
            width: 100%; /* ให้ตารางมีความกว้างเต็มที่ */
        }

        table thead th, table tbody td {
            text-align: center; /* จัดข้อความในเซลล์ให้อยู่ตรงกลาง */
            vertical-align: middle; /* จัดข้อความให้อยู่กึ่งกลางในแนวตั้ง */
        }

        table tbody td:first-child { /* คอลัมน์แรก (หมายเลข) ให้อยู่กลาง */
            text-align: center; /* กำหนดให้ข้อความในคอลัมน์แรกอยู่ตรงกลาง */
        }

        table tbody td:nth-child(2) { /* คอลัมน์ที่ 2 (คำแนะนำ) ชิดซ้าย */
            text-align: left; /* จัดเรียงคอลัมน์คำแนะนำให้ชิดซ้าย */
        }

        table td:nth-child(3), table td:nth-child(4), /* ปรับขนาดความกว้างของคอลัมน์ปุ่มลบและแก้ไข */
        table th:nth-child(3), table th:nth-child(4) {
            width: 100px; /* กำหนดความกว้างของคอลัมน์ปุ่มลบและแก้ไข */
        }

        table th:nth-child(2) {
            width: 100%; /* กำหนดความกว้างให้กับคอลัมน์คำแนะนำ */
        }

        table th:first-child, table td:first-child { /* กำหนดความกว้างของคอลัมน์ # */
            width: 60px; /* ปรับความกว้างของคอลัมน์หมายเลข */
        }

        .pagination { /* การแบ่งหน้า */
            display: flex;
            justify-content: center; /* จัดกลาง */
            align-items: center; /* จัดให้อยู่กลางแนวตั้ง */
            margin-top: 20px; /* ระยะห่างด้านบน */
        }

        .pagination .page-item {
            margin: 0 5px; /* ระยะห่างระหว่างปุ่ม */
        }

        .pagination .page-link {
            padding: 10px 15px; /* ขนาดปุ่ม */
            border: 1px solid #007bff; /* สีกรอบ */
            border-radius: 10px; /* มุมมน */
            color: #007bff; /* สีตัวอักษร */
            text-decoration: none; /* ไม่ให้ขีดเส้นใต้ */
            transition: background-color 0.3s; /* เพิ่มการเปลี่ยนแปลงเมื่อเลื่อนเมาส์ */
        }

        .pagination .page-link:hover {
            background-color: #007bff; /* สีพื้นหลังเมื่อเมาส์ชี้ */
            color: white; /* เปลี่ยนสีตัวอักษรเมื่อเมาส์ชี้ */
        }

        .pagination .active .page-link {
            background-color: #007bff; /* สีพื้นหลังสำหรับหน้า active */
            color: white; /* สีตัวอักษรสำหรับหน้า active */
            pointer-events: none; /* ไม่ให้คลิกหน้า active */
        }
    </style>
</head>
<body>
    <header class="manage">
        <div class="content-manage">
            <div class="header-logo-manage">
                <img src="logo.png" alt="Logo" class="logo">
            </div>

            <div class="header-text-manage">
                <h1> ระบบวิเคราะห์ผลการเรียนจากต้นไม้ตัดสินใจเพื่อจำแนกกลุ่มผู้เรียน </h1>
                <h2> โรงเรียนบ้านนายูง </h2>
            </div>
        </div>
        <nav class="manage">
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

    <div class="container mt-5">
        <h1 class="mt-5"> ข้อมูลคำแนะนำ </h1>
        <a href="insert.php" class="btn btn-success"> เพิ่ม </a>
        <hr>
        <table id="mytable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th> # </th>
                    <th> คำแนะนำ </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // แสดงข้อมูลในแต่ละหน้า
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo isset($row['suggest_id']) ? htmlspecialchars($row['suggest_id']) : 'ไม่มี'; ?></td>
                        <td><?php echo htmlspecialchars($row['suggest_text']); ?></td>
                        <td><a href="update.php?suggest_id=<?php echo isset($row['suggest_id']) ? $row['suggest_id'] : ''; ?>" class="btn btn-warning"> แก้ไข </a></td>
                        <td><a href="delete.php?suggest_id=<?php echo $row['suggest_id']; ?>" class="btn btn-danger"> ลบ </a></td>
                    </tr>
                <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'> ยังมีไม่มีข้อมูล </td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        <ul class="pagination">
            <!-- ปุ่มย้อนกลับไปหน้าแรก -->
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="data_manage.php?page=1"> &laquo; </a>
                </li>
            <?php endif; ?>
            
            <!-- ลูปสำหรับแสดงหมายเลขหน้า -->
            <?php
                // ตั้งค่าจำนวนหน้าที่จะแสดง
                $max_links = 5;
                
                // คำนวณช่วงของหน้า
                $start_page = max(1, $page - floor($max_links / 2));
                $end_page = min($total_pages, $start_page + $max_links - 1);
                
                // ปรับค่า $start_page ใหม่ถ้า $end_page มีจำนวนหน้าไม่ถึง $max_links
                if ($end_page - $start_page + 1 < $max_links) {
                    $start_page = max(1, $end_page - $max_links + 1); // เลื่อนการแสดงกลับไปให้ครบ $max_links
                }
                
                // แสดงหน้าตามช่วงที่คำนวณได้
                for ($i = $start_page; $i <= $end_page; $i++) {
                    // เพิ่มคลาส 'active' ให้กับหน้าปัจจุบัน
                    echo "<li class='page-item " . ($i == $page ? "active" : "") . "'><a class='page-link' href='data_manage.php?page=" . $i . "'>" . $i . "</a></li>";
                }
            ?>
            
            <!-- ปุ่มไปหน้าสุด -->
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="data_manage.php?page=<?php echo $total_pages; ?>"> &raquo; </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>