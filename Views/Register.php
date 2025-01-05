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

    $roles = 'Visitor';
    $created_at = (new DateTime())->format('Y-m-d H:i:s');

    if (!empty($f_name) && !empty($l_name) && !empty($reg_email) && !empty($reg_pwd)) {
        if (strlen($reg_pwd) >= 8) {
            $result = register($f_name, $l_name, $reg_email, $reg_pwd, $roles, $created_at);
            if ($result) {
                $msg = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                
                // echo "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
            } else {
                $msg = "L'email est déjà utilisé ou une erreur est survenue.";
                // echo "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
            }
        } else {
            $msg = "Le mot de passe doit contenir au moins 8 caractères.";
            // echo "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
        }
    } else {
        $msg = "Veuillez remplir tous les champs.";
        // echo "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>";
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