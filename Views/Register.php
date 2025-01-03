<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Includes/Functions.php';
if (isset($_POST['exit'])) {
    header('location: /Index.php');
    exit;
}
if (isset($_POST['reg_btn'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $reg_email = $_POST['reg_email'];
    $reg_pwd = $_POST['reg_pwd'];

    // Assure-toi que les champs sont remplis avant d'appeler la fonction de registre
    if (!empty($f_name) && !empty($l_name) && !empty($reg_email) && !empty($reg_pwd)) {
        register($f_name, $l_name, $reg_email, $reg_pwd);
    } else {
        $msg = "Veuillez remplir tous les champs.";
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

<body class="relative h-screen bg-gradient-to-b from-[#383838] via-[#787878] to-[#5E5E5E]">
    <div class="absolute top-0 left-0 w-full h-full">
        <img src="/Asset/Image/hero.jpg" alt="Image De Hero" class="w-full h-full object-cover">
        <div class="absolute top-0 left-0 w-full h-full bg-[#1C1C1C]/70"></div>
    </div>

    <header class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-center z-10">
        <div class="p-8 rounded-xl bg-[#383838]/30 w-96">
            <form method="post" class="space-y-6">
                <div class="flex justify-between items-center text-[#E7E7E7] mb-6">
                    <h2 class="text-2xl font-semibold tracking-wide">Inscription</h2>
                    <button name="exit" class="text-3xl hover:text-[#787878] transition-colors duration-300">&times;</button>
                </div>

                <div class="flex space-x-2">
                    <div class="space-y-2">
                        <label for="f_name" class="block text-[#E7E7E7] text-left text-sm tracking-wide">Nom</label>
                        <input type="text" name="f_name" id="f_name" placeholder="votre nom" class="w-full px-4 py-2 bg-[#5E5E5E] text-[#E7E7E7] rounded-lg
                        placeholder-[#787878] focus:outline-none focus:ring-2 focus:ring-[#E7E7E7]/50
                        transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="l_name" class="block text-[#E7E7E7] text-left text-sm tracking-wide">Prenom</label>
                        <input type="text" name="l_name" id="l_name" placeholder="votre prenom" class="w-full px-4 py-2 bg-[#5E5E5E] text-[#E7E7E7] rounded-lg
                        placeholder-[#787878] focus:outline-none focus:ring-2 focus:ring-[#E7E7E7]/50
                        transition-all duration-300">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="reg_email" class="block text-[#E7E7E7] text-left text-sm tracking-wide">Email</label>
                    <input type="email" name="reg_email" id="reg_email" placeholder="votre_email@exemple.com" class="w-full px-4 py-2 bg-[#5E5E5E] text-[#E7E7E7] rounded-lg
                        placeholder-[#787878] focus:outline-none focus:ring-2 focus:ring-[#E7E7E7]/50
                        transition-all duration-300">
                </div>

                <div class="space-y-2">
                    <label for="reg_pwd" class="block text-[#E7E7E7] text-left text-sm tracking-wide">Mot de passe</label>
                    <input type="password" name="reg_pwd" id="reg_pwd" placeholder="votre mot de passe" class="w-full px-4 py-2 bg-[#5E5E5E] text-[#E7E7E7] rounded-lg
                        placeholder-[#787878] focus:outline-none focus:ring-2 focus:ring-[#E7E7E7]/50
                        transition-all duration-300">
                </div>

                <button type="submit" name="reg_btn" class="w-full px-6 py-2 bg-[#787878] text-[#E7E7E7] hover:bg-[#5E5E5E] 
                    rounded-lg transition-all duration-300 ease-in-out tracking-wide
                    shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#E7E7E7]/50">
                    S'inscrire
                </button>
                <div class="text-[#E7E7E7] text-sm pt-4">
                    <p class="tracking-wide">Vous avez un compte?
                        <a href="Login.php" class="text-[#787878] hover:text-[#E7E7E7] underline transition-colors duration-300">Connectez-vous</a>
                    </p>
                </div>
                <?php if (isset($msg)) : ?>
                    <?php echo "<script>alert($msg)</script>" ;?>
                <?php endif; ?>
            </form>
        </div>
    </header>
</body>

</html>