@extends('layouts.vertical', ['title' => 'الأطباق'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">قائمة الأطباق</h4>
                <a href="{{ route('admin.dishes.create') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:add-circle-bold-duotone" class="me-1"></iconify-icon>
                    إضافة طبق
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>القسم</th>
                                <th>السعر</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dishes as $dish)
                                <tr>
                                    <td>{{ $dish->id }}</td>
                                    <td>
                                        @if($dish->image)
                                            <img src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $dish->name }}</td>
                                    <td>{{ $dish->category->name }}</td>
                                    <td>{{ number_format($dish->price, 2) }} {{ $currency }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.dishes.edit', $dish) }}" class="btn btn-sm btn-soft-primary">
                                                <iconify-icon icon="solar:pen-2-bold-duotone"></iconify-icon>
                                            </a>
                                            <form action="{{ route('admin.dishes.destroy', $dish) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">لا توجد أطباق</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

