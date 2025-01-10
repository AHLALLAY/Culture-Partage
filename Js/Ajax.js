document.addEventListener("DOMContentLoaded", function() {
    // Gérer les boutons de suspension
    document.querySelectorAll('[id^="suspend-btn-"]').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.userId;
            const currentStatus = button.dataset.status;
            const newStatus = currentStatus == 1 ? 0 : 1;

            // Créer la requête AJAX avec Fetch
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ id: userId, suspend: true })
            })
            .then(response => {
                if (response.ok) {
                    button.classList.toggle('text-teal-500', newStatus === 1);
                    button.classList.toggle('text-rose-500', newStatus === 0);
                    button.querySelector('.button-text').textContent = newStatus === 1 ? 'Activate' : 'Suspend';
                    button.dataset.status = newStatus;
                } else {
                    alert('Une erreur est survenue lors de la mise à jour du statut.');
                }
            })
            .catch(() => alert('Une erreur est survenue.'));
        });
    });

    // Gérer l'ajout d'article
    const article = document.getElementById('addArticleForm');
    article.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(article);

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Article ajouté avec succès !');
                document.getElementById("articleModal").classList.add("hidden");
            } else {
                alert('Erreur lors de l\'ajout de l\'article.');
            }
        })
        .catch(() => alert('Une erreur est survenue.'));
    });

    // Gérer l'ajout de catégorie
    const category = document.getElementById('addCategoryForm');
    category.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(category);

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Category ajouté avec succès !');
                document.getElementById("categoryModal").classList.add("hidden");
            } else {
                alert('Erreur lors de l\'ajout de la catégorie.');
            }
        })
        .catch(() => alert('Une erreur est survenue.'));
    });
});
