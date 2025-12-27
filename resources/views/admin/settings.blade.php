@extends('layouts.vertical', ['title' => 'الإعدادات'])

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">إعدادات الواتساب</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="whatsapp_number" class="form-label">رقم الواتساب <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $whatsappNumber) }}" placeholder="966501234567" required>
                        <small class="text-muted">أدخل الرقم بالصيغة الدولية بدون + أو - (مثال: 966501234567)</small>
                        @error('whatsapp_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="currency" class="form-label">العملة <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency" value="{{ old('currency', $currency) }}" placeholder="ر.س" required>
                        <small class="text-muted">أدخل رمز العملة (مثال: ر.س، $، €)</small>
                        @error('currency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">حفظ</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">QR Code للمينيو</h4>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="{{ $qrCode }}" alt="QR Code" class="img-fluid" style="max-width: 300px;">
                </div>
                <p class="text-muted mb-3">رابط المينيو: <a href="{{ $menuUrl }}" target="_blank">{{ $menuUrl }}</a></p>
                <a href="{{ route('admin.settings.qr-download') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:download-bold-duotone" class="me-1"></iconify-icon>
                    تحميل QR Code
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

