<!DOCTYPE html>
<html>
<head>
<title>Stand Table</title>
</head>
<body>
<?php
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tree');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($conn, 'utf8');

echo "
    <table>
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


//Mersawa
$mersawa_query = "SELECT * FROM new_forest WHERE spgroup = 1";
$result_Mersawa = $conn->query($mersawa_query);
    echo "<tr>";
    echo "<td> Mersawa</td>";
    if ($result_Mersawa->num_rows > 0){
        while($row = $result_Mersawa->fetch_assoc()) {
            $totalVolume[] = $row['Volume'];
            $totalNumber[] = 1;

            if ($row['Status'] == 'Cut'){
                $Prod[] = 1;
            }else{
                $Prod[] = 0;
            }

            if($row['Damage'] == 'V2' || $row['Damage'] == 'V1'){
                $Damage[] = 1;
            }else{
                $Damage[] = 0;
            }

            if ($row['Status'] == 'Keep'){
                $Remain[] = 1;
            }else{
                $Remain[] = 0;
            }
             
            $totalGrowth30[] = $row['GrowthD30'];
            $totalProd30[] = $row['production30'];
        }
    }
    echo "<td>".array_sum($totalVolume)."</td>";
    echo "<td>".array_sum($totalNumber)."</td>";
    echo "<td>".array_sum($Prod)."</td>";
    echo "<td>".array_sum($Damage)."</td>";
    echo "<td>".array_sum($Remain)."</td>";
    echo "<td>".array_sum($totalGrowth30)."</td>";
    echo "<td>".array_sum($totalProd30)."</td>";
    echo "</tr>";
//Keruing
$Keruing_query = "SELECT * FROM new_forest WHERE spgroup = 2";
$result_Keruing = $conn->query($Keruing_query);
$totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();  // Clear arrays
echo "<tr>";
echo "<td>Keruing</td>";
if ($result_Keruing->num_rows > 0){
    while($row = $result_Keruing->fetch_assoc()) {
        $totalVolume[] = $row['Volume'];
        $totalNumber[] = 1;

        if ($row['Status'] == 'Cut'){
            $Prod[] = 1;
        }else{
            $Prod[] = 0;
        }

        if($row['Damage'] == 'V2' || $row['Damage'] == 'V1'){
            $Damage[] = 1;
        }else{
            $Damage[] = 0;
        }

        if ($row['Status'] == 'Keep'){
            $Remain[] = 1;
        }else{
            $Remain[] = 0;
        }
         
        $totalGrowth30[] = $row['GrowthD30'];
        $totalProd30[] = $row['production30'];
    }
}
echo "<td>".array_sum($totalVolume)."</td>";
echo "<td>".array_sum($totalNumber)."</td>";
echo "<td>".array_sum($Prod)."</td>";
echo "<td>".array_sum($Damage)."</td>";
echo "<td>".array_sum($Remain)."</td>";
echo "<td>".array_sum($totalGrowth30)."</td>";
echo "<td>".array_sum($totalProd30)."</td>";
echo "</tr>";
//DipCommercial
$DipCommercial_query = "SELECT * FROM new_forest WHERE spgroup = 3";
$result_DipCommercial = $conn->query($DipCommercial_query);
$totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();  // Clear arrays
echo "<tr>";
echo "<td>DipCommercial</td>";
if ($result_DipCommercial->num_rows > 0){
    while($row = $result_DipCommercial->fetch_assoc()) {
        $totalVolume[] = $row['Volume'];
        $totalNumber[] = 1;

        if ($row['Status'] == 'Cut'){
            $Prod[] = 1;
        }else{
            $Prod[] = 0;
        }

        if($row['Damage'] == 'V2' || $row['Damage'] == 'V1'){
            $Damage[] = 1;
        }else{
            $Damage[] = 0;
        }

        if ($row['Status'] == 'Keep'){
            $Remain[] = 1;
        }else{
            $Remain[] = 0;
        }
         
        $totalGrowth30[] = $row['GrowthD30'];
        $totalProd30[] = $row['production30'];
    }
}
echo "<td>".array_sum($totalVolume)."</td>";
echo "<td>".array_sum($totalNumber)."</td>";
echo "<td>".array_sum($Prod)."</td>";
echo "<td>".array_sum($Damage)."</td>";
echo "<td>".array_sum($Remain)."</td>";
echo "<td>".array_sum($totalGrowth30)."</td>";
echo "<td>".array_sum($totalProd30)."</td>";
echo "</tr>";
//DipNonCommercial
$DipNonCommercial_query = "SELECT * FROM new_forest WHERE spgroup = 4";
$result_DipNonCommercial = $conn->query($DipNonCommercial_query);
$totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();  // Clear arrays
echo "<tr>";
echo "<td>DipNonCommercial</td>";
if ($result_DipNonCommercial->num_rows > 0){
    while($row = $result_DipNonCommercial->fetch_assoc()) {
        $totalVolume[] = $row['Volume'];
        $totalNumber[] = 1;

        if ($row['Status'] == 'Cut'){
            $Prod[] = 1;
        }else{
            $Prod[] = 0;
        }

        if($row['Damage'] == 'V2' || $row['Damage'] == 'V1'){
            $Damage[] = 1;
        }else{
            $Damage[] = 0;
        }

        if ($row['Status'] == 'Keep'){
            $Remain[] = 1;
        }else{
            $Remain[] = 0;
        }
         
        $totalGrowth30[] = $row['GrowthD30'];
        $totalProd30[] = $row['production30'];
    }
}
echo "<td>".array_sum($totalVolume)."</td>";
echo "<td>".array_sum($totalNumber)."</td>";
echo "<td>".array_sum($Prod)."</td>";
echo "<td>".array_sum($Damage)."</td>";
echo "<td>".array_sum($Remain)."</td>";
echo "<td>".array_sum($totalGrowth30)."</td>";
echo "<td>".array_sum($totalProd30)."</td>";
echo "</tr>";
//NonDipCommercial
$NonDipCommercial_query = "SELECT * FROM new_forest WHERE spgroup = 5";
$result_NonDipCommercial = $conn->query($NonDipCommercial_query);
$totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();  // Clear arrays
echo "<tr>";
echo "<td>NonDipCommercial</td>";
if ($result_DipNonCommercial->num_rows > 0){
    while($row = $result_NonDipCommercial->fetch_assoc()) {
        $totalVolume[] = $row['Volume'];
        $totalNumber[] = 1;

        if ($row['Status'] == 'Cut'){
            $Prod[] = 1;
        }else{
            $Prod[] = 0;
        }

        if($row['Damage'] == 'V2' || $row['Damage'] == 'V1'){
            $Damage[] = 1;
        }else{
            $Damage[] = 0;
        }

        if ($row['Status'] == 'Keep'){
            $Remain[] = 1;
        }else{
            $Remain[] = 0;
        }
         
        $totalGrowth30[] = $row['GrowthD30'];
        $totalProd30[] = $row['production30'];
    }
}
echo "<td>".array_sum($totalVolume)."</td>";
echo "<td>".array_sum($totalNumber)."</td>";
echo "<td>".array_sum($Prod)."</td>";
echo "<td>".array_sum($Damage)."</td>";
echo "<td>".array_sum($Remain)."</td>";
echo "<td>".array_sum($totalGrowth30)."</td>";
echo "<td>".array_sum($totalProd30)."</td>";
echo "</tr>";
//NonDipNonCommercial
$NonDipNonCommercial_query = "SELECT * FROM new_forest WHERE spgroup = 6";
$result_NonDipNonCommercial = $conn->query($NonDipNonCommercial_query);
$totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();  // Clear arrays
echo "<tr>";
echo "<td>NonDipCommercial</td>";
if ($result_NonDipNonCommercial->num_rows > 0){
    while($row = $result_NonDipNonCommercial->fetch_assoc()) {
        $totalVolume[] = $row['Volume'];
        $totalNumber[] = 1;

        if ($row['Status'] == 'Cut'){
            $Prod[] = 1;
        }else{
            $Prod[] = 0;
        }

        if($row['Damage'] == 'V2' || $row['Damage'] == 'V1'){
            $Damage[] = 1;
        }else{
            $Damage[] = 0;
        }

        if ($row['Status'] == 'Keep'){
            $Remain[] = 1;
        }else{
            $Remain[] = 0;
        }
         
        $totalGrowth30[] = $row['GrowthD30'];
        $totalProd30[] = $row['production30'];
    }
}
echo "<td>".array_sum($totalVolume)."</td>";
echo "<td>".array_sum($totalNumber)."</td>";
echo "<td>".array_sum($Prod)."</td>";
echo "<td>".array_sum($Damage)."</td>";
echo "<td>".array_sum($Remain)."</td>";
echo "<td>".array_sum($totalGrowth30)."</td>";
echo "<td>".array_sum($totalProd30)."</td>";
echo "</tr>";
//Others
$Others_query = "SELECT * FROM new_forest WHERE spgroup = 7";
$result_Others = $conn->query($Others_query);
$totalVolume = $totalNumber = $Prod = $Damage = $Remain = $totalGrowth30 = $totalProd30 = array();  // Clear arrays
echo "<tr>";
echo "<td>Others</td>";
if ($result_Others->num_rows > 0){
    while($row = $result_Others->fetch_assoc()) {
        $totalVolume[] = $row['Volume'];
        $totalNumber[] = 1;

        if ($row['Status'] == 'Cut'){
            $Prod[] = 1;
        }else{
            $Prod[] = 0;
        }

        if($row['Damage'] == 'V2' || $row['Damage'] == 'V1'){
            $Damage[] = 1;
        }else{
            $Damage[] = 0;
        }

        if ($row['Status'] == 'Keep'){
            $Remain[] = 1;
        }else{
            $Remain[] = 0;
        }
         
        $totalGrowth30[] = $row['GrowthD30'];
        $totalProd30[] = $row['production30'];
    }
}
echo "<td>".array_sum($totalVolume)."</td>";
echo "<td>".array_sum($totalNumber)."</td>";
echo "<td>".array_sum($Prod)."</td>";
echo "<td>".array_sum($Damage)."</td>";
echo "<td>".array_sum($Remain)."</td>";
echo "<td>".array_sum($totalGrowth30)."</td>";
echo "<td>".array_sum($totalProd30)."</td>";
echo "</tr>";

?>

</body>
</html>