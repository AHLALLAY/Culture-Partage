<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Includes/Functions.php';

// session_start();
$users = get_users();
$category = get_category();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['logout'])) {
    logout();
}

if (isset($_POST['suspend']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    sus_or_act($id);
}

if (isset($_POST['Add_category'])) {
    if (!empty($_POST['categoryName'])) {
        // Traitement de l'ajout de la catégorie
        $result = new_category($_POST['categoryName']);
        if ($result) {
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de la catégorie.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Le champ de catégorie est vide.']);
        exit();
    }
}

if (isset($_POST['Add_article'])) {
    if (!empty($_POST['articleTitle']) && !empty($_POST['articleDescription']) && !empty($_POST['articleCategory'])) {
        $result = new_article($_POST['articleTitle'], $_POST['articleDescription'], $_POST['articleCategory']);
        if ($result) {
            // echo"<script>alert('Category added with success')</script>";  
        }
    } else {
        echo "<script>alert('Remplir le champ de categorie')</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>DashBoard Admin</title>
</head>

<body class="min-h-screen relative bg-[#1F2821] text_white">
    <!-- Modal d'article -->
    <div id="articleModal" class="fixed inset-0 bg-[#1F2821]/90 z-50 hidden flex items-center justify-center backdrop-blur-sm select-none">
        <div class="bg-[#191A1F] w-full max-w-2xl rounded-lg shadow-2xl p-6 mx-4 max-h-[90vh] flex flex-col border border-[#4C7DA4]">
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="rounded p-4 space-y-2">
                        <h2 class="text-2xl font-bold text-[#FAF9FA]">Ajouter un Article</h2>
                    </div>
                </div>
                <button onclick="closeModal('articleModal')" class="text-[#ECD9B6] hover:text-[#FAF9FA] text-xl font-bold transition-colors">&times;</button>
            </div>

            <form id="addArticleForm" method="POST" enctype="multipart/form-data">
                <div class="border-t border-[#4C7DA4] py-4 my-4 flex-1 flex flex-col">
                    <!-- Titre de l'article -->
                    <div class="mb-4">
                        <label for="articleTitle" class="text-[#FAF9FA] font-semibold">Titre de l'article</label>
                        <input type="text" id="articleTitle" name="articleTitle" class="w-full p-3 mt-2 bg-[#2E3530] text-[#FAF9FA] rounded-lg border border-[#4C7DA4]" required>
                    </div>

                    <!-- Description de l'article -->
                    <div class="mb-4">
                        <label for="articleDescription" class="text-[#FAF9FA] font-semibold">Description</label>
                        <textarea id="articleDescription" name="articleDescription" class="w-full p-3 mt-2 bg-[#2E3530] text-[#FAF9FA] rounded-lg border border-[#4C7DA4]" rows="4" required></textarea>
                    </div>

                    <!-- Catégorie -->
                    <div class="mb-4">
                        <label for="articleCategory" class="text-[#FAF9FA] font-semibold">Catégorie</label>
                        <select id="articleCategory" name="articleCategory" class="w-full p-3 mt-2 bg-[#2E3530] text-[#FAF9FA] rounded-lg border border-[#4C7DA4]" required>
                            <option disabled selected>Sélectionner une catégorie</option>
                            <?php foreach ($category as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['cat']) ?>"><?= htmlspecialchars($cat['cat']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Bouton d'envoi -->
                <div class="flex justify-end">
                    <button type="submit" name="Add_article" class="bg-[#4C7DA4] text-[#FAF9FA] py-2 px-6 rounded-lg hover:bg-[#3D6394]">
                        Ajouter l'article
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de categorie-->
    <div id="categoryModal" class="fixed inset-0 bg-[#1F2821]/90 z-50 hidden flex items-center justify-center backdrop-blur-sm select-none">
        <div class="bg-[#191A1F] w-full max-w-2xl rounded-lg shadow-2xl p-6 mx-4 max-h-[90vh] flex flex-col border border-[#4C7DA4]">
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="rounded p-4 space-y-2">
                        <h2 class="text-2xl font-bold text-[#FAF9FA]">Ajouter un catégorie</h2>
                    </div>
                </div>
                <button onclick="closeModal('categoryModal')" class="text-[#ECD9B6] hover:text-[#FAF9FA] text-xl font-bold transition-colors">&times;</button>
            </div>

            <form id="addCategoryForm" method="POST" enctype="multipart/form-data">
                <div class="border-t border-[#4C7DA4] py-4 my-4 flex-1 flex flex-col">
                    <!-- Titre de l'article -->
                    <div class="mb-4">
                        <label for="categoryName" class="text-[#FAF9FA] font-semibold">catégorie</label>
                        <input type="text" id="categoryName" name="categoryName" class="w-full p-3 mt-2 bg-[#2E3530] text-[#FAF9FA] rounded-lg border border-[#4C7DA4]" required>
                    </div>
                </div>

                <!-- Bouton d'envoi -->
                <div class="flex justify-end">
                    <button type="submit" name="Add_category" class="bg-[#4C7DA4] text-[#FAF9FA] py-2 px-6 rounded-lg hover:bg-[#3D6394]">
                        Ajouter le catégorie
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image de bg -->
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
                    <span class="text-[#ECD9B6]"><?= explode('@', $_SESSION['email'])[0]; ?></span>
                </div>
                <form method="post">
                    <div class="space-y-2">
                        <button type="button" name="display_users" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-52">Display users</button>
                        <button type="button" id="New_article" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-52">Add article</button>
                        <button type="button" id="New_category" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4] w-52">Add Category</button>
                        <button type="button" name="logout" class="text-[#FAF9FA] rounded-lg px-4 py-2 bg-[#4C7DA4]/60 w-52">Logout</button>
                    </div>
                </form>
            </nav>
        </aside>

        <main class="ml-64 p-8 w-full select-none">
            <section class="bg-[#1F2821]/30 text-[#FAF9FA] border-b-4 border-[#4C7DA4] rounded-lg shadow-xl p-6 backdrop-blur">
                <header class="mb-6 border-b border-[#4C7DA4] pb-4">
                    <h2 class="text-2xl font-bold text-[#FAF9FA]">Users</h2>
                    <!-- <span class="text-white"><?= "<script>alert('$msg')</script>" ?></span> -->
                </header>

                <div class="overflow-x-auto relative shadow-md rounded-lg border border-[#4C7DA4]">
                    <table class="w-full text-left text-[#FAF9FA]">
                        <thead class="text-[#FAF9FA] uppercase bg-[#191A1F]">
                            <tr>
                                <th scope="col" class="px-6 py-4 hidden">ID</th>
                                <th scope="col" class="px-6 py-4">Image</th>
                                <th scope="col" class="px-6 py-4">Full Name</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Articles</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr class="border-b border-[#4C7DA4] bg-[#1F2821]/50">
                                    <td colspan="6" class="px-6 py-4 text-center">No users found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="border-b border-[#4C7DA4] bg-[#1F2821]/50 hover:bg-[#191A1F] transition-colors">
                                        <form method="POST">
                                            <td class="px-6 py-4 font-medium hidden">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($user['users_id']) ?>">
                                                <?= htmlspecialchars($user['users_id']) ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="w-16 h-16 relative">
                                                    <img class="rounded-full object-cover border-2 border-[#4C7DA4] w-full h-full" src="data:image/*;base64,<?= base64_encode($user['images']) ?>" alt="<?= htmlspecialchars($user['f_name']) ?>'s profile">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 font-medium">
                                                <?= htmlspecialchars($user['f_name']) . ' ' . htmlspecialchars($user['l_name']) ?>
                                            </td>
                                            <td name="email" class="px-6 py-4">
                                                <?= htmlspecialchars($user['email']) ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 rounded-full text-sm <?= strtolower($user['roles']) === 'admin' ? 'bg-purple-500' : 'bg-[#4C7DA4]' ?>">
                                                    <?= htmlspecialchars($user['roles']) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <button name="view_articles"
                                                    class="text-[#4C7DA4] hover:text-[#FAF9FA] font-medium transition-colors flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    View Articles
                                                </button>
                                            </td>
                                            <td class="px-6 py-4">
                                                <?php if (strtolower($user['roles']) != 'admin'): ?>
                                                    <button type="button" id="suspend-btn-<?= htmlspecialchars($user['users_id']) ?>"
                                                        class="font-medium transition-colors flex items-center gap-2
                                                        <?php if ($user['is_suspend'] == 1): ?>
                                                            text-teal-500 hover:text-teal-800
                                                        <?php else: ?>
                                                            text-rose-500 hover:text-rose-800
                                                        <?php endif; ?>"
                                                        data-user-id="<?= htmlspecialchars($user['users_id']) ?>"
                                                        data-status="<?= $user['is_suspend'] ?>">
                                                        <!-- Icône et texte dynamiques ici -->
                                                        <span class="button-text">
                                                            <?= $user['is_suspend'] == 1 ? 'Activate' : 'Suspend' ?>
                                                        </span>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </form>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script src="/Js/Script.js"></script>
    <!-- <script src="/Js/Ajax.js"></script> -->

    <script>
        const category = document.getElementById('addCategoryForm');
        category.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData(category);

            fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Réponse réseau non OK');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Category ajouté avec succès !');
                        document.getElementById("categoryModal").classList.add("hidden");
                    } else {
                        alert('Erreur lors de l\'ajout de la catégorie: ' + (data.message || ''));
                    }
                })
                .catch((error) => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue.');
                });
        });
    </script>

</body>

</html>