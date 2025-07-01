<?php
// Database connection
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

// Get BlockX and BlockY from query parameters
$blockX = isset($_GET['BlockX']) ? intval($_GET['BlockX']) : 1; 
$blockY = isset($_GET['BlockY']) ? intval($_GET['BlockY']) : 1; 
$spgroup = isset($_GET['SpGroup']) ? intval($_GET['SpGroup']) : 8;

if ($spgroup == 8) {
    $count_query = "SELECT * FROM new_forest WHERE BlockX = $blockX AND BlockY = $blockY";
} else {
    $count_query = "SELECT * FROM new_forest WHERE BlockX = $blockX AND BlockY = $blockY AND spgroup = $spgroup";
    
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