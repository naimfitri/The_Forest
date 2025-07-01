<!DOCTYPE html>
<html>
<head>
    <title>Species Table</title>
</head>
<body>

<h1>Species Information</h1>
<p>This table displays species codes, names, and group codes.</p>

<table border="1">
    <tr>
        <th>Species Code</th>
        <th>Species</th>
        <th>Species Group Code</th>
        <th>Name Group</th>
    </tr>
    <?php
    $sCode = array();
    $species = array();
    $spCode = array();
    $sGroupCode = array("1","2","3","4","5","6","7");
    $Dupl = array_unique($sGroupCode);

    $sGroupName = array(
        "Mersawa",
        "Keruing",
        "Dip Commercial",
        "Dip NonCommercial",
        "NonDip Commercial",
        "NonDip NonCommercial",
        "Others"

    );
    $SpName = [
        "PHDEAK",
        "CHHOETEAL BANGKOUNEANGO",
        "CHHOETEAL BRENG",
        "CHHOETEAL CHHNGAR",
        "CHHOETEAL MOSAU",
        "CHORCHONG",
        "CHRASMAS",
        "KOKI MOSAU",
        "KOKI PHNONG\\KAMNHAN",
        "LUMBOR",
        "PHCEK",
        "TBENG",
        "KCHOV/KAMLENG",
        "KOKI DEK",
        "KOKI KHASAC",
        "KOKI THMOR",
        "POPEL",
        "RAING PHNOM",
        "TRORLAT",
        "ANGKOT KHMAU",
        "ATITH/NEANG PHOR EK",
        "BENG",
        "BOSNEAK",
        "CHAM BAK",
        "CHHOEU KHMAV/NEANG KHMAV",
        "CHOEUNG KO",
        "CHAN KRASNA",
        "CHHLIK",
        "CHHAM CHHA",
        "CHAN TOUM PEANG",
        "DONCHERM",
        "DEY KHLA",
        "HOUN DAN/MOREASPREOUPHNOM",
        "KOMPENG REACH",
        "KRAY",
        "KROEL",
        "KRORKORS",
        "KRORNHOUNG",
        "KRAY SAR",
        "MEYSAK",
        "NEANG NOUN",
        "PRAM DOMLENG",
        "PRO LOUP",
        "PRING/KRORB BEK",
        "SOKROM",
        "SAM PONG",
        "SRAL",
        "SROL KRAHAM",
        "SRORLAO",
        "SROL SAR",
        "SVAY PREY",
        "SVAY CHAM REANG",
        "TAOUR",
        "TEP PHIROU",
        "THNONG KROHORM",
        "THNONG SOR",
        "TRORP TOM",
        "TROR YING",
        "TATRAV",
        "ANGKANH",
        "ANGKAT TMAAT",
        "ANGKRANG PHNOM",
        "ATEANG/ROTEANG",
        "BAK DERM",
        "BANGKANG",
        "BAKDORNG",
        "BELOY",
        "BANGKEOU SVA",
        "BAG KHEOU",
        "BAY POU VAING",
        "KHCHOENG",
        "CHOEUNG CHAB",
        "CHAMRIEK",
        "CHORNY",
        "CHHOE PHLOEUNG",
        "CHRAKENG",
        "CHANG KONG ROMEANG",
        "CHREIS",
        "CHORNG UOR THMAT",
        "CHEK TUM",
        "CHREY",
        "DONGKOR",
        "DOK MEY",
        "HAISANH/NGAYSANG/CHANSAR",
        "KANGSENGPHNOM",
        "KCHAS",
        "KANN DEANG",
        "KDURCH",
        "KDOL",
        "KES",
        "KONG KANGCHHMOL",
        "KONG KANGNHY",
        "KONG KANGPHNOM",
        "KANNDOL",
        "KHNOR PREY",
        "KRANG",
        "KREAS",
        "KRORBAO",
        "KRORLANH",
        "KRONG",
        "KHTOM",
        "KHVAO",
        "LO NGIENG",
        "MAK BREING",
        "MAK PRANG",
        "MAK KLOEU",
        "MEAN PREY",
        "NEANG SAR",
        "PANG",
        "PHNHEAV",
        "PHAONG",
        "PROR HOUT",
        "PLONG",
        "PHNEANG",
        "PHNGEAS",
        "POPUOL BAY",
        "PON SVAR",
        "POPEA KHE",
        "PONG RO",
        "POPULTHMOR",
        "PHNEL/POPOUL",
        "PREAS PHNOV/SOMBOK KROHOM",
        "PROUS",
        "PHKAI PROEK",
        "RAING TOEK",
        "ROKA",
        "ROUNG",
        "SAMBOUR LOVENG",
        "SAM RONG",
        "SAMBOUR MEAS",
        "SDAV",
        "SDEY",
        "SLENG",
        "SMACH",
        "SME",
        "SMA KRABEY",
        "SNAY",
        "SNUOL",
        "SOURY",
        "SOM POR",
        "SPEOU PREY",
        "SPEOU TEK",
        "SRAKOM",
        "SVAY SVAK",
        "SVAY CHANTI",
        "SVAY PONGTRONG",
        "TKOV",
        "THLOK",
        "TOUNLORP",
        "TOM POUNG",
        "TRANG",
        "TRA MENG",
        "TRORMOUNG",
        "TRORMOUNGSEK",
        "VOR YONG",
        "ACH SAT",
        "ACHDERK",
        "ANGKEA SEL",
        "AMBENG BEK",
        "AMBENG CHAN",
        "AMPIL TOEUK PREY",
        "ANGKOCH",
        "ANGKEA BOS",
        "ANGRE DEK",
        "APHEAN",
        "ATES",
        "ANNTUNG SOR",
        "BANGKONG KENGKONG",
        "BAKPAO",
        "BOR BORK",
        "BO PROEUK",
        "BROR CHOK",
        "BATPHTIL",
        "CHAM BAK BARAING",
        "CHHOENG CHKER",
        "CHANG ENG SEK",
        "CHHAR",
        "CHHOM POU PREY",
        "CHEUNG KRORVAING",
        "CHUNGKONG PHON",
        "CHEUNG KRAPEU",
        "CHORNLOS",
        "CHANG NANG",
        "CHNOK",
        "CHOV",
        "CHHOETEAL PREUS",
        "CHNOK TROU",
        "CHORNTESPLOUK",
        "DANG KEAP KDAM",
        "DANGKEABPROEUS",
        "DOKPO",
        "DOUNKAY",
        "DORNG DAV",
        "DEY SAMPOCH",
        "EYSEIPHSAM SRACH",
        "KACHEAL",
        "KAKHUCH",
        "KANA",
        "KANER",
        "KANTOUT PREY",
        "KATOUNG",
        "KA YOUK",
        "KRORLORNG",
        "KANCHOEU BEY DACH",
        "KBAL DERK",
        "KROBAO KHEK",
        "KA CHIEP",
        "KANDAB CHANG ET",
        "KDOR COMBROK",
        "KHANNMA",
        "KHNHE",
        "KHOS",
        "KHTING",
        "KHVENG",
        "KALKAL",
        "KALAP",
        "KBAL KRORLORNG",
        "KLING",
        "KLOUNG",
        "KLENG POR",
        "KOM PERT",
        "KNALL",
        "KNAY MORN",
        "KORNDORK",
        "KON KHMOM",
        "KOKTMAT",
        "KO MOUY",
        "KORK",
        "KORTHET",
        "KRORCHORK ANDERK",
        "KROENG",
        "KROR EM",
        "KROR MOURN",
        "KROCH PREY",
        "KRORNG SOEUR",
        "KHOES REOUS",
        "KRORVANN",
        "KTITH",
        "LORT",
        "LOR VEA",
        "LORVING",
        "LORLOT",
        "MADEHN",
        "MADEHN MEAS",
        "MOR MANG",
        "MLOUTRAYOUK",
        "NGOK",
        "NHAM",
        "NIV",
        "ONLOK PHOR EM",
        "PA NGAB",
        "PA NGES",
        "PECH CHANGVA",
        "PHLANG",
        "PHNERK CHMA",
        "PHNOM PHNERNG",
        "PHOR",
        "PLOV NEANG",
        "PLUOUNG",
        "PLONG KEOV",
        "PLOR",
        "PLOV SOMPOUCH",
        "PROMOY VIENG",
        "PHNEK PREAP",
        "PON ORMBORK",
        "POUCH",
        "PO PLEAR",
        "POUN",
        "POPLEA PRUES",
        "POPOULVAK",
        "PREAL",
        "PROMAT KHLAKMOM",
        "PROUM",
        "RAING",
        "ROM CHORNG",
        "ROMDOUL",
        "ROMLEANG",
        "ROMENGTHA NGE0Y",
        "ROVIENG",
        "ROMPEAT CHROUK",
        "SANDA",
        "SANG HA",
        "SANDAN",
        "SANGKROV",
        "SANTOUCH",
        "SBOUNG",
        "SOAVIEN",
        "SRE RUSSEI",
        "SOMBO",
        "SOUEM",
        "SONTHOM",
        "SOMPOR",
        "SOUYNG",
        "SPONG",
        "SPRAIT MEAS",
        "STENG",
        "SVAY PHDAAVENG",
        "TA OK",
        "TAOK",
        "TANG BAK",
        "TANGDONG",
        "TANG TAV",
        "TANORN",
        "TAOK VENG",
        "TANG SAT",
        "TAOR",
        "TBUNG",
        "THOL",
        "THLENGKOUV",
        "THORNTAYOUK",
        "THMEAN",
        "THMEIN",
        "THMOUL KOK",
        "THPEUNG",
        "TOEUCK KANGKOR",
        "TOEU CHHOS",
        "TOEU MOAN",
        "TOUCH PREY",
        "TRACH KERSEAVENG",
        "TRACH KHLONG",
        "TRALORNG",
        "TRASUOK",
        "TRASOL",
        "TROU",
        "TRORLAS",
        "TRONGMOT",
        "VA",
        "YAM REAH"
    ];

    for ($i = 0; $i < 300; $i++) {
        $sCode[] = $i;
        $species[] = "Species".$i;
        $spCode[] = rand(0,317);

        
        // for ($i = 0; $i < 300; $i++) {

//     $SpBlockX[] = $blokX;
//     $SpBlockY[] = $blokY;

//     $SpNo[] = $i;
//     $SpCode[] = rand(1, count($SpName) - 1);
//     $SpCoorX[] = rand(0,100);
//     $SpCoorY[] = rand(0,100);

//     if ($SpCode[$i] == 1){
//         $SpGroupCode[] = 1;
//     }
//     else if ($SpCode[$i] > 1 && $SpCode[$i] <= 5){
//         $SpGroupCode[] = 2;
//     }
//     else if ($SpCode[$i] == 317 || $SpCode[$i] ==318){
//         $SpGroupCode[] = 2;
//     }
//     else if ($SpCode[$i] > 5 && $SpCode[$i] <= 13){
//         $SpGroupCode[] = 3;
//     }
//     else if ($SpCode[$i] > 13 && $SpCode[$i] <= 19){
//         $SpGroupCode[] = 4;
//     }
//     else if ($SpCode[$i] > 19 && $SpCode[$i] <= 59){
//         $SpGroupCode[] = 5;
//     }
//     else if ($SpCode[$i] > 59 && $SpCode[$i] <= 155){
//         $SpGroupCode[] = 6;
//     }
//     else if ($SpCode[$i] > 155 && $SpCode[$i] <= 316){
//         $SpGroupCode[] = 7;
//     }else{
//         $SpGroupCode[] = 0;
//     }

//     if(($i + 1) % 10 == 0){
//         $blokX++;
//     }
//     else if(($i + 1) % 20 == 0){
//         $blokY++;
//     }
//     else if($blokY > 10){
//         $blokY = 0;
//     }

        
//     }
        
    }
    
    for ($i = 0; $i < count($sCode); $i++) {
        echo "<tr>";
        echo "<td>" . $sCode[$i] . "</td>";
        echo "<td>" . $SpName[$spCode[$i]] . "</td>";
        echo "<td>" . $spCode[$i] . "</td>";
        
        if ($spCode[$i] == 1){
        	echo "<td> Group ".$sGroupCode[0]."</td>";
        }
        else if ($spCode[$i] > 1 && $spCode[$i] < 6){
        	echo "<td> Group ".$sGroupCode[1]."</td>";
        }
        else if ($spCode[$i] > 6 && $spCode[$i] < 13){
        	echo "<td> Group ".$sGroupCode[2]."</td>";
        }
        else if ($spCode[$i] > 13 && $spCode[$i] < 20){
        	echo "<td> Group ".$sGroupCode[3]."</td>";
        }
        else if ($spCode[$i] > 20 && $spCode[$i] < 60){
        	echo "<td> Group ".$sGroupCode[4]."</td>";
        }
        else if ($spCode[$i] > 60 && $spCode[$i] < 156){
        	echo "<td> Group ".$sGroupCode[5]."</td>";
        }
        else if ($spCode[$i] > 156 && $spCode[$i] < 318){
        	echo "<td> Group ".$sGroupCode[6]."</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
<br>
<table border="1">
    <tr>
        <th>Species Group Code</th>
        <th>Name Group</th>
    </tr>
    <?php
    

    
    for ($i = 0; $i < count($Dupl); $i++) {
        echo "<tr>";
  
        echo "<td>" . $sGroupCode[$i] . "</td>";
        echo "<td> ".$sGroupName[$sGroupCode[$i]]."</td>";


        // if ($sGroupCode[$i] == "1"){
        // 	echo "<td> ".$sGroupName[$sGroupCode[$i]]."</td>";
        // }
        // if ($sGroupCode[$i] == "2"){
        // 	echo "<td> Group 2 </td>";
        // }
        echo "</tr>";
    }
    ?>
</table>

<table border="1">
    <tr>
        <th>Species Code</th>
        <th>Species</th>
        <th>Species Group Code</th>
        <!-- <th>Species Rand</th> -->
        <th>BlockX</th>
        <th>BlockY</th>
        <th>Xcoor</th>
        <th>Ycoor</th>
        <th>Diameter</th>
        <th>Height</th>
        <th>Volume</th>
    </tr>
    <?php
    $Xcood = array();
    $Ycood = array();
    $speciesRand = array();
    $Diameter = array();
    $Height = array();
    $volume = array();
    $blokX = array();
    $blokY = array();

    for ($i = 0; $i < count($sCode); $i++) {
        $Xcoor[] = rand(1, 100);
        $Ycoor[] = rand(1, 100);
        // $speciesRand[] = rand(1, 10);
        $Diameter[] = rand(300, 1000)/10;
        $Height[] = rand(15, 40);
    }

    for ($i = 0; $i < count($sCode); $i++ ) {
        
        
       

        echo "<tr>";
        echo "<td>" . $sCode[$i] . "</td>";
        echo "<td>" . $species[$i] . "</td>";

        if ($spCode[$i] == 1){
        	echo "<td> Group ".$sGroupCode[0]."</td>";
        }
        else if ($spCode[$i] > 1 && $spCode[$i] < 6){
        	echo "<td> Group ".$sGroupCode[1]."</td>";
        }
        else if ($spCode[$i] > 6 && $spCode[$i] < 13){
        	echo "<td> Group ".$sGroupCode[2]."</td>";
        }
        else if ($spCode[$i] > 13 && $spCode[$i] < 20){
        	echo "<td> Group ".$sGroupCode[3]."</td>";
        }
        else if ($spCode[$i] > 20 && $spCode[$i] < 60){
        	echo "<td> Group ".$sGroupCode[4]."</td>";
        }
        else if ($spCode[$i] > 60 && $spCode[$i] < 156){
        	echo "<td> Group ".$sGroupCode[5]."</td>";
        }
        else if ($spCode[$i] > 156 && $spCode[$i] < 318){
        	echo "<td> Group ".$sGroupCode[6]."</td>";
        }

        // echo "<td>" . $speciesRand[$i] . "</td>";
        echo "<td>" . $bX . "</td>";
        echo "<td>" . $bY . "</td>";
        echo "<td>" . $Xcoor[$i] . "</td>";
        echo "<td>" . $Ycoor[$i] . "</td>";
        echo "<td>" . $Diameter[$i] . "</td>";
        echo "<td>" . $Height[$i] . "</td>";

        if ($Diameter[$i] < 15){
            $Volume = 0.022 + 3.4 * pow($Diameter[$i], 2);
            // $volume[] = $Volume;
            echo "<td>" . $Volume . "</td>";
        }

        else if ($Diameter[$i] > 15){
            $Volume = 0.015 + 2.137 * pow($Diameter[$i], 2) + (0.513 * pow($Diameter[$i], 2))*$Height[$i] ;
            // $volume[] = $Volume;
            echo "<td>" . $Volume . "</td>";
        }

        echo "<td>" . $z . "</td>";
        
        echo "</tr>";
    }
    ?>
</table>

<table border="1">
    <tr>
        <th>Species Group Code</th>
        <th>Diameter 5-15</th>
        <th>Diameter 15-30</th>
        <th>Diameter 30-45</th>
        <th>Diameter 45-60</th>
        <th>Diameter 60+</th>
    </tr>
    <?php
    $uniqueGroups = array_unique($sGroupCode);

    $sum1 = 0;
    $sum2 = 0;
    $sum3 = 0;
    $sum4 = 0;
    $sum5 = 0;

    
    
    foreach ($uniqueGroups as $group) {
        
        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $sum4 = 0;
        $sum5 = 0;

        for ($i = 0; $i < count($sGroupCode); $i++) {
            
            if ($sGroupCode[$i] == $group) {
                if ($Diameter[$i] > 30 && $Diameter[$i] < 45) {
                    $sum1++;
                }
                else if ($Diameter[$i] > 45 && $Diameter[$i] < 60) {
                    $sum2++;
                }
                else if ($Diameter[$i] > 45 && $Diameter[$i] < 60) {
                    $sum3++;
                }
                else if ($Diameter[$i] > 45 && $Diameter[$i] < 60) {
                    $sum4++;
                }
                if ($Diameter[$i] > 60) {
                    $sum5++;
                }
            }
        }
        echo "<tr>";
        echo "<td>" . $group . "</td>";
        echo "<td>" . $sum1 . "</td>";
        echo "<td>" . $sum2 . "</td>";
        echo "<td>" . $sum3 . "</td>";
        echo "<td>" . $sum4 . "</td>";
        echo "<td>" . $sum5 . "</td>";
        echo "</tr>";
    }
    
    ?>
</table>



</body>
</html>
