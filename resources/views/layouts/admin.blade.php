
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel') | Fashion Store</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    <div class="admin-container">

        <!-- Sidebar -->
        <aside class="admin-sidebar">

            <!-- Close Button -->
            <button
                type="button"
                class="sidebar-close"
                id="sidebarClose"
                aria-label="Close sidebar">
                &times;
            </button>

            <!-- Brand -->
            <div class="sidebar-brand">
                <h2>FASHION STORE</h2>
                <span>ADMIN PANEL</span>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">

                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    Dashboard
                </a>

                <div class="nav-section">MANAGEMENT</div>

           <a href="{{ route('admin.products.index') }}" class="nav-link">
    Products
</a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link">
    Categories
</a>
               <a href="{{ route('admin.brands.index') }}" class="nav-link">
    Brands
</a>


<a href="{{ route('admin.sizes.index') }}"
   class="nav-link {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}">
    Sizes
</a>
<a href="{{ route('admin.colors.index') }}"
   class="nav-link {{ request()->routeIs('admin.colors.*') ? 'active' : '' }}">
    Colors
</a>
<a href="{{ route('admin.inventory.index') }}"
   class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
    Inventory
</a>
                <a href="{{ route('admin.orders.index') }}"
   class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
    Orders
</a>
               <a href="{{ route('admin.customers.index') }}"
   class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
    Customers
</a>
                <a href="#" class="nav-link">Reviews</a>
            <a href="{{ route('admin.coupons.index') }}"
   class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
    Coupons
</a>

                <div class="nav-section">SYSTEM</div>

                <a href="#" class="nav-link">Settings</a>

            </nav>

            <!-- Logout -->
            <div class="sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="logout-button">
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        <!-- Sidebar Overlay -->
        <div
            class="sidebar-overlay"
            id="sidebarOverlay">
        </div>

        <!-- Main Content -->
        <main class="admin-main">

            <!-- Header -->
            <header class="admin-header">

                <!-- Hamburger Button -->
                <button
                    type="button"
                    class="menu-toggle"
                    id="menuToggle"
                    aria-label="Open sidebar">
                    ☰
                </button>

                <div class="header-title">
                    <h3>@yield('page-heading', 'Dashboard')</h3>
                    <p>Welcome to your administration panel.</p>
                </div>

                <!-- Admin Profile -->
                <div class="admin-profile">

                    <span>{{ Auth::user()->firstname }}</span>

                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                    </div>

                </div>

            </header>

            <!-- Page Content -->
            <section class="admin-content">
                @yield('content')
            </section>

        </main>

    </div>

    <!-- Sidebar JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const adminContainer = document.querySelector('.admin-container');
            const menuToggle = document.getElementById('menuToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebarClose = document.getElementById('sidebarClose');

            function openSidebar() {
                adminContainer.classList.add('sidebar-open');
            }

            function closeSidebar() {
                adminContainer.classList.remove('sidebar-open');
            }

            // Open sidebar
            menuToggle.addEventListener('click', openSidebar);

            // Close sidebar using X
            sidebarClose.addEventListener('click', closeSidebar);

            // Close sidebar by clicking outside
            sidebarOverlay.addEventListener('click', closeSidebar);

            // Close sidebar using Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            // Close sidebar after selecting a navigation link on mobile
            document.querySelectorAll('.sidebar-nav .nav-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });

        });
    </script>

</body>
</html>
