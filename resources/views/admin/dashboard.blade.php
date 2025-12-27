@extends('layouts.vertical', ['title' => 'لوحة التحكم'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar-md bg-soft-primary rounded mx-auto mb-3">
                    <iconify-icon icon="solar:category-bold-duotone" class="avatar-title fs-32 text-primary"></iconify-icon>
                </div>
                <h3 class="text-dark">{{ $categoriesCount }}</h3>
                <p class="text-muted mb-0">عدد الأقسام</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar-md bg-soft-success rounded mx-auto mb-3">
                    <iconify-icon icon="solar:fork-knife-bold-duotone" class="avatar-title fs-32 text-success"></iconify-icon>
                </div>
                <h3 class="text-dark">{{ $dishesCount }}</h3>
                <p class="text-muted mb-0">عدد الأطباق</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar-md bg-soft-info rounded mx-auto mb-3">
                    <iconify-icon icon="solar:qr-code-bold-duotone" class="avatar-title fs-32 text-info"></iconify-icon>
                </div>
                <h5 class="text-dark mb-0">QR Code</h5>
                <p class="text-muted mb-2">للمينيو</p>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-primary">عرض QR Code</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">روابط سريعة</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary w-100">
                            <iconify-icon icon="solar:category-bold-duotone" class="fs-24 d-block mb-2"></iconify-icon>
                            إدارة الأقسام
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.dishes.index') }}" class="btn btn-outline-success w-100">
                            <iconify-icon icon="solar:fork-knife-bold-duotone" class="fs-24 d-block mb-2"></iconify-icon>
                            إدارة الأطباق
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-info w-100">
                            <iconify-icon icon="solar:settings-bold-duotone" class="fs-24 d-block mb-2"></iconify-icon>
                            الإعدادات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('menu.index') }}" target="_blank" class="btn btn-outline-secondary w-100">
                            <iconify-icon icon="solar:eye-bold-duotone" class="fs-24 d-block mb-2"></iconify-icon>
                            عرض المينيو
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

