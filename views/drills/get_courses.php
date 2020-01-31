<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new mysqli('localhost', 'root', 'root', 'Drills');

$sql = "SELECT * FROM courses";

if( !empty( $_GET['cool_search'] ) ) {
    $cool_search = $_GET['cool_search'];
    $sql .= " WHERE course_name LIKE '%$cool_search%'
                OR instructor LIKE '%$cool_search%'";
}

$sql .= " ORDER BY quarter";


$results = $db->query($sql);

$cooler_array = array();
while($row = $results->fetch_assoc()){
    $cooler_array[] = $row;
}
echo json_encode($cooler_array);
