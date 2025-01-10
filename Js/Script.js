// // Gestion de la soumission du formulaire de catégorie
// document.getElementById('addCategoryForm').addEventListener('submit', async (e) => {
//     e.preventDefault();

//     const formData = new FormData(e.target);
//     const response = await fetch('', {
//         method: 'POST',
//         body: formData,
//     });

//     const result = await response.json();
//     if (result.success) {
//         alert('Category added successfully!');
//         // closeModal('categoryModal');
//     } else {
//         alert('Failed to add category: ' + result.message);
//     }
// });

// // Gestion de la soumission du formulaire d'article
// document.getElementById('addArticleForm').addEventListener('submit', async (e) => {
//     e.preventDefault();

//     const formData = new FormData(e.target);
//     const response = await fetch('', {
//         method: 'POST',
//         body: formData,
//     });

//     const result = await response.json();
//     if (result.success) {
//         alert('Article added successfully!');
//         // closeModal('articleModal');
//     } else {
//         alert('Failed to add article: ' + result.message);
//     }
// });

document.getElementById('New_article').addEventListener('click', () => {
    openModal('articleModal');
});

document.getElementById('New_category').addEventListener('click', () => {
    openModal('categoryModal');
});

function openModal(id){
    document.getElementById(id).classList.remove('hidden')
}

function closeModal(id){
    document.getElementById(id).classList.add('hidden')
}

document.getElementById('display_users').addEventListener('click', () => {
    document.getElementById('users').classList.remove('hidden');
    document.getElementById('articles').classList.add('hidden');
});

document.getElementById('display_article').addEventListener('click', () => {
    document.getElementById('users').classList.add('hidden');
    document.getElementById('articles').classList.remove('hidden');
});