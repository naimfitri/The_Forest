<?php
// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$regime = $data['regime'] ?? 'regime';

$tableName = '';
$log = 0;

// Determine the target table and regime logic
switch ($regime) {
    case 'regime50':
        $tableName = 'new_forest_50';
        
        break;
    case 'regime55':
        $tableName = 'new_forest_55';
        
        break;
    case 'regime60':
        $tableName = 'new_forest_60';
        
        break;
    case 'regime':
        $tableName = 'new_forest';
        
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

$count_query = "SELECT TreeNumber, diameter, spgroup, StemHeight FROM $tableName WHERE Status = 'Keep' OR Status = 'V2'";
$result = mysqli_query($conn, $count_query);

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}

$row_count = mysqli_num_rows($result);
echo "Number of rows retrieved: " . $row_count . "</br>";

$insert_count = 0; // Counter for executed insert queries

$start_time = microtime(true); // Start profiling

$diameter = [];
$production3045 = [];
$production3050 = [];
$production3055 = [];
$production3060 = [];
$TreeNum = [];
$vol30 = [];

while ($row = mysqli_fetch_assoc($result)) {
    $TreeNum[] = $row['TreeNumber'];
    $D = $row['diameter'];
    $G = $row['spgroup'];
    $H = $row['StemHeight'];
    $diameter[] = growth($D);
    $newDia = growth($D);
    $production3045[] = LogCond($G, $newDia, $log = 45);
    $production3050[] = LogCond($G, $newDia, $log = 50);
    $production3055[] = LogCond($G, $newDia, $log = 55);
    $production3060[] = LogCond($G, $newDia, $log = 60);
    $vol30[] = calculateVolume30($newDia, $G, $H);
    
}

function growth($D){
    for ($i = 1 ; $i <= 30 ; $i++) {
        if ($D > 5 && $D <= 15) {
            $D = $D + 0.4;
        } else if ($D > 15 && $D <= 30) {
            $D = $D + 0.6;
        } else if ($D > 30 && $D <= 45) {
            $D = $D + 0.5;
        } else if ($D > 45 && $D <= 60) {
            $D = $D + 0.5;
        } else if ($D > 60) {
            $D = $D + 0.7;
        }
    }

    return $D;
}

function LogCond($G, $newDia, $log) {
    if (in_array($G, [1, 2, 3, 5]) && $newDia > $log) {
        return 1;
    }
    return 0;
}

function calculateVolume30($newDia, $G, $H) {
    // Convert to meters
    $Dia = number_format(($newDia / 100), 2);
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


$batch_size = 100;
$batch_updates = [];
$counter = 0;

for($i = 0; $i < count($diameter); $i++){
    $batch_updates[] = "UPDATE $tableName
        SET
            GrowthD30 = {$diameter[$i]},
            production3045 = {$production3045[$i]},
            production3050 = {$production3050[$i]},
            production3055 = {$production3055[$i]},
            production3060 = {$production3060[$i]},
            Volume30 = {$vol30[$i]}
        WHERE TreeNumber = '{$TreeNum[$i]}'";

    $counter++;

    if ($counter % $batch_size == 0 || $i == count($diameter) - 1) {
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

mysqli_close($conn);
?>
