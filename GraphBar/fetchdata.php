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
    SUM(production3045) AS production3045,
    SUM(production3050) AS production3050,
    SUM(production3055) AS production3055,
    SUM(production3060) AS production3060,
    SUM(Production) AS Production
FROM $table";

$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    die(json_encode(['error' => mysqli_error($conn)]));
}

mysqli_close($conn);
?>
