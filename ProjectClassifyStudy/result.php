<?php
    session_start();
    include('server.php');
    $errors = array();

    if ($selected_grade = isset($_POST['selected_grade']) ? $_POST['selected_grade'] : ''); {
        $grade_array = explode(',', $selected_grade);
        // รับค่าจากฟอร์ม
        $TH = isset($_POST['TH']) ? (float)$_POST['TH'] : null;
        $math = isset($_POST['math']) ? (float)$_POST['math'] : null;
        $sci = isset($_POST['sci']) ? (float)$_POST['sci'] : null;
        $sci_calculate = isset($_POST['sci_calculate']) ? (float)$_POST['sci_calculate'] : null;
        $social = isset($_POST['social']) ? (float)$_POST['social'] : null;
        $history = isset($_POST['history']) ? (float)$_POST['history'] : null;
        $PE = isset($_POST['PE']) ? (float)$_POST['PE'] : null;
        $work = isset($_POST['work']) ? (float)$_POST['work'] : null;
        $computer = isset($_POST['computer']) ? (float)$_POST['computer'] : null;
        $work_add = isset($_POST['work_add']) ? (float)$_POST['work_add'] : null;
        $ENG = isset($_POST['ENG']) ? (float)$_POST['ENG'] : null;
        $ENG_add = isset($_POST['ENG_add']) ? (float)$_POST['ENG_add'] : null;
    }
    
    // เงื่อนไขวิเคราะห์กลุ่มตามที่กำหนด
    // กฎข้อที่ 1
    if (($ENG == 2.5 || $ENG == 3) && ($PE == 1 || $PE == 1.5 || $PE == 2) && ($social == 2.5 || $social == 3)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($history == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 1: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 1;
        
        // กฎข้อที่ 2
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 1 || $PE == 1.5 || $PE == 2) && ($social == 1 || $social == 1.5 || $social == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($history == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 2: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 2;

        // กฎข้อที่ 3
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 1 || $PE == 1.5 || $PE == 2) && ($social == 3.5 || $social == 4)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($history == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 3: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 3;

        // กฎข้อที่ 4
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 1 || $history == 1.5 || $history == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 4: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 4;

        // กฎข้อที่ 5
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 2.5 || $history == 3) && ($work == 2.5 || $work == 3)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 5: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 5;

        // กฎข้อที่ 6
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 2.5 || $history == 3) && ($work == 3.5 || $work == 4) && ($ENG_add == 3.5 || $ENG_add == 4)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($computer == null) && ($work_add == null)) {
        $tree = "จากต้นไม้กฎที่ 6: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 6;

        // กฎข้อที่ 7
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 2.5 || $history == 3) && ($work == 3.5 || $work == 4) && ($ENG_add == 2.5 || $ENG_add == 3)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($computer == null) && ($work_add == null)) {
        $tree = "จากต้นไม้กฎที่ 7: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 7;

        // กฎข้อที่ 8
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 2.5 || $history == 3) && ($work == 3.5 || $work == 4) && ($ENG_add == 1 || $ENG_add == 1.5 || $ENG_add == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($computer == null) && ($work_add == null)) {
        $tree = "จากต้นไม้กฎที่ 8: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 8;

        // กฎข้อที่ 9
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 2.5 || $history == 3) && ($work == 1 || $work == 1.5 || $work == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 9: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 9;

        // กฎข้อที่ 10
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 3.5 || $history == 4) && ($sci_calculate == 2.5 || $sci_calculate == 3)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 10: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 10;

        // กฎข้อที่ 11
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 3.5 || $history == 4) && ($sci_calculate == 3.5 || $sci_calculate == 4)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 11: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 11;

        // กฎข้อที่ 12
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 3.5 || $PE == 4) && ($history == 3.5 || $history == 4) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 12: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 12;

        // กฎข้อที่ 13
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 2.5 || $PE == 3) && ($sci_calculate == 2.5 || $sci_calculate == 3) && ($computer == 1 || $computer == 1.5 || $computer == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($work == null)&& ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 13: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 13;

        // กฎข้อที่ 14
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 2.5 || $PE == 3) && ($sci_calculate == 2.5 || $sci_calculate == 3) && ($computer == 2.5 || $computer == 3)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($work == null)&& ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 14: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 14;

        // กฎข้อที่ 15
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 2.5 || $PE == 3) && ($sci_calculate == 2.5 || $sci_calculate == 3) && ($computer == 3.5 || $computer == 4)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($work == null)&& ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 15: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 15;

        // กฎข้อที่ 16
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 2.5 || $PE == 3) && ($sci_calculate == 3.5 || $sci_calculate == 4) && ($sci == 1 || $sci == 1.5 || $sci == 2)
        && ($TH == null) && ($math == null) && ($social == null) && ($history == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 16: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 16;

        // กฎข้อที่ 17
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 2.5 || $PE == 3) && ($sci_calculate == 3.5 || $sci_calculate == 4) && ($sci == 2.5 || $sci == 3)
        && ($TH == null) && ($math == null) && ($social == null) && ($history == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 17: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 17;

        // กฎข้อที่ 18
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 2.5 || $PE == 3) && ($sci_calculate == 3.5 || $sci_calculate == 4) && ($sci == 3.5 || $sci == 4)
        && ($TH == null) && ($math == null) && ($social == null) && ($history == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 18: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 18;

        // กฎข้อที่ 19
    } elseif (($ENG == 2.5 || $ENG == 3) && ($PE == 2.5 || $PE == 3) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 19: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 19;

        // กฎข้อที่ 20
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 2.5 || $TH == 3)
        && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 20: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 20;

        // กฎข้อที่ 21
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 1 || $math == 1.5 || $math == 2)
        && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 21: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 21;

        // กฎข้อที่ 22
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 2.5 || $math == 3) && ($sci_calculate == 2.5 || $sci_calculate == 3)
        && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 22: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 22;

        // กฎข้อที่ 23
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($sci_calculate == 3.5 || $sci_calculate == 4) && ($computer == 1 || $computer == 1.5 || $computer == 2)
        && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 23: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 23;

        // กฎข้อที่ 24
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 2.5 || $math == 3) && ($sci_calculate == 3.5 || $sci_calculate == 4) && ($computer == 2.5 || $computer == 3)
        && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 24: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 24;

        // กฎข้อที่ 25
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 2.5 || $math == 3) && ($sci_calculate == 3.5 || $sci_calculate == 4) && ($computer == 3.5 || $computer == 4)
        && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 25: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 25;

        // กฎข้อที่ 26
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 2.5 || $math == 3) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2)
        && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 26: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 26;

        // กฎข้อที่ 27
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 3.5 || $math == 4) && ($computer == 1 || $computer == 1.5 || $computer == 2)
        && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 27: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 27;

        // กฎข้อที่ 28
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 3.5 || $math == 4) && ($computer == 2.5 || $computer == 3)
        && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 28: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 28;

        // กฎข้อที่ 29
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 3.5 || $TH == 4) && ($math == 3.5 || $math == 4) && ($computer == 3.5 || $computer == 4)
        && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 29: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 29;

        // กฎข้อที่ 30
    } elseif (($ENG == 3.5 || $ENG == 4) && ($TH == 1 || $TH == 1.5 || $TH == 2)
        && ($math == null) && ($sci == null) && ($sci_calculate == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 30: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 30;

        // กฎข้อที่ 31
    } elseif (($ENG == 1 || $ENG == 1.5 || $ENG == 2) && ($sci_calculate == 2.5 || $sci_calculate == 3)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 31: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 31;

        // กฎข้อที่ 32
    } elseif (($ENG == 1 || $ENG == 1.5 || $ENG == 2) && ($sci_calculate == 3.5 || $sci_calculate == 4)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($work_add == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 32: ";
        $group = "คุณจัดอยู่ในกลุ่ม เก่ง";
        $rule_number = 32;

        // กฎข้อที่ 33
    } elseif (($ENG == 1 || $ENG == 1.5 || $ENG == 2) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2) && ($work_add == 3.5 || $work_add == 4)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 33: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 33;

        // กฎข้อที่ 34
    } elseif (($ENG == 1 || $ENG == 1.5 || $ENG == 2) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2) && ($work_add == 2.5 || $work_add == 3) && ($history == 1 || $history == 1.5 || $history == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($PE == null) && ($work == null) && ($computer == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 34: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 34;

        // กฎข้อที่ 35
    } elseif (($ENG == 1 || $ENG == 1.5 || $ENG == 2) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2) && ($work_add == 2.5 || $work_add == 3) && ($history == 2.5 || $history == 3)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($PE == null) && ($work == null) && ($computer == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 35: ";
        $group = "คุณจัดอยู่ในกลุ่ม ปานกลาง";
        $rule_number = 35;

        // กฎข้อที่ 36
    } elseif (($ENG == 1 || $ENG == 1.5 || $ENG == 2) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2) && ($work_add == 2.5 || $work_add == 3) && ($history == 3.5 || $history == 4)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($PE == null) && ($work == null) && ($computer == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 36: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 36;

        // กฎข้อที่ 37
    } elseif (($ENG == 1 || $ENG == 1.5 || $ENG == 2) && ($sci_calculate == 1 || $sci_calculate == 1.5 || $sci_calculate == 2) && ($work_add == 1 || $work_add == 1.5 || $work_add == 2)
        && ($TH == null) && ($math == null) && ($sci == null) && ($social == null) && ($history == null) && ($PE == null) && ($work == null) && ($computer == null) && ($ENG_add == null)) {
        $tree = "จากต้นไม้กฎที่ 37: ";
        $group = "คุณจัดอยู่ในกลุ่ม อ่อน";
        $rule_number = 37;
        
        // ไม่มีในกฎ
    } else {
        $tree = "";
        $group = "ไม่พบข้อมูลที่ตรงกับกฎการจําแนก";
    }

    $suggestions = "";
    if (isset($rule_number)) {
        $sql_suggestion = "SELECT suggest_id,rule_number, suggest_text FROM suggest WHERE rule_number = $rule_number"; 
        $result_suggestion = mysqli_query($conn, $sql_suggestion);
        $row = mysqli_fetch_assoc($result_suggestion);
        
        if ($row && $row['rule_number'] == $rule_number) {
            $suggestions = htmlspecialchars($row['suggest_text']);
        } else {
            $suggestions = ""; // กรณีที่ไม่พบ rule_number
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> result </title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1> ผลการวิเคราะห์ </h1>
        <p><strong><?php echo $tree; ?></strong><?php echo $group; ?></p>

        <!-- แสดงคำแนะนำจากฐานข้อมูล -->
        <p><strong> คำแนะนำ: </strong><?php echo $suggestions; ?></p>
        <a href="index.php" class="btn-result"> ย้อนกลับ </a>
    </div>
</body>
</html>