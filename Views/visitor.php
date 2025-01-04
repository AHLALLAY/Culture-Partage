<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['logout'])) {
    logout();
}

$msg = get_user_id($_SESSION['email']);

echo "<script>alert($msg)</script>";

if (isset($_POST['upgrade'])) {

    update_user_role(get_user_id($_SESSION['email']));

    header('location: author.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Articles</title>
</head>

<body class="min-h-screen relative bg-[#1F2821]">
    <!-- Modal -->
    <div id="articleModal" class="fixed inset-0 bg-[#1F2821]/90 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-[#191A1F] w-full max-w-2xl rounded-lg shadow-2xl p-6 mx-4 max-h-[90vh] flex flex-col border border-[#4C7DA4]">
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <img id="modalImage" class="w-20 h-20 rounded-full object-cover border-2 border-[#4C7DA4]" src="path_to_image.jpg" alt="Photo de l'article">
                    <div class="rounded p-4 space-y-2">
                        <h2 id="modalTitle" class="text-2xl font-bold text-[#FAF9FA]">Title</h2>
                        <p id="modalAuthor" class="text-[#ECD9B6]">Auteur</p>
                        <div class="text-[#ECD9B6]">
                            <span>Date</span> - <span>Catégorie</span>
                        </div>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-[#ECD9B6] hover:text-[#FAF9FA] text-xl font-bold transition-colors">&times;</button>
            </div>

            <div class="border-t border-[#4C7DA4] py-4 my-4 flex-1 flex flex-col">
                <h3 class="text-[#FAF9FA] font-semibold mb-2">Description</h3>
                <div class="overflow-y-auto max-h-[300px] pr-4">
                    <p id="modalDescription" class="text-[#ECD9B6]">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam doloribus quibusdam commodi? Vero,
                        expedita atque? Veniam quibusdam dignissimos in exercitationem sapiente dicta sit earum debitis commodi,
                        quas ullam? Incidunt veniam illum ut fugit adipisci voluptatibus itaque nulla enim, ratione odit fuga saepe rem doloremque at.
                        Dolorem consequatur inventore iste, cupiditate molestiae accusantium itaque quisquam reiciendis repudiandae omnis.
                        Perspiciatis quas deleniti, velit ducimus corporis possimus repudiandae nostrum illum officiis.
                        Vitae accusamus itaque beatae expedita eum assumenda consequatur adipisci ea nisi placeat? Cumque,
                        at placeat provident repellendus perferendis voluptatum voluptatem fugit obcaecati odit odio magni ipsa nostrum fugiat
                        deserunt nemo possimus corrupti animi quos? Odit corporis optio beatae esse nemo earum aut! Hic obcaecati iusto tenetur sequi reprehenderit,
                        in dolorum repudiandae commodi cumque? Dignissimos quaerat qui ut numquam incidunt alias. Voluptatibus esse maiores praesentium dicta deleniti,
                        nihil animi, aspernatur odio, unde provident repellat mollitia magnam assumenda atque alias qui.
                        Non iusto earum quod neque cum sunt voluptatem culpa incidunt, modi, omnis placeat repellendus tempore corrupti corporis magnam,
                        eaque veniam asperiores ea. Deleniti nam, recusandae rem eaque magnam voluptatem provident earum amet ipsa dignissimos maiores ex
                        iusto temporibus ut corporis eveniet. Perferendis autem voluptates excepturi, deserunt sequi quo assumenda deleniti rem illum accusantium nisi
                        quaerat vitae dignissimos obcaecati labore recusandae amet magnam iusto. Deserunt eaque in totam ex sunt ullam quam voluptatibus. Explicabo harum minus nam doloremque,
                        ducimus quas asperiores commodi magnam deleniti odit saepe laborum aspernatur voluptate dignissimos excepturi facere sapiente molestiae ratione!
                        Quidem doloremque debitis facere delectus voluptatum, dolor tenetur accusantium, quo dolorem quis impedit vero sint corrupti obcaecati similique!
                        Exercitationem reprehenderit architecto aliquid numquam dignissimos quae minima possimus.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed inset-0">
        <img src="/Asset/people.png" alt="Background" class="w-full h-full object-cover opacity-30">
    </div>

    <!-- Layout principal -->
    <div class="flex relative">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#191A1F] min-h-screen p-6 fixed border-r border-[#4C7DA4]">
            <nav>
                <div class="space-y-2 border-b border-[#FAF9FA] mb-4">
                    <h1 class="text-[#FAF9FA] text-xl font-bold">welcome</h1>
                    <span class="text-[#ECD9B6]"><?php echo $_SESSION['email']; ?></span>
                </div>
                <form method="post">
                    <div class="space-y-2">
                        <button name="logout" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-52">Logout</button>
                        <button name="upgrade" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-52">Upgrade</button>
                    </div>
                </form>
            </nav>
        </aside>

        <!-- Contenu principal -->
        <main class="ml-64 p-8 w-full">
            <section class="bg-[#1F2821]/30 text-[#FAF9FA] border-b-4 border-[#4C7DA4] rounded-lg shadow-xl p-6 backdrop-blur">
                <header class="mb-6 border-b border-[#4C7DA4] pb-4">
                    <h2 class="text-2xl font-bold text-[#FAF9FA]">Articles Disponibles</h2>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <article class="bg-[#191A1F] rounded-lg overflow-hidden shadow-lg border border-[#4C7DA4] hover:border-[#FAF9FA] transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <img class="w-16 h-16 rounded-full object-cover border-2 border-[#ECD9B6]" src="path_to_image.jpg" alt="Photo du client">
                                <div>
                                    <h3 class="text-[#FAF9FA] font-bold text-lg">Title</h3>
                                    <h4 class="text-[#ECD9B6]">Author - category</h4>
                                </div>
                            </div>
                            <p class="text-[#ECD9B6] mb-4 border-l-2 border-[#4C7DA4] pl-4">
                                Description courte de l'article...
                            </p>
                            <button onclick="openModal()"
                                class="w-full text-center bg-[#4C7DA4] text-[#FAF9FA] py-2 rounded-lg hover:bg-[#10ADE9] transition-colors duration-300">
                                Voir l'article
                            </button>
                        </div>
                    </article>
                </div>
            </section>
        </main>
    </div>

    <script src="../JS/script.js"></script>
</body>

</html>