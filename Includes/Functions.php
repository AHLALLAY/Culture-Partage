<?php

require_once 'Connect.php';


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
        $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $con->prepare("INSERT INTO users(f_name, l_name, email, password_hashed) VALUES (?,?,?,?)");
        $stmt->bindParam(1, $f_name, PDO::PARAM_STR);
        $stmt->bindParam(2, $l_name, PDO::PARAM_STR);
        $stmt->bindParam(3, $email, PDO::PARAM_STR);
        $stmt->bindParam(4, $pwd_hashed, PDO::PARAM_STR);
        $stmt->execute();
        header('location:') . $visiteur;
        $msg = "Inscription Réussie";
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
        $stmt = $con->prepare("SELECT password_hashed, roles FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($pass && password_verify($pass, $resultat['password_hashed'])) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['roles'] = $resultat['roles'];
            header('location : /Views/Visitor.php');
        }
    }
    return false;
}
function logout(){
    session_unset();
    session_destroy();
    header('location: login.php');
}

function get_user_id($email){ //email sera extrait du session;
    global $con, $msg;
    try{
        $stmt = $con->prepare("SELECT id_user FROM users WHERE email = ?");
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id_user'];
    }catch(PDOException $e){
        return false;
    }
}
function get_categories(){
    global $con;
    try{
        $stmt = $con->prepare("SELECT * FROM categories");
        $stmt->bindParam(1 , $category, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }catch(PDOException $e){
        return false;
    }
}

function get_category_id($category){ // category sera extrait d'un list de choix;
    global $con;
    try{
        $stmt = $con->prepare("SELECT id_category FROM categories WHERE name_category = ?");
        $stmt->bindParam(1 , $category, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result['id_category'];
    }catch(PDOException $e){
        return false;
    }
}
function update_user_role($id){
    global $con;
    $role = 'Author';
    try{
        $stmt = $con->prepare("UPDATE users SET roles = ? WHERE id_user = ?");
        $stmt->bindParam(1, $role, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }catch(PDOException $e){
        return false;
    }
}
function add_article($title, $textbox, $statut, $created_at, $updated_at, $id_user, $id_category){
    global $con;
    try{
        $stmt = $con->prepare("INSERT INTO articles(title, textbox, statut, created_at, updated_at, id_user, id_category) 
                                        VALUES(:title, :textbox, :statut, :created_at, :updated_at, :id_user, :id_category)");
        $stmt->bindParam(':title' , $title);
        $stmt->bindParam(':textbxox' , $textbox);
        $stmt->bindParam(':statut' , $statut);
        $stmt->bindParam(':created_at' , $created_at);
        $stmt->bindParam(':updated_at' , $updated_at);
        $stmt->bindParam(':id_user' , $id_user);
        $stmt->bindParam(':id_category' , $id_category);
        $stmt->execute();
        return true;
    }catch(PDOException $e){
        return false;
    }
}

function get_article(){
    global $con;
    try{
        $stmt = $con->prepare("SELECT * FROM articles");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }catch(PDOException $e){
        return "Articles not founde";
    }
}