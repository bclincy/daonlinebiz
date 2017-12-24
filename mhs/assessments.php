<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Muskegon Heights School Academy Assessments and Data Information</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<h1>Assessement data</h1>
        <h1>Testing Data</h1>
        <form>
         <p><label for="testing">Grade:</label><select name="testing">
         <option selected="selected">Pick a Grade Level</option>
        <option>1st Grade</option>
        </select></p>
         <p><label>Testing Standard</label><select name="standard">
          <option selected="selected">Select Test</option>
         </select></p>
         <p><label for="schoo">By School</label><select name="school"><option selected="selected">Pick a School</option></select></p>
        </form>
        <ul>
        <li><a href="edgewoodgle2012-13.php">Egdewood GLE Testing</a></li>
        <li><a href="ACTCReadStand.php">10th Grade ACT Reading Standards</a></li>
        <li><a href="ACTBaseAchievement.php">ACT Baseline &amp; Achievement Gap</a></li>
        <li><a href="mmesnapshot.php">2011-12 MME SnapShot</a></li>
        </ul>

<? include_once('footer.php'); ?>
</body>
</html>