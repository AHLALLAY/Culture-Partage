<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Includes/Functions.php';

if (isset($_POST['exit'])) {
    header('location: /Index.php');
    exit;
}

// if (isset($_POST['reg_btn'])) {
//     $f_name = $_POST['f_name'];
//     $l_name = $_POST['l_name'];
//     $pic = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
//     $reg_email = $_POST['reg_email'];
//     $reg_pwd = $_POST['reg_pwd'];

//     $roles = 'Visitor';
//     $created_at = (new DateTime())->format('Y-m-d H:i:s');

//     if (!empty($f_name) && !empty($l_name) && !empty($img) && !empty($reg_email) && !empty($reg_pwd)) {
//         if (strlen($reg_pwd) >= 8) {
//             $result = register($f_name, $l_name, $pic, $reg_email, $reg_pwd, $roles, $created_at);
//             if ($result) {
//                 $msg = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
//             } else {
//                 $msg = "L'email est déjà utilisé ou une erreur est survenue.";
//             }
//         } else {
//             $msg = "Le mot de passe doit contenir au moins 8 caractères.";
//         }
//     } else {
//         $msg = "Veuillez remplir tous les champs.";
//     }
// }

if (isset($_POST['reg_btn'])) {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];  // Chemin temporaire du fichier téléchargé
        $fileName = $_FILES['image']['name'];         // Nom du fichier téléchargé
        $fileSize = $_FILES['image']['size'];         // Taille du fichier
        $fileType = $_FILES['image']['type'];         // Type du fichier
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Extension du fichier

        // Dossier de destination (Asset/ dans votre projet)
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/Asset/';
        
        // Vérifier si le dossier existe, sinon le créer
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Créer le dossier si nécessaire
        }

        // Chemin complet du fichier de destination
        $destinationPath = $targetDir . basename($fileName);

        // Vérifier si le fichier est une image
        if (getimagesize($fileTmpPath) !== false) {
            // Déplacer le fichier téléchargé vers le dossier Asset
            if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                // Enregistrer le chemin dans la base de données
                $imagePath = '/Asset/' . basename($fileName);  // Chemin relatif à partir de la racine du projet

                // Enregistrez le chemin de l'image dans la base de données
                $stmt = $con->prepare("INSERT INTO images (image_path) VALUES (:image_path)");
                $stmt->execute([':image_path' => $imagePath]);

                echo "L'image a été téléchargée avec succès et enregistrée dans la base de données.";
            } else {
                echo "Une erreur est survenue lors du déplacement de l'image.";
            }
        } else {
            echo "Le fichier téléchargé n'est pas une image valide.";
        }
    } else {
        echo "Aucun fichier n'a été téléchargé ou une erreur est survenue.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative h-screen bg-gradient-to-b from-[#1F2821] via-[#4C7DA4] to-[#191A1F]">
    <div class="absolute top-0 left-0 w-full h-full">
        <img src="/Asset/people.png" alt="Image De Hero" class="w-full h-full object-cover">
        <div class="absolute top-0 left-0 w-full h-full bg-[#191A1F]/70"></div>
    </div>

    <header class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-center z-10">
        <div class="p-8 rounded-xl bg-[#1F2821]/30 w-96">
            <form method="post" class="space-y-6 select-none">
                <div class="flex justify-between items-center text-[#FAF9FA] mb-6">
                    <h2 class="text-2xl font-semibold tracking-wide">Inscription</h2>
                    <button name="exit" class="text-3xl hover:text-[#4C7DA4] transition-colors duration-300">&times;</button>
                </div>
                <div class="flex space-x-2">
                    <div class="space-y-2">
                        <label for="f_name" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Nom</label>
                        <input type="text" name="f_name" id="f_name" placeholder="votre nom"
                            class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                            placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                            transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="l_name" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Prenom</label>
                        <input type="text" name="l_name" id="l_name" placeholder="votre prenom"
                            class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                            placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                            transition-all duration-300">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="photo" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Photo</label>
                    <input type="file" name="photo" id="photo" placeholder="votre photo"
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                        placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                        transition-all duration-300">
                </div>

                <div class="space-y-2">
                    <label for="reg_email" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Email</label>
                    <input type="email" name="reg_email" id="reg_email" placeholder="votre_email@exemple.com"
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                        placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                        transition-all duration-300">
                </div>

                <div class="space-y-2">
                    <label for="reg_pwd" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Mot de passe</label>
                    <input type="password" name="reg_pwd" id="reg_pwd" placeholder="votre mot de passe"
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                        placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                        transition-all duration-300">
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
                    <?php echo "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>"; ?>
                <?php endif; ?>
            </form>
        </div>
    </header>
</body>

</html>