<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
</head>
<body>
    <h1>Student Registration Form</h1>

    <form action="assign/student.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" maxlength="30" required><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="addr">Address:</label><br>
        <input type="text" id="addr" name="addr" maxlength="40" required><br><br>

        <label for="phno">Phone Number:</label><br>
        <input type="text" id="phno" name="phno" maxlength="10" required><br><br>

        <label for="cbid">Course:</label><br>
            <?php
            require_once "../dbcon.php";

            $squery =
                "SELECT CourseID, CourseName FROM Course ORDER BY CourseName ASC";
            $courses = $conn->query($squery);

            if ($courses->num_rows > 0) {
                echo "<select id='cid' name='cid'>";
                while ($row = $courses->fetch_assoc()) {
                    echo "<option value='" .
                        $row["CourseID"] .
                        "'>" .
                        $row["CourseName"] .
                        "</option>";
                }
                echo "</select>";
            } else {
                echo "No results found.";
            }
            ?>
        <br><br>

        <label for="cbid">Branch:</label><br>
        <select id="bid" name="bid"></select>

        <br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>

<script src="utils/update_branches.js"></script>

