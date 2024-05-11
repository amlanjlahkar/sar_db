<?php
require_once "../../dbcon.php";
require_once "../../utils.php";

$student_id = $_GET["id"];

$q_get_st_info = "SELECT s.Name, s.DOB, s.Address, s.PhoneNo, btc.CourseID, btc.BranchID
    FROM Student s
    JOIN BranchToCourse AS btc ON s.BCID = btc.BCID
    WHERE s.StudentID = '$student_id'";

$result = $conn->query($q_get_st_info);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Student Registration Form</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        />
        <link rel="stylesheet" type="text/css" href="../../stylesheets/style.css" />
    </head>

    <body>
        <div id="form_container">
            <div id="student_form">
                <div id="heading_block">
                    <div>
                        <p id="heading">Student Info Updation Form</p>
                    </div>
                </div>
                <div id="form_block">
                    <form id="st_form">
                        <br />
                        <div class="input_block">
                            <label for="st_name">Student Name</label><br />
                            <input
                                type="text"
                                id="st_name"
                                name="st_name"
                                autocomplete="off"
                                value="<?= $row["Name"] ?>"
                                required
                            />
                            <br />
                            <span class="err" id="err_st_name"></span>
                        </div>


                        <div class="input_block">
                            <label for="st_addr">Address</label><br />
                            <input
                                type="text"
                                id="st_addr"
                                name="st_addr"
                                maxlength="40"
                                autocomplete="off"
                                value="<?= $row["Address"] ?>"
                                required
                            />
                            <br />
                            <span class="err" id="err_st_name"></span>
                        </div>


                        <div class="input_block">
                            <label for="st_dob">Date of Birth</label><br />
                            <input
                                type="date"
                                id="st_dob"
                                name="st_dob"
                                value="<?= $row["DOB"] ?>"
                                required
                            /><br />
                            <span class="err" id="err_st_dob"></span>
                        </div>


                        <div class="input_block">
                            <label for="st_phno">Phone No.</label><br />
                            <input
                                type="text"
                                id="st_phno"
                                name="st_phno"
                                minlength="10"
                                maxlength="10"
                                autocomplete="off"
                                value="<?= $row["PhoneNo"] ?>"
                                required
                            />
                            <br />
                            <span class="err" id="err_st_phno"></span>
                        </div>


                        <div class="input_block">
                            <label for="st_course">Course</label><br />
                            <select id="st_course" name="st_course">
                                <option value="" disabled hidden>
                                    Select a course
                                </option>
                                <?php
                                $q_course_info =
                                    "SELECT CourseID, CourseName FROM Course ORDER BY CourseName ASC";

                                $courses = $conn->query($q_course_info);

                                if ($courses->num_rows > 0) {
                                    while ($course = $courses->fetch_assoc()) {
                                        if (
                                            $course["CourseID"] ===
                                            $row["CourseID"]
                                        ) {
                                            echo "<option value='" .
                                                $course["CourseID"] .
                                                "' selected>" .
                                                $course["CourseName"] .
                                                "</option>";
                                        } else {
                                            echo "<option value='" .
                                                $course["CourseID"] .
                                                "'>" .
                                                $course["CourseName"] .
                                                "</option>";
                                        }
                                    }
                                }

                                $courses->free();
                                ?>
                            </select>
                            <br />


                        </div>
                        <div class="input_block">
                            <label for="st_branch">Branch</label><br />
                            <select id="st_branch" name="st_branch">
                                <option value="" disabled hidden>
                                    Select branch
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    <?php $fetchURL = "../../scripts/fetch_branches.php" ?>

    <script>
        let fetchURL = "<?= $fetchURL ?>"
    </script>

    <script src="../../scripts/update_branches.js"></script>

</html>


