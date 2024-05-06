<!doctype html>

<html>
    <head>
        <title>Student Registration Form</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        />
        <link rel="stylesheet" type="text/css" href="./style.css" />
    </head>

    <body>
        <div id="form_container">
            <div id="student_form">
                <div id="heading_block">
                    <div>
                        <p id="heading">Student Registration Form</p>
                    </div>
                </div>
                <div id="form_block">

                    <form
                        id="st_info"
                        action="assign/student.php"
                        method="POST"
                    >

                        <br />
                        <div class="input_block">
                            <label for="st_name">Student Name</label><br />
                            <input
                                type="text"
                                id="st_name"
                                name="st_name"
                                autocomplete="off"
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
                                maxlength="10"
                                autocomplete="off"
                                required
                            />
                            <br />
                            <span class="err" id="err_st_phno"></span>
                        </div>


                        <div class="input_block">
                            <label for="st_course">Course</label><br />
                            <select id="st_cid" name="st_cid">
                                <option value="" disabled selected hidden>
                                    Select a course
                                </option>
                                <?php
                                require_once "../dbcon.php";

                                $q_course_info =
                                    "SELECT CourseID, CourseName FROM Course ORDER BY CourseName ASC";

                                $courses = $conn->query($q_course_info);

                                if ($courses->num_rows > 0) {
                                    while ($row = $courses->fetch_assoc()) {
                                        echo "<option value='" .
                                            $row["CourseID"] .
                                            "'>" .
                                            $row["CourseName"] .
                                            "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <br />


                        </div>
                        <div class="input_block">
                            <label for="st_branch">Branch</label><br />
                            <select id="st_bid" name="st_bid">
                                <option value="" disabled selected hidden>
                                    Select branch
                                </option>
                            </select>
                        </div>
                    </form>
                </div>

                <div id="submit_block">
                    <button form="st_info" type="submit" name="Register">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </body>

    <script src="./validate.js"></script>

    <script src="utils/update_branches.js"></script>

    <script>
        let formEl = document.getElementById("st_info");

        formEl.addEventListener("submit", event => {
            event.preventDefault();

            const formData = new FormData(formEl);
            const data = Object.fromEntries(formData);

            fetch("assign/student.php", {
                method: "POST",
                body: formData
            }).then((res) => { if (res.ok) return res.json() })
                .then((data) => {
                    alert(data.msg)
                    if (data.success) {
                        formEl.reset()
                    }
                })
                .catch((err) => console.error("Error fetching data:", err))
        })
    </script>
</html>
