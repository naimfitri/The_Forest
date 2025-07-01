<?php
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

// Fetch all damage tree records
$fetch_query = "SELECT * FROM damagetree";
$result = mysqli_query($conn, $fetch_query);

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

while($row = mysqli_fetch_assoc($result)){
    $treenumber = $row['victim']; // Get victim tree number
    $damage = $row['category_damage']; // Get category of damage

    // Update the tree damage in new_forest table
    $update_query = "UPDATE new_forest SET Status = 'V$damage', Damage = 'V$damage' WHERE TreeNumber = '$treenumber'";
    $update_result = mysqli_query($conn, $update_query);

    if (!$update_result) {
        die('Error executing update query: ' . mysqli_error($conn));
    }
}

// Close connection
mysqli_close($conn);
?>
