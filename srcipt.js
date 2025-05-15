const searchBar = document.getElementById('search-bar');
const autocompleteList = document.getElementById('autocomplete-list');

searchBar.addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length > 0) { //
        fetch(`auto.php?search=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                autocompleteList.innerHTML = ''; // Réinitialiser la liste
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const listItem = document.createElement('li');
                        listItem.textContent = item.nom; // Affiche le nom du jeu
                        listItem.addEventListener('click', () => {
                            searchBar.value = item.nom; // Remplit la barre de recherche
                            autocompleteList.innerHTML = ''; // Vide la liste
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
    } 
});

// Fermer la liste si on clique en dehors
document.addEventListener('click', (e) => {
    if (!searchBar.contains(e.target) && !autocompleteList.contains(e.target)) {
        autocompleteList.innerHTML = '';
    }
});