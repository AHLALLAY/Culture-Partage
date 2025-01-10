-- Active: 1735634973185@@localhost@3306@cp
DROP DATABASE CP;

CREATE DATABASE CP;

USE CP;

CREATE TABLE users (
    users_id INT PRIMARY KEY AUTO_INCREMENT,
    f_name VARCHAR(50),
    l_name VARCHAR(50),
    email VARCHAR(50) UNIQUE,
    pwd_hashed VARCHAR(100),
    images BLOB,
    roles VARCHAR(10),
    created_at DATETIME,
    is_suspend BOOLEAN DEFAULT true
);

CREATE TABLE category (
    cat_id INT PRIMARY KEY AUTO_INCREMENT,
    cat VARCHAR(20) UNIQUE,
    created_at DATETIME
);

CREATE TABLE articles (
    article_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50),
    art_body text,
    created_at DATETIME,
    author_id INT,
    cat_id INT,
    Foreign Key (author_id) REFERENCES users (users_id),
    Foreign Key (cat_id) REFERENCES category (cat_id)
);

INSERT INTO users (f_name, l_name, email, pwd_hashed, roles, created_at) VALUES
    ('user-1', 'user-1', 'user-1@user.com', '$2y$10$wFXwP7g14s4UlFzK4basLOvI2oB5dcglId6r5RgxnAq7r8BYf5Tdq', 'Visitor', NOW()),
    ('user-2', 'user-2', 'user-2@user.com', '$2y$10$FiEYDrTHgPSph8R74X.kR.PpsnCA//WUOcatCXcdRnOwpWpTaoQ4q', 'Visitor', NOW()),
    ('user-3', 'user-3', 'user-3@user.com', '$2y$10$0FW.Y9V0K7I1c1OlAInrUuYBilleNybvyuU6QtDZB6GEUx5B8y/g2', 'Visitor', NOW()),
    ('user-4', 'user-4', 'user-4@user.com', '$2y$10$3NRoWBlAbbedT2OBPEwYM.t9M0c58VCyXmObiABbRsQpVerczJoXq', 'Visitor', NOW()),
    ('user-5', 'user-5', 'user-5@user.com', '$2y$10$Y.J2BRTd1/2iJBXHuKvzKeCLModMOkx73OaJjjlFkICOXirCWMQAa', 'Visitor', NOW()),
    ('user-6', 'user-6', 'user-6@user.com', '$2y$10$NA06U22pBSiyxpBCc2XQtuTHICP2ANOeGqIh0vYDyb2yr4SqjZW6O', 'Visitor', NOW());

INSERT INTO category (cat, created_at) VALUES 
    ('Technologie', NOW()),
    ('Programmation', NOW()),
    ('Sécurité', NOW()),
    ('Infrastructure', NOW()),
    ('Intelligence Artificielle',NOW()),
    ('Mobile', NOW());

INSERT INTO articles (title,art_body,created_at,author_id,cat_id) VALUES (
        'Les avancées de l''Intelligence Artificielle en 2024',
        'L''année 2024 a marqué un tournant décisif dans le développement de l''intelligence artificielle. Les nouveaux modèles de langage ont atteint des niveaux de compréhension sans précédent, transformant radicalement nos interactions avec les machines. Les applications pratiques se sont multipliées dans des domaines aussi variés que la médecine, l\'éducation et la recherche scientifique. Les chercheurs ont notamment réalisé des progrès significatifs dans le domaine de l''IA explicable, rendant les décisions des systèmes automatisés plus transparentes et compréhensibles. Cette évolution soulève néanmoins des questions éthiques importantes concernant la confidentialité des données et l''impact sur l''emploi.',
        '2024-01-02 10:00:00',
        1,
        1
    ),
    (
        'Guide du Développement Web Moderne',
        'Le développement web moderne nécessite une compréhension approfondie de nombreuses technologies et frameworks. De HTML5 à React, en passant par Node.js et les API RESTful, les développeurs doivent maîtriser un ensemble de compétences de plus en plus large. Ce guide couvre les fondamentaux du développement front-end et back-end, les meilleures pratiques en matière de sécurité, et les techniques d''optimisation des performances. Une attention particulière est portée aux principes du design responsive et à l''accessibilité, essentiels pour créer des applications web inclusives et performantes.',
        '2024-01-03 14:30:00',
        2,
        2
    ),
    (
        'La Cybersécurité en Entreprise',
        'Face à la multiplication des cyberattaques, la sécurité informatique est devenue une priorité absolue pour les entreprises. Les menaces évoluent constamment, des ransomwares aux attaques par déni de service distribué (DDoS). Ce guide présente les stratégies essentielles pour protéger les données sensibles, former les employés aux bonnes pratiques de sécurité, et mettre en place une politique de cybersécurité efficace. La conformité aux réglementations comme le RGPD et les procédures de réponse aux incidents sont également abordées en détail.',
        '2024-01-04 09:15:00',
        2,
        3
    ),
    (
        'Le Cloud Computing Expliqué',
        'Le cloud computing a révolutionné la façon dont les entreprises gèrent leurs ressources informatiques. Des services comme AWS, Google Cloud et Azure offrent une flexibilité et une scalabilité sans précédent. Cet article explore les différents modèles de services cloud (IaaS, PaaS, SaaS), leurs avantages et inconvénients, ainsi que les considérations importantes pour la migration vers le cloud. Les aspects pratiques comme la gestion des coûts, la sécurité et la conformité sont également traités en profondeur.',
        '2024-01-05 11:45:00',
        4,
        4
    ),
    (
        'Introduction au Machine Learning',
        'Le machine learning transforme rapidement de nombreux secteurs d''activité. Cet article présente les concepts fondamentaux de l''apprentissage automatique, des algorithmes de base aux techniques avancées comme les réseaux de neurones profonds. À travers des exemples concrets, nous explorons les applications pratiques dans des domaines tels que la reconnaissance d''images, le traitement du langage naturel et l''analyse prédictive. Les défis et les limites actuelles du machine learning sont également discutés.',
        '2024-01-06 16:20:00',
        3,
        5
    ),
    (
        'Développement Mobile en 2024',
        'Le développement d''applications mobiles continue d''évoluer rapidement. Des frameworks cross-platform comme Flutter et React Native aux dernières fonctionnalités natives d''iOS et Android, les développeurs ont plus d''options que jamais. Cet article examine les tendances actuelles, les meilleures pratiques et les outils essentiels pour créer des applications mobiles modernes. L''accent est mis sur l''expérience utilisateur, la performance et la maintenance à long terme des applications.',
        '2024-01-07 13:00:00',
        6,
        6
    );