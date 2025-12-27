<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="{{ route('admin.dashboard') }}" class="logo-dark">
            <img src="/images/logo.png" class="logo-sm" alt="logo sm">
            <img src="/images/logo.png" class="logo-lg" alt="logo dark">
        </a>

        <a href="{{ route('admin.dashboard') }}" class="logo-light">
            <img src="/images/logo.png" class="logo-sm" alt="logo sm">
            <img src="/images/logo.png" class="logo-lg" alt="logo light">
        </a>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">القائمة الرئيسية</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                         </span>
                    <span class="nav-text"> لوحة التحكم </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:category-bold-duotone"></iconify-icon>
                         </span>
                    <span class="nav-text"> الأقسام </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dishes.index') }}">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:fork-knife-bold-duotone"></iconify-icon>
                         </span>
                    <span class="nav-text"> الأطباق </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings.index') }}">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:settings-bold-duotone"></iconify-icon>
                         </span>
                    <span class="nav-text"> الإعدادات </span>
                </a>
            </li>

            <li class="menu-title mt-2">حساب</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <span class="nav-icon">
                              <iconify-icon icon="solar:logout-2-bold-duotone"></iconify-icon>
                         </span>
                    <span class="nav-text"> تسجيل الخروج </span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</div>
