<?php
    // กำหนดข้อมูลการเชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_classify_study";

    // สร้างการเชื่อมต่อ
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // เชื่อมต่อกับฐานข้อมูล
    $conn = mysqli_connect("localhost", "root", "", "project_classify_study");
    if (!$conn) {
        die("การเชื่อมต่อล้มเหลว: " . mysqli_connect_error());
    }
?>