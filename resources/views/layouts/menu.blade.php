<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('layouts.partials/title-meta', ['title' => $title ?? 'المينيو'])
    @yield('css')
    @include('layouts.partials/head-css')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('menu.index') }}">المينيو الإلكتروني</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <iconify-icon icon="solar:cart-large-3-bold-duotone" class="fs-24"></iconify-icon>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count" style="display: none;">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    @include("layouts.partials/footer-scripts")
    @vite(['resources/js/app.js','resources/js/layout.js'])
    
    <script>
    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route("cart.json") }}')
            .then(response => response.json())
            .then(data => {
                const cartCount = data.cart_count || 0;
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = cartCount;
                    if (cartCount > 0) {
                        cartCountElement.style.display = 'inline-block';
                    } else {
                        cartCountElement.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error loading cart count:', error));
    });
    </script>
    
    @yield('scripts')
</body>
</html>

