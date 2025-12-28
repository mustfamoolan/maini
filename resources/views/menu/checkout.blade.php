@extends('layouts.menu-vertical', ['title' => 'إتمام الطلب'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="mb-4">إتمام الطلب</h2>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">تفاصيل الطلب</h5>
            </div>
            <div class="card-body">
                @php
                    $total = 0;
                @endphp
                @foreach($cart as $item)
                    @php
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                    @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                        <span>{{ number_format($itemTotal, 2) }} {{ $currency }}</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>الإجمالي</strong>
                    <strong class="text-primary">{{ number_format($total, 2) }} {{ $currency }}</strong>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">معلومات العميل</h5>
            </div>
            <div class="card-body">
                <form id="checkout-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">العنوان <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظات (اختياري)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <iconify-icon icon="solar:phone-calling-bold-duotone" class="me-2"></iconify-icon>
                            إرسال الطلب عبر واتساب
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary">العودة للسلة</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-bottom')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = {
            name: formData.get('name'),
            phone: formData.get('phone'),
            address: formData.get('address'),
            notes: formData.get('notes'),
            _token: formData.get('_token')
        };

        fetch('{{ route("order.send-whatsapp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Open WhatsApp directly (works on iPhone)
                window.location.href = data.whatsapp_url;
            } else {
                alert('حدث خطأ أثناء إرسال الطلب');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إرسال الطلب');
        });
    });
});
</script>
@endsection

