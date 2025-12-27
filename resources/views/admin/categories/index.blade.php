@extends('layouts.vertical', ['title' => 'الأقسام'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">قائمة الأقسام</h4>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:add-circle-bold-duotone" class="me-1"></iconify-icon>
                    إضافة قسم
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
                                <th>الترتيب</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->order }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-soft-primary">
                                                <iconify-icon icon="solar:pen-2-bold-duotone"></iconify-icon>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
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
                                    <td colspan="5" class="text-center text-muted">لا توجد أقسام</td>
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

