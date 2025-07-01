<!DOCTYPE html>
<html>
<head>
<title>Final Output</title>
    <style>
        :root {
        --color-primary: #0073ff;
        --color-white: #e9e9e9;
        --color-black: #141d28;
        --color-black-1: #212b38;
        --color-table-header: #003366;
        --color-table-row: #1a1a2e;
        --color-table-hover: #0073ff;
        }

        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        }

        body {
        font-family: sans-serif;
        background-color: var(--color-black);
        color: var(--color-white);
        }

        .logo {
        color: var(--color-white);
        font-size: 30px;
        }

        .logo span {
        color: var(--color-primary);
        }

        .menu-bar {
        background-color: var(--color-black);
        height: 80px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%;

        position: relative;
        }

        .menu-bar ul {
        list-style: none;
        display: flex;
        }

        .menu-bar ul li {
        padding: 10px 30px;
        position: relative;
        }

        .menu-bar ul li a {
        font-size: 20px;
        color: var(--color-white);
        text-decoration: none;

        transition: all 0.3s;
        }

        .menu-bar ul li a:hover {
        color: var(--color-primary);
        }

        .fas {
        float: right;
        margin-left: 10px;
        padding-top: 3px;
        }

        .dropdown-menu {
        display: none;
        }

        .menu-bar ul li:hover .dropdown-menu {
        display: block;
        position: absolute;
        left: 0;
        top: 100%;
        background-color: var(--color-black);
        }

        .menu-bar ul li:hover .dropdown-menu ul {
        display: block;
        margin: 10px;
        }

        .menu-bar ul li:hover .dropdown-menu ul li {
        width: 150px;
        padding: 10px;
        }

        .dropdown-menu-1 {
        display: none;
        }

        .dropdown-menu ul li:hover .dropdown-menu-1 {
        display: block;
        position: absolute;
        left: 150px;
        top: 0;
        background-color: var(--color-black);
        }

        .hero {
        height: calc(100vh - 80px);
        background-image: url(./bg.jpg);
        background-position: center;
        }

        table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: var(--color-table-row);
        color: var(--color-white);
        }

        table, th, td {
        border: 1px solid var(--color-white);
        }

        th {
        background-color: var(--color-table-header);
        padding: 10px;
        text-align: center;
        }

        td {
        padding: 10px;
        text-align: center;
        }

        tr:hover {
        background-color: var(--color-table-hover);
        }

        h1 {
        text-align:center;
        }

    </style>
</head>
<body>
    <?php
    include_once("../nav.php");
    ?>

    <div class="hero">
        <?php
            DEFINE ('DB_USER', 'root');
            DEFINE ('DB_PASSWORD', '');
            DEFINE ('DB_HOST', 'localhost');
            DEFINE ('DB_NAME', 'tree');

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
            mysqli_set_charset($conn, 'utf8');

            echo "
                <table>
                <h1>Forest Final Output Regime 50</h1>
                <tr>
                    <th>Species Group</th>
                    <th>Total Volume 0</th>
                    <th>Total Number 0</th>
                    <th>Prod 0</th>
                    <th>Damage 0</th>
                    <th>Remain 0</th>
                    <th>Total Growth 30</th>
                    <th>Total Prod 30</th>
                </tr>
            ";

            $totalVolume = array();
            $totalNumber = array();
            $Prod = array();
            $Damage = array();
            $Remain = array();
            $totalGrowth30 = array();
            $totalProd30 = array();
            $totalProdVolume = array();

            $speciesGroups = [
                ['name' => 'Mersawa', 'spgroup' => 1],
                ['name' => 'Keruing', 'spgroup' => 2],
                ['name' => 'DipCommercial', 'spgroup' => 3],
                ['name' => 'DipNonCommercial', 'spgroup' => 4],
                ['name' => 'NonDipCommercial', 'spgroup' => 5],
                ['name' => 'NonDipNonCommercial', 'spgroup' => 6],
                ['name' => 'Others', 'spgroup' => 7]
            ];

            foreach ($speciesGroups as $group) {
                $query = "SELECT * FROM new_forest_50 WHERE spgroup = " . $group['spgroup'];
                $result = $conn->query($query);
                $totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();

                echo "<tr><td>{$group['name']}</td>";

                $totalVolume = [];
                $totalNumber = [];
                $Prod = [];
                $Damage = [];
                $Remain = [];
                $totalGrowth30 = [];
                $totalProd30 = [];
                $totalProdVolume = []; 

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        if($row['Status'] === 'Cut'){
                            $totalProdVolume[] = $row['Volume'];
                        }else{
                            $totalProdVolume[] = 0;
                        }
                        $totalVolume[] = $row['Volume'];
                        $totalNumber[] = 1;
                        $Prod[] = $row['Status'] === 'Cut' ? 1 : 0;
                        $Damage[] = in_array($row['Status'], ['V1', 'V2']) ? 1 : 0;
                        $Remain[] = in_array($row['Status'], ['Keep', 'V2']) ? 1 : 0;
                        $totalGrowth30[] = $row['GrowthD30'];
                        $totalProd30[] = $row['production3050'];
                    }
                }

                echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalProdVolume)), 2) . "</td>";
                echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalNumber)), 2) . "</td>";
                echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $Prod)), 2) . "</td>";
                echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $Damage)), 2) . "</td>";
                echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $Remain)), 2) . "</td>";
                echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalGrowth30)), 2) . "</td>";
                echo "<td>" . number_format(array_sum(array_map(fn($value) => $value / 100, $totalProd30)), 2) . "</td>";


                echo "</tr>";
            }

            echo "</table>";
        ?>
    </div>
</body>
</html>
