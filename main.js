document.addEventListener('DOMContentLoaded', () => {
    // Scroll behavior
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(10, 14, 19, 0.95)';
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.5)';
            } else {
                navbar.style.background = 'rgba(13, 17, 23, 0.8)';
                navbar.style.boxShadow = 'none';
            }
        }
    });

    // Auth Modal Logic
    const loginBtn = document.getElementById('loginBtn');
    const authModal = document.getElementById('authModal');
    const closeModal = document.getElementById('closeModal');
    const authForm = document.getElementById('authForm');
    const authTitle = document.getElementById('authTitle');
    const authSubmit = document.getElementById('authSubmit');
    const toggleFormBtn = document.getElementById('toggleFormBtn');

    let isLogin = true;

    if (loginBtn && authModal) {
        loginBtn.addEventListener('click', () => {
            authModal.classList.add('active');
        });

        closeModal.addEventListener('click', () => {
            authModal.classList.remove('active');
        });

        authModal.addEventListener('click', (e) => {
            if (e.target === authModal) {
                authModal.classList.remove('active');
            }
        });

        toggleFormBtn.addEventListener('click', () => {
            isLogin = !isLogin;
            if (isLogin) {
                authTitle.textContent = 'INICIAR SESIÓN';
                authSubmit.textContent = 'Ingresar';
                toggleFormBtn.innerHTML = '¿No tienes cuenta? <span>Regístrate</span>';
            } else {
                authTitle.textContent = 'REGISTRARSE';
                authSubmit.textContent = 'Crear Cuenta';
                toggleFormBtn.innerHTML = '¿Ya tienes cuenta? <span>Inicia Sesión</span>';
            }
        });

        authForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert(isLogin ? 'Sesión iniciada correctamente' : 'Cuenta creada. Bienvenido al Escuadrón.');
            authModal.classList.remove('active');
            authForm.reset();
        });
    }

    // Cart Logic
    const cartBtn = document.getElementById('cartBtn');
    const cartSidebar = document.getElementById('cartSidebar');
    const closeCart = document.getElementById('closeCart');
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotalAmount = document.getElementById('cartTotalAmount');
    const cartCounts = document.querySelectorAll('.cart-count');
    
    let cart = JSON.parse(localStorage.getItem('titanCart')) || [];

    function saveCart() {
        localStorage.setItem('titanCart', JSON.stringify(cart));
    }

    function renderCart() {
        if (!cartItemsContainer) return;

        cartItemsContainer.innerHTML = '';
        let total = 0;
        let count = 0;

        cart.forEach((item, index) => {
            total += item.price * item.quantity;
            count += item.quantity;
            
            const itemEl = document.createElement('div');
            itemEl.className = 'cart-item';
            itemEl.innerHTML = `
                <div class="cart-item-info">
                    <h4>${item.name}</h4>
                    <p>${item.price.toFixed(2)} € x ${item.quantity}</p>
                </div>
                <div class="remove-item" data-index="${index}">Eliminar</div>
            `;
            cartItemsContainer.appendChild(itemEl);
        });

        cartTotalAmount.textContent = total.toFixed(2) + ' €';
        cartCounts.forEach(c => c.textContent = count);

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const idx = parseInt(e.target.getAttribute('data-index'));
                cart.splice(idx, 1);
                saveCart();
                renderCart();
            });
        });
    }

    if (cartBtn && cartSidebar) {
        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.add('active');
        });

        closeCart.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
        });

        document.getElementById('checkoutBtn').addEventListener('click', () => {
            if (cart.length > 0) {
                alert('Iniciando proceso de pago para sus suministros...');
            } else {
                alert('El carrito está vacío. Añade arsenal primero.');
            }
        });
    }

    // Add to cart buttons
    const buyBtns = document.querySelectorAll('.buy-btn');
    buyBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const card = e.target.closest('.product-card');
            const name = card.querySelector('h3').textContent;
            const priceText = card.querySelector('.price').textContent;
            const price = parseFloat(priceText.replace('€', '').trim());

            const existingItem = cart.find(i => i.name === name);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ name, price, quantity: 1 });
            }

            saveCart();
            renderCart();
            
            // Show cart automatically
            if (cartSidebar) {
                cartSidebar.classList.add('active');
            }
        });
    });

    // Initial render
    renderCart();
});
