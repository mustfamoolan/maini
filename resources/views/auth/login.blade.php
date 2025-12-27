@extends('layouts.auth', ['title' => 'تسجيل الدخول'])

@section('content')
    <div class="d-flex flex-column h-100 p-3">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">
                <div class="col-xxl-7">
                    <div class="row justify-content-center h-100">
                        <div class="col-lg-6 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
                                    <a href="{{ route('admin.dashboard') }}" class="logo-dark">
                                        <img src="/images/logo.png" height="24" alt="logo dark">
                                    </a>

                                    <a href="{{ route('admin.dashboard') }}" class="logo-light">
                                        <img src="/images/logo.png" height="24" alt="logo light">
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24">تسجيل الدخول</h2>

                                <p class="text-muted mt-1 mb-4">أدخل رقم الهاتف وكلمة المرور للوصول إلى لوحة التحكم.</p>

                                <div class="mb-5">
                                    <form method="POST" action="{{ route('login') }}" class="authentication-form">
                                        @csrf
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger">{{ $error }}</div>
                                            @endforeach
                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label" for="phone">رقم الهاتف</label>
                                            <input type="text" id="phone" name="phone"
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}" required autofocus>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <a href="{{ route('password.request') }}"
                                               class="float-end text-muted text-unline-dashed ms-1">نسيت كلمة المرور؟</a>
                                            <label class="form-label" for="password">كلمة المرور</label>
                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="أدخل كلمة المرور" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">تذكرني</label>
                                            </div>
                                        </div>

                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit">تسجيل الدخول</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden">
                        <div class="d-flex flex-column h-100">
                            <img src="/images/small/img-10.jpg" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
