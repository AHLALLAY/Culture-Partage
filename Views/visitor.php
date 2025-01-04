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

<body class="min-h-screen relative bg-[#1C1C1C]">
    <!-- Modal -->
    <div id="articleModal" class="fixed inset-0 bg-[#1C1C1C]/90 z-50 hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-[#383838] w-full max-w-2xl rounded-lg shadow-2xl p-6 mx-4 max-h-[90vh] flex flex-col border border-[#5E5E5E]">
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <img id="modalImage" class="w-20 h-20 rounded-full object-cover border-2 border-[#787878]" src="path_to_image.jpg" alt="Photo de l'article">
                    <div class="rounded p-4 space-y-2">
                        <h2 id="modalTitle" class="text-2xl font-bold text-[#E7E7E7]">Title</h2>
                        <p id="modalAuthor" class="text-[#787878]">Auteur</p>
                        <div class="text-[#787878]">
                            <span>Date</span> - <span>Catégorie</span>
                        </div>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-[#787878] hover:text-[#E7E7E7] text-xl font-bold transition-colors">&times;</button>
            </div>

            <div class="border-t border-[#5E5E5E] py-4 my-4 flex-1 flex flex-col">
                <h3 class="text-[#E7E7E7] font-semibold mb-2">Description</h3>
                <div class="overflow-y-auto max-h-[300px] pr-4">
                    <p id="modalDescription" class="text-[#787878]">
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
                        Iste laudantium earum sapiente expedita voluptatem dolore, nihil, omnis numquam ex, illo molestias vel ut enim nostrum doloribus porro excepturi nisi animi natus repellat saepe ipsum necessitatibus explicabo.
                        Voluptatum, beatae, sint provident debitis dignissimos tenetur laborum fugit nemo aperiam alias magnam expedita quaerat quod! Voluptatibus unde aliquam perferendis incidunt reiciendis nam aut corporis dicta eum dolor debitis at placeat totam maiores,
                        doloremque sint voluptates optio. Quae nisi culpa et, vero adipisci, ullam quos nulla libero ipsum dolore sunt mollitia iusto eaque assumenda aspernatur,
                        laborum voluptatem maxime ipsam ab nesciunt! Ipsa, voluptatem possimus ipsum fugit sequi aliquam itaque nulla, maiores dolorum expedita dignissimos quasi quaerat quidem aut cum odio quo libero corporis asperiores quis non! Dolore ipsum facere rem aut asperiores voluptate aspernatur magni,
                        consectetur assumenda nemo et ex consequuntur quibusdam error iusto accusantium quas numquam optio iste ratione temporibus corporis animi minima? Earum optio mollitia commodi voluptas maxime iusto ipsa expedita error quia! Voluptas praesentium voluptatum incidunt distinctio animi, ipsum facilis soluta dolore error impedit odit, aperiam modi neque. Sapiente, sunt. Quaerat excepturi porro perferendis minima officiis laboriosam soluta consequuntur ad rerum, optio aspernatur consectetur modi unde esse aperiam ratione, dolorem necessitatibus. Enim rerum vitae, iste aliquam repellat voluptate ipsam nemo possimus dolor voluptatum cumque asperiores optio sint vero earum praesentium temporibus iusto recusandae dolorem mollitia ratione aliquid incidunt. Nisi porro ipsam libero minima, fugiat quo ea animi! Magni reiciendis similique quae accusantium numquam provident dolor quasi veritatis! Perspiciatis placeat amet tempore dolorum dolores in cum commodi ad ipsa fuga accusamus delectus corporis vero, atque ut iste recusandae voluptas? Temporibus distinctio, explicabo autem laboriosam iure corrupti ea ipsa dolor illo id exercitationem nisi beatae omnis voluptatem blanditiis, iusto aut magnam quo, quibusdam porro quisquam! Fugit, explicabo repellendus optio in porro, perspiciatis cupiditate maiores corrupti tempore harum eum. Vero possimus nulla magnam mollitia est earum rerum facilis neque? Architecto sed quo voluptates. Dolor, ipsa. Explicabo nulla velit quos sed repellendus vel consectetur ea, facere temporibus quam, officia error id asperiores labore qui culpa non! Minima quod non officia dignissimos repellendus consectetur laborum, perferendis id animi autem! Obcaecati magni nemo rem doloribus eaque quasi neque cumque? Corrupti, deleniti magni sapiente autem soluta eaque doloremque accusamus, suscipit quas consequatur repellendus, voluptatem quis veritatis quibusdam ipsa fuga. Iusto et perspiciatis a veritatis voluptatibus architecto nostrum reiciendis itaque, laboriosam exercitationem voluptatem possimus quos inventore nemo ea aliquid dolorum laudantium. Soluta, expedita illum. Quaerat, itaque odio impedit voluptates suscipit at rerum minima aperiam quod est ratione? Molestias enim vero deserunt autem officiis molestiae et pariatur excepturi? Incidunt harum nihil nulla eius iusto. Fugit est maiores inventore totam minima id blanditiis perspiciatis at, porro earum incidunt praesentium repellat sint similique laborum possimus tempore. Perferendis modi repellendus facere quisquam. Vitae, necessitatibus id tenetur dignissimos aperiam perferendis nostrum, eius aspernatur modi architecto blanditiis odit ullam quae esse explicabo corrupti laudantium deleniti, inventore labore sapiente quaerat suscipit possimus. Expedita ad tempora iure esse, laboriosam saepe, dicta architecto labore aspernatur ratione culpa reiciendis repudiandae officiis ab animi corrupti. Eaque atque quibusdam similique laudantium non fugit? Minima dignissimos commodi illum. Porro perspiciatis officia quidem corporis exercitationem odit tempora perferendis. Quaerat quis quae quia repudiandae, minima veritatis minus eaque inventore voluptates, animi laboriosam ut odio dignissimos voluptatibus et nihil excepturi ullam provident, eos voluptatem! Molestiae, soluta inventore temporibus beatae odit tenetur rem, obcaecati omnis dolorum laudantium et quasi voluptate quidem. Ab repellat, incidunt dicta natus cum enim libero, ipsa ut doloribus, a tempora necessitatibus accusamus repellendus commodi! Commodi impedit explicabo quod. Quam nulla quidem accusamus, voluptas unde enim voluptatibus illo assumenda cumque numquam officia, nisi necessitatibus molestias dolor vero eos quas id optio error quisquam ipsa! Natus architecto laudantium quae repudiandae odit rem voluptatibus cum nostrum tempore facere autem exercitationem obcaecati libero dolores animi nisi facilis, sint velit recusandae ipsam voluptatum molestias! Ab modi itaque, in neque delectus ut soluta aspernatur perspiciatis consectetur deleniti id unde sequi perferendis nostrum commodi amet architecto provident. Est labore enim, in at, eaque soluta, commodi praesentium consequuntur tenetur quo exercitationem sit error cum odit! Quisquam voluptate vel laborum eos
                        velit beatae labore dicta nihil iure cumque optio officia repellendus, temporibus ea porro, ducimus vero modi veritatis recusandae cupiditate cum animi suscipit quam.
                        Libero dolore numquam, doloribus culpa, deserunt aliquam eveniet laboriosam harum explicabo perspiciatis similique ut pariatur laudantium! Repellat minima inventore veritatis quidem totam natus beatae consequuntur blanditiis esse,
                        illum sunt? Officia quaerat earum repellendus, perspiciatis delectus nobis cum!
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
        <aside class="w-64 bg-[#383838] min-h-screen p-6 fixed border-r border-[#5E5E5E]">
            <nav>
                <div class="space-y-2 border-b border-[#E7E7E7] mb-4">
                    <h1 class="text-[#E7E7E7] text-xl font-bold">welcome</h1>
                    <span class="text-white"><?php echo $_SESSION['email']; ?></span>
                </div>
                <form method="post">
                    <div class="space-y-2">
                        <button name="logout" class="text-[#E7E7E7] rounded-lg px-4 py-2 bg-[#5E5E5E] w-52">Logout</button>
                        <button name="upgrade" class="text-[#E7E7E7] rounded-lg px-4 py-2 bg-[#5E5E5E] w-52">upgrade</button>
                    </div>
                </form>
            </nav>
        </aside>

        <!-- Contenu principal -->
        <main class="ml-64 p-8 w-full">
            <section class="bg-[#1C1C1C]/30 text-[#E7E7E7] border-b-4 border-[#787878] rounded-lg shadow-xl p-6 backdrop-blur">
                <header class="mb-6 border-b border-[#5E5E5E] pb-4">
                    <h2 class="text-2xl font-bold text-[#E7E7E7]">Articles Disponibles</h2>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <article class="bg-[#383838] rounded-lg overflow-hidden shadow-lg border border-[#5E5E5E] hover:border-[#E7E7E7] transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <img class="w-16 h-16 rounded-full object-cover border-2 border-[#787878]" src="path_to_image.jpg" alt="Photo du client">
                                <div>
                                    <h3 class="text-[#E7E7E7] font-bold text-lg">Title</h3>
                                    <h4 class="text-[#787878]">Author - category</h4>
                                </div>
                            </div>
                            <p class="text-[#787878] mb-4 border-l-2 border-[#5E5E5E] pl-4">
                                Description courte de l'article...
                            </p>
                            <button onclick="openModal()"
                                class="w-full text-center bg-[#5E5E5E] text-[#E7E7E7] py-2 rounded-lg hover:bg-[#787878] transition-colors duration-300">
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