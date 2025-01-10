<?php

require_once 'Connect.php';

session_start();
function is_exist($email){
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

function register($f_name, $l_name, $pic, $email, $pwd, $roles, $created_at, $is_suspend = 0){
    global $con, $msg;

    try {
        if (is_exist($email)) {
            return "<script>alert('Email already exists');</script>";
        }
        $stmt = $con->prepare("INSERT INTO users (f_name, l_name, pic, email, pwd_hashed, roles, created_at, is_suspend) 
                               VALUES (:f_name, :l_name, :pic, :email, :pwd_hashed, :roles, :created_at, : is_suspend)");


        $stmt->execute([
            ':f_name' => $f_name,
            ':l_name' => $l_name,
            ':pic' => $pic,
            ':email' => $email,
            ':pwd_hashed' => password_hash($pwd, PASSWORD_DEFAULT),
            ':roles' => $roles,
            ':created_at' => $created_at,
            ':is_suspend' => $is_suspend
        ]);

        if ($con->lastInsertId()) {
            header('location: Login.php');
            exit;
        } else {
            $msg = "Registration failed";
            return "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
        }
    } catch (PDOException $e) {
        $msg = "Error: " . $e->getMessage();
        return "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
    }
}

function is_suspend($email){
    global $con;
    try {
        $stmt = $con->prepare("SELECT is_suspend FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result['is_suspend'] == 1){
            return true;
        }else{
            return false;
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function login($email, $pwd){
    global $con, $msg;

    try {
        $stmt = $con->prepare("SELECT email, pwd_hashed, roles FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res) {
            if (password_verify($pwd, $res['pwd_hashed'])) {
                $_SESSION['email'] = $res['email'];
                $_SESSION['role'] = $res['roles'];

                return header('Location:' . $res['roles'] . '.php');
            } else {
                $msg = "Mot de passe incorrect.";
                return false;
            }
        } else {
            $msg = "Aucun compte trouvé avec cet email.";
            return false;
        }
    } catch (PDOException $e) {
        $msg = "Erreur : " . $e->getMessage();
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
    global $con;

    try {
        if (!empty($email)) {
            $stmt = $con->prepare("SELECT email, roles FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                try {
                    $stmt = $con->prepare("UPDATE users SET roles = 'Author' WHERE email = :email");
                    $stmt->execute([':email' => $email]);
                    header('location: Author.php');
                    exit;
                } catch (PDOException $e) {
                    return $e->getMessage();
                }
            }
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}


function get_articles($email = null){
    global $con, $msg;
    $articles = [];
    try {
        if ($email) {
            $stmt = $con->prepare("SELECT articles.title, articles.art_body, articles.created_at, users.email, users.images, category.cat 
                                    FROM articles 
                                    LEFT JOIN users ON articles.author_id = users.users_id
                                    LEFT JOIN category ON articles.cat_id = category.cat_id
                                    WHERE users.email = :email ORDER BY articles.created_at DESC");
            $stmt->bindParam(':email', $email);
        } else {
            $stmt = $con->prepare("SELECT articles.title, articles.art_body, articles.created_at, users.email, users.images, category.cat
                                    FROM articles 
                                    LEFT JOIN users ON articles.author_id = users.users_id
                                    LEFT JOIN category ON articles.cat_id = category.cat_id
                                    ORDER BY articles.created_at DESC");
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

function get_users(){
    global $con;

    try {
        $stmt = $con->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    } catch (PDOException $e) {
        return "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
    }
}

function get_category(){
    global $con;

    try {
        $stmt = $con->prepare("SELECT cat FROM category");
        $stmt->execute();
        $cat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cat;
    } catch (PDOException $e) {
        return "Erreur lors de la récupération des categories : " . $e->getMessage();
    }
}

function suspend($id){
    global $con, $msg;
    try {
        $stmt = $con->prepare("UPDATE users SET is_suspend = 1 WHERE users_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return "Suspend" . $e->getMessage();
    }
}

function activate($id){
    global $con, $msg;
    try {
        $stmt = $con->prepare("UPDATE users SET is_suspend = 0 WHERE users_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return "Suspend" . $e->getMessage();
    }
}

function sus_or_act($id){
    global $con;
    try {
        $stmt = $con->prepare("SELECT is_suspend FROM users WHERE users_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->execute();

        $stat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stat['is_suspend'] == 0) {
            suspend($id);
        } else {
            activate($id);
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function new_category($category) {
    global $con;
    try {
        $date = new DateTime();
        $current_date = $date->format('d-m-y H:i:s');

        $stmt = $con->prepare("INSERT INTO category(cat, created_at) VALUES (?,?)");
        $stmt->bindParam(1, $category, PDO::PARAM_STR);
        $stmt->bindParam(2, $current_date, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function new_article($title, $art_body, $created_at=null, $author_id=null, $cat_id=null) {
    global $con;
    try {
        $date = new DateTime();
        $created_at = $date->format('d-m-y H:i:s');
        $author_id = get_users();
        $cat_id = get_category();

        $stmt = $con->prepare("INSERT INTO articles(title, art_body, created_at, author_id, cat_id) VALUES (?,?,?,?,?)");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $art_body, PDO::PARAM_STR);
        $stmt->bindParam(3, $created_at, PDO::PARAM_STR);
        $stmt->bindParam(4, $author_id['users_id'], PDO::PARAM_STR);
        $stmt->bindParam(5, $cat_id['cat_id'], PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
