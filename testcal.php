<?php
function isTreeAffected($cutTree, $height, $fallingAngle, $victimTree) {
    // Cut tree coordinates
    $x_c = $row['x'];
    $y_c = $row['y'];
    $fallingAngle = $row['Cut_Angle'];
    $stemHeight = $row['StemHeight'];

    // Victim tree coordinates
    $x_v = $row1['x'];
    $y_v = $row1['y'];

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
    if ($theta_min < $theta_max) {
        // Normal case
        return ($angle_to_victim_deg >= $theta_min && $angle_to_victim_deg <= $theta_max);
    } else {
        // Wrap-around case
        return ($angle_to_victim_deg >= $theta_min || $angle_to_victim_deg <= $theta_max);
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
?>
