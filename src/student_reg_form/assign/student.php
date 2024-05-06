<?php

function gen_studentID($sql_conn, $cbid) {
    $q_get_student_count = "SELECT StudentID FROM Student WHERE BCID = '$cbid' AND YOA = YEAR(CURDATE())";
    $result = $sql_conn->query($q_get_student_count);

    $serial_no = $result->num_rows + 1;

    return $cbid . sprintf("%02d", $serial_no);
}

function is_duplicate_phno($sql_conn, $phno) {
    $q_get_no = "SELECT PhoneNo FROM Student WHERE PhoneNo = '$phno'";

    $result = $sql_conn->query($q_get_no);

    return $result->num_rows > 0;
}

function send_response($success, $msg) {
    $resp = array(
        "success" => $success,
        "msg" => $msg,
    );
    header("Content-Type: application/json");
    echo json_encode($resp);
}

require_once "../../dbcon.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["st_name"];
    $addr = $_POST["st_addr"];
    $dob = $_POST["st_dob"];
    $phno = $_POST["st_phno"];
    $cid = $_POST["st_cid"];
    $bid = $_POST["st_bid"];

    if (is_duplicate_phno($conn, $phno)) {
        send_response(false, "Phone No. is already taken");
        $conn->close();
        exit();
    }

    $q_fetch_cbid = "SELECT BCID FROM BranchToCourse WHERE CourseID = '$cid' AND BranchID = '$bid'";
    $result = $conn->query($q_fetch_cbid);

    if ($result->num_rows == 1) {
        $cbid = $result->fetch_assoc()["BCID"];

        $sql_insert =
            "
            INSERT INTO Student (StudentID, Name, DOB, Address, PhoneNo, BCID)
                VALUES (CONCAT(YEAR(CURDATE()), '" .
            gen_studentID($conn, $cbid) .
            "'), '$name', '$dob', '$addr', '$phno', '$cbid')";

        if ($conn->query($sql_insert)) {
            send_response(true, "Data inserted successfully");
        } else {
            send_response(false, "Error inserting data: " . $conn->error);
        }
    } else {
        send_response(false, "No BCID found for the given course and branch");
    }
}

?>
