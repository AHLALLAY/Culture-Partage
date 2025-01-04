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


function is_email_exist($email) {
    global $con;
    try {
        $stmt = $con->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Database query failed: " . $e->getMessage());
        return false;
    }
}

function register($f_name, $l_name, $email, $pwd) {
    global $con;
    $visiteur = $_SERVER['DOCUMENT_ROOT'] . '/views/visiteur.php';
    if (!is_email_exist($email)) {
        try {
            $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
            $stmt = $con->prepare("INSERT INTO users (f_name, l_name, email, password_hashed) VALUES (?, ?, ?, ?)");
            $stmt->execute([$f_name, $l_name, $email, $pwd_hashed]);
            header('Location: ' . $visiteur);
            exit();
        } catch (PDOException $e) {
            error_log("Registration failed: " . $e->getMessage());
            return "Registration failed. Please try again later.";
        }
    } else {
        return "Email already exists.";
    }
}

function get_role($email) {
    global $con;
    try {
        $stmt = $con->prepare("SELECT roles FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['roles'] ?? null;
    } catch (PDOException $e) {
        error_log("Database query failed: " . $e->getMessage());
        return null;
    }
}

function login($email, $pass) {
    global $con;
    try {
        if (is_email_exist($email)) {
            $stmt = $con->prepare("SELECT password_hashed, roles FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultat && password_verify($pass, $resultat['password_hashed'])) {
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['roles'] = $resultat['roles'];
                header('Location: Visitor.php');
                exit();
            }
        }
    } catch (PDOException $e) {
        error_log("Login failed: " . $e->getMessage());
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
        $stmt = $con->prepare("SELECT id_user FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id_user'] ?? null;
    } catch (PDOException $e) {
        error_log("Database query failed: " . $e->getMessage());
        return null;
    }
}

function get_categories() {
    global $con;
    try {
        $stmt = $con->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database query failed: " . $e->getMessage());
        return [];
    }
}

function get_category_id($category) {
    global $con;
    try {
        $stmt = $con->prepare("SELECT id_category FROM categories WHERE name_category = :category");
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id_category'] ?? null;
    } catch (PDOException $e) {
        error_log("Database query failed: " . $e->getMessage());
        return null;
    }
}

function update_user_role($id, $role = 'Author') {
    global $con;
    try {
        $stmt = $con->prepare("UPDATE users SET roles = :role WHERE id_user = :id_user");
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
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

function get_articles() {
    global $con;
    try {
        $stmt = $con->prepare("SELECT * FROM articles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Failed to fetch articles: " . $e->getMessage());
        return [];
    }
}