<!DOCTYPE html>
<html lang="en">
<head>
<title>Score Submission</title>

<meta charset="utf-8">
<meta name="description" content="Score Submission for Archery Australia">
<meta name="keywords" content="Score, Archery, Archery Australia">
<meta name="author" content="Finnley">

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    margin: auto;
    padding: 4px;
    text-align: center;
  }
body {
    text-align: center;
}
</style>

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

    //data will only be sent and a confirmation page will only show if connection is successful
 if ($conn) {
    /*******************************************************************/
    /* CHECKING ALL MANDATORY FIELDS HAVE DATA + ASSIGNING VARIABLES   */
    /*******************************************************************/
    if (isset($_POST["ArcherID"])) {
        $archerID = $_POST["ArcherID"];
    }

    if (isset($_POST["RoundType"])) {
        $roundName = $_POST["RoundType"];
    }

    if (isset($_POST["ScoreDate"])) {
        $scoreDate = $_POST["ScoreDate"];
    }

    if (isset($_POST["ScoreTime"])) {
        $scoreTime = $_POST["ScoreTime"];
    }

    if (isset($_POST["EquipmentType"])) {
    $equipmentType = $_POST["EquipmentType"];
    }
    /**********************************************************************/
    /* SENDING SCORE DATA
    /**********************************************************************/

    $insertData = "INSERT INTO $tableStaging (ArcherID ,RoundName ,ScoreDate ,ScoreTime ,Equipment ,Approved)
    VALUES ('$archerID','$roundName','$scoreDate','$scoreTime','$equipmentType','0')";

    $insertResult = mysqli_query($conn, $insertData);

    //will flag if the data was not sent correctly and notify the user
    if(!$insertResult) {
        echo "<p>Error: Score could not be added at this time.</p>";
    }

    /**********************************************************************/
    /* COLLECTING RANGE SCORES
    /**********************************************************************/

    $nameFQuery = "SELECT (FirstName) FROM Archer WHERE ArcherID = $archerID";
    $findNameF = mysqli_query($conn, $nameFQuery);
    $nameFRow = mysqli_fetch_assoc($findNameF);
    $userNameF = $nameFRow["FirstName"];

    echo "<h1>New Score Submission</h1>";
    echo "<p><i>Hello, $userNameF!</i>";
    echo "<p> Your chosen round is: <b>$roundName</b></p>";
    echo "<p> The ranges for your round are displayed below. </p>";

    $sqlRound = "SELECT Distance
	    ,NumOfEnds
	    ,TargetFaceSize
        FROM RangeType
        WHERE RangeID IN (
		SELECT RangeID
		FROM RangesInRound
		WHERE RoundName = '$roundName'
		)";
    $resultRound = mysqli_query($conn, $sqlRound);
    $resultCheck = mysqli_num_rows($resultRound);

    // PRINTING TABLE WITH RANGE DETAILS
    if ($resultCheck > 0)
    {
        // to know how many ranges to print later
        $arrayRangeEndCount = array();

        echo "<table><tr>
        <th>Distance</th>
        <th>Number of ends</th>
        <th>Target Face Size</th>
        </tr>
        <tr>";

       while($rowRound = mysqli_fetch_assoc($resultRound))
       {
            echo "<td>" . $rowRound['Distance'] . "</td>";
            echo "<td>" . $rowRound['NumOfEnds'] . "</td>";
            echo "<td>" . $rowRound['TargetFaceSize'] . "</td></tr>";
            $arrayRangeEndCount[] = $rowRound['NumOfEnds'];
        }
        echo "</table><br><br>";
    }

    // ENTERING SCORES
    ?>
    <form method="post" action="processScore.php">

	<fieldset><legend>New Score Details</legend>

    <p>Please enter in all arrow scores for each end. Arrow scores should be entered highest to lowest.</p>

    <?php
    $count = 1;

    foreach ($arrayRangeEndCount as $currentRangeEndCount)
    {
        echo "<br><h2>Range $count</h2><br><hr>";
        $count += 1;

        $endCount = 1;
        while ($endCount <= $currentRangeEndCount)
        {
            echo "<p><b>End $endCount</b></p>";

            $arrowCount = 1;
            for ($i = 1; $i <= 6; $i++)
            {
                echo "<p class=\"row\"><label for=\"ArrowScores[]\">Arrow $i: </label>
                <input type=\"number\" name=\"ArrowScores[]\" id=\"arrowScore\" required=\"true\" max=\"10\"/></p>";
            }
            $endCount +=1;
        }
        echo "<hr>";
    }

    echo "<form action=\"processScore.php\" method=\"post\">
          <input type=\"hidden\" name=\"rangeNumber\" value= $count/>
          </form>";

    }

    else {
        echo "Error: Connection to Database failed. Please try again later.<br>";
    }
    ?>
    <p>	<input type="submit" value="Add New Score" /></p>
	</fieldset>
	</form>
</body>
</html>

