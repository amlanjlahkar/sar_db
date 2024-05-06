<?php

const HOST = "localhost";
const USER = "amlan";
const PASS = "";
const DB = "student_academic_record";

$conn = mysqli_init();

if (!$conn) {
    die("Connection faild");
}

if (!$conn->real_connect(HOST, USER, PASS, DB)) {
    die(
        "Connect Error (" .
            mysqli_connect_errno() .
            ") " .
            mysqli_connect_error()
    );
}

// echo "Success... (" . $conn->host_info . ")\n";

// $conn->close();

?>
