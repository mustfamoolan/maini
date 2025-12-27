@extends('layouts.menu-vertical', ['title' => 'السلة'])

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">سلة التسوق</h2>
        
        <div id="cart-items">
            @if(!empty($cart))
                @php
                    $total = 0;
                @endphp
                @foreach($cart as $item)
                    @php
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                    @endphp
                    <div class="card mb-3 cart-item" data-dish-id="{{ $item['id'] }}">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    @if($item['image'] ?? null)
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-light-subtle d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 80px;">
                                            <iconify-icon icon="solar:fork-knife-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1">{{ $item['name'] }}</h5>
                                    <p class="text-muted mb-0">{{ number_format($item['price'], 2) }} {{ $currency }} لكل قطعة</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="max-width: 150px;">
                                        <button class="btn btn-outline-secondary btn-sm decrease-qty" type="button">-</button>
                                        <input type="number" class="form-control form-control-sm text-center quantity-input" value="{{ $item['quantity'] }}" min="1" readonly>
                                        <button class="btn btn-outline-secondary btn-sm increase-qty" type="button">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="fw-bold fs-16">{{ number_format($itemTotal, 2) }} {{ $currency }}</span>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-danger btn-sm remove-item">
                                        <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">الإجمالي</h4>
                            <h4 class="mb-0 text-primary" id="cart-total">{{ number_format($total, 2) }} {{ $currency }}</h4>
                        </div>
                    </div>
                </div>
                
                <div class="text-end mt-4">
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">متابعة التسوق</a>
                    <a href="{{ route('order.checkout') }}" class="btn btn-primary">إتمام الطلب</a>
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted fs-18">السلة فارغة</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">العودة للمينيو</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script-bottom')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Increase quantity
    document.querySelectorAll('.increase-qty').forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const dishId = cartItem.getAttribute('data-dish-id');
            const quantityInput = cartItem.querySelector('.quantity-input');
            const newQuantity = parseInt(quantityInput.value) + 1;
            updateQuantity(dishId, newQuantity);
        });
    });

    // Decrease quantity
    document.querySelectorAll('.decrease-qty').forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const dishId = cartItem.getAttribute('data-dish-id');
            const quantityInput = cartItem.querySelector('.quantity-input');
            const newQuantity = Math.max(1, parseInt(quantityInput.value) - 1);
            updateQuantity(dishId, newQuantity);
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const dishId = cartItem.getAttribute('data-dish-id');
            removeItem(dishId);
        });
    });

    function updateQuantity(dishId, quantity) {
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                dish_id: dishId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to update totals
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث الكمية');
        });
    }

    function removeItem(dishId) {
        if (!confirm('هل تريد حذف هذا الطبق من السلة؟')) {
            return;
        }

        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                dish_id: dishId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الطبق');
        });
    }
});
</script>
@endsection

