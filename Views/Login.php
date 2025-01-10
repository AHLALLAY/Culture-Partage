<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Includes/Functions.php';
$msg = null;

if (isset($_POST['exit'])) {
    header('location: /Index.php');
    exit;
}

if (isset($_POST['log_btn'])) {
    $email = $_POST['log_email'];
    $pass = $_POST['log_pwd'];

    if (!empty($email) && !empty($pass)) {
        $suspend = is_suspend($email);
        if ($suspend) {
            $msg = "Votre compte a été suspendu. Veuillez contacter l'administrateur.";
        } else {
            $res = login($email, $pass);
            if ($res) {
                header('location: Visitor.php');
                exit;
            } else {
                $msg = "L'email ou le mot de passe est incorrect.";
            }
        }
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

<body class="relative h-screen bg-gradient-to-b from-[#1F2821] via-[#4C7DA4] to-[#191A1F]">
    <div class="absolute top-0 left-0 w-full h-full">
        <img src="/Asset/people.png" alt="Image De Hero" class="w-full h-full object-cover">
        <div class="absolute top-0 left-0 w-full h-full bg-[#191A1F]/70"></div>
    </div>

    <header class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-center z-10">
        <div class="p-8 rounded-xl bg-[#1F2821]/30 w-96">
            <form method="post" class="space-y-6 select-none">
                <div class="flex justify-between items-center text-[#FAF9FA] mb-6">
                    <h2 class="text-2xl font-semibold tracking-wide">Connexion</h2>
                    <button name="exit" class="text-3xl hover:text-[#4C7DA4] transition-colors duration-300">&times;</button>
                </div>

                <div class="space-y-2">
                    <label for="log_email" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Email</label>
                    <input type="email" name="log_email" id="log_email" placeholder="votre_email@exemple.com"
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                        placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                        transition-all duration-300">
                </div>

                <div class="space-y-2">
                    <label for="log_pwd" class="block text-[#FAF9FA] text-left text-sm tracking-wide">Mot de passe</label>
                    <input type="password" name="log_pwd" id="log_pwd" placeholder="votre mot de passe"
                        class="w-full px-4 py-2 bg-[#191A1F] text-[#FAF9FA] rounded-lg
                        placeholder-[#4C7DA4] focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50
                        transition-all duration-300">
                </div>

                <button type="submit" name="log_btn"
                    class="w-full px-6 py-2 bg-[#4C7DA4] text-[#FAF9FA] hover:bg-[#10ADE9] 
                    rounded-lg transition-all duration-300 ease-in-out tracking-wide
                    shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50">
                    Se connecter
                </button>
                <div class="text-[#FAF9FA] text-sm pt-4">
                    <p class="tracking-wide">Vous n'avez pas de compte?
                        <a href="Register.php" class="text-[#4C7DA4] hover:text-[#10ADE9] underline transition-colors duration-300">Inscrivez-vous</a>
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