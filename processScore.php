<!-- / adding the range to the db
        $insertRange = "INSERT INTO $tableStagedRangeScore (StagedID) SELECT MAX(StagedID) FROM $tableStaging";

        $insertRangeResult = mysqli_query($conn, $insertRange);

        //will flag if the data was not sent correctly and notify the user
        if(!$insertResult) {
            echo "<p>Error: Score could not be added at this time.</p>";
        }
    -->


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
