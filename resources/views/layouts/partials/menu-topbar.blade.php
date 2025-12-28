<header class="topbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="d-flex align-items-center gap-2">
                <!-- Logo -->
                <div class="topbar-item">
                    <a href="{{ route('menu.index') }}" class="d-flex align-items-center">
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="img-fluid" style="max-height: 40px; width: auto;">
                    </a>
                </div>
                <!-- Title -->
                <div class="topbar-item">
                    <h4 class="fw-bold topbar-button pe-none mb-0">{{ $title ?? 'المينيو' }}</h4>
                </div>
            </div>

            <div class="d-flex align-items-center gap-1">
                <!-- Theme Color (Light/Dark) -->
                <div class="topbar-item">
                    <button type="button" class="topbar-button" id="light-dark-mode">
                        <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                    </button>
                </div>

                <!-- Cart -->
                <div class="topbar-item">
                    <a href="{{ route('cart.index') }}" class="topbar-button position-relative" id="cart-link">
                        <iconify-icon icon="solar:cart-large-3-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge bg-danger rounded-pill" id="cart-count-badge" style="display: none;">0</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
// Update cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    
    function updateCartCount() {
        fetch('{{ route("cart.json") }}')
            .then(response => response.json())
            .then(data => {
                const cartCount = data.cart_count || Object.keys(data.cart || data).length;
                const cartCountBadge = document.getElementById('cart-count-badge');
                if (cartCountBadge) {
                    cartCountBadge.textContent = cartCount;
                    if (cartCount > 0) {
                        cartCountBadge.style.display = 'inline-block';
                    } else {
                        cartCountBadge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
    }
    
    // Update cart count every 5 seconds
    setInterval(updateCartCount, 5000);
});
</script>
