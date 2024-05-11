<?php

// TODO: Integrity check for when updating StudentID(BCID)

require_once "../dbcon.php";
require_once "../utils.php";

$student_id = $_GET["id"];
$bcid = $_GET["bcid"];

function gen_studentID($sql_conn, $bcid) {
    $q_get_student_count = "WITH CurYear AS (
            SELECT YEAR(CURDATE()) as current_year
        )
        SELECT CurYear.*, StudentInfo.*
        FROM (
            SELECT StudentID
            FROM Student
            WHERE BCID = '$bcid' AND YOA = YEAR(CURDATE())
        ) AS StudentInfo
        RIGHT JOIN CurYear ON 1=1
        ORDER BY StudentID DESC LIMIT 1";

    $result = try_query($sql_conn, $q_get_student_count);

    if (!($result instanceof mysqli_result)) {
        $sql_conn->close();
        send_response(false, $result["err_msg"], $result["strace"]);
        exit();
    }

    $rinfo = $result->fetch_row();

    /* assign 1 no data exists
     * else assign 1 + serial no. of the last student
     */
    $serial_no = $rinfo[1] == null ? 1 : intval(substr($rinfo[1], -2)) + 1;
    $year = $rinfo[0];

    $result->free();

    return $year . $bcid . sprintf("%02d", $serial_no);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["st_name"];
    $addr = $_POST["st_addr"];
    $dob = $_POST["st_dob"];
    $phno = $_POST["st_phno"];
    $course_id = $_POST["st_course"];
    $branch_id = $_POST["st_branch"];
}

$q_fetch_bcid = "SELECT BCID FROM BranchToCourse WHERE CourseID = '$course_id' AND BranchID = '$branch_id'";

$result = try_query($conn, $q_fetch_bcid);

if (!($result instanceof mysqli_result)) {
    $conn->close();
    send_response(false, $result["err_msg"]);
    exit();
}

if ($result->num_rows == 1) {
    try {
        $stmt_update = $conn->prepare(
            "UPDATE Student
            SET StudentID = ?, Name = ?, DOB = ?, Address = ?, PhoneNo = ?, BCID = ?
            WHERE StudentID = ?",
        );
    } catch (mysqli_sql_exception $e) {
        send_response(
            false,
            "Error executing query(check logs)",
            $e->getTrace(),
        );
        exit();
    }

    $new_bcid = $result->fetch_assoc()["BCID"];

    if ($new_bcid !== $bcid) {
        $new_student_id = gen_studentID($conn, $new_bcid);
    } else {
        $new_student_id = $student_id;
    }

    $stmt_update->bind_param(
        "sssssss",
        $new_student_id,
        $name,
        $dob,
        $addr,
        $phno,
        $new_bcid,
        $student_id,
    );

    // Need exception handling
    if ($stmt_update->execute()) {
        send_response(true, "Student info updated successfully");
    }
} else {
    send_response(false, "No BCID found for the selected course and branch");
}
?>
