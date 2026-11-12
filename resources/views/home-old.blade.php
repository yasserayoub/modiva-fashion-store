
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>YF Store | Modern Fashion</title>

    <meta name="description" content="Discover modern fashion and timeless essentials at YF Store.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Homepage CSS -->
    <link rel="stylesheet" href="{{ asset('css/store/home.css') }}">
</head>

<body>

    <!-- Announcement -->
    <div class="announcement-bar">
        FREE SHIPPING ON ORDERS OVER $100
    </div>

    <!-- Header -->
    <header class="store-header">

        <button class="mobile-menu-button"
                id="mobileMenuButton"
                aria-label="Toggle navigation">
            ☰
        </button>

        <a href="{{ route('home') }}" class="store-logo">
            YF
        </a>

        <nav class="store-nav" id="storeNav">
            <a href="{{ route('home') }}">Home</a>
            <a href="#new-arrivals">New Arrivals</a>
            <a href="#categories">Collections</a>
            <a href="#featured">Featured</a>
        </nav>

        <div class="store-header-actions">

            @auth
                <a href="#">{{ Auth::user()->firstname }}</a>

                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST"
                      hidden>
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Account</a>
                <a href="{{ route('register') }}">Join</a>
            @endauth

            <a href="#" aria-label="Shopping bag">Bag (0)</a>

        </div>

    </header>

    <!-- Hero -->
    <section class="hero">

        <img
            class="hero-image"
            src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=2000&q=85"
            alt="YF fashion collection"
        >

        <div class="hero-overlay"></div>

        <div class="hero-content">

            <p class="hero-eyebrow">
                THE NEW COLLECTION — 2026
            </p>

            <h1>
                Style is<br>
                an attitude.
            </h1>

            <p class="hero-description">
                Discover a new perspective on everyday fashion.
                Carefully selected pieces, timeless designs,
                and effortless style.
            </p>

            <a href="#new-arrivals" class="hero-button">
                Discover Collection
            </a>

        </div>

    </section>

    <!-- Categories -->
    <section class="store-section" id="categories">

        <div class="section-heading">
            <h2>Explore Our Collections</h2>
            <p>Find your style. Discover your next favorite piece.</p>
        </div>

        <div class="category-grid">

            <a href="#new-arrivals" class="category-card">
                <img
                    src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=700&q=85"
                    alt="Women's fashion"
                >

                <div class="category-card-content">
                    <h3>Women</h3>
                    <span>Explore Collection</span>
                </div>
            </a>

            <a href="#new-arrivals" class="category-card">
                <img
                    src="https://images.unsplash.com/photo-1516257984-b1b4d707412e?auto=format&fit=crop&w=700&q=85"
                    alt="Men's fashion"
                >

                <div class="category-card-content">
                    <h3>Men</h3>
                    <span>Explore Collection</span>
                </div>
            </a>

            <a href="#new-arrivals" class="category-card">
                <img
                    src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=700&q=85"
                    alt="Fashion accessories"
                >

                <div class="category-card-content">
                    <h3>Accessories</h3>
                    <span>Explore Collection</span>
                </div>
            </a>

            <a href="#new-arrivals" class="category-card">
                <img
                    src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=700&q=85"
                    alt="New season fashion"
                >

                <div class="category-card-content">
                    <h3>New Season</h3>
                    <span>Explore Collection</span>
                </div>
            </a>

        </div>

    </section>

    <!-- New Arrivals -->
    <section class="store-section" id="new-arrivals">

        <div class="section-heading">
            <h2>New Arrivals</h2>
            <p>The latest additions to our collection.</p>
        </div>

        <div class="product-grid">

            <div class="product-card">
                <div class="product-image">
                    <img
                        src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?auto=format&fit=crop&w=700&q=85"
                        alt="Classic white shirt"
                    >
                    <span class="product-badge">New</span>
                </div>

                <div class="product-info">
                    <h3>Classic White Shirt</h3>
                    <span class="product-price">$39.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <img
                        src="https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=700&q=85"
                        alt="Modern denim jeans"
                    >
                    <span class="product-badge">New</span>
                </div>

                <div class="product-info">
                    <h3>Modern Denim Jeans</h3>
                    <span class="product-price">$55.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <img
                        src="https://images.unsplash.com/photo-1618354691229-88d47f285158?auto=format&fit=crop&w=700&q=85"
                        alt="Essential everyday t-shirt"
                    >
                </div>

                <div class="product-info">
                    <h3>Essential T-Shirt</h3>
                    <span class="product-price">$25.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <img
                        src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=700&q=85"
                        alt="Minimal jacket"
                    >
                    <span class="product-badge">Popular</span>
                </div>

                <div class="product-info">
                    <h3>Minimal Jacket</h3>
                    <span class="product-price">$79.00</span>
                </div>
            </div>

        </div>

    </section>

    <!-- Editorial Collection -->
    <section class="editorial-banner" id="featured">

        <img
            class="editorial-image"
            src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1200&q=85"
            alt="Contemporary fashion editorial"
        >

        <div class="editorial-content">

            <span>YF — THE ESSENTIAL COLLECTION</span>

            <h2>
                Less, but<br>
                better.
            </h2>

            <p>
                Build a wardrobe around pieces that make a statement
                without saying too much. Explore timeless essentials
                designed for everyday life.
            </p>

            <a href="#new-arrivals" class="text-link">
                Discover More
            </a>

        </div>

    </section>

    <!-- Newsletter -->
    <section class="newsletter">

        <h2>Stay in the Loop</h2>

        <p>
            Subscribe to receive updates about new collections
            and exclusive offers.
        </p>

        <form class="newsletter-form" action="#" method="POST">

            <input
                type="email"
                placeholder="Enter your email address"
                aria-label="Email address"
                required
            >

            <button type="submit">
                SUBSCRIBE
            </button>

        </form>

    </section>

    <!-- Footer -->
    <footer class="store-footer">

        <div class="footer-grid">

            <div class="footer-brand">
                <h2>YF</h2>

                <p>
                    Modern fashion. Timeless essentials.
                    Discover your style with YF Store.
                </p>
            </div>

            <div class="footer-column">
                <h3>SHOP</h3>
                <a href="#categories">Women</a>
                <a href="#categories">Men</a>
                <a href="#categories">Accessories</a>
                <a href="#new-arrivals">New Arrivals</a>
            </div>

            <div class="footer-column">
                <h3>HELP</h3>
                <a href="#">Contact Us</a>
                <a href="#">Shipping Information</a>
                <a href="#">Returns</a>
                <a href="#">FAQs</a>
            </div>

            <div class="footer-column">
                <h3>ACCOUNT</h3>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
                <a href="#">My Orders</a>
            </div>

        </div>

        <div class="footer-bottom">
            <span>
                © {{ date('Y') }} YF Store. All rights reserved.
            </span>

            <span>
                Designed for modern living.
            </span>
        </div>

    </footer>

    <!-- JavaScript -->
    <script>

        // Mobile navigation
        const menuButton = document.getElementById('mobileMenuButton');
        const storeNav = document.getElementById('storeNav');

        menuButton.addEventListener('click', function () {
            storeNav.classList.toggle('is-open');
        });

        // Close mobile menu after selecting a link
        storeNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function () {
                storeNav.classList.remove('is-open');
            });
        });

        // Header shadow on scroll
        const header = document.querySelector('.store-header');

        window.addEventListener('scroll', function () {
            header.classList.toggle('is-scrolled', window.scrollY > 30);
        });

        // Scroll reveal animation
        const revealElements = document.querySelectorAll(
            '.section-heading, .category-card, .product-card, .editorial-banner, .newsletter'
        );

        revealElements.forEach(element => {
            element.classList.add('reveal');
        });

        const revealObserver = new IntersectionObserver((entries, observer) => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }

            });

        }, {
            threshold: 0.12
        });

        revealElements.forEach(element => {
            revealObserver.observe(element);
        });

        // Back to top button
        const backToTop = document.createElement('button');

        backToTop.className = 'back-to-top';
        backToTop.innerHTML = '↑';
        backToTop.setAttribute('aria-label', 'Back to top');

        document.body.appendChild(backToTop);

        window.addEventListener('scroll', function () {
            backToTop.classList.toggle('is-visible', window.scrollY > 500);
        });

        backToTop.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

    </script>

</body>
</html>
