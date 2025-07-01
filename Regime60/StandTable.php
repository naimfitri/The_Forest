<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ST 45</title>
    <style>
        h1 {
        text-align: center;
        }
        table {
            width: 70%;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
        th {
            background-color: #e6e6e6;
        }
        .panel {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        #panelA {
            background-color:rgb(255, 255, 255);
        }
        #panelB {
            background-color:rgb(255, 255, 255);
        }
        #panelC {
            background-color:rgb(255, 255, 255);
        }
        #panelD {
            background-color:rgb(255, 255, 255);
        }
    </style>
</head>
<body>
    <?php
    include_once("../nav.php");
    ?>
    <br>

    <h1>Stand Table</h1>
    <label for="panelSelect">Choose a Stand Table:</label>
    <select id="panelSelect" onchange="showPanel()">
        <option value="">-- Select a Stand Table --</option>
        <option value="panelA">ST 0-30</option>
        <option value="panelB">ST Cut Tree</option>
        <option value="panelC">ST Damage</option>
        <option value="panelD">ST Production</option>
    </select>

    <div id="panelA" class="panel">
    <h1>Stand Table Year 0</h1>
    <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php
                DEFINE ('DB_USER', 'root');
                DEFINE ('DB_PASSWORD', '');
                DEFINE ('DB_HOST', 'localhost');
                DEFINE ('DB_NAME', 'tree');

                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
                mysqli_set_charset($conn, 'utf8');

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                $totalVolume1[] = $row['Volume'];
                                $totalNumber1[] = 1;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                $totalVolume2[] = $row['Volume'];
                                $totalNumber2[] = 1;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                $totalVolume3[] = $row['Volume'];
                                $totalNumber3[] = 1;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                $totalVolume4[] = $row['Volume'];
                                $totalNumber4[] = 1;
                            } elseif ($diameter > 60) {
                                $totalVolume5[] = $row['Volume'];
                                $totalNumber5[] = 1;
                            }
                        }
                    }
                    
                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>

        <h1>Stand Table Year 30</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume1[] = $row['Volume30'];
                                }
                                $totalNumber1[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume2[] = $row['Volume30'];
                                }
                                $totalNumber2[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume3[] = $row['Volume30'];
                                }
                                $totalNumber3[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume4[] = $row['Volume30'];
                                }
                                $totalNumber4[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if (in_array($row['Status'], ['Keep', 'V2'])) {
                                    $totalVolume5[] = $row['Volume30'];
                                }
                                $totalNumber5[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                            }
                        }
                    }
                    
                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="panelB" class="panel">
    <h1>Stand Table Cut Tree</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = $row['Status'] === 'Cut' ? 1 : 0;
                            }
                        }
                    }
                    
                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="panelC" class="panel">
    <h1>Stand Table Damage</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if (in_array($row['Status'], ['V1', 'V2'])) {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                            }
                        }
                    }
                    
                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="panelD" class="panel">
    <h1>Stand Table Production Year 0</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['diameter'];

                            if ($diameter >= 5 && $diameter <= 15) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = $row['Status'] === 'Cut' ? 1 : 0;
                            } elseif ($diameter > 60) {
                                if ($row['Status'] === 'Cut') {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = $row['Status'] === 'Cut' ? 1 : 0;
                            }
                        }
                    }
                    
                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>

        <h1>Stand Table Production Year 30</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Species Group Name</th>
                    <th colspan="6">Diameter Range</th>
                </tr>
                <tr>
                    <th></th>
                    <th>5cm-15cm</th>
                    <th>15cm-30cm</th>
                    <th>30cm-45cm</th>
                    <th>45cm-60cm</th>
                    <th>60cm+</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Define the categories and initialize rows
                $categories = [
                    ['name' => 'Mersawa', 'spgroup' => 1],
                    ['name' => 'Keruing', 'spgroup' => 2],
                    ['name' => 'DipCommercial', 'spgroup' => 3],
                    ['name' => 'DipNonCommercial', 'spgroup' => 4],
                    ['name' => 'NonDipCommercial', 'spgroup' => 5],
                    ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                    ['name' => 'Others', 'spgroup' => 7]
                ];

                foreach ($categories as $category) {

                    $query = "SELECT * FROM new_forest_60 WHERE spgroup = " . $category['spgroup'];
                    $result = $conn->query($query);
                    $totalVolume1 = $totalVolume2 = $totalVolume3 = $totalVolume4 = $totalVolume5 = array();
                    $totalNumber1 = $totalNumber2 = $totalNumber3 = $totalNumber4 = $totalNumber5 = array();

                    $totalVolume1 = [];
                    $totalVolume2 = [];
                    $totalVolume3 = [];
                    $totalVolume4 = [];
                    $totalVolume5 = [];
                    $totalNumber1 = [];
                    $totalNumber2 = [];
                    $totalNumber3 = [];
                    $totalNumber4 = [];
                    $totalNumber5 = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $diameter = $row['GrowthD30'];
                            

                            if ($diameter >= 5 && $diameter <= 15) {
                                if ($row['production3060'] == 1) {
                                    $totalVolume1[] = $row['Volume'];
                                }
                                $totalNumber1[] = $row['production3060'];
                            } elseif ($diameter > 15 && $diameter <= 30) {
                                if ($row['production3060'] == 1) {
                                    $totalVolume2[] = $row['Volume'];
                                }
                                $totalNumber2[] = $row['production3060'];
                            } elseif ($diameter > 30 && $diameter <= 45) {
                                if ($row['production3060'] == 1) {
                                    $totalVolume3[] = $row['Volume'];
                                }
                                $totalNumber3[] = $row['production3060'];
                            } elseif ($diameter > 45 && $diameter <= 60) {
                                if ($row['production3060'] == 1) {
                                    $totalVolume4[] = $row['Volume'];
                                }
                                $totalNumber4[] = $row['production3060'];
                            } elseif ($diameter > 60) {
                                if ($row['production3060'] == 1) {
                                    $totalVolume5[] = $row['Volume'];
                                }
                                $totalNumber5[] = $row['production3060'];
                            }
                        }
                    }
                    
                    echo "<tr><td rowspan='2'>{$category['name']}</td>";
                    // First row for 'No'
                    echo "  <td>No</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber5)), 2) . "</td>
                        </tr>";
                    // Second row for 'Vol'
                    echo "<tr>
                            <td>Vol</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume1)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume2)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume3)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume4)), 2) . "</td>
                            <td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalVolume5)), 2) . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function showPanel() {
            // Hide all panels
            const panels = document.querySelectorAll('.panel');
            panels.forEach(panel => panel.style.display = 'none');

            // Get the selected panel ID
            const selectedPanel = document.getElementById('panelSelect').value;

            // Show the selected panel
            if (selectedPanel) {
                document.getElementById(selectedPanel).style.display = 'block';
            }
        }
    </script>
    
</body>
</html>
