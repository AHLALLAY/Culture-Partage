<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Includes/Functions.php';

if (isset($_POST['exit'])) {
    header('location: /Index.php');
    exit;
}

if (isset($_POST['reg_btn'])) {
    $f_name = trim($_POST['f_name']);
    $l_name = trim($_POST['l_name']);
    $reg_email = trim($_POST['reg_email']);
    $reg_pwd = trim($_POST['reg_pwd']);

    // Validation des champs
    if (empty($f_name) || empty($l_name) || empty($reg_email) || empty($reg_pwd)) {
        $msg = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
        $msg = "L'adresse e-mail n'est pas valide.";
    } elseif (strlen($reg_pwd) < 8) {
        $msg = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        // Vérifier si un fichier a été uploadé
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileType = $_FILES['photo']['type'];

            // Vérifier que le fichier est une image
            if (strpos($fileType, 'image') === 0) {
                // Lire le fichier en binaire
                $imageData = file_get_contents($fileTmpPath);

                // Enregistrer l'utilisateur dans la base de données
                $roles = 'Visitor';
                $created_at = (new DateTime())->format('Y-m-d H:i:s');
                $result = register($f_name, $l_name, $fileTmpPath, $reg_email, $reg_pwd, $roles, $created_at);

                if ($result) {
                    header('location: Login.php');
                    exit;
                } else {
                    $msg = "Une erreur est survenue lors de l'inscription.";
                }
            } else {
                $msg = "Le fichier doit être une image.";
            }
        } else {
            $msg = "Veuillez télécharger une image valide.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative h-screen bg-gradient-to-b from-[#1F2821] via-[#4C7DA4] to-[#191A1F]">
    <div class="absolute top-0 left-0 w-full h-full">
        <img src="/Asset/people.png" alt="Image De Hero" class="w-full h-full object-cover">
        <div class="absolute top-0 left-0 w-full h-full bg-[#191A1F]/70"></div>
    </div>

    <header class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-center z-10">
        <div class="p-8 rounded-xl bg-[#1F2821]/30 w-96">
            <form method="post" enctype="multipart/form-data" class="space-y-6 select-none">
                <div class="flex justify-between items-center text-[#FAF9FA] mb-6">
                    <h2 class="text-2xl font-semibold tracking-wide">Inscription</h2>
                    <button name="exit" class="text-3xl hover:text-[#4C7DA4] transition-colors duration-300">&times;</button>
                </div>
                <div class="flex space-x-2">
                    <div class="space-y-2">
                        <label for="f_name" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Nom</label>
                        <input type="text" name="f_name" id="f_name" placeholder="Votre nom"
                            class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                            placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                            transition-all duration-300" required>
                    </div>
                    <div class="space-y-2">
                        <label for="l_name" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Prénom</label>
                        <input type="text" name="l_name" id="l_name" placeholder="Votre prénom"
                            class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                            placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                            transition-all duration-300" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="photo" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Photo</label>
                    <input type="file" name="photo" id="photo" accept="image/*" required
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                                placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50 transition-all duration-300">
                </div>

                <div class="space-y-2">
                    <label for="reg_email" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Email</label>
                    <input type="email" name="reg_email" id="reg_email" placeholder="votre_email@exemple.com"
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                        placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                        transition-all duration-300" required>
                </div>

                <div class="space-y-2">
                    <label for="reg_pwd" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Mot de passe</label>
                    <input type="password" name="reg_pwd" id="reg_pwd" placeholder="Votre mot de passe"
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                        placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                        transition-all duration-300" required>
                </div>

                <button type="submit" name="reg_btn"
                    class="w-full px-6 py-2 bg-[#4C7DA4] text-[#FAF9FA] hover:bg-[#10ADE9] 
                    rounded-lg transition-all duration-300 ease-in-out tracking-wide
                    shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50">
                    S'inscrire
                </button>
                <div class="text-[#FAF9FA] text-sm pt-4">
                    <p class="tracking-wide">Vous avez un compte?
                        <a href="Login.php" class="text-[#4C7DA4] hover:text-[#10ADE9] underline transition-colors duration-300">Connectez-vous</a>
                    </p>
                </div>
                <?php if (isset($msg)) : ?>
                    <div class="text-red-500 text-sm"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </form>
        </div>
    </header>
</body>

</html>