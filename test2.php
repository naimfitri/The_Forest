<?php
// Function to calculate the area of a triangle given three points
function calculateArea($x1, $y1, $x2, $y2, $x3, $y3) {
    return abs($x1 * ($y2 - $y3) + $x2 * ($y3 - $y1) + $x3 * ($y1 - $y2)) / 2.0;
}

// Function to check if a point lies inside the triangle
function isPointInsideTriangle($ax, $ay, $bx, $by, $cx, $cy, $px, $py) {
    $areaABC = calculateArea($ax, $ay, $bx, $by, $cx, $cy);
    $areaABP = calculateArea($ax, $ay, $bx, $by, $px, $py);
    $areaBCP = calculateArea($bx, $by, $cx, $cy, $px, $py);
    $areaCAP = calculateArea($cx, $cy, $ax, $ay, $px, $py);
    $epsilon = 0.0001;
    return (abs($areaABC - ($areaABP + $areaBCP + $areaCAP)) < $epsilon);
}

// Function to calculate the coordinates of B and C based on the falling angle
function calculatePoint($x, $y, $r, $theta_deg) {
    $theta_rad = $theta_deg * (pi() / 180);
    $x_new = $x + $r * cos($theta_rad);
    $y_new = $y + $r * sin($theta_rad);
    return array(round($x_new), round($y_new));
}

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tree');

// Create a connection to the database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

// Query to fetch details of the cutting tree
$sql_cut_tree = "SELECT x, y, TreeNumber, StemHeight, Cut_Angle FROM new_forest WHERE TreeNumber = 'T01017303'";
$result_cut_tree = mysqli_query($conn, $sql_cut_tree);
$cut_tree = mysqli_fetch_assoc($result_cut_tree);

if ($cut_tree) {
    $ax = $cut_tree['x'];
    $ay = $cut_tree['y'];
    $r = $cut_tree['StemHeight'];
    $theta = $cut_tree['Cut_Angle'];

    // Calculate the triangle points
    $bx_coords = calculatePoint($ax, $ay, $r, $theta + 1);
    $cx_coords = calculatePoint($ax, $ay, $r, $theta - 1);

    $bx = $bx_coords[0];
    $by = $bx_coords[1];
    $cx = $cx_coords[0];
    $cy = $cx_coords[1];

    // Define the victim tree numbers to check
    $victim_trees = ['T01016218', 'T01015823', 'T01015624'];
    
    foreach ($victim_trees as $victim_tree) {
        $sql_victim_tree = "SELECT x, y, TreeNumber FROM new_forest WHERE TreeNumber = '$victim_tree'";
        $result_victim_tree = mysqli_query($conn, $sql_victim_tree);
        $victim_data = mysqli_fetch_assoc($result_victim_tree);

        if ($victim_data) {
            $px = $victim_data['x'];
            $py = $victim_data['y'];

            // Check if the victim tree is inside the triangle
            if (isPointInsideTriangle($ax, $ay, $bx, $by, $cx, $cy, $px, $py)) {
                echo "Tree {$victim_data['TreeNumber']} is a victim.\n";
            } else {
                echo "Tree {$victim_data['TreeNumber']} is NOT inside the falling area.\n";
            }
        } else {
            echo "Tree $victim_tree not found in the database.\n";
        }
    }
} else {
    echo "Cutting tree (T01017303) not found in the database.\n";
}

mysqli_close($conn);
?>
