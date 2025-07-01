<?php
// Database connection
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tree');

// Make the connection:
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());

// Set the encoding...
mysqli_set_charset($conn, 'utf8');

// Variables
$NoBlockX = 10;
$NoBlockY = 10;
$NoGroupSpecies = 7; // You should define this based on your data
$NumDclass = 5; // You should define this based on your data

// Example TreePerha array (you need to define this based on your data)
$TreePerha = [
    [15, 12, 4, 2, 2], // Number of trees per hectare for each species group and diameter class
    [21, 18, 6, 4, 4],
    [21, 18, 6, 4, 4],
    [30, 27, 9, 5, 3],
    [30, 27, 9, 4, 4],
    [39, 36, 12, 7, 4],
    [44, 42, 14, 9, 4]
];

// Example ListSpecies array (you need to define this based on your data)
$ListSpecies = [];
$sql = "SELECT No, species FROM speciesnames";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ListSpecies[$row['No']] = $row['species'];
    }
} else {
    die("No species found in the database.");
}



for ($IX = 1; $IX <= $NoBlockX; $IX++) {
    for ($JY = 1; $JY <= $NoBlockY; $JY++) {
        $blockx = $IX;
        $blocky = $JY;

        for ($I = 1; $I <= $NoGroupSpecies; $I++) {
            for ($J = 1; $J <= $NumDclass; $J++) {
                $NumTree = $TreePerha[$I-1][$J-1];

                for ($K = 1; $K <= $NumTree; $K++) {
                    // Determine Species
                    if ($I == 1) $SequenceSp = rand(1, 1);
                    else if ($I == 2) $SequenceSp = rand(2, 6);
                    else if ($I == 3) $SequenceSp = rand(7, 19);
                    else if ($I == 4) $SequenceSp = rand(19, 60);
                    else if ($I == 5) $SequenceSp = rand(61, 150);
                    else if ($I == 6) $SequenceSp = rand(151, 250);
                    else if ($I == 7) $SequenceSp = rand(251, 400);

                    $species = $ListSpecies[$SequenceSp];

                    // Determine Diameter
                    if ($J == 1) $diameter = rand(500, 1500) / 100;
                    else if ($J == 2) $diameter = rand(1500, 3000) / 100;
                    else if ($J == 3) $diameter = rand(3000, 4500) / 100;
                    else if ($J == 4) $diameter = rand(4500, 6000) / 100;
                    else if ($J == 5) $diameter = rand(6000, 7500) / 100;

                    // Determine Height
                    if ($J == 1) $height = rand(250, 550) / 100;
                    else if ($J == 2) $height = rand(550, 1000) / 100;
                    else if ($J == 3) $height = rand(1000, 1500) / 100;
                    else if ($J == 4) $height = rand(1500, 4000) / 100;
                    else if ($J == 5) $height = rand(1500, 4000)/ 100;

                    // Determine Location
                    $locationx = rand(1, 100);
                    $locationy = rand(1, 100);
                    $x = ($blockx - 1) * 100 + $locationx;
                    $y = ($blocky - 1) * 100 + $locationy;

                    $spgroup = $I; // Assuming spgroup corresponds to the outer loop index $I

                    // Determine diameterclass
                    $diameterclass = $J; // Assuming diameterclass corresponds to the inner loop index $J
                    
                    // Store in database
                    $sql = "INSERT INTO new_forest (BlockX, BlockY, x, y, species, diameter, StemHeight, spgroup, diameterclass) VALUES ($blockx, $blocky ,$x, $y, '$species', $diameter, $height, $spgroup, $diameterclass)";
                    if ($conn->query($sql) === TRUE) {
                      
                    } else {
                      
                    }
                }
            }
        }
    }
}



$conn->close();
?>
