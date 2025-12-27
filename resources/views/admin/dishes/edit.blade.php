@extends('layouts.vertical', ['title' => 'تعديل طبق'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">تعديل الطبق</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.dishes.update', $dish) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="category_id" class="form-label">القسم <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">اختر القسم</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $dish->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">اسم الطبق <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $dish->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">السعر <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $dish->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف (اختياري)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $dish->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">صورة الطبق (اختياري)</label>
                        @if($dish->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}" style="max-width: 200px; max-height: 200px;" class="rounded">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{ route('admin.dishes.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

