<?php
function emptyInputSignup($firstName, $lastName, $email, $pwd, $pwdRepeat){
    //$result;
    if (empty($firstName) || empty($email) ||empty($lastName) ||empty($pwd) ||empty($pwdRepeat)){

        $result = true;
    } else{
        $result = false;
    }
    return $result;
}
function invalidFirstName($firstName){
    //$result;
    if (!preg_match("/^[a-zA-Z]*$/",$firstName)){

        $result = true;
    } else{
        $result = false;
    }
    return $result;
}
function invalidLastName( $lastName){
    //$result;
    if (!preg_match("/^[a-zA-Z]*$/",$lastName)){

        $result = true;
    } else{
        $result = false;
    }
    return $result;
}
function invalidEmail( $email){
    //$result;
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)){

        $result = true;
    } else{
        $result = false;
    }
    return $result;
}
function pwdMatch( $pwd,$pwdRepeat){
    //$result;
    if ($pwd !== $pwdRepeat){

        $result = true;
    } else{
        $result = false;
    }
    return $result;
}
function emailExists($conn, $email){
    $sql = "SELECT * FROM users WHERE usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){

        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s",$email);

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;


    }else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);

}
function createUser($conn, $firstName,$lastName, $email, $pwd){
    $sql = "INSERT INTO users (firstName, lastName, usersEmail,usersPwd) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){

        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssss",$firstName,$lastName,$email,$hashedPwd);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.html");
    exit();
}

function emptyInputLogin($email, $pwd){
    //$result;
    if (empty($email)||empty($pwd) ){

        $result = true;
    } else{
        $result = false;
    }
    return $result;
}   

function loginUser($conn, $email,$pwd){
$emailExists = emailExists($conn, $email);
if($emailExists === false){
    header("location: ../login.php?error=checkagain");
    exit();
}
$pwdHashed = $emailExists["usersPwd"];
$checkPwd = password_verify($pwd,$pwdHashed);
if ($checkPwd === false){
    header("location: ../login.php?error=wronglogin");
}else if ($checkPwd ===true ){
    session_start();
    $_SESSION["userid"] = $emailExists["userId"];
    
    $_SESSION["useremail"] = $emailExists["usersEmail"];
    header("location: ../index.html");
    exit();

}

}