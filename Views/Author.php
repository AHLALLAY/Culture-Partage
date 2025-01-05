<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Includes/Functions.php';
$msg = null;

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
} else {
    $articles = get_articles();
}

if(isset($_POST['upgrade'])){
    upgrade_role($_SESSION['email']);
}


if (isset($_POST['logout'])) {
    logout();
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
        <div class="bg-[#191A1F] w-full max-w-2xl rounded-lg shadow-2xl p-6 mx-4 max-h-[90vh] overflow-y-auto border border-[#4C7DA4]">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <img id="modalImage" class="w-16 h-16 rounded-full object-cover border-2 border-[#4C7DA4]" src="/Asset/default-avatar.jpg" alt="Photo de l'article">
                    <div class="space-y-2">
                        <h2 id="modalTitle" class="text-xl font-bold text-[#FAF9FA]"></h2> <!-- titre -->
                        <div class="text-[#ECD9B6] text-sm">
                            <span id="modalAuthor"></span> - <span id="modalCategory"></span> <!-- nom & prenom -->
                            <div id="modalDate" class="mt-1"></div> <!-- date -->
                        </div>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-[#ECD9B6] hover:text-[#FAF9FA] text-xl font-bold">&times;</button> <!-- fermer -->
            </div>
            <div class="border-t border-[#4C7DA4] py-4">
                <div class="prose prose-invert">
                    <div id="modalDescription" class="text-[#ECD9B6] whitespace-pre-wrap"></div> <!-- article -->
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
        <aside class="w-64 bg-[#191A1F] min-h-screen p-6 fixed border-r border-[#4C7DA4] select-none">
            <nav>
                <div class="space-y-2 border-b border-[#FAF9FA] mb-4">
                    <h1 class="text-[#FAF9FA] text-xl font-bold">Welcome</h1>
                    <span class="text-[#ECD9B6]"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                </div>
                <form method="post" class="select-none">
                    <div class="space-y-2">
                        <button name="logout" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-full hover:bg-[#10ADE9] transition-colors">Logout</button>
                        <button name="upgrade" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-full hover:bg-[#10ADE9] transition-colors">Display All</button>
                        <button name="new" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-full hover:bg-[#10ADE9] transition-colors">Add Article</button>
                    </div>
                </form>
            </nav>
        </aside>

        <!-- Contenu principal -->
        <main class="ml-64 p-8 w-full">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if ($articles && count($articles) > 0) : ?>
                    <?php foreach ($articles as $article) : ?>
                        <?php
                        $shortBody = strlen($article['art_body']) > 150 ?
                            substr($article['art_body'], 0, 150) . '...' :
                            $article['art_body'];
                        $date = date('d/m/Y', strtotime($article['created_at']));
                        ?>
                        <article class="select-none bg-[#191A1F] rounded-lg overflow-hidden shadow-lg border border-[#4C7DA4] hover:border-[#FAF9FA] transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <img class="w-16 h-16 rounded-full object-cover border-2 border-[#ECD9B6]" src="/Asset/default-avatar.jpg" alt="Photo de l'auteur">
                                    <div>
                                        <h3 class="text-[#FAF9FA] font-bold text-lg"><?= htmlspecialchars($article['title']) ?></h3>
                                        <h4 class="text-[#ECD9B6]"><?= htmlspecialchars(explode('@', $article['email'])[0]) ?></h4>
                                        <span class="text-sm text-[#ECD9B6]"><?= htmlspecialchars($article['category']) ?></span>
                                    </div>
                                </div>
                                <p class="text-[#ECD9B6] mb-4 border-l-2 border-[#4C7DA4] pl-4">
                                    <?= htmlspecialchars($shortBody) ?>
                                </p>
                                <button
                                    onclick='showArticle(<?= json_encode([
                                                                "title" => $article['title'],
                                                                "author" => explode('@', $article['email'])[0],
                                                                "category" => $article['category'],
                                                                "date" => $date,
                                                                "body" => $article['art_body']
                                                            ]) ?>)'
                                    class="w-full text-center bg-[#4C7DA4] text-[#FAF9FA] py-2 rounded-lg hover:bg-[#10ADE9] transition-colors duration-300">
                                    Voir l'article
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-span-3 text-center text-[#ECD9B6]">
                        Aucun article disponible pour le moment.
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php if (isset($msg)) : ?>
        <?php echo "<script>alert('" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "');</script>"; ?>
    <?php endif; ?>
    <script src="../JS/script.js"></script>
</body>

</html>