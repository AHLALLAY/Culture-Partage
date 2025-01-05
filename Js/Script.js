function openModal(title, author, category, date, description) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalAuthor').textContent = author;
    document.getElementById('modalDescription').textContent = description;
    
    // Mettre à jour la date et la catégorie
    const dateCategory = document.querySelector('#modalTitle').nextElementSibling.nextElementSibling;
    dateCategory.innerHTML = `<span>${date}</span> - <span>${category}</span>`;
    
    // Afficher la modal
    document.getElementById('articleModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('articleModal').classList.add('hidden');
}

// Fermer la modal en cliquant en dehors
document.getElementById('articleModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});