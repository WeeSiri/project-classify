<?php
    session_start();
    include('server.php');
    $errors = array();

    // ตรวจสอบว่ามีการส่งแบบฟอร์มมา
    if (isset($_POST['insert'])) {
        $suggest = $_POST['suggest']; // รับค่าที่ผู้ใช้กรอก
        $rule_number = $_POST['rule_number']; // รับหมายเลขกฎจากฟอร์ม

        // ตรวจสอบว่าช่อง rule_number และ suggest ไม่ว่าง
        if (!empty($rule_number) && !empty($suggest)) {
            // เรียกใช้ฟังก์ชันเพิ่มคำแนะนำ
            $suggest_id = insertSuggest($suggest, $rule_number);

            if ($suggest_id) {
                echo "<script>
                        alert('เพิ่มกฎและคำแนะนำสำเร็จ!');
                        window.location.href = 'data_manage.php'; // เปลี่ยนเส้นทางไปยังหน้า data manage
                      </script>";
                exit;
            } else {
                echo "เกิดข้อผิดพลาดในการเพิ่มคำแนะนำ!";
            }
        } else {
            echo "กรุณากรอกข้อมูลให้ครบถ้วน!";
        }
    }

    // ฟังก์ชันสำหรับเพิ่มคำแนะนำ (Insert Suggest)
    function insertSuggest($suggest, $rule_number) {
        global $conn;
        $sql = "INSERT INTO suggest (suggest_text, rule_number) VALUES ('$suggest', '$rule_number')";
        if (mysqli_query($conn, $sql)) {
            return mysqli_insert_id($conn); // คืนค่า ID ของคำแนะนำที่เพิ่ม
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            return false;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> insert </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f8f8;
        }

        .equal-buttons {
            flex: 1;
            margin: 0 5px;
        } .button-container {
            display: flex;
            justify-content: space-between;
        }

        .mt-3 {
            margin-top: 1rem !important;
        } .alert-info {
            color: #03045E;
            background-color: #CAF0F8;
        } .alert {
            position: relative;
            padding: 1rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 10px;
        } select {
            color: #ADB5BD; /* สีเริ่มต้นเมื่อไม่ได้เลือกค่า */
        } select:focus {
            color: #000000; /* เมื่อคลิกแล้วให้เป็นสีดำ */
        } option[value=""] {
            color: #ADB5BD; /* สีสำหรับ option ที่ไม่มีค่า */
        } option:not([value=""]) {
            color: #000000; /* สีของตัวเลือกที่มีค่า */
        }

        
        textarea[name="suggest"] {
            color: #000000 !important;
        } textarea::placeholder {
            color: #ADB5BD;
            font-style: italic;
        }
    </style>

    <script>
        function showMessage() {
            var ruleNumber = document.getElementById("rule_number").value;
            var messages = {
                "1": "กฎข้อที่ 1 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 1, 1.5 หรือ 2 และ วิชาสังคมศึกษาได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "2": "กฎข้อที่ 2 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 1, 1.5 หรือ 2 และ วิชาสังคมศึกษาได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "3": "กฎข้อที่ 3 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ พลศึกษาได้เกรด 1, 1.5 หรือ 2 และ สังคมศึกษาได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "4": "กฎข้อที่ 4 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "5": "กฎข้อที่ 5 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "6": "กฎข้อที่ 6 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 3.5 หรือ 4 และ วิชาภาษาอังกฤษเพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "7": "กฎข้อที่ 7 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 3.5 หรือ 4 และ วิชาภาษาอังกฤษเพิ่มเติมได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "8": "กฎข้อที่ 8 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 3.5 หรือ 4 และ วิชาภาษาอังกฤษเพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "9": "กฎข้อที่ 9 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาการงานอาชีพได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "10": "กฎข้อที่ 10 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "11": "กฎข้อที่ 11 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "12": "กฎข้อที่ 12 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 3.5 หรือ 4 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "13": "กฎข้อที่ 13 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "14": "กฎข้อที่ 14 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "15": "กฎข้อที่ 15 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "16": "กฎข้อที่ 16 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "17": "กฎข้อที่ 17 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์ได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "18": "กฎข้อที่ 18 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์ได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "19": "กฎข้อที่ 19 ถ้า วิชาภาษาอังกฤษได้เกรด 2.5 หรือ 3 และ วิชาพลศึกษาได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "20": "กฎข้อที่ 20 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "21": "กฎข้อที่ 21 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "22": "กฎข้อที่ 22 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "23": "กฎข้อที่ 23 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "24": "กฎข้อที่ 24 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้แกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "25": "กฎข้อที่ 25 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "26": "กฎข้อที่ 26 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 2.5 หรือ 3 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "27": "กฎข้อที่ 27 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "28": "กฎข้อที่ 28 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "29": "กฎข้อที่ 29 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 3.5 หรือ 4 และ วิชาคณิตศาสตร์ได้เกรด 3.5 หรือ 4 และ วิชาคอมพิวเตอร์เพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "30": "กฎข้อที่ 30 ถ้า วิชาภาษาอังกฤษได้เกรด 3.5 หรือ 4 และ วิชาภาษาไทยได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "31": "กฎข้อที่ 31 ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "32": "กฎข้อที่ 32 ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มเก่ง",
                "33": "กฎข้อที่ 33 ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "34": "กฎข้อที่ 34 ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 2.5 หรือ 3 และ วิชาประวัติศาสตร์ได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "35": "กฎข้อที่ 35 ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 2.5 หรือ 3 และ วิชาประวัติศาสตร์ได้เกรด 2.5 หรือ 3 แล้ว จัดอยู่ในกลุ่มปานกลาง",
                "36": "กฎข้อที่ 36 ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 2.5 หรือ 3 และ วิชาประวัติศาสตร์ได้เกรด 3.5 หรือ 4 แล้ว จัดอยู่ในกลุ่มอ่อน",
                "37": "กฎข้อที่ 37 ถ้า วิชาภาษาอังกฤษได้เกรด 1, 1.5 หรือ 2 และ วิชาวิทยาศาสตร์คำนวณได้เกรด 1, 1.5 หรือ 2 และ วิชาการงานอาชีพเพิ่มเติมได้เกรด 1, 1.5 หรือ 2 แล้ว จัดอยู่ในกลุ่มอ่อน"
            };

            // แสดงข้อความตามหมายเลขกฎที่เลือก
            var message = messages[ruleNumber] || "ไม่พบกฎที่เลือก";
            document.getElementById("ruleDescription").innerText = message; // แสดงข้อความใน HTML
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5"> เพิ่มคำแนะนำ </h1>
        <hr>

        <form action="" method="post">
            <div class="mb-3">
                <label for="rule_number" class="form-label"> เลือกกฎข้อที่ </label>
                <select id="rule_number" name="rule_number" class="form-select" onchange="showMessage()" required>
                    <option value=""> -- กรุณาเลือก -- </option>
                    <?php for ($i = 1; $i <= 37; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>

                <div id="ruleDescription" class="alert alert-info mt-3"> โปรดเลือกหมายเลขกฎเพื่อดูรายละเอียด </div>
            </div>

            <!-- แสดงข้อความตามหมายเลขกฎที่เลือก -->
            <div id="message" class="mb-3" style="font-weight: bold; color: green;"></div>

            <div class="mb-3">
                <label for="suggest" class="form-label"> กรุณาพิมพ์รายละเอียดคำแนะนำ </label>
                <textarea name="suggest" cols="30" rows="6" class="form-control" placeholder="พิมพ์คำแนะนำที่นี่..." required></textarea>
            </div>
            <br>

            <div class="button-container">
                <button type="submit" name="insert" class="btn btn-success equal-buttons"> เพิ่ม </button>
                <a href="data_manage.php" class="btn btn-primary equal-buttons"> ย้อนกลับ </a>
            </div>
        </form>
    </div>
</body>
</html>