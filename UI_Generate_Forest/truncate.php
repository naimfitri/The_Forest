<?php
// Database connection
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

// Truncate the table
$truncate_sql = "TRUNCATE TABLE new_forest";
$truncate_sql2 = "TRUNCATE TABLE new_forest_50";
$truncate_sql3 = "TRUNCATE TABLE new_forest_55";
$truncate_sql4 = "TRUNCATE TABLE new_forest_60";
$truncate_sql5 = "TRUNCATE TABLE damagetree";
$truncate_sql6 = "TRUNCATE TABLE damagetree50";
$truncate_sql7 = "TRUNCATE TABLE damagetree55";
$truncate_sql8 = "TRUNCATE TABLE damagetree60";
if ($conn->query($truncate_sql) === TRUE &&
    $conn->query($truncate_sql2) === TRUE &&
    $conn->query($truncate_sql3) === TRUE &&
    $conn->query($truncate_sql4) === TRUE &&
    $conn->query($truncate_sql5) === TRUE &&
    $conn->query($truncate_sql6) === TRUE &&
    $conn->query($truncate_sql7) === TRUE &&
    $conn->query($truncate_sql8) === TRUE) {
    // Include Generate_Forest script
    sleep(2); // Delay for 2 seconds
    include 'C:\xampp\htdocs\deforest\Generate_Forest.php';
    echo "Forest data cleared and regenerated successfully!";
} else {
    echo "Error clearing forest data: " . $conn->error;
}

$conn->close();
?>
