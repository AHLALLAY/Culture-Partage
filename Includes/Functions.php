<?php

require_once 'Connect.php';

session_start();
function is_exist($email)
{
    global $con, $msg;
    try {
        $stmt = $con->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res) {
            $msg = "Email already exists";
            return "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
        }
    } catch (PDOException $e) {
        $msg = "Error: " . $e->getMessage();
        return "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
    }
}

function register($f_name, $l_name, $email, $pwd, $roles, $created_at)
{
    global $con, $msg;
    try {
        // Vérifier si l'email existe déjà avant de procéder à l'insertion
        if (is_exist($email)) {
            return "<script>alert('Email already exists');</script>";
        }

        // Préparer la requête d'insertion
        $stmt = $con->prepare("INSERT INTO users (f_name, l_name, email, pwd_hashed, roles, created_at) 
                               VALUES (:f_name, :l_name, :email, :pwd_hashed, :roles, :created_at)");

        // Exécuter l'insertion
        $stmt->execute([
            ':f_name' => $f_name,
            ':l_name' => $l_name,
            ':email' => $email,
            ':pwd_hashed' => password_hash($pwd, PASSWORD_DEFAULT),
            ':roles' => $roles,
            ':created_at' => $created_at
        ]);

        if ($con->lastInsertId()) {
            header('location: Login.php');
            exit;
        } else {
            $msg = "Registration failed";
            return "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
        }

    } catch (PDOException $e) {
        // En cas d'erreur d'exécution, afficher le message d'erreur
        $msg = "Error: " . $e->getMessage();
        return "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
    }
}

function login($email, $pwd) {
    global $con, $msg;

    try {
        $stmt = $con->prepare("SELECT email, pwd_hashed, roles FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res) {
            if (password_verify($pwd, $res['pwd_hashed'])) {
                $_SESSION['email'] = $res['email'];
                $_SESSION['role'] = $res['roles'];
                return header('location:'. $res['roles'] .'.php');
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $msg = "Error: " . $e->getMessage();
        return false;
    }
}


function logout(){
    session_unset();
    session_destroy();
    header('location: Login.php');
    exit;
}

function upgrade_role($email){
    global $con, $msg;

    try {
        if(!empty($email)){
            $stmt = $con->prepare("SELECT email, roles FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res){
                try{
                    $stmt = $con->prepare("UPDATE users SET roles = 'Author' WHERE email = :email");
                    $stmt->execute([':email' => $email]);
                    header('location: Author.php');
                    exit;
                }catch(PDOException $e){
                    return $e->getMessage();
                }
            }    
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}


function get_articles($email = null) {
    global $con, $msg;
    $articles = [];
    try {
        if ($email) {
            $stmt = $con->prepare("SELECT articles.*, users.email FROM articles 
                                   LEFT JOIN users ON articles.author_id = users.users_id 
                                   WHERE users.email = :email");
            $stmt->bindParam(':email', $email);
        } else {
            $stmt = $con->prepare("SELECT articles.*, users.email FROM articles 
                                   JOIN users ON articles.author_id = users.users_id");
        }

        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($articles) && $email) {
            $msg = "Vous n'avez pas encore d'articles.";
        }

    } catch (PDOException $e) {
        $msg = "Erreur lors de la récupération des articles : " . $e->getMessage();
    }

    return $articles;
}
