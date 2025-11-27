<?php
// =======================================================
// PARTIE 1 : LOGIQUE PHP (Simule la base de données et les sessions)
// =======================================================
session_start();

// --- Simulation des produits (Base de données) ---
$products = [
    [
        'id' => 1,
        'name' => "L'Ambre Noir",
        'description' => "Un sillage mystérieux de Santal et d'Encens.",
        'price' => 120.00,
        'image_seed' => 'flacon1',
        'url' => 'produit-star.php?id=1'
    ],
    [
        'id' => 2,
        'name' => "Fleur de Nuit",
        'description' => "Jasmin rare et Tubéreuse pour une féminité éclatante.",
        'price' => 110.00,
        'image_seed' => 'flacon2',
        'url' => 'produit-star.php?id=2'
    ],
    [
        'id' => 3,
        'name' => "Vétiver Royal",
        'description' => "Une fraîcheur verte et boisée pour l'homme moderne.",
        'price' => 95.00,
        'image_seed' => 'flacon3',
        'url' => 'produit-star.php?id=3'
    ]
];

// --- Logique d'ajout au panier (côté serveur PHP) ---
$message = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    
    // Dans un vrai site, vous traiteriez l'ajout à la session ou à la base de données ici.
    // Pour l'exemple, nous allons simuler le succès.
    $product_name = array_filter($products, fn($p) => $p['id'] == $product_id);
    $product_name = $product_name ? reset($product_name)['name'] : "Produit inconnu";
    
    $message = "$product_name ajouté au panier (simulé côté serveur).";
}

// Simulation du nombre d'articles dans le panier
// Le vrai compte doit se baser sur la session PHP, mais le JavaScript gère l'affichage immédiat
$cart_item_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sillage d'Or - Haute Parfumerie</title>

    <style>
        /* Styles de base et typographie */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; line-height: 1.6; color: #333; background-color: #f8f8f8; }
        a { text-decoration: none; color: #555; transition: color 0.3s; }
        a:hover { color: #a00; }
        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; color: #222; margin-bottom: 0.5em; }
        ul { list-style: none; }
        
        /* Header & Navigation */
        .main-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 5%; background-color: #fff; border-bottom: 1px solid #eee; }
        .logo h1 { font-size: 1.8em; font-weight: 700; }
        .main-nav ul { display: flex; }
        .main-nav li { margin: 0 15px; }
        .user-actions a { margin-left: 20px; font-size: 0.9em; }

        /* Bannière Héro */
        .hero-section { position: relative; height: 600px; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; color: #fff; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5); }
        .hero-content h2 { font-size: 3.5em; margin-bottom: 10px; color: #fff; }
        .hero-content p { font-size: 1.2em; margin-bottom: 30px; }

        /* Boutons */
        .btn-primary, .btn-secondary { display: inline-block; padding: 12px 30px; border: 1px solid transparent; text-transform: uppercase; font-weight: 700; font-size: 0.9em; transition: all 0.3s; cursor: pointer; }
        .btn-primary { background-color: #a00; color: #fff; border-color: #a00; }
        .btn-primary:hover { background-color: #700; border-color: #700; }
        .btn-secondary { background-color: #fff; color: #333; border-color: #333; margin-top: 10px; }
        .btn-secondary:hover { background-color: #333; color: #fff; }

        /* Section Produits */
        .featured-products { padding: 60px 5%; text-align: center; }
        .featured-products h3 { font-size: 2em; margin-bottom: 40px; }
        .product-grid { display: flex; justify-content: space-around; gap: 20px; flex-wrap: wrap; }
        .product-card { width: 300px; padding: 20px; background: #fff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); text-align: center; }
        .product-card img { width: 100%; height: auto; margin-bottom: 15px; }
        .product-card h4 { font-size: 1.5em; }
        .product-card .price { display: block; font-weight: 700; margin: 10px 0; color: #a00; }

        /* Footer */
        .main-footer { background-color: #222; color: #ccc; padding: 40px 5%; text-align: center; font-size: 0.9em; }
        .main-footer p { margin: 0; }
        
        /* Media Query pour le Responsive (Mobile) */
        @media (max-width: 768px) {
            .main-header { flex-direction: column; text-align: center; }
            .main-nav ul { flex-direction: column; padding: 10px 0; }
            .main-nav li { margin: 5px 0; }
            .hero-content h2 { font-size: 2.5em; }
            .product-card { width: 100%; }
        }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="logo"><h1>Sillage d'Or</h1></div>
        <nav class="main-nav">
            <ul>
                <li><a href="catalogue.php">Collections</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <a href="mon-compte.php">Compte</a>
            <a href="panier.php">Panier (<?php echo $cart_item_count; ?>)</a>
        </div>
    </header>

    <section class="hero-section" style="background-image: url('https://picsum.photos/seed/parfum1/1600/600');">
        <div class="hero-content">
            <h2>L'Élégance Capturée.</h2>
            <p>Notre nouvelle collection est une ode aux matières premières les plus nobles.</p>
            <a href="catalogue.php" class="btn-primary">Explorer les Parfums</a>
        </div>
    </section>

    <?php if ($message): ?>
        <div style="text-align: center; padding: 15px; background-color: #e6ffe6; color: #008000; font-weight: bold;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <section class="featured-products">
        <h3>Nos Signatures Olfactives</h3>
        <div class="product-grid">
            
            <?php foreach ($products as $product): ?>
            
            <div class="product-card">
                <a href="<?php echo $product['url']; ?>">
                    <img src="https://picsum.photos/seed/<?php echo $product['image_seed']; ?>/300/400" alt="Flacon de <?php echo $product['name']; ?>">
                    <h4><?php echo $product['name']; ?></h4>
                </a>
                <p><?php echo $product['description']; ?></p>
                <span class="price"><?php echo number_format($product['price'], 2, ',', ' '); ?> €</span>
                
                <form method="POST" action="index.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" name="add_to_cart" class="btn-secondary add-to-cart-js" 
                            data-product-name="<?php echo htmlspecialchars($product['name']); ?>" 
                            data-product-price="<?php echo $product['price']; ?>">
                        Ajouter au Panier
                    </button>
                </form>

            </div>
            
            <?php endforeach; ?>

        </div>
    </section>

    <footer class="main-footer">
        <p>&copy; <?php echo date("Y"); ?> Sillage d'Or. Tous droits réservés.</p>
    </footer>

    <script>
        let cart = [];

        function loadCart() {
            const storedCart = localStorage.getItem('sillageDorCart');
            if (storedCart) {
                cart = JSON.parse(storedCart);
            }
        }

        function saveCart() {
            localStorage.setItem('sillageDorCart', JSON.stringify(cart));
        }

        function getCartItemCount() {
            return cart.reduce((total, item) => total + item.quantity, 0);
        }

        function updateCartDisplay() {
            // Cible le lien du panier dans l'en-tête (Header)
            const cartLink = document.querySelector('.user-actions a[href="panier.php"]'); 
            if (cartLink) {
                const itemCount = getCartItemCount();
                cartLink.textContent = `Panier (${itemCount})`;
            }
        }

        function addToCart(name, price, quantity = 1) {
            const existingItem = cart.find(item => item.name === name);

            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ name, price, quantity });
            }

            saveCart();
            updateCartDisplay();
            console.log(`Produit ajouté (JS): ${name}`);
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadCart();
            updateCartDisplay();

            // Gestion des Boutons "Ajouter au Panier" (Côté Client JS)
            const addButtons = document.querySelectorAll('.add-to-cart-js');

            addButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    // Ici, nous laissons le formulaire PHP faire son action (POST)
                    // MAIS nous utilisons aussi le JS pour l'affichage immédiat du compteur
                    
                    const name = button.getAttribute('data-product-name');
                    const price = parseFloat(button.getAttribute('data-product-price'));
                    
                    if (name && !isNaN(price)) {
                        // Ajout au panier LocalStorage pour l'affichage immédiat
                        addToCart(name, price);
                        
                        // Note: L'action POST du formulaire va recharger la page
                        // C'est un comportement typique du PHP simple.
                    }
                });
            });
        });
    </script>
</body>
</html>