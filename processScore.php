<!DOCTYPE html>
<html lang="en">
<head>
<title>Score Submission</title>

<meta charset="utf-8">
<meta name="description" content="Score Submission for Archery Australia">
<meta name="keywords" content="Score, Archery, Archery Australia">
<meta name="author" content="Finnley">

<link rel="stylesheet" type="text/css" href="scoreSubmission.css" >
</head>

<body>
<?php
 require_once "settings.php";
/********************/
/* MySQL TABLES */
/********************/

 $tableStaging = "StagingTable";
 $tableStagedRangeScore = "StagedRangeScore";
 $tableStagedEndScore = "StagedRangeScore";
 $tableArcher = "Archer";

 $conn = @mysqli_connect($host, $user, $pwd, $sql_db);


 if (isset($_POST["rangeNumber"]))
 {
    $rangeCount = $_POST["rangeNumber"];

    echo "<p> $rangeCount </p>";
 }


 if (isset($_POST["ArrowScores[]"]))
 {
    $arrowScore = $_POST["ArrowScores[]"];

    foreach($arrowScore as $score)
    {
        echo "<p> $score";
    }
 }



?>
</body>
</html>
