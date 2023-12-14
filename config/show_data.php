<?php
// ฟังก์ชั่นเพื่อดึงข้อมูลครูจากฐานข้อมูล
function getTeacher($conn) {
    try {
        $teacherQuery = $conn->prepare("SELECT T_ID, T_fname,T_lname FROM teacher");
        $teacherQuery->execute();
        // ดึงข้อมูลทั้งหมดแบบ associative array
        $result = $teacherQuery->fetchAll(PDO::FETCH_ASSOC);

        // คืนค่าข้อมูลครู
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getuserS($conn, $username) {
    try {
        // กำหนดคำสั่ง SQL
        $sql = "SELECT student.* ,teacher.T_fname,teacher.T_lname FROM student 
         INNER JOIN teacher ON student.T_ID = teacher.T_ID
         WHERE S_username = :S_username";

        // ใช้ PDO statement เพื่อประมวลผลคำสั่ง SQL
        $stmt = $conn->prepare($sql);
        // กำหนดค่า parameter
        $stmt->bindParam(':S_username', $username);

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // ดึงข้อมูลแบบ associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getuserT($conn, $username) {
    try {
        // กำหนดคำสั่ง SQL
        $sql = "SELECT * FROM teacher WHERE T_username = :T_username ";

        // ใช้ PDO statement เพื่อประมวลผลคำสั่ง SQL
        $stmt = $conn->prepare($sql);
        // กำหนดค่า parameter
        $stmt->bindParam(':T_username', $username);

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // ดึงข้อมูลแบบ associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getmajor($conn) {
    try {
        // กำหนดคำสั่ง SQL
        $sql = "SELECT * FROM major ";

        // ใช้ PDO statement เพื่อประมวลผลคำสั่ง SQL
        $stmt = $conn->prepare($sql);
        // กำหนดค่า parameter
//        $stmt->bindParam(':S_username', $username);

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // ดึงข้อมูลแบบ associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getstudenall($conn) {
    try {
        $sqlS = "SELECT student.*, teacher.T_fname, teacher.T_lname 
         FROM student
         INNER JOIN teacher ON student.T_ID = teacher.T_ID";
        $stmtS = $conn->prepare($sqlS);
        $stmtS->execute();
        $result = $stmtS->fetchAll(PDO::FETCH_ASSOC);
        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getteacherall($conn) {
    try {
        $sqlT = "SELECT * FROM teacher WHERE T_status = 0";
        $stmtT = $conn->prepare($sqlT);
        $stmtT->execute();
        $result = $stmtT->fetchAll(PDO::FETCH_ASSOC);
        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getroomall($conn) {
    try {
        $sqlRoom = "SELECT room.*,student.S_fname,student.S_lname,teacher.T_fname ,teacher.T_lname,student.S_enrollment_year
            FROM room
            LEFT JOIN student ON room.R_ID = student.R_ID
            LEFT JOIN teacher ON room.R_ID = teacher.R_ID
                                                ";

        $stmtRoom = $conn->prepare($sqlRoom);
        $stmtRoom->execute();

        // เก็บผลลัพธ์ในตัวแปร $result
        $result = $stmtRoom->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getroom($conn,$R_ID) {
    try {
        $sql = "SELECT room.*, student.S_fname,student.S_lname,
       student.S_major, student.S_ID, teacher.T_fname,teacher.T_lname
            FROM room
            LEFT JOIN student ON room.R_ID = student.R_ID
            LEFT JOIN teacher ON room.R_ID = teacher.R_ID
            WHERE room.R_ID = $R_ID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }


}
function getroomToRID($conn, $R_ID,$search = '') {
    try {
        $sql = "SELECT room.*, student.S_fname, student.S_lname, student.S_major, student.S_ID, student.S_enrollment_year, teacher.T_fname, teacher.T_lname
            FROM room
            LEFT JOIN student ON room.R_ID = student.R_ID
            LEFT JOIN teacher ON student.T_ID = teacher.T_ID
            WHERE room.R_ID = :R_ID";

        // เพิ่มเงื่อนไขค้นหาจากชื่อนักศึกษา
        if (!empty($search)) {
            $sql .= " AND student.S_fname LIKE :search OR student.S_enrollment_year LIKE :search";
        }

        $sql .= " ORDER BY R_room ASC";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':R_ID', $R_ID, PDO::PARAM_INT);

        // ผูกค่าค้นหาจากชื่อนักศึกษา
        if (!empty($search)) {
            $searchParam = '%' . $search . '%';
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getstudentToID($conn, $ID, $search = '') {
    try {
        // SQL query เริ่มต้น
        $sql = "SELECT student.*, student.S_fname, student.S_lname, student.S_major, student.S_ID, teacher.T_fname, teacher.T_lname, room.*
            FROM student
            LEFT JOIN teacher ON student.T_ID = teacher.T_ID
            LEFT JOIN room ON student.R_ID = room.R_ID
            WHERE student.T_ID = :ID";

        // เพิ่มเงื่อนไขค้นหาจากชื่อและนามสกุลของนักศึกษา
        if (!empty($search)) {
            $sql .= " AND student.S_fname LIKE :search OR student.S_lname LIKE :search";
        }

        // SQL query ส่วนท้าย
        $sql .= " ORDER BY student.S_ID ASC";

        // เตรียมและ execute SQL statement
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);

        // ผูกค่าค้นหาจากชื่อและนามสกุล
        if (!empty($search)) {
            $searchParam = '%' . $search . '%';
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->execute();
        // ดึงข้อมูลผลลัพธ์
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
        return false;
    }
}

function getcompanyall($conn) {
    try {
        $sql = "SELECT * FROM company";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getcompany($conn,$company_ID) {
    try {
        $sql = "SELECT * FROM company WHERE company_ID = $company_ID ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getstudent($conn,$S_ID) {
    try {
        $sqlS = "SELECT student.*, teacher.T_fname, teacher.T_lname 
         FROM student
         INNER JOIN teacher ON student.T_ID = teacher.T_ID
         WHERE S_ID = $S_ID";
        $stmtS = $conn->prepare($sqlS);
        $stmtS->execute();
        $result = $stmtS->fetch(PDO::FETCH_ASSOC);
        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getTeachers($conn,$T_ID) {
    try {
        $sql = "SELECT * FROM teacher
            WHERE teacher.T_ID = $T_ID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getCompanyToPetition($conn)
{
    try {
            $sql = "SELECT * FROM company ORDER BY timestamp_company DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (แสดงข้อความหรือทำอย่างอื่น)
        echo "Error: " . $e->getMessage();
        return false;
    }
}
function getrequest($conn,$S_ID) {
    try {
        $sql = "SELECT * FROM request WHERE S_ID = $S_ID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }

}
function getselect($conn) {
    // สร้าง SQL query เพื่อดึงข้อมูล
    $sqlRoomID = "SELECT DISTINCT R_ID FROM room";
    $sqlLevel = "SELECT DISTINCT R_level FROM room";
    $sqlLevelNumber = "SELECT DISTINCT R_level_numder FROM room";
    $sqlRoom = "SELECT DISTINCT R_room FROM room";

// ประมวลผลและแสดงผล Room ID
    $resultRoomID = $conn->query($sqlRoomID);
    $optionsRoomID = '';
    foreach ($resultRoomID as $row) {
        $optionsRoomID .= '<option value="' . $row['R_ID'] . '">' . $row['R_ID'] . '</option>';
    }


// ประมวลผลและแสดงผล Level
    $resultLevel = $conn->query($sqlLevel);
    $optionsLevel = '';
    foreach ($resultLevel as $row) {
        $optionsLevel .= '<option value="' . $row['R_level'] . '">' . $row['R_level'] . '</option>';
    }

// ประมวลผลและแสดงผล Level Number
    $resultLevelNumber = $conn->query($sqlLevelNumber);
    $optionsLevelNumber = '';
    foreach ($resultLevelNumber as $row) {
        $optionsLevelNumber .= '<option value="' . $row['R_level_numder'] . '">' . $row['R_level_numder'] . '</option>';
    }

// ประมวลผลและแสดงผล Room
    $resultRoom = $conn->query($sqlRoom);
    $optionsRoom = '';
    foreach ($resultRoom as $row) {
        $optionsRoom .= '<option value="' . $row['R_room'] . '">' . $row['R_room'] . '</option>';
    }
    return array($optionsRoomID,$optionsLevel,$optionsLevelNumber,$optionsRoom);
}

//function getrequestallTOH($conn,$T_ID){
//    try {
//        $sql = "SELECT request.*, student.S_fname ,student.T_ID, student.S_lname,student.S_img
//                        , company.C_name , company.C_img, company.C_tambon, company.C_amphoe,company.C_province   FROM request
//        INNER JOIN student ON student.S_ID = request.S_ID
//        INNER JOIN company ON company.company_ID = request.company_ID
//        WHERE request.RE_teacher_opinion = '1' OR student.T_ID = $T_ID
//        ORDER BY timestamp_request";
//        $stmt = $conn->prepare($sql);
//        $stmt->execute();
//        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//        foreach ($result as $key => $row) {
//            $dateRangeArray = explode(" - ", $row['RE_period']);
//            // ดึงวันที่เริ่มต้นและวันที่สิ้นสุดจากอาร์เรย์
//            $startDateString = $dateRangeArray[0];
//            $endDateString = $dateRangeArray[1];
//            // แปลงวันที่เป็นรูปแบบที่ใช้งานได้กับ DateTime
//            $startDate = DateTime::createFromFormat('d/m/Y', $startDateString);
//            $endDate = DateTime::createFromFormat('d/m/Y', $endDateString);
//            // คำนวณจำนวนเดือน
//            $interval = $startDate->diff($endDate);
//            $months = ($interval->y * 12) + $interval->m;
//
//            // เพิ่ม key 'months' เข้าไปใน $result
//            $result[$key]['months'] = $months;
//        }
//
//        // ส่งข้อมูลกลับ
//        return $result;
//    } catch (PDOException $e) {
//        // จัดการข้อผิดพลาด (ถ้ามี)
//        echo "Error: " . $e->getMessage();
//        return false;
//    }
//}
function getrequestTOTeacher($conn, $T_ID, $search = ''){
    try {
        $sql = "SELECT request.*, student.S_fname, student.S_lname, student.S_img,
                        company.C_name, company.C_img, company.C_tambon, company.C_amphoe, company.C_province
                FROM request 
                INNER JOIN student ON student.S_ID = request.S_ID
                INNER JOIN company ON company.company_ID = request.company_ID
                WHERE student.T_ID = :T_ID AND request.RE_teacherH_opinion = '' OR request.RE_teacher_opinion = '0'";

        // เพิ่มเงื่อนไขค้นหา (ตัวอย่าง: ค้นหาจากชื่อบริษัท)
        if (!empty($search)) {
            $sql .= " AND company.C_name LIKE :search";
        }

        $sql .= " ORDER BY timestamp_request";

        $stmt = $conn->prepare($sql);

        // ผูกค่า T_ID
        $stmt->bindParam(':T_ID', $T_ID, PDO::PARAM_INT);

        // ผูกค่าค้นหาถ้ามี
        if (!empty($search)) {
            $searchParam = '%' . $search . '%';
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $row) {
            $dateRangeArray = explode(" - ", $row['RE_period']);
            // ดึงวันที่เริ่มต้นและวันที่สิ้นสุดจากอาร์เรย์
            $startDateString = $dateRangeArray[0];
            $endDateString = $dateRangeArray[1];
            // แปลงวันที่เป็นรูปแบบที่ใช้งานได้กับ DateTime
            $startDate = DateTime::createFromFormat('d/m/Y', $startDateString);
            $endDate = DateTime::createFromFormat('d/m/Y', $endDateString);
            // คำนวณจำนวนเดือน
            $interval = $startDate->diff($endDate);
            $months = ($interval->y * 12) + $interval->m;

            // เพิ่ม key 'months' เข้าไปใน $result
            $result[$key]['months'] = $months;
        }

        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }
}

//ฟังชั่นแสดงคำร้องขอที่ผ่านอนุมัติของครูที่ปรึกษาและ+เพิ่มค้นหาข้อมูล
function getrequestallTOHsearch($conn, $T_ID, $searchKeyword = '') {
    try {
        $sql = "SELECT request.*, student.S_fname, student.T_ID, student.S_lname, student.S_img, company.C_name, company.C_img, company.C_tambon, company.C_amphoe, company.C_province FROM request 
        INNER JOIN student ON student.S_ID = request.S_ID
        INNER JOIN company ON company.company_ID = request.company_ID
        WHERE (request.RE_teacher_opinion = '1' OR student.T_ID = :T_ID)";

        // เพิ่มเงื่อนไขค้นหา (ตัวอย่าง: ค้นหาจากชื่อนักศึกษา)
        if (!empty($searchKeyword)) {
            $sql .= " AND (student.S_fname LIKE :searchKeyword OR student.S_lname LIKE :searchKeyword OR company.C_name LIKE :searchKeyword)";
        }

        $sql .= " ORDER BY timestamp_request";

        $stmt = $conn->prepare($sql);

        // ผูกค่า T_ID
        $stmt->bindParam(':T_ID', $T_ID, PDO::PARAM_INT);

        // ผูกค่าค้นหาถ้ามี
        if (!empty($searchKeyword)) {
            $searchParam = '%' . $searchKeyword . '%';
            $stmt->bindParam(':searchKeyword', $searchParam, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $row) {
            $dateRangeArray = explode(" - ", $row['RE_period']);
            // ดึงวันที่เริ่มต้นและวันที่สิ้นสุดจากอาร์เรย์
            $startDateString = $dateRangeArray[0];
            $endDateString = $dateRangeArray[1];
            // แปลงวันที่เป็นรูปแบบที่ใช้งานได้กับ DateTime
            $startDate = DateTime::createFromFormat('d/m/Y', $startDateString);
            $endDate = DateTime::createFromFormat('d/m/Y', $endDateString);
            // คำนวณจำนวนเดือน
            $interval = $startDate->diff($endDate);
            $months = ($interval->y * 12) + $interval->m;

            // เพิ่ม key 'months' เข้าไปใน $result
            $result[$key]['months'] = $months;
        }

        // ส่งข้อมูลกลับ
        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด (ถ้ามี)
        echo "Error: " . $e->getMessage();
        return false;
    }
}



?>

