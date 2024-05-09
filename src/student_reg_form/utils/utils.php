<?php

/*
 * Safely execute a query
 *
 * @param mysqli_object $sql_conn Mysqli object returned by mysqli_init
 * @param string $q SQL query to execute
 * @return mysqli_result|array Mysqli_result object if execution is successful, else an array containing exception info
 */
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

/*
 * Send a json encoded response to the client
 *
 * @param bool $success Whether it's a response to indicate successful execution or not
 * @param string $msg The response message
 * @param array [$strace] The stacktrace obtained from try_query if it's an SQL error. Default is `null`
 */
function send_response($success, $msg, $strace = null) {
    $resp = [
        "success" => $success,
        "msg" => $msg,
        "strace" => $strace ?? null,
    ];
    header("Content-Type: application/json");
    echo json_encode($resp);
}

/*
 * Check if a query outputs any result. Can be used to avoid duplications
 * @param mysqli_object $sql_conn Mysqli object returned by mysqli_init
 * @param string $q SQL Query to execute
 * @return bool|array Boolean value upon successful execution, else array returned by try_query
 */
function is_unique($sql_conn, $q) {
    $result = try_query($sql_conn, $q);

    return $result instanceof mysqli_result ? $result->num_rows == 0 : $result;
}

?>
