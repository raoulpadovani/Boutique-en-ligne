const searchBar = document.getElementById('search-bar');
const autocompleteList = document.getElementById('autocomplete-list');

searchBar.addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length > 0) {
        fetch(`./php/auto.php?search=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                autocompleteList.innerHTML = ''; // Réinitialiser la liste
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const listItem = document.createElement('li');
                        listItem.textContent = item.nom; // Affiche le nom du jeu
                        listItem.addEventListener('click', () => {
                            // Redirige vers la page détail avec l'image en GET
                            window.location.href = `detail.php?image=${encodeURIComponent(item.image_url)}`;
                        });
                        autocompleteList.appendChild(listItem);
                    });
                } else {
                    const noResult = document.createElement('li');
                    noResult.textContent = 'Aucun résultat trouvé';
                    autocompleteList.appendChild(noResult);
                }
            })
            .catch(error => console.error('Erreur:', error));
    } else {
        autocompleteList.innerHTML = '';
    }
});

// Fermer la liste si on clique en dehors
document.addEventListener('click', (e) => {
    if (!searchBar.contains(e.target) && !autocompleteList.contains(e.target)) {
        autocompleteList.innerHTML = '';
    }
});