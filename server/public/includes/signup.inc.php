<?php
if (isset($_POST["submit"])){
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($firstName, $lastName, $email, $pwd, $pwdRepeat) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidFirstName($firstName) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidLastName($lastName) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidEmail($email) !== false){
        header("location: ../signup.php?error=invalidEmail");
        exit();
    }
    if (pwdMatch( $pwd, $pwdRepeat) !== false){
        header("location: ../signup.php?error=passwordsDontMatch");
        exit();
    }
    if (emailExists( $conn, $email) !== false){
        header("location: ../signup.php?error=EmailAlreadyExists");
        exit();
    }
    createUser($conn, $firstName,$lastName, $email, $pwd);

}

else {
    header("location: ../signup.php");
}