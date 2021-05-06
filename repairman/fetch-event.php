<?php
    require_once "db.php";

    $repairmanid = $_GET['repairmanid'];
    $json = array();

    $sqlQuery = "SELECT * FROM calendar WHERE repairmanid = '$repairmanid' ORDER BY id ASC";

    $result = mysqli_query($conn, $sqlQuery);
    $eventArray = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($eventArray, $row);
    }
    mysqli_free_result($result);

    mysqli_close($conn);
    echo json_encode($eventArray);
?>