CREATE DATABASE CP;
USE CP;
CREATE TABLE users(
    users_id INT PRIMARY KEY AUTO_INCREMENT,
    f_name VARCHAR(50),
    l_name VARCHAR(50),
    email VARCHAR(50) UNIQUE,
    pwd_hashed VARCHAR(100),
    roles ENUM('Admin', 'Visitor', 'Author'),
    created_at DATETIME
);

CREATE TABLE categories(
    cat_id INT PRIMARY KEY AUTO_INCREMENT,
    cat_name VARCHAR(50),
    created_at DATE
);

CREATE TABLE articles(
    article_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50),
    art_body text,
    category_id INT,
    author_id INT,
    Foreign Key (category_id) REFERENCES categories(cat_id),
    Foreign Key (author_id) REFERENCES users(users_id)
);