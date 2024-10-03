<?php
session_start();
require_once('../model/database.php');

$code = filter_input(INPUT_POST, 'code');
$name = filter_input(INPUT_POST, 'name');
$version = filter_input(INPUT_POST, 'version');
$release = filter_input(INPUT_POST, 'date'); 

if ($code == null || $name == null || $version == null || $release == null) {
    $_SESSION['error'] = 'Invalid data. Please make sure all fields are filled.';
    $url = "../errors/error.php";
    header("Location: " . $url);
    die(); 
}

//  switch statement to handle different date formats
switch (true) {
    case preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $release):
        $releaseDateObj = DateTime::createFromFormat('m/d/Y', $release);
        break;

    case preg_match('/^\d{4}-\d{2}-\d{2}$/', $release):
        $releaseDateObj = DateTime::createFromFormat('Y-m-d', $release);
        break;

    case preg_match('/^[A-Za-z]+\s+\d{1,2},?\s+\d{4}$/i', $release):
        $releaseDateObj = new DateTime($release); 
        break;

    case preg_match('/^\d{1,2}\s+[A-Za-z]+,?\s+\d{4}$/i', $release):
        $releaseDateObj = new DateTime($release); 
        break;

    case preg_match('/^\d{1,2}[A-Za-z]+\s+\d{4}$/i', $release):
        $releaseDateObj = new DateTime($release);
        break;

    case preg_match('/^\d{1,2}-[A-Za-z]+-\d{4}$/i', $release):
        $releaseDateObj = new DateTime($release); 
        break;

    case preg_match('/^[A-Za-z]+\s+\d{1,2}(?:st|nd|rd|th)?,?\s+\d{4}$/i', $release):
        $releaseDateObj = new DateTime($release); 
        break;

    default:
        $_SESSION['error'] = 'Invalid date format. Please use a valid date format (MM/DD/YYYY, YYYY-MM-DD, Month Day Year, Day Month Year).';
        header("Location: ../errors/error.php");
        die();
}

if (!$releaseDateObj) {
    $_SESSION['error'] = 'Invalid date format. Please use a valid date.';
    header("Location: ../errors/error.php");
    die();
}


$release = $releaseDateObj->format('Y-m-d');

    $query = "INSERT INTO products (productCode, name, version, releaseDate) VALUES (:code, :name, :version, :releaseDate)";
    $statement = $db->prepare($query);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':version', $version);
    $statement->bindValue(':releaseDate', $release); // Insert properly formatted date
    $statement->execute();
    $statement->closeCursor();

$_SESSION['product'] = $name . ', version of (' . $version . ')';

/
?>
