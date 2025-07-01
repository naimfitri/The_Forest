<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damage Tree Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h3 {
            text-align: center;
        }

        .table-container {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            width: 50%; /* Match the table width */
            margin-left: auto;
            margin-right: auto; /* Center the container */
        }

        .table-scrollable {
            max-height: 300px; /* Adjust the height limit as needed */
            overflow-y: auto;
        }

        table {
            width: 100%; /* Use full width of the container */
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #007bff;
            color: #fff;
            position: sticky;
            top: 0; /* Ensures header stays visible during scrolling */
            z-index: 1;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        caption {
            caption-side: top;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
        }

    </style>
</head>
<body>
<?php
    include_once("../nav.php");
    ?>

<?php
// Database connection
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

// Query to fetch unique Cut_Tree values
$cutTreeQuery = "SELECT DISTINCT cut_tree FROM damagetree55";
$cutTreeResult = $conn->query($cutTreeQuery);

if ($cutTreeResult->num_rows > 0) {
    while ($cutTreeRow = $cutTreeResult->fetch_assoc()) {
        $cutTree = $cutTreeRow['cut_tree'];

        // Query to fetch data for the current Cut_Tree
        $dataQuery = "SELECT victim, category_damage FROM damagetree55 WHERE cut_tree = '$cutTree'";
        $dataResult = $conn->query($dataQuery);

        echo "<div class='table-container'>";
        echo "<br>";
        echo "<h3>Tree ID: $cutTree</h3>";
        echo "<div class='table-scrollable'>";
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Victim</th>
                    <th>Category Damage</th>
                </tr>
              </thead>
              <tbody>";

    
        
        while ($dataRow = $dataResult->fetch_assoc()) {
            echo "<tr>";
            
            echo "<td>{$dataRow['victim']}</td>";
            echo "<td>{$dataRow['category_damage']}</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
        echo "</div>"; // Close table-scrollable
        echo "</div>"; // Close table-container
    }
} else {
    echo "<p>No data found in the database.</p>";
}

$conn->close();
?>

</body>
</html>
