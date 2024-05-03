<?php
require_once "../../dbcon.php";

$courseID = $_GET["courseID"];

$squery = "SELECT b.BranchID, b.BranchName
           FROM Branch b
           INNER JOIN CourseToBranch cb ON b.BranchID = cb.BranchID
           WHERE cb.CourseID = $courseID
           ORDER BY b.BranchName ASC";

$result = $conn->query($squery);

$branches = [];
while ($row = $result->fetch_assoc()) {
    $branches[] = $row;
}

// Return branches as JSON
header("Content-Type: application/json");
echo json_encode($branches);

$conn->close();

?>

