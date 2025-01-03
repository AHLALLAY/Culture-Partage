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

<body class="relative h-screen bg-gradient-to-b from-[#383838] via-[#787878] to-[#5E5E5E]">
    <div class="absolute top-0 left-0 w-full h-full">
        <img src="/Asset/Image/hero.jpg" alt="Image De Hero" class="w-full h-full object-cover">
        <!-- Overlay plus sombre pour un meilleur contraste -->
        <div class="absolute top-0 left-0 w-full h-full bg-[#1C1C1C]/70"></div>
    </div>

    <header class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-center z-10">
        <h1 class="text-4xl font-semibold mb-6 text-[#E7E7E7]">
            <span class="block text-shadow-lg">Soyez Bienvenus Chez</span>
            <span class="block text-5xl font-bold tracking-wide text-[#787878]">Culture Partage</span>
        </h1>
        
        <div class="p-8 rounded-xl bg-[#383838]/30">
            <form action="#" method="post" class="space-x-4">
                <button type="submit" name="log_btn"
                    class="px-6 py-2 bg-[#E7E7E7] font-bold text-[#5E5E5E] hover:bg-[#5E5E5E] hover:text-[#E7E7E7] 
                    rounded-lg transition-all duration-300 ease-in-out 
                    shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#E7E7E7]/50">
                    Connexion
                </button>
                <button type="submit" name="reg_btn"
                    class="px-6 py-2 bg-[#E7E7E7] font-bold text-[#5E5E5E] hover:bg-[#5E5E5E] hover:text-[#E7E7E7] 
                    rounded-lg transition-all duration-300 ease-in-out 
                    shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#E7E7E7]/50">
                    Inscription
                </button>
            </form>
        </div>
    </header>
</body>

</html>