<?php
require_once "../../dbcon.php";

$courseID = $_GET["courseID"];

$q_cb_info = "SELECT b.BranchID, b.BranchName
           FROM Branch b
           INNER JOIN BranchToCourse cb ON b.BranchID = cb.BranchID
           WHERE cb.CourseID = $courseID
           ORDER BY b.BranchName ASC";

$result = $conn->query($q_cb_info);

$branches = [];
while ($row = $result->fetch_assoc()) {
    $branches[] = $row;
}

header("Content-Type: application/json");
echo json_encode($branches);

$conn->close();
?>

