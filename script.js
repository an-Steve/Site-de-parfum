// =======================================================
// JAVASCRIPT POUR LA GESTION DU PANIER (FICHIER : script.js)
// =======================================================

// 1. Initialisation du Panier
let cart = [];

/**
 * Charge le panier depuis le stockage local (LocalStorage) du navigateur.
 */
function loadCart() {
    const storedCart = localStorage.getItem('sillageDorCart');
    if (storedCart) {
        cart = JSON.parse(storedCart);
    }
}

/**
 * Sauvegarde le panier dans le stockage local.
 */
function saveCart() {
    localStorage.setItem('sillageDorCart', JSON.stringify(cart));
}

/**
 * Calcule le nombre total d'articles dans le panier.
 * @returns {number} Le nombre total d'articles.
 */
function getCartItemCount() {
    return cart.reduce((total, item) => total + item.quantity, 0);
}

/**
 * Met à jour l'affichage du compteur du panier dans le header.
 */
function updateCartDisplay() {
    const cartLink = document.querySelector('.user-actions a[href="#"]'); // Cibler le lien du panier
    if (cartLink) {
        const itemCount = getCartItemCount();
        cartLink.textContent = `Panier (${itemCount})`;
    }
}

/**
 * Ajoute un produit au panier.
 * @param {string} name - Nom du produit.
 * @param {number} price - Prix du produit.
 * @param {number} quantity - Quantité à ajouter (par défaut : 1).
 */
function addToCart(name, price, quantity = 1) {
    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({ name, price, quantity });
    }

    saveCart();
    updateCartDisplay();
    alert(`${name} a été ajouté à votre panier !`);
}

// 2. Événements au Chargement de la Page
document.addEventListener('DOMContentLoaded', () => {
    // Charge le panier au démarrage et met à jour l'affichage
    loadCart();
    updateCartDisplay();

    // 3. Gestion des Boutons "Ajouter au Panier" (Page d'Accueil)
    const addButtons = document.querySelectorAll('.product-card .btn-secondary');

    addButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Empêche le lien de recharger la page
            
            // Remonter au conteneur du produit
            const productCard = button.closest('.product-card');
            
            // Récupérer les informations du produit depuis le HTML
            const nameElement = productCard.querySelector('h4');
            const priceElement = productCard.querySelector('.price');

            if (nameElement && priceElement) {
                const name = nameElement.textContent.trim();
                // Nettoyer la chaîne de prix pour obtenir une valeur numérique (ex: "120 €" -> 120)
                const price = parseFloat(priceElement.textContent.replace(' €', '').replace(',', '.').trim());
                
                // Vérification de base pour s'assurer que les données sont valides
                if (name && !isNaN(price)) {
                    addToCart(name, price);
                } else {
                    console.error("Impossible de récupérer les informations du produit.");
                }
            }
        });
    });
});