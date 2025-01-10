document.addEventListener("DOMContentLoaded", function () {
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
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json().catch(err => {
                    throw new Error('Le serveur n\'a pas retourné du JSON valide');
                });
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Succès',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#4C7DA4'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("categoryModal").classList.add("hidden");
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Erreur',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#4C7DA4'
                    });
                }
            })
            .catch((error) => {
                console.error('Erreur:', error);
                Swal.fire({
                    title: 'Erreur',
                    text: 'Une erreur est survenue lors de l\'ajout de la catégorie',
                    icon: 'error',
                    confirmButtonColor: '#4C7DA4'
                });
            });
    });
});
