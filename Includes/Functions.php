<?php

require_once 'Connect.php';

function execute_query($query, $params){
    global $con;
    try {
        $stmt = $con->prepare($query);
        $stmt->execute($params);
        if (strpos($query, "SELECT") !== false) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return true;

    } catch(PDOException $e) {
        return false;
    }
}


function is_email_exist($email){
    global $msg;
    try {
        $result = execute_query("SELECT email FROM users WHERE email = ?", [$email]);
        if ($result) {
            $msg = "L'email existe déjà.";
            echo "<script>alert('$msg')</script>";
            return true;
        }
    } catch(PDOException $e) {
        return false;
    }
}


function register($f_name, $l_name, $email, $pwd, $role = 'Visitor'){
    $msg = null;
    $visiteur = $_SERVER['DOCUMENT_ROOT'] . '/views/visiteur.php';
    
    if (!is_email_exist($email)) {
        try{
            execute_query("INSERT INTO users(f_name, l_name, email, pwd_hashed, roles) VALUES (?, ?, ?, ?, ?)",
            [$f_name, $l_name, $email, password_hash($pwd, PASSWORD_DEFAULT), $role]);
            header('location: ' . $visiteur);
            $msg = "Inscription réussie";
            return "<script>alert('$msg')</script>";
        }catch(PDOException $e){
            $msg = "Inscription Echoue";
            return "<script>alert('$msg')</script>";
        }
    }
}

function get_role($email) {
    try {
        return execute_query("SELECT roles FROM users WHERE email = ?", [$email]);
    } catch (PDOException $e) {
        return null;
    }
}

function login($email, $pass){
    if (is_email_exist($email)) {
        $resultat = execute_query("SELECT password_hashed, roles FROM users WHERE email = ?", [$email]);
        if ($resultat && password_verify($pass, $resultat['password_hashed'])) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['roles'] = $resultat['roles'];
            header('location: Visitor.php');
        }
    }
    return false;
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

function get_user_id($email) {
    global $con;
    try {
        return execute_query("SELECT id_user FROM users WHERE email = ?", [$email]);
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function get_categories(){
    try {
        return execute_query("SELECT * FROM categories", []);
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}


function get_category_id($category) {
    try {
        return execute_query("SELECT cat_id FROM categories WHERE cat_name = ?", [$category]);
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function update_user_role($id, $role = 'Author') {
    global $con;
    try {
        return execute_query("UPDATE users SET roles = ? WHERE users_id = ?", [$role, $id]);
    } catch (PDOException $e) {
        error_log("Failed to update user role: " . $e->getMessage());
        return false;
    }
}

function add_article($title, $textbox, $statut, $created_at, $updated_at, $id_user, $id_category) {
    global $con;
    try {
        $stmt = $con->prepare("INSERT INTO articles (title, textbox, statut, created_at, updated_at, id_user, id_category) 
                               VALUES (:title, :textbox, :statut, :created_at, :updated_at, :id_user, :id_category)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':textbox', $textbox);
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':updated_at', $updated_at);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_category', $id_category);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Failed to add article: " . $e->getMessage());
        return false;
    }
}
