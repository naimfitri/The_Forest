<?php
// Database connection
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');


$spgroup = isset($_GET['SpGroup']) ? intval($_GET['SpGroup']) : 8;

if ($spgroup == 8) {
    $count_query = "SELECT * FROM new_forest_55";
} else {
    $count_query = "SELECT * FROM new_forest_55 WHERE spgroup = $spgroup";
    
}

$result = mysqli_query($conn, $count_query);

    $treeData = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $treeData[] = $row; 
    }

    mysqli_close($conn);


    header('Content-Type: application/json');
    echo json_encode($treeData);

?>