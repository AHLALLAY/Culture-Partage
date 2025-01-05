function showArticle(article) {
    document.getElementById('modalTitle').textContent = article.title;
    document.getElementById('modalAuthor').textContent = article.author;
    document.getElementById('modalCategory').textContent = article.category;
    document.getElementById('modalDate').textContent = article.date;
    document.getElementById('modalDescription').textContent = article.body;
    document.getElementById('articleModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('articleModal').classList.add('hidden');
}

// Fermer la modale si on clique en dehors
document.getElementById('articleModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Empêcher la fermeture quand on clique sur le contenu de la modale
document.querySelector('#articleModal > div').addEventListener('click', function(e) {
    e.stopPropagation();
});