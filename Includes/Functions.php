<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Includes/Connect.php';

$msg = null;
function is_email_exist($email){
    global $con, $msg;
    try{
        $stmt = $con->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            $msg = "l'email est déjà existe";
            echo "<script>alert('$msg')</script>";
            return true;
        }
    }catch(PDOException $e){
        return false;
    }
}
function register($f_name, $l_name, $email, $pwd){
    global $con, $msg;
    $visiteur = $_SERVER['DOCUMENT_ROOT'] . '/views/visiteur.php';
    if (!is_email_exist($email)) {
        try{
            $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
            $stmt = $con->prepare("INSERT INTO users(f_name, l_name, email, pwd_hashed) VALUES (?,?,?,?)");
            $stmt->bindParam(1, $f_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $l_name, PDO::PARAM_STR);
            $stmt->bindParam(3, $email, PDO::PARAM_STR);
            $stmt->bindParam(4, $pwd_hashed, PDO::PARAM_STR);
            $stmt->execute();
            header('location:') . $visiteur;
            $msg = "Inscription Réussie";
            return "<script>alert('$msg')</script>";
        }catch(PDOException $e){
            $msg = $e->getMessage();
            return "<script>alert('$msg')</script>";
        }
    }else{
        $msg = "Email déjà existe";
        return "<script>alert('$msg')</script>";
    }
}
function get_role($email){
    global $con, $msg;
    try{
        $stmt = $con->prepare("SELECT roles FROM users WHERE email = ?");
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['roles'];
    }catch(PDOException $e){
        return false;
    }
}
function login($email, $pass){
    global $con;
    if (is_email_exist($email)) {
        $stmt = $con->prepare("SELECT pwd_hashed, roles FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($pass && password_verify($pass, $resultat['pwd_hashed'])) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['roles'] = $resultat['roles'];
            switch(strtolower($resultat['roles'])){
                case 'admin':
                    header('location: admin.php');
                    break;
                case 'author':
                    header('location: author.php');
                    break;
                case 'visiteur':
                    header('location: visiteur.php');
                    break;
                default:
                    header('location: login.php');
                    break;
            }
        }
    }
    return false;
}