<?php
// Database connection
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

// Fetch table name dynamically
$table = isset($_GET['table']) ? $_GET['table'] : null;

if (!$table) {
    die(json_encode(['error' => 'Table name not specified']));
}

// Sanitize and validate table name
$allowed_tables = ['new_forest', 'new_forest_50', 'new_forest_55', 'new_forest_60'];
if (!in_array($table, $allowed_tables)) {
    die(json_encode(['error' => 'Invalid table name']));
}

// Query to get sums for the graph
$query = "SELECT 
    SUM(CASE WHEN production3045 = 1 THEN Volume30 ELSE 0 END) AS Sum_Volume30_3045,
    SUM(CASE WHEN production3050 = 1 THEN Volume30 ELSE 0 END) AS Sum_Volume30_3050,
    SUM(CASE WHEN production3055 = 1 THEN Volume30 ELSE 0 END) AS Sum_Volume30_3055,
    SUM(CASE WHEN production3060 = 1 THEN Volume30 ELSE 0 END) AS Sum_Volume30_3060,
    SUM(CASE WHEN Production = 1 THEN Volume ELSE 0 END) AS Sum_Volume_Production
FROM $table";


$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    die(json_encode(['error' => mysqli_error($conn)]));
}

mysqli_close($conn);
?>
