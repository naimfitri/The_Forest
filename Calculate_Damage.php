<?php

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$regime = $data['regime'] ?? 'regime';

$tableName = '';
$damagetree = '';

// Determine the target table and regime logic
switch ($regime) {
    case 'regime50':
        $tableName = 'new_forest_50';
        $damagetree = 'damagetree50';
        break;
    case 'regime55':
        $tableName = 'new_forest_55';
        $damagetree = 'damagetree55';
        break;
    case 'regime60':
        $tableName = 'new_forest_60';
        $damagetree = 'damagetree60';
        break;
    case 'regime':
        $tableName = 'new_forest';
        $damagetree = 'damagetree';
        break;

    default:
        echo "Invalid regime specified.";
        exit;
}

ini_set('max_execution_time', 300); 
echo "</table>";

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tree');

// Make the connection:
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');

// Perform your calculations here using the existing data in the database

// For example, you can retrieve data from the 'tree_data' table and perform calculations:
// Construct the SQL query to retrieve data for all "Cut" trees
$sql = "SELECT TreeNumber, Cut_Angle, x, y, StemHeight FROM $tableName WHERE Status = 'Cut'";
$result = mysqli_query($dbc, $sql);

// Check if the query executed successfully
if (!$result) {
    die('Error executing query: ' . mysqli_error($dbc));
}

while ($row = mysqli_fetch_assoc($result)) {

    // Extracting coordinates from the row
    $cut_tree_coordinate = $row['TreeNumber']; // Coordinate of the cut tree
    $x0 = $row['x'];
    $y0 = $row['y'];
    $cutAngle = $row['Cut_Angle'];
    $stemHeight = $row['StemHeight'];
    
    $buffer = 10;  // 5 + 5 as described

    $count_query = ""; // Initialize count_query to empty string

    if ($cutAngle > 0 && $cutAngle <= 90) {
        // Quadrant I: 0 - 90 degrees
        $x_upper = $x0 + $stemHeight + $buffer;
        $y_upper = $y0 + $stemHeight + $buffer;

        $count_query = "SELECT TreeNumber, x, y FROM $tableName WHERE Status != 'Cut' AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";
        
    }
    elseif ($cutAngle > 90 && $cutAngle <= 180) {
        // Quadrant II: 90 - 180 degrees
        $x_upper = $x0 + $stemHeight + $buffer;
        $y_upper = $y0 - $stemHeight - $buffer;
        $count_query = "SELECT TreeNumber, x, y FROM $tableName WHERE Status != 'Cut' AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";
        
    }
    elseif ($cutAngle > 180 && $cutAngle <= 270) {
        // Quadrant III: 180 - 270 degrees
        $x_upper = $x0 - $stemHeight - $buffer;
        $y_upper = $y0 - $stemHeight - $buffer;
        $count_query = "SELECT TreeNumber, x, y FROM $tableName WHERE Status != 'Cut' AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";
        
    } elseif ($cutAngle > 270 && $cutAngle <= 360) {
        // Quadrant IV: 270 - 360 degrees
        $x_upper = $x0 - $stemHeight - $buffer;
        $y_upper = $y0 + $stemHeight + $buffer;
        $count_query = "SELECT TreeNumber, x, y FROM $tableName WHERE Status != 'Cut' AND x > $x0 AND x < $x_upper AND y > $y0 AND y < $y_upper";
        
    }

    // Ensure count_query is not empty before executing the query
    if (!empty($count_query)) {
        // Execute the query to find affected trees
        $result1 = mysqli_query($dbc, $count_query);

        // if (!$result1) {
        //     die('Error executing query: ' . mysqli_error($dbc));
        // }

        if ($result1) {
            // If the result is not empty, echo the count_query
            echo $count_query;
        } else {
            // Optionally, handle the case where the query failed
            echo "Query execution failed: " . mysqli_error($dbc);
        }

        while ($row1 = mysqli_fetch_assoc($result1)) {
                // Cut tree coordinates
            $x_c = $x0;
            $y_c = $y0;
            $fallingAngle = $cutAngle;
            $height = $stemHeight;

            // Victim tree coordinates
            $x_v = $row1['x'];
            $y_v = $row1['y'];
            $victim_treenum = $row1['TreeNumber'];

            // Convert falling angle to radians
            $theta_rad = deg2rad($fallingAngle);

            // Calculate the falling direction endpoint
            $x_f = $x_c + $height * sin($theta_rad);
            $y_f = $y_c - $height * cos($theta_rad);

            // Calculate the angles for the spread
            $theta_min = $fallingAngle - 1;
            $theta_max = $fallingAngle + 1;

            // Normalize angles to [0, 360)
            $theta_min = ($theta_min + 360) % 360;
            $theta_max = ($theta_max + 360) % 360;

            // Calculate the angle from the cut tree to the victim tree
            $angle_to_victim = atan2($y_v - $y_c, $x_v - $x_c);
            $angle_to_victim_deg = rad2deg($angle_to_victim);
            $angle_to_victim_deg = ($angle_to_victim_deg + 360) % 360;

            // Check if the angle to the victim is within the falling angle range
            $isAffected = false;
            if ($theta_min < $theta_max) {
                // Normal case
                $isAffected = ($angle_to_victim_deg >= $theta_min && $angle_to_victim_deg <= $theta_max);
            } else {
                // Wrap-around case
                $isAffected = ($angle_to_victim_deg >= $theta_min || $angle_to_victim_deg <= $theta_max);
            }

            // Output the result
            if ($isAffected) {

                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coordinate', '$victim_treenum', 'V1') ";
                $result3 = mysqli_query($dbc, $insert_query);
                if (!$result3) {
                    die('Error inserting victim data: ' . mysqli_error($dbc));
                }

            } else {

            }

            $radius = 5; // Radius to check
            // Calculate the distance from the crown to the victim tree
            $distance = sqrt(pow($x_f - $x_v, 2) + pow($y_f - $y_v, 2));

            // Check if the victim tree is within the radius
            $isAffectedCrown = $distance <= $radius;

            // Output the result for crown radius
            if ($isAffectedCrown) {
                $insert_query = "INSERT INTO $damagetree (cut_tree, victim, category_damage) VALUES ('$cut_tree_coordinate', '$victim_treenum', 'V2') ";
                $resultA = mysqli_query($dbc, $insert_query);
                if (!$resultA) {
                    die('Error inserting victim data: ' . mysqli_error($dbc));
                }
            } else {
            }
        }
    } else {
        // Optionally, handle the case where the count_query is empty
        echo "Count query is empty.";
    }
}
?>
