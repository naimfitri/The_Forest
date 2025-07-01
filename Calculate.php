<?php
// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$regime = $data['regime'] ?? '';

$tableName = '';
$log = 0;

// Determine the target table and regime logic
switch ($regime) {
    case 'regime50':
        $tableName = 'new_forest_50';
        $log = 50;
        break;
    case 'regime55':
        $tableName = 'new_forest_55';
        $log = 55;
        break;
    case 'regime60':
        $tableName = 'new_forest_60';
        $log = 60;
        break;
    case 'regime':
        $tableName = 'new_forest';
        $log = 45;
        break;

    default:
        echo "Invalid regime specified.";
        exit;
}


DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

// Generate Data
$id = [];
$SpCode = [];
$SpGroupCode = [];
$TreeNum = [];
$SpBlockX = [];
$SpBlockY = [];
$SpCoorX = [];
$SpCoorY = [];
$Diameter = [];
$Height = [];
$Volume = [];
$DiameterClass = [];
$Status = [];
$CutAngle = [];
$Production = [];

$sql = "SELECT * FROM new_forest";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id[] = $row['ID'];
        $SpCode[] = $row['species'];
        $SpGroupCode[] = $row['spgroup'];
        $TreeNum[] = "T" . str_pad($row['BlockX'], 2, '0', STR_PAD_LEFT) .
                     str_pad($row['BlockY'], 2, '0', STR_PAD_LEFT) .
                     str_pad($row['x'], 2, '0', STR_PAD_LEFT) .
                     str_pad($row['y'], 2, '0', STR_PAD_LEFT);
        $SpBlockX[] = $row['BlockX'];
        $SpBlockY[] = $row['BlockY'];
        $SpCoorX[] = $row['x'];
        $SpCoorY[] = $row['y'];
        $DiameterClass[] = $row['diameterclass'];
        $Diameter[] = $row['diameter'];
        $Height[] = $row['StemHeight'];

        $D = $row['diameter'];
        $G = $row['spgroup'];
        $H = $row['StemHeight'];

        $Volume[] = CalVolume($D, $G, $H);
        $Status[] = LogCond($G, $D, $log);
        $Production[] = (LogCond($G, $D, $log) == "Keep") ? 0 : 1;
        $CutAngle[] = CutAngle($G, $D, $log);
    }
}

function CalVolume($D, $G, $H) {
    // Convert to meters
    $Dia = number_format(($D / 100), 2);
    $Hie = number_format(($H), 2);

    if ($G <= 4) { // Dipterocarp groups (Group 1, 2, 3, 4)
        if ($Dia < 15) {
            $vol = 0.022 + (3.4 * pow($Dia, 2));
        } else {
            $vol = 0.015 + (2.137 * pow($Dia, 2)) + (0.513 * pow($Dia, 2) * $Hie);
        }
    } else { // Non-Dipterocarp groups (Group 5, 6, 7)
        if ($Dia < 15) {
            $vol = 0.03 + (2.8 * pow($Dia, 2));
        } else {
            $vol = -0.0023 + (2.942 * pow($Dia, 2)) + (0.262 * pow($Dia, 2) * $Hie);
        }
    }

    return round($vol ?? 0, 2);
}

function LogCond($G, $D, $log) {
    if (in_array($G, [1, 2, 3, 5]) && $D > $log) {
        return "Cut";
    }
    return "Keep";
}

function CutAngle($G, $D, $log) {
    if (in_array($G, [1, 2, 3, 5]) && $D > $log) {
        return rand(0, 360);
    }
    return 0;
}

// Batch Update
$batch_size = 100; // Adjust batch size for performance
$batch_updates = [];
$counter = 0;

for ($i = 0; $i < count($SpCode); $i++) {
    $batch_updates[] = "UPDATE $tableName
        SET 
            Volume = {$Volume[$i]}, 
            TreeNumber = '{$TreeNum[$i]}', 
            Status = '{$Status[$i]}', 
            Production = {$Production[$i]}, 
            Cut_Angle = {$CutAngle[$i]}
        WHERE ID = {$id[$i]}";

    $counter++;

    // Execute the batch when the size reaches the limit
    if ($counter % $batch_size == 0 || $i == count($SpCode) - 1) {
        $batch_query = implode("; ", $batch_updates) . ";";
        if ($conn->multi_query($batch_query)) {
            do {
                // Clear result set for the current query batch
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            echo "Error executing batch: " . $conn->error . "<br>";
        }
        $batch_updates = []; // Clear the batch
    }
}

echo "Total Data Processed: " . count($SpCode) . "<br>";

$conn->close();
?>
