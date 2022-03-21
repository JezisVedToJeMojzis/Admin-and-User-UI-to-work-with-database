<?php
require_once "MyPdo.php";
require_once "Word.php";
require_once "Translation.php";

$servername = //add yours
$username =  //add yours
$password =  //add yours
$dbname =  //add yours

// Connect to DB
$conn = new myPDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Upload CSV file into DB
if(isset($_FILES['file'])){
    $file = fopen($_FILES['file']['tmp_name'],"r");
    while(!feof($file)){
        $array=fgetcsv($file,null,";");
        if($array[0]) {
            $word = new Word($conn);
            $word->setTitle($array[0]);
            $word->save();

            $englishTranslation = new Translation($conn);
            $englishTranslation->setTitle($array[0]);
            $englishTranslation->setDescription($array[1]);
            $englishTranslation->setLanguageId(1);
            $englishTranslation->setWordId($word->getId());
            $englishTranslation->save();

            $slovakTranslation = new Translation($conn);
            $slovakTranslation->setTitle($array[2]);
            $slovakTranslation->setDescription($array[3]);
            $slovakTranslation->setLanguageId(2);
            $slovakTranslation->setWordId($word->getId());
            $slovakTranslation->save();

        }
    }
}

// Upload term into DB
$titleEN =  $_REQUEST['titleEN'];
$titleSK = $_REQUEST['titleSK'];
$descriptionEN =  $_REQUEST['descriptionEN'];
$descriptionSK = $_REQUEST['descriptionSK'];

$toAdd = [$titleEN,$descriptionEN,$titleSK,$descriptionSK]; //like array in Upload CSV

if(isset($_POST["titleEN"]) && isset($_POST["descriptionEN"]) && isset($_POST["titleSK"]) && isset($_POST["descriptionSK"])) {
    $newWord = new Word($conn);
    $newWord->setTitle($toAdd[0]);
    $newWord->save();

    $englishTranslation = new Translation($conn);
    $englishTranslation->setTitle($toAdd[0]);
    $englishTranslation->setDescription($toAdd[1]);
    $englishTranslation->setLanguageId(1);
    $englishTranslation->setWordId($newWord->getId());
    $englishTranslation->save();

    $slovakTranslation = new Translation($conn);
    $slovakTranslation->setTitle($toAdd[2]);
    $slovakTranslation->setDescription($toAdd[3]);
    $slovakTranslation->setLanguageId(2);
    $slovakTranslation->setWordId($newWord->getId());
    $slovakTranslation->save();

    $titleEN =  null;
    $titleSK = null;
    $descriptionEN =  null;
    $descriptionSK = null;
}

//Modify data in DB by ID (just description)
if(isset($_POST["modID"]) && isset($_POST["newDescription"])) {
    $modID = $_REQUEST['modID'];
    $newDes = $_REQUEST['newDescription'];

    $sql = "UPDATE translations SET description='$newDes' WHERE id='$modID'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}



// Delete term from DB by ID
if(isset($_POST["delID"])) {
    $delID = $_REQUEST['delID'];

     $sql = "SET FOREIGN_KEY_CHECKS = 0;
            DELETE FROM words WHERE id= '$delID';
            DELETE FROM translations WHERE word_id = '$delID';
            SET FOREIGN_KEY_CHECKS = 1;";
     $stmt = $conn->prepare($sql);
     $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin UI</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Admin UI</h1>

<hr>

<div id = "container">
<form action ="admin.php" method="post" enctype="multipart/form-data">
    <h2>Upload CSV file into DB:</h2>
    <div>
        <label for="file">File:</label>
        <input id="file" name="file" type="file">
    </div>
    <div>
        <input id="btn" type="submit" value="Upload">
    </div>
</form>
</div>

<hr>

<div id = "container">
<form action ="admin.php" method="post" enctype="multipart/form-data">
        <h2>Upload term into DB:</h2>
        <div>
            <label for="titleEN">Title (EN):</label>
            <input id="titleEN" name="titleEN" type="text">
        </div>
        <div>
            <label for="titleSK">Názov (SK):</label>
            <input id="titleSK" name="titleSK" type="text">
        </div>
        <div>
            <label for="descriptionEN">Description (EN):</label>
            <input id="descriptionEN" name="descriptionEN" type="text">
        </div>
        <div>
            <label for="descriptionSK">Popis (SK):</label>
            <input id="descriptionSK" name="descriptionSK" type="text">
        </div>
        <div>
            <input id="btn" type="submit" value="Upload">
        </div>
</form>
</div>

<hr>

<div id = "container">
<form action ="admin.php" method="post" enctype="multipart/form-data">
    <h2>Modify term in DB:</h2>
    <div>
        <label for="modID">ID of term to be modified (table translations):</label>
        <input id="modID" name="modID" type="number">
    </div>
    <div>
        <label for="newDescription">New description:</label>
        <input id="newDescription" name="newDescription" type="text">
    </div>
    <div>
        <input id="btn" type="submit" value="Modify">
    </div>
</form>
</div>

<hr>

<div id = "container">
<form action ="admin.php" method="post" enctype="multipart/form-data">
    <h2>Delete term from DB:</h2>
    <div>
        <label for="delID">ID:</label>
        <input id="delID" name="delID" type="number">
    </div>
    <div>
        <input id="btn" type="submit" value="Delete">
    </div>
</form>
</div>
</body>
</html>