<?php

require_once "../dbcon.php";
require_once "../utils/utils.php";

$stmt_del = $conn->prepare("DELETE FROM Student WHERE StudentID = ?");

$student_id = $_GET["StudentId"];

$stmt_del->bind_param("s", $student_id);

if($stmt_del->execute()) {
    send_response(true, "Removed student entry successfully");
}
?>


