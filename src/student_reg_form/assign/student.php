<?php

function gen_studentID($sql_conn, $cbid) {
    $q_get_student_count = "SELECT StudentID FROM Student WHERE CBID = '$cbid' AND YOA = YEAR(CURDATE())";
    $result = $sql_conn->query($q_get_student_count);

    $serial_no = $result->num_rows + 1;

    return $cbid . sprintf("%02d", $serial_no);
}

require_once "../../dbcon.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["st_name"];
    $addr = $_POST["st_addr"];
    $dob = $_POST["st_dob"];
    $phno = $_POST["st_phno"];
    $cid = $_POST["st_cid"];
    $bid = $_POST["st_bid"];

    $q_fetch_cbid = "SELECT CBID FROM CourseToBranch WHERE CourseID = '$cid' AND BranchID = '$bid'";
    $result = $conn->query($q_fetch_cbid);

    if ($result->num_rows == 1) {
        $cbid = $result->fetch_assoc()["CBID"];

        $sql_insert =
            "
            INSERT INTO Student (StudentID, Name, DOB, Address, PhoneNo, CBID)
                VALUES (CONCAT(YEAR(CURDATE()), '" .
            gen_studentID($conn, $cbid) .
            "'), '$name', '$dob', '$addr', '$phno', '$cbid')";

        if ($conn->query($sql_insert)) {
            echo "Data inserted successfully.";
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    } else {
        echo "No CBID found for the given course and branch.";
    }
}

?>
