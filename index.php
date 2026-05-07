<?php
require_once 'config.php';

// Manejo del formulario de nuevo operativo
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_operative') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, 'hashed_password_placeholder']);
        $message = "OPERATIVO " . strtoupper($username) . " ALISTADO CON ÉXITO EN LA BASE DE DATOS.";
    } catch (PDOException $e) {
        $message = "ERROR AL ALISTAR: " . $e->getMessage();
    }
}

// Obtener productos
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

// Obtener usuarios
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html class="dark scroll-smooth" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Titan Supplements - Equipamiento de Élite (Dynamic)</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Hanken+Grotesk:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .noise-overlay { background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E"); opacity: 0.05; pointer-events: none; }
        .chiaroscuro-gradient { background: linear-gradient(to right, rgba(20, 19, 19, 1) 0%, rgba(20, 19, 19, 0.4) 50%, rgba(20, 19, 19, 0) 100%) }
        body { min-height: max(884px, 100dvh); }
        .text-vertical { writing-mode: vertical-rl; text-orientation: mixed; }
        .modal-overlay { visibility: hidden; opacity: 0; transition: all 0.3s ease; }
        .modal-overlay.active { visibility: visible; opacity: 1; }
        .cart-sidebar { transform: translateX(100%); transition: transform 0.3s ease; }
        .cart-sidebar.active { transform: translateX(0); }
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 12px; border: 1px solid #444748; background-color: #2b2a2a; }
        .cart-item-info h4 { font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; color: #e5e2e1; text-transform: uppercase; line-height: 1; }
        .cart-item-info p { font-family: 'Hanken Grotesk', sans-serif; font-size: 0.875rem; color: #c4c7c7; margin-top: 4px; }
        .remove-item { font-family: 'Hanken Grotesk', sans-serif; font-size: 0.75rem; font-weight: bold; color: #ffb4ab; text-transform: uppercase; cursor: pointer; padding: 4px 8px; border: 1px solid transparent; transition: all 0.2s; }
        .remove-item:hover { border-color: #ffb4ab; }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-container": "#201f1f", "surface": "#141313", "tertiary-container": "#1a1a1a", "on-secondary-fixed-variant": "#434931", "error": "#ffb4ab", "surface-tint": "#c8c6c5", "on-primary": "#313030", "surface-container-high": "#2b2a2a", "inverse-surface": "#e5e2e1", "outline-variant": "#444748", "on-secondary-fixed": "#181e09", "on-tertiary-fixed-variant": "#474747", "on-primary-fixed": "#1c1b1b", "inverse-primary": "#5f5e5e", "on-error": "#690005", "on-tertiary-fixed": "#1b1c1c", "surface-dim": "#141313", "surface-container-highest": "#353434", "on-surface": "#e5e2e1", "surface-bright": "#3a3939", "secondary-fixed": "#e0e6c5", "on-secondary": "#2d331c", "tertiary": "#c8c6c6", "on-primary-container": "#848282", "on-tertiary-container": "#838282", "primary-fixed": "#e5e2e1", "error-container": "#93000a", "on-error-container": "#ffdad6", "on-primary-fixed-variant": "#474746", "primary": "#c8c6c5", "outline": "#8e9192", "on-tertiary": "#303030", "surface-variant": "#353434", "on-surface-variant": "#c4c7c7", "inverse-on-surface": "#313030", "tertiary-fixed-dim": "#c8c6c6", "background": "#141313", "surface-container-low": "#1c1b1b", "secondary": "#c3caaa", "primary-container": "#1a1a1a", "secondary-container": "#464c33", "surface-container-lowest": "#0e0e0e", "primary-fixed-dim": "#c8c6c5", "secondary-fixed-dim": "#c3caaa", "on-secondary-container": "#b5bc9c", "tertiary-fixed": "#e4e2e2", "on-background": "#e5e2e1"
                    },
                    fontFamily: { "label-sm": ["Hanken Grotesk"], "h1": ["Bebas Neue"], "h3": ["Bebas Neue"], "body-md": ["Hanken Grotesk"], "body-lg": ["Hanken Grotesk"], "h2": ["Bebas Neue"] },
                    fontSize: { "label-sm": ["12px", { "lineHeight": "1.2", "letterSpacing": "0.1em", "fontWeight": "700" }], "h1": ["80px", { "lineHeight": "1.0", "letterSpacing": "0.02em", "fontWeight": "400" }], "h3": ["32px", { "lineHeight": "1.1", "letterSpacing": "0.03em", "fontWeight": "400" }], "body-md": ["16px", { "lineHeight": "1.5", "letterSpacing": "0", "fontWeight": "400" }], "body-lg": ["18px", { "lineHeight": "1.6", "letterSpacing": "0", "fontWeight": "400" }], "h2": ["48px", { "lineHeight": "1.0", "letterSpacing": "0.02em", "fontWeight": "400" }] },
                    spacing: { "lg": "24px", "gutter": "24px", "xl": "48px", "xs": "4px", "md": "16px", "margin": "48px", "unit": "4px", "xxl": "96px", "sm": "8px" }
                }
            }
        }
    </script>
</head>

<body class="bg-background text-on-surface font-body-md selection:bg-secondary selection:text-on-secondary overflow-x-hidden">
    <div class="fixed inset-0 noise-overlay z-0 pointer-events-none"></div>

    <!-- Header -->
    <header class="w-full top-0 sticky bg-surface border-b border-outline-variant z-40 flex justify-between items-center px-margin py-md" id="navbar">
        <div class="flex items-center gap-md">
            <span class="material-symbols-outlined text-primary cursor-pointer active:opacity-80 md:hidden" onclick="document.getElementById('mobileNav').classList.toggle('hidden')">menu</span>
            <span class="font-h2 text-h2 text-on-surface tracking-widest uppercase">TITAN SUPPLEMENTS</span>
        </div>
        <nav class="hidden md:flex gap-xl" id="mobileNav">
            <a class="font-label-sm text-label-sm uppercase text-on-surface-variant hover:text-primary transition-colors duration-100" href="#inicio">INICIO</a>
            <a class="font-label-sm text-label-sm uppercase text-on-surface-variant hover:text-primary transition-colors duration-100" href="#filosofia">LA DISCIPLINA</a>
            <a class="font-label-sm text-label-sm uppercase text-on-surface-variant hover:text-primary transition-colors duration-100" href="#productos">EL ARSENAL</a>
            <a class="font-label-sm text-label-sm uppercase text-on-surface-variant hover:text-primary transition-colors duration-100" href="#inteligencia">INTELIGENCIA</a>
        </nav>
        <div class="flex items-center gap-md">
            <button id="loginBtn" class="font-label-sm text-label-sm uppercase border border-outline px-md py-sm hover:bg-white hover:text-background transition-colors hidden md:block">INGRESAR</button>
            <div id="cartBtn" class="relative cursor-pointer hover:text-primary transition-colors duration-100 active:opacity-80">
                <span class="material-symbols-outlined text-primary">shopping_cart</span>
                <span class="cart-count absolute -top-2 -right-2 bg-secondary text-on-secondary text-[10px] font-bold px-1.5 py-0.5 rounded-full">0</span>
            </div>
        </div>
    </header>

    <?php if ($message): ?>
    <div class="fixed top-20 right-margin z-50 bg-secondary-container border border-secondary text-on-secondary-container px-lg py-md shadow-2xl animate-bounce">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>

    <main class="relative z-10">
        <!-- Hero Section -->
        <section id="inicio" class="relative h-[795px] w-full overflow-hidden flex items-center">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover grayscale opacity-60" alt="Athlete focused" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDJopn_ZXTjFDizDSMGR6QbHvdMK4P0t-zHf2wWKP6948K58idIi-9Hu1kmFff4wvpr4K8OwYPYOG8NZrrdN5u81OGtj0BEoBhHWg9GJhjZEXk22kG03RwMUKl0bXbd_5Bar-atVSV8_mtgM3OsnJ4UVwrNDz1luZuBo7Ucu79ORSjOaReEgm1S32ynQ2eLjfdwLbX3ySceWht3llAyJeV4ppoHSZCPgB13PrRyQ9AF2qOc-helauFwS06h_paf2ZgsFBTBbryS8bE" />
                <div class="absolute inset-0 chiaroscuro-gradient"></div>
            </div>
            <div class="relative z-10 px-margin max-w-4xl">
                <div class="mb-sm">
                    <span class="font-label-sm text-label-sm text-secondary bg-secondary-container px-sm py-xs inline-block">MISION CRÍTICA</span>
                </div>
                <h1 class="font-h1 text-h1 mb-md">ENTRENA COMO<br />UN TITÁN.</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mb-xl">Descubre los suplementos diseñados para llevar tu físico más allá de los límites humanos. Conviértete en la élite. Sobrevive a cada serie.</p>
                <div class="flex flex-wrap gap-md">
                    <button class="bg-[#3E442C] text-white px-xl py-md font-label-sm text-label-sm uppercase hover:bg-on-surface hover:text-surface transition-all duration-100" onclick="document.getElementById('productos').scrollIntoView({ behavior: 'smooth' });">EXPLORAR ARSENAL</button>
                    <button class="border border-outline px-xl py-md font-label-sm text-label-sm uppercase hover:bg-white hover:text-background transition-all duration-100" onclick="document.getElementById('filosofia').scrollIntoView({ behavior: 'smooth' });">VER DIRECTIVAS</button>
                </div>
            </div>
        </section>

        <!-- Philosophy Section -->
        <section id="filosofia" class="py-xxl px-margin grid grid-cols-12 gap-gutter bg-surface-container-low border-b border-outline-variant">
            <div class="col-span-12 md:col-span-2 hidden md:block">
                <div class="sticky top-margin">
                    <p class="text-vertical font-h2 text-h2 text-outline-variant opacity-30 leading-none">NUESTRA HISTORIA</p>
                </div>
            </div>
            <div class="col-span-12 md:col-span-8 flex flex-col gap-xl">
                <div class="flex flex-col gap-md">
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.2em]">01. EL LLAMADO</span>
                    <h2 class="font-h2 text-h2 uppercase">MÁS ALLÁ DE LOS LÍMITES</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">En Titan Supplements, nacimos con una única misión: proporcionar el equipamiento de élite necesario para que superes tus límites humanos. No somos una marca más, somos el Escuadrón de Reconocimiento del fitness.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-xl items-center">
                    <div class="aspect-square border border-outline-variant overflow-hidden">
                        <img class="w-full h-full object-cover grayscale opacity-60" alt="Training Rope" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_QXbd6Zc3l4Tpc9G00EBGOJX3ih3vXbje4SYGZGI8Oe_sp3UV42fFcgwlnXHXSeR1gKeZskDhZtm3sIqHbrys7HWRVFYJce1o_LAzZjxf5XKMw754eMPZOVYn-OonKBA840jb91pVYQidf7zURqEVZeOnIHihYDYfh40LLZCL5Xs8y4d2RtdF0u9EnSwFzn9f4Csuu9W3FMY-vUB_GDK8IJFv2nlooa116xCLA-h5Y6PnYe61bP3tBeK-BR5TlC0qgL4dxlbMQB0" />
                    </div>
                    <div class="flex flex-col gap-md">
                        <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.2em]">02. LA DOCTRINA</span>
                        <h3 class="font-h3 text-h3 uppercase">PRECISIÓN QUIRÚRGICA</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Aquí encontrarás suplementos formulados con la máxima precisión, diseñados para otorgarte fuerza explosiva, energía inagotable y recuperación acelerada. Entregamos todo nuestro esfuerzo para que tú puedas entregar tu corazón a los hierros.</p>
                        <div class="h-px w-full bg-outline-variant my-md"></div>
                        <div class="flex gap-lg">
                            <div><p class="font-h3 text-h3 text-on-surface">100%</p><p class="font-label-sm text-label-sm text-on-surface-variant uppercase">Eficacia</p></div>
                            <div><p class="font-h3 text-h3 text-on-surface">0%</p><p class="font-label-sm text-label-sm text-on-surface-variant uppercase">Excusas</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section id="productos" class="py-xxl px-margin bg-surface">
            <div class="flex flex-col md:flex-row justify-between items-end mb-xl gap-md">
                <div><span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Equipamiento</span><h2 class="font-h2 text-h2 uppercase">NUESTRO ARSENAL</h2></div>
                <p class="font-label-sm text-label-sm text-on-surface-variant max-w-xs border-l border-outline-variant pl-md">RE-INGENIERÍA DEL RENDIMIENTO BIOLÓGICO MEDIANTE COMPOSICIÓN QUÍMICA SUPERIOR.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                <?php foreach ($products as $product): ?>
                <div class="product-card group border border-outline-variant bg-surface-container-low p-md flex flex-col gap-md hover:border-secondary transition-colors duration-200">
                    <div class="aspect-[4/5] bg-surface-container overflow-hidden">
                        <img class="w-full h-full object-cover grayscale group-hover:scale-105 transition-transform duration-500" alt="<?php echo $product['name']; ?>" src="<?php echo $product['image_url']; ?>" />
                    </div>
                    <div>
                        <h3 class="font-h3 text-h3 text-on-surface uppercase leading-tight"><?php echo $product['name']; ?></h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-md h-12"><?php echo $product['description']; ?></p>
                        <div class="flex justify-between items-center pt-md border-t border-outline-variant">
                            <span class="price font-h3 text-h3"><?php echo number_format($product['price'], 2); ?> €</span>
                            <button class="buy-btn text-on-surface hover:text-secondary transition-colors active:scale-95">
                                <span class="material-symbols-outlined">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Mission Intelligence Section (Database View) -->
        <section id="inteligencia" class="py-xxl px-margin bg-surface-container-low border-t border-outline-variant">
            <div class="flex flex-col gap-xl">
                <div><span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">Base de Datos</span><h2 class="font-h2 text-h2 uppercase">INTELIGENCIA DE MISIÓN</h2></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl">
                    <!-- Table 1: Operatives (Users) -->
                    <div class="flex flex-col gap-md">
                        <h3 class="font-h3 text-h3 text-on-surface border-b border-outline-variant pb-xs">OPERATIVOS REGISTRADOS</h3>
                        <div class="overflow-x-auto border border-outline-variant">
                            <table class="w-full text-left font-label-sm">
                                <thead class="bg-surface-container-high text-on-surface uppercase tracking-tighter">
                                    <tr><th class="px-md py-sm border-r border-outline-variant">ID</th><th class="px-md py-sm border-r border-outline-variant">Usuario</th><th class="px-md py-sm">Email</th></tr>
                                </thead>
                                <tbody id="operativesTableBody" class="text-on-surface-variant">
                                    <?php foreach ($users as $user): ?>
                                    <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                        <td class="px-md py-sm border-r border-outline-variant"><?php echo $user['id']; ?></td>
                                        <td class="px-md py-sm border-r border-outline-variant font-bold"><?php echo $user['username']; ?></td>
                                        <td class="px-md py-sm"><?php echo $user['email']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Table 2: Arsenal (Products) -->
                    <div class="flex flex-col gap-md">
                        <h3 class="font-h3 text-h3 text-on-surface border-b border-outline-variant pb-xs">INVENTARIO DEL ARSENAL</h3>
                        <div class="overflow-x-auto border border-outline-variant">
                            <table class="w-full text-left font-label-sm">
                                <thead class="bg-surface-container-high text-on-surface uppercase tracking-tighter">
                                    <tr><th class="px-md py-sm border-r border-outline-variant">Nombre</th><th class="px-md py-sm border-r border-outline-variant">Categoría</th><th class="px-md py-sm border-r border-outline-variant">Precio</th><th class="px-md py-sm">Stock</th></tr>
                                </thead>
                                <tbody id="arsenalTableBody" class="text-on-surface-variant">
                                    <?php foreach ($products as $product): ?>
                                    <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                        <td class="px-md py-sm border-r border-outline-variant font-bold"><?php echo $product['name']; ?></td>
                                        <td class="px-md py-sm border-r border-outline-variant"><?php echo $product['category']; ?></td>
                                        <td class="px-md py-sm border-r border-outline-variant text-primary font-bold"><?php echo number_format($product['price'], 2); ?> €</td>
                                        <td class="px-md py-sm font-mono"><?php echo $product['stock']; ?> unidades</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form to Add Operative -->
                <div class="max-w-2xl mt-xl border border-secondary p-xl bg-surface-container shadow-2xl">
                    <h3 class="font-h3 text-h3 uppercase mb-md text-secondary">ALISTAR NUEVO OPERATIVO</h3>
                    <p class="font-body-md text-on-surface-variant mb-lg">Añade información crítica a la base de datos central de la Legión.</p>
                    <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <input type="hidden" name="action" value="add_operative">
                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-on-surface-variant uppercase">Nombre de Usuario</label>
                            <input type="text" name="username" required class="bg-background border border-outline-variant text-on-surface px-md py-sm focus:border-secondary outline-none font-body-md">
                        </div>
                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-on-surface-variant uppercase">Email de Operativo</label>
                            <input type="email" name="email" required class="bg-background border border-outline-variant text-on-surface px-md py-sm focus:border-secondary outline-none font-body-md">
                        </div>
                        <div class="md:col-span-2 flex justify-end mt-md">
                            <button type="submit" class="bg-secondary text-on-secondary px-xl py-md font-label-sm uppercase hover:bg-on-surface hover:text-background transition-all active:scale-95">ACTUALIZAR BASE DE DATOS</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="w-full py-xl bg-surface-container-lowest border-t border-outline-variant flex flex-col items-center gap-md px-margin text-center relative z-10">
        <h2 class="font-h2 text-h2 text-on-surface tracking-widest">TITAN SUPPLEMENTS</h2>
        <div class="flex flex-wrap justify-center gap-lg">
            <a class="font-label-sm text-label-sm uppercase tracking-tighter text-on-surface-variant hover:text-primary transition-colors underline" href="#">Protocolos</a>
            <a class="font-label-sm text-label-sm uppercase tracking-tighter text-on-surface-variant hover:text-primary transition-colors" href="#">Cadena de Suministro</a>
            <a class="font-label-sm text-label-sm uppercase tracking-tighter text-on-surface-variant hover:text-primary transition-colors" href="#">Privacidad</a>
            <a class="font-label-sm text-label-sm uppercase tracking-tighter text-on-surface-variant hover:text-primary transition-colors" href="#">Directivas</a>
        </div>
        <p class="font-label-sm text-label-sm uppercase tracking-tighter text-on-surface-variant mt-md">&copy; 2026 TITAN SUPPLEMENTS | ENTREGA TU CORAZÓN A LOS HIERROS</p>
    </footer>

    <!-- Mobile Bottom Nav -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full flex justify-around items-center px-gutter py-sm bg-surface-container-highest border-t border-outline-variant z-50">
        <div class="flex flex-col items-center justify-center text-on-surface-variant pt-2 hover:text-on-surface transition-transform active:scale-95"><span class="material-symbols-outlined">storefront</span><span class="font-label-sm text-label-sm">Tienda</span></div>
        <div class="flex flex-col items-center justify-center text-on-surface-variant pt-2 hover:text-on-surface transition-transform active:scale-95" onclick="document.getElementById('cartBtn').click()"><span class="material-symbols-outlined">shopping_bag</span><span class="font-label-sm text-label-sm relative">Carrito <span class="cart-count text-secondary ml-1">0</span></span></div>
        <div class="flex flex-col items-center justify-center text-secondary border-t-2 border-secondary pt-2 active:scale-95 transition-transform" onclick="document.getElementById('loginBtn').click()"><span class="material-symbols-outlined">person</span><span class="font-label-sm text-label-sm">Perfil</span></div>
    </nav>

    <!-- Modals -->
    <div class="modal-overlay fixed inset-0 bg-black/80 z-[100] flex items-center justify-center backdrop-blur-sm" id="authModal">
        <div class="bg-surface border border-outline-variant p-xl max-w-md w-full relative mx-4">
            <span class="material-symbols-outlined absolute top-md right-md text-on-surface-variant cursor-pointer hover:text-white" id="closeModal">close</span>
            <h2 id="authTitle" class="font-h2 text-h2 uppercase mb-lg text-center">INICIAR SESIÓN</h2>
            <form id="authForm" class="flex flex-col gap-md">
                <div class="flex flex-col gap-xs"><label for="email" class="font-label-sm text-label-sm uppercase text-on-surface-variant">Correo Electrónico</label><input type="email" id="email" class="bg-surface-container border border-outline-variant text-on-surface px-md py-sm focus:border-secondary outline-none font-body-md" required></div>
                <div class="flex flex-col gap-xs"><label for="password" class="font-label-sm text-label-sm uppercase text-on-surface-variant">Contraseña</label><input type="password" id="password" class="bg-surface-container border border-outline-variant text-on-surface px-md py-sm focus:border-secondary outline-none font-body-md" required></div>
                <button type="submit" id="authSubmit" class="bg-[#3E442C] text-white py-md font-label-sm text-label-sm uppercase hover:bg-white hover:text-background transition-colors mt-sm">Ingresar</button>
            </form>
            <div class="text-center mt-md"><button type="button" class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" id="toggleFormBtn">¿No tienes cuenta? <span class="underline text-secondary">Regístrate</span></button></div>
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar fixed top-0 right-0 h-full w-full sm:w-[400px] bg-surface border-l border-outline-variant z-[100] flex flex-col shadow-2xl" id="cartSidebar">
        <div class="flex justify-between items-center p-lg border-b border-outline-variant bg-surface-container-lowest"><h2 class="font-h2 text-h2 uppercase tracking-widest text-on-surface">TU ARSENAL</h2><span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-white" id="closeCart">close</span></div>
        <div class="flex-1 overflow-y-auto p-lg flex flex-col gap-md" id="cartItems"><!-- JS injected --></div>
        <div class="p-lg border-t border-outline-variant bg-surface-container-lowest"><div class="flex justify-between items-center mb-lg"><span class="font-label-sm text-label-sm uppercase text-on-surface-variant">Total Operación:</span><span id="cartTotalAmount" class="font-h3 text-h3 text-primary">0.00 €</span></div><button id="checkoutBtn" class="w-full bg-[#3E442C] text-white py-md font-label-sm text-label-sm uppercase hover:bg-white hover:text-background transition-colors">Confirmar Suministros</button></div>
    </div>

    <script src="main.js"></script>
</body>
</html>
