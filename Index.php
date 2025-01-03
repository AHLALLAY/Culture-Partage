<?php
    if(isset($_POST['log_btn'])){
        header('location: /Views/Login.php');
        exit;
    }
    if(isset($_POST['reg_btn'])){
        header('location: /Views/Register.php');
        exit;
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
        <img src="/Asset/Image/people.png" alt="Image De Hero" class="w-full h-full object-cover">
        <!-- Overlay plus sombre pour un meilleur contraste -->
        <div class="absolute top-0 left-0 w-full h-full bg-[#191A1F]/70"></div>
    </div>

    <header class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-center z-10">
        <h1 class="text-4xl font-semibold mb-6 text-[#FAF9FA]">
            <span class="block text-shadow-lg">Soyez Bienvenus Chez</span>
            <span class="block text-5xl font-bold tracking-wide text-[#ECD9B6]">Culture Partage</span>
        </h1>
        
        <div class="p-8 rounded-xl bg-[#1F2821]/30">
            <form action="#" method="post" class="space-x-4">
                <button type="submit" name="log_btn"
                    class="px-6 py-2 bg-[#FAF9FA] font-bold text-[#191A1F] hover:bg-[#10ADE9] hover:text-[#FAF9FA] 
                    rounded-lg transition-all duration-300 ease-in-out 
                    shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50">
                    Connexion
                </button>
                <button type="submit" name="reg_btn"
                    class="px-6 py-2 bg-[#FAF9FA] font-bold text-[#191A1F] hover:bg-[#10ADE9] hover:text-[#FAF9FA] 
                    rounded-lg transition-all duration-300 ease-in-out 
                    shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#ECD9B6]/50">
                    Inscription
                </button>
            </form>
        </div>
    </header>
</body>

</html>