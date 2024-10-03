<?php
session_start();
require_once('../model/database.php');
$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$email = filter_input(INPUT_POST, 'email');
$phone = filter_input(INPUT_POST, 'phone');
$password = filter_input(INPUT_POST, 'password');


if ($firstName == null || $lastName == null || $email == null || $phone == null || $password == null) {
    $_SESSION['error'] = 'Invalid data. Please make sure all fields are filled';
    $url = "../errors/error.php";
    header("Location: " . $url); / 
} else {

    $query = "INSERT INTO technicians (firstName, lastName, email, phone, password) VALUES (:firstName, :lastName, :email, :phone, :password)";
    $statement = $db->prepare($query);

    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':password', $password);

      $statement->execute();
      $statement->closeCursor();

}

$_SESSION['technician'] = $firstName . ' ' . $lastName;


?>
