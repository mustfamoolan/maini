<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layouts.partials/title-meta', ['title' => $title ?? 'المينيو'])
    @yield('css')
    @include('layouts.partials/head-css')
</head>

<body>

<div class="wrapper">

    @include("layouts.partials/menu-topbar", ['title' => $title])

    <div class="page-content" style="margin-right: 0 !important; margin-left: 0 !important;">

        <div class="container-fluid">
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

        @include("layouts.partials/footer")

    </div>

</div>

@include("layouts.partials/footer-scripts")
@vite(['resources/js/app.js','resources/js/layout.js'])

@yield('script-bottom')

</body>

</html>

