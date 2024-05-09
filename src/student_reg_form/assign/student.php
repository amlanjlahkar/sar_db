<?php

function try_query($sql_conn, $q) {
    try {
        $result = $sql_conn->query($q);
    } catch (mysqli_sql_exception $e) {
        $result = [
            "err_msg" => "Error executing query(check logs)",
            "strace" => $e->getTrace(),
        ];
    } finally {
        return $result;
    }
}

function send_response($success, $msg, $strace = null) {
    $resp = [
        "success" => $success,
        "msg" => $msg,
        "strace" => $strace ?? null,
    ];
    header("Content-Type: application/json");
    echo json_encode($resp);
}

function gen_studentID($sql_conn, $bcid) {
    $q_get_student_count = "SELECT YOA FROM Student WHERE BCID = '$bcid' AND YOA = YEAR(CURDATE())";

    $result = try_query($sql_conn, $q_get_student_count);

    if (!($result instanceof mysqli_result)) {
        $sql_conn->close();
        send_response(false, $result["err_msg"], $result["strace"]);
        exit();
    }

    $serial_no = $result->num_rows + 1;
    $year = $result->fetch_column(0);

    $result->free();

    return $year . $bcid . sprintf("%02d", $serial_no);
}

function is_duplicate_phno($sql_conn, $phno) {
    $q_get_no = "SELECT PhoneNo FROM Student WHERE PhoneNo = '$phno'";

    $result = try_query($sql_conn, $q_get_no);

    return $result instanceof mysqli_result ? $result->num_rows > 0 : $result;
}

require_once "../../dbcon.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["st_name"];
    $addr = $_POST["st_addr"];
    $dob = $_POST["st_dob"];
    $phno = $_POST["st_phno"];
    $course_id = $_POST["st_course"];
    $branch_id = $_POST["st_branch"];

    $result = is_duplicate_phno($conn, $phno);

    if (!is_bool($result) || $result === true) {
        $conn->close();
        $err_msg = is_bool($result)
            ? "Phone No. is already taken"
            : $result["err_msg"];
        send_response(false, $err_msg, $result["strace"] ?? null);
        exit();
    }

    $q_fetch_cbid = "SELECT BCID FROM BranchToCourse WHERE CourseID = '$course_id' AND BranchID = '$branch_id'";

    $result = try_query($conn, $q_fetch_cbid);

    if (!($result instanceof mysqli_result)) {
        $conn->close();
        send_response(false, $result["err_msg"]);
        exit();
    }

    if ($result->num_rows == 1) {
        try {
            $stmt_insert = $conn->prepare(
                "INSERT INTO Student(StudentID, Name, DOB, Address, PhoneNo, BCID) VALUES (?, ?, ?, ?, ?, ?)",
            );
        } catch (mysqli_sql_exception $e) {
            send_response(false, "Error executing query(check logs)", $e->getTrace());
            exit();
        }

        $bcid = $result->fetch_assoc()["BCID"];
        $student_id = gen_studentID($conn, $bcid);

        $stmt_insert->bind_param(
            "ssssss",
            $student_id,
            $name,
            $dob,
            $addr,
            $phno,
            $bcid,
        );

        if ($stmt_insert->execute()) {
            send_response(true, "Registered successfully");
        } else {
            send_response(false, "Error inserting data");
        }
    } else {
        send_response(
            false,
            "No BCID found for the selected course and branch",
        );
    }
}

?>
