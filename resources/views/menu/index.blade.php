@extends('layouts.menu-vertical', ['title' => 'قائمة الطعام'])

@section('css')
@vite(['node_modules/nouislider/dist/nouislider.min.css'])
<style>
    /* Categories horizontal scroll on mobile */
    .categories-scroll-container {
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #09839A transparent;
    }
    
    .categories-scroll-container::-webkit-scrollbar {
        height: 6px;
    }
    
    .categories-scroll-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .categories-scroll-container::-webkit-scrollbar-thumb {
        background-color: #09839A;
        border-radius: 3px;
    }
    
    .categories-scroll {
        min-width: max-content;
        padding-bottom: 4px;
    }
    
    /* Prevent wrapping on mobile */
    @media (max-width: 768px) {
        .categories-scroll {
            flex-wrap: nowrap;
        }
    }
    
    /* Allow wrapping on larger screens */
    @media (min-width: 769px) {
        .categories-scroll {
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card bg-light-subtle mb-4">
            <div class="card-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <div class="search-bar">
                        <span><i class="bx bx-search-alt"></i></span>
                        <input type="search" class="form-control" id="search" placeholder="بحث ...">
                    </div>
                </div>
                
                <!-- Category Filter Buttons with Horizontal Scroll on Mobile -->
                <div class="categories-scroll-container">
                    <div class="d-flex gap-2 align-items-center categories-scroll">
                        <button class="btn btn-primary category-filter-btn active flex-shrink-0" data-category-id="all" type="button">
                            <iconify-icon icon="solar:list-bold-duotone" class="align-middle me-1"></iconify-icon>
                            الكل
                        </button>
                        @foreach($categories as $category)
                            <button class="btn btn-outline-primary category-filter-btn flex-shrink-0" data-category-id="{{ $category->id }}" type="button">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <!-- Dishes Count -->
                <div class="mt-3">
                    <p class="mb-0 text-muted">
                        عرض <span class="text-dark fw-semibold" id="dishes-count">{{ $categories->sum(fn($cat) => $cat->dishes->count()) }}</span> طبق
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="dishes-container">
    @php
        $allDishes = collect();
        foreach($categories as $category) {
            foreach($category->dishes as $dish) {
                $allDishes->push([
                    'dish' => $dish,
                    'category_id' => $category->id
                ]);
            }
        }
    @endphp
    
    @forelse($allDishes as $item)
        @php $dish = $item['dish']; @endphp
        <div class="col-md-6 col-xl-3 mb-4 dish-item" data-category-id="{{ $item['category_id'] }}">
            <div class="card position-relative">
                @if($dish->image)
                    <img src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}" class="img-fluid" style="width: 100%; height: 250px; object-fit: cover;">
                @else
                    <div class="bg-light-subtle d-flex align-items-center justify-content-center" style="height: 250px;">
                        <iconify-icon icon="solar:fork-knife-bold-duotone" class="fs-48 text-muted"></iconify-icon>
                    </div>
                @endif
                <div class="card-body bg-light-subtle rounded-bottom">
                    <h5 class="text-dark fw-medium fs-16 mb-2">{{ $dish->name }}</h5>
                    @if($dish->description)
                        <p class="text-muted mb-2" style="font-size: 14px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $dish->description }}
                        </p>
                    @endif
                    <div class="my-1">
                        <h4 class="fw-semibold text-dark mt-2 d-flex align-items-center gap-2 mb-0">
                            <span>{{ number_format($dish->price, 2) }} {{ $currency }}</span>
                        </h4>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-outline-dark border border-secondary-subtle d-flex align-items-center justify-content-center gap-1 w-100 add-to-cart" 
                                data-dish-id="{{ $dish->id }}" 
                                data-dish-name="{{ $dish->name }}">
                            <iconify-icon icon="solar:cart-plus-2-bold-duotone" class="align-middle"></iconify-icon>
                            أضف للسلة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <iconify-icon icon="solar:fork-knife-bold-duotone" class="fs-64 text-muted mb-3"></iconify-icon>
                <p class="text-muted fs-18">لا توجد أطباق متوفرة حالياً</p>
            </div>
        </div>
    @endforelse
</div>

@endsection

@section('script-bottom')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update cart count on page load
    updateCartCount();

    let selectedCategoryId = 'all';

    // Category filter buttons
    document.querySelectorAll('.category-filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.category-filter-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');
            
            // Update selected category
            selectedCategoryId = this.getAttribute('data-category-id');
            
            // Filter dishes
            filterDishes();
        });
    });

    // Search functionality
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterDishes();
        });
    }

    function filterDishes() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const dishes = document.querySelectorAll('.dish-item');
        let visibleCount = 0;

        dishes.forEach(item => {
            const categoryId = item.getAttribute('data-category-id');
            const dishName = item.querySelector('h5').textContent.toLowerCase();
            const dishDescription = item.querySelector('p') ? item.querySelector('p').textContent.toLowerCase() : '';
            
            // Check category filter
            const matchesCategory = selectedCategoryId === 'all' || selectedCategoryId === categoryId;
            
            // Check search filter
            const matchesSearch = !searchTerm || dishName.includes(searchTerm) || dishDescription.includes(searchTerm);
            
            if (matchesCategory && matchesSearch) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        document.getElementById('dishes-count').textContent = visibleCount;
    }

    // Add to cart buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const dishId = this.getAttribute('data-dish-id');
            const dishName = this.getAttribute('data-dish-name');
            const buttonElement = this;
            
            // Disable button during request
            buttonElement.disabled = true;
            const originalText = buttonElement.innerHTML;
            buttonElement.innerHTML = '<iconify-icon icon="solar:hourglass-line-bold-duotone" class="align-middle"></iconify-icon> جاري الإضافة...';
            
            // Add to cart via AJAX
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    dish_id: dishId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                    // Show success feedback
                    buttonElement.innerHTML = '<iconify-icon icon="solar:check-circle-bold-duotone" class="align-middle text-success"></iconify-icon> تمت الإضافة';
                    setTimeout(() => {
                        buttonElement.disabled = false;
                        buttonElement.innerHTML = originalText;
                    }, 1500);
                } else {
                    alert('حدث خطأ أثناء إضافة الطبق إلى السلة');
                    buttonElement.disabled = false;
                    buttonElement.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إضافة الطبق إلى السلة');
                buttonElement.disabled = false;
                buttonElement.innerHTML = originalText;
            });
        });
    });

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
    
    // Update cart count every 2 seconds
    setInterval(updateCartCount, 2000);
});
</script>
@endsection
