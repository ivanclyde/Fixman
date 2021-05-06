<?php
require_once "db.php";

$title = isset($_POST['title']) ? $_POST['title'] : "";
$start = isset($_POST['start']) ? $_POST['start'] : "";
$end = isset($_POST['end']) ? $_POST['end'] : "";
$repairmanid = isset($_POST['repairmanid']) ? $_POST['repairmanid'] : "";

$sqlInsert = "INSERT INTO calendar (repairmanid,title,start,end) VALUES ('".$repairmanid."','".$title."','".$start."','".$end ."')";

$result = mysqli_query($conn, $sqlInsert);

if (! $result) {
    $result = mysqli_error($conn);
}
?>