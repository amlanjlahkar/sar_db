<?php

require_once "../../utils.php";

function gen_table($sql_conn, $q) {
    $result = try_query($sql_conn, $q);

    if (!($result instanceof mysqli_result)) {
        $sql_conn->close();
        send_response(false, $result["errMsg"], $result["strace"]);
        exit();
    }

    $tb_data = "";

    if ($result->num_rows > 0) {
        $update_page = "../../ui/modify/student.php";

        $tb_data .= "<tr>";

        while ($finfo = $result->fetch_field()) {
            $tb_data .= "<th>" . $finfo->name . "</th>";
        }

        $tb_data .= "<th id='th_action' colspan=2>Actions</th>";

        $tb_data .= "</tr>";

        while ($rinfo = $result->fetch_assoc()) {
            $tb_data .= "<tr>";

            foreach ($rinfo as $value) {
                $tb_data .= "<td>" . $value . "</td>";
            }

            $tb_data .=
                "<td class='action_link_up'>
                <a href='" .
                $update_page .
                "?id=" .
                $rinfo["StudentID"] .
                "'>Update Entry</a>
                </td>
                <td class='action_link_del'>
                <a href='#' onclick=deleteStudent('" .
                $rinfo["StudentID"] .
                "')>Delete Entry</a>
                </td>";

            $tb_data .= "</tr>";
        }
    } else {
        $tb_data .= "<p id='empty_notifier'>Table is empty!</p>";
    }

    return $tb_data;
}

?>
