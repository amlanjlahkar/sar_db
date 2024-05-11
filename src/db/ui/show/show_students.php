<!DOCTYPE html>

<html>
    <head>
        <title>Student Info</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        />
        <link rel="stylesheet" type="text/css" href="../stylesheets/display_table.css" />
    </head>
    <body>
        <h1>Student Info</h1>

        <table>
            <?php
            require_once "../../scripts/gen_table.php";
            require_once "../../dbcon.php";

            $q_get_students = "SELECT * FROM Student GROUP BY StudentID ASC";

            // TODO: provide optional arg(or other param) to inform gen_table
            // about the function(name) for deletion for click event
            echo gen_table($conn, $q_get_students);
            ?>
        </table>
    </body>

    <script>
        function deleteStudent(studentId) {
            if (
                confirm(
                    `Do you really want to delete this student from the database(studentID = ${studentId})?\n\nThis can not be undone`
                )
            ) {
                let url = "../../delete/student.php?StudentId=" + studentId

                fetch(url)
                .then((res) => { if (res.ok) { console.log("OK"); return res.json() } })
                .then((data) => {
                    if (data.success) {
                        window.location.reload()
                    }
                })
                .catch((err) => console.error("Error fetching data:", err))
            }
        }
    </script>

</html>
