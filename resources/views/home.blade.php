
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Discover fashion at Modiva.">
    <title>Modiva — Wear Your Identity</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/store/home.css') }}">
</head>

<body>

    @if (session('order_success'))
        <div style="background:#d1fae5;color:#065f46;padding:15px 20px;margin:15px auto;max-width:900px;border-radius:10px;text-align:center;">
            {{ session('order_success') }}
        </div>
    @endif

    <div class="progress" id="progress"></div>
    <div class="cursor" id="cursor"></div>

    <div class="announcement-bar">
        <div class="ticker">
            <span>Free shipping over $100 ✦ New styles arriving ✦ Free returns for 30 days ✦ Free shipping over $100 ✦ New styles arriving ✦ Free returns for 30 days ✦</span>
        </div>
    </div>

    <header class="site-header" id="siteHeader">
        <button class="menu-toggle" id="menuToggle" aria-label="Open navigation">
            <span></span><span></span>
        </button>

        <a href="{{ route('home') }}" class="logo">Modiva<i>.</i></a>

        <nav class="main-nav" id="mainNav">
            <a href="#shop">Shop all</a>
            <a href="#new-arrivals">New arrivals</a>
            <a href="#collections">Collections</a>
            <a href="#about">Our story</a>
        </nav>

        <div class="header-actions">
            @auth
                <a href="{{ route('home') }}" class="account-link">
                    {{ Auth::user()->firstname }}
                </a>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="account-link">Login</a>
            @endauth

            <a href="#" class="bag-link" data-open="cart">
                Bag <span id="bagCount">0</span>
            </a>
        </div>
    </header>

    <main>

        {{-- HERO --}}
        <section class="hero" id="hero">
            <div class="blob b1"></div>
            <div class="blob b2"></div>
            <div class="blob b3"></div>

            <div class="hero-content">
                <p class="hero-eyebrow">The 2026 collection is here</p>

                <h1 class="hero-title" aria-label="Wear your identity.">
                    <span class="line"><em>Wear</em></span>
                    <span class="line"><em class="grad">your</em></span>
                    <span class="line"><em>identity.</em></span>
                </h1>

                <p class="hero-description">
                    Everyday essentials, made loud. Designed for people who set their own style.
                </p>

                <a href="#shop" class="hero-cta magnetic">
                    <b>Shop the collection</b><span>↗</span>
                </a>
            </div>

            <div class="hero-stack" aria-hidden="true">
                <img class="float f1" data-depth="30" src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=800&q=85" alt="">
                <img class="float f2" data-depth="-20" src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=700&q=85" alt="">
                <img class="float f3" data-depth="45" src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=600&q=85" alt="">
                <div class="sticker">NEW<br>DROP</div>
            </div>
        </section>

        <div class="marquee" aria-hidden="true">
            <div class="marquee-track">
                <span>Be loud ✺ Be you ✺ Wear your identity ✺ Be loud ✺ Be you ✺</span>
                <span>Be loud ✺ Be you ✺ Wear your identity ✺ Be loud ✺ Be you ✺</span>
            </div>
        </div>

        {{-- ABOUT --}}
        <section class="intro-section" id="about">
            <h2 class="intro-title" data-split>
                Style isn't about following. It's about becoming.
            </h2>

            <div class="stats">
                <div class="reveal">
                    <strong data-count="6">0</strong>
                    <span>fashion categories</span>
                </div>
                <div class="reveal">
                    <strong data-count="100">0</strong>
                    <span>ways to express yourself</span>
                </div>
                <div class="reveal">
                    <strong data-count="1">0</strong>
                    <span>unique identity</span>
                </div>
            </div>
        </section>

        {{-- COLLECTIONS --}}
        <section class="collections-section" id="collections">
            <div class="section-header reveal">
                <h2>Find your collection.</h2>
                <p>Explore our categories</p>
            </div>

            <div class="collection-grid">
                <a href="#shop" data-cat="T-Shirts" class="collection-card active reveal" style="--c:#5b2bff">
                    <img src="https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=1200&q=85" alt="T-Shirts">
                    <div class="collection-info">
                        <h3>T-Shirts</h3>
                        <span class="collection-arrow">↗</span>
                    </div>
                </a>

                <a href="#shop" data-cat="Jeans" class="collection-card reveal" style="--c:#ff6a3d">
                    <img src="https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=1000&q=85" alt="Jeans">
                    <div class="collection-info">
                        <h3>Jeans</h3>
                        <span class="collection-arrow">↗</span>
                    </div>
                </a>

                <a href="#shop" data-cat="Jackets" class="collection-card reveal" style="--c:#ffb800">
                    <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=1000&q=85" alt="Jackets">
                    <div class="collection-info">
                        <h3>Jackets</h3>
                        <span class="collection-arrow">↗</span>
                    </div>
                </a>

                <a href="#shop" data-cat="Sneakers" class="collection-card reveal" style="--c:#00a6a6">
                    <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=1000&q=85" alt="Sneakers">
                    <div class="collection-info">
                        <h3>Sneakers</h3>
                        <span class="collection-arrow">↗</span>
                    </div>
                </a>
            </div>
        </section>

        {{-- SHOP ALL --}}
        @php
            $productCategories = collect($storeProducts)
                ->pluck('cat')
                ->filter()
                ->unique()
                ->sort()
                ->values();

            $productBrands = collect($storeProducts)
                ->pluck('brand')
                ->filter()
                ->unique()
                ->sort()
                ->values();

            $productGenders = collect($storeProducts)
                ->pluck('gender')
                ->filter()
                ->unique()
                ->sort()
                ->values();
        @endphp

        <section class="shop-section" id="shop">

            <div class="section-header reveal">
                <h2>Shop all.</h2>
                <p id="resultCount"></p>
            </div>

            {{-- SEARCH AND FILTER CONTROLS --}}
            <div class="shop-tools">

                <input
                    type="search"
                    id="fSearch"
                    placeholder="Search products…"
                    aria-label="Search products"
                >

                {{-- DYNAMIC BRANDS --}}
                <select id="fBrand" aria-label="Filter by brand">
                    <option value="">All brands</option>

                    @foreach($productBrands as $brand)
                        <option value="{{ $brand }}">
                            {{ $brand }}
                        </option>
                    @endforeach
                </select>

                {{-- PRICE --}}
                <select id="fPrice" aria-label="Filter by price">
                    <option value="">Any price</option>
                    <option value="0-30">Under $30</option>
                    <option value="30-60">$30 – $60</option>
                    <option value="60-100">$60 – $100</option>
                    <option value="100-999999">$100 and up</option>
                </select>

                {{-- SORTING --}}
                <select id="fSort" aria-label="Sort products">
                    <option value="new">Newest</option>
                    <option value="asc">Price: low to high</option>
                    <option value="desc">Price: high to low</option>
                    <option value="pop">Most popular</option>
                </select>

            </div>

            {{-- DYNAMIC CATEGORY AND GENDER FILTERS --}}
            <div class="chips" id="chips">

                {{-- ALL CATEGORIES --}}
                <button
                    type="button"
                    class="chip on"
                    data-k="cat"
                    data-v=""
                >
                    All
                </button>

                {{-- CATEGORIES ACTUALLY USED BY PRODUCTS --}}
                @foreach($productCategories as $category)
                    <button
                        type="button"
                        class="chip"
                        data-k="cat"
                        data-v="{{ $category }}"
                    >
                        {{ $category }}
                    </button>
                @endforeach

                <span class="sep"></span>

                {{-- ALL GENDERS --}}
                <button
                    type="button"
                    class="chip on"
                    data-k="gender"
                    data-v=""
                >
                    Everyone
                </button>

                {{-- GENDERS ACTUALLY USED BY PRODUCTS --}}
                @foreach($productGenders as $gender)
                    <button
                        type="button"
                        class="chip"
                        data-k="gender"
                        data-v="{{ $gender }}"
                    >
                        {{ $gender }}
                    </button>
                @endforeach

            </div>

            {{-- PRODUCTS --}}
            <div class="shop-grid" id="shopGrid"></div>

            {{-- PAGINATION --}}
            <nav class="pager" id="pager" aria-label="Pagination"></nav>

        </section>

        {{-- EDITORIAL --}}
        <section class="editorial-section">
            <div class="editorial-image reveal">
                <img data-parallax src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1800&q=90" alt="Modiva fashion editorial">
            </div>

            <div class="editorial-content reveal">
                <h2>Less noise.<br><em class="grad">More meaning.</em></h2>
                <p>We make pieces that speak without shouting. Thoughtful design, timeless attitude, and confidence in every detail.</p>
                <a href="#shop" class="dark-cta magnetic">
                    <b>Discover Modiva</b><span>↗</span>
                </a>
            </div>
        </section>

        {{-- NEWSLETTER --}}
        <section class="newsletter-section reveal">
            <h2>Something good<br>is always coming.</h2>
            <p>Join the list and get first access to every drop.</p>

            <form class="newsletter-form" action="#" method="POST">
                <input type="email" placeholder="Your email address" aria-label="Your email address" required>
                <button type="submit">Subscribe ↗</button>
            </form>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-top">
            <a href="{{ route('home') }}" class="footer-logo">Modiva<i>.</i></a>
            <p>Wear your identity.</p>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} Modiva Store. All rights reserved.</span>
            <div>
                <a href="#">Instagram</a>
                <a href="#">Contact</a>
                <a href="#">Privacy</a>
            </div>
        </div>
    </footer>

    {{-- OVERLAYS --}}
    <div class="overlay" id="overlay"></div>

    {{-- PRODUCT DETAILS --}}
    <div class="panel modal" id="product" role="dialog" aria-modal="true" aria-label="Product details">
        <button class="x" data-close aria-label="Close">✕</button>

        <div class="pd">
            <div>
                <div class="pd-main">
                    <img id="pdImg" src="" alt="">
                </div>
                <div class="thumbs" id="pdThumbs"></div>
            </div>

            <div class="pd-info">
                <span class="product-tag" id="pdCat" style="position:static;display:inline-block"></span>
                <h2 id="pdName"></h2>
                <div class="pd-price" id="pdPrice"></div>
                <p class="pd-desc" id="pdDesc"></p>

                <div class="opt-label">Size</div>
                <div class="opts" id="pdSizes"></div>

                <div class="opt-label">Color</div>
                <div class="opts" id="pdColors"></div>

                <div class="opt-label">Quantity</div>
                <div class="qty">
                    <button type="button" id="pdMinus" aria-label="Less">−</button>
                    <span id="pdQty">1</span>
                    <button type="button" id="pdPlus" aria-label="More">+</button>
                </div>

                <div class="pd-actions">
                    <button class="btn grad-bg" id="pdAdd" type="button">Add to cart</button>
                </div>

                <div class="hint" id="pdHint"></div>
            </div>
        </div>
    </div>

    {{-- CART --}}
    <aside class="panel drawer" id="cart" aria-label="Shopping cart">
        <button class="x" data-close aria-label="Close">✕</button>
        <h2>Your bag</h2>

        <div class="free-note" id="freeNote"></div>
        <div class="cart-items" id="cartItems"></div>

        {{-- PROMO CODE --}}
        <div class="promo-section">
            <div class="sec-t">Have a promo code?</div>

            <div class="promo-input">
                <input
                    type="text"
                    class="f-input"
                    id="promoCode"
                    placeholder="Enter promo code"
                >

                <button class="btn" type="button" id="applyPromo">
                    Apply
                </button>
            </div>

            <p id="promoMessage" class="promo-message"></p>
        </div>

        {{-- CART TOTALS --}}
        <div class="sum">
            <div>
                <span>Subtotal</span>
                <span id="cSub">$0.00</span>
            </div>

            <div>
                <span>Shipping</span>
                <span id="cShip">$0.00</span>
            </div>

            <div id="discountRow" style="display:none;">
                <span>Discount</span>
                <span id="cDiscount">-$0.00</span>
            </div>

            <div class="total">
                <span>Total</span>
                <span id="cTotal">$0.00</span>
            </div>
        </div>

        <button class="btn grad-bg full" id="toCheckout" type="button">
            Checkout
        </button>
    </aside>

    {{-- CHECKOUT --}}
    <div class="panel modal" id="checkout" role="dialog" aria-modal="true" aria-label="Checkout">
        <button class="x" data-close aria-label="Close">✕</button>

        <div id="checkoutForm">
            <h2>Checkout</h2>

            <form id="coForm" action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="sec-t">Customer information</div>

                <div class="form-grid">
                    <input class="f-input" name="firstname" placeholder="First name" required>
                    <input class="f-input" name="lastname" placeholder="Last name" required>
                    <input class="f-input" type="email" name="email" placeholder="Email">
                    <input class="f-input" type="tel" name="phone" placeholder="Phone" required>
                </div>

                <div class="sec-t">Shipping address</div>

                <div class="form-grid">
                    <input class="f-input wide" name="streetaddress" placeholder="Street address" required>
                    <input class="f-input" name="city" placeholder="City" required>
                    <input class="f-input" name="postalcode" placeholder="Postal code">
                    <input class="f-input wide" name="country" value="Lebanon" placeholder="Country" required>
                </div>

                <div class="sec-t">Delivery</div>

                <div class="pick" data-ship>
                    <label>
                        <span>
                            <input type="radio" name="deliverymethod" value="standard" checked>
                            Standard · 3–5 days
                        </span>
                        <b>Free</b>
                    </label>

                    <label>
                        <span>
                            <input type="radio" name="deliverymethod" value="express">
                            Express · 1–2 days
                        </span>
                        <b>$9.00</b>
                    </label>
                </div>

                <div class="sec-t">Payment</div>

                <div class="pick">
                    <label>
                        <span>
                            <input type="radio" name="paymentmethod" value="cash_on_delivery" checked>
                            Cash on delivery
                        </span>
                    </label>
                </div>

                <div class="sum">
                    <div class="total">
                        <span>Total</span>
                        <span id="coTotal">$0.00</span>
                    </div>
                </div>

                <button class="btn grad-bg full" type="submit">
                    Place order
                </button>
            </form>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    {{-- Keep your existing external JavaScript include here --}}
</body>
</html>


<script>
(() => {
    const $ = (s, c = document) => [...c.querySelectorAll(s)];
    const el = id => document.getElementById(id);
    const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
    const fine = matchMedia('(hover:hover)').matches;
    const money = n => '$' + Number(n || 0).toFixed(2);
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    /* ===== DATA FROM LARAVEL ===== */
    const PRODUCTS = @json($storeProducts);
    const CART_ADD_URL = @json(route('cart.add'));
    const CART_UPDATE_URL = @json(route('cart.update'));
    const CART_REMOVE_URL = @json(route('cart.remove'));
    const CART_GET_URL = @json(route('cart.get'));
    const CART_APPLY_COUPON_URL = @json(route('cart.applyCoupon'));

    const byId = id => PRODUCTS.find(p => String(p.id) === String(id));
    const variantOf = (p, vid) => p?.variants?.find(v => String(v.id) === String(vid));
    const price = p => Number(p?.sale ?? p?.price ?? 0);
    const thumb = p => p?.imgs?.[0] || p?.mainImage || '';

    /* ===== SERVER CART REQUESTS ===== */
    const csrfToken = () =>
        document.querySelector('meta[name="csrf-token"]')?.content ||
        el('coForm')?.querySelector('input[name="_token"]')?.value || '';

    async function cartRequest(url, method, data) {
        const res = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
            body: JSON.stringify(data)
        });
        let body = {};
        try { body = await res.json(); } catch (_) { /* server sent HTML (419/500) */ }
        if (!res.ok) throw new Error(body.message || (res.status === 419 ? 'Session expired. Refresh the page.' : 'The cart could not be updated.'));
        return body;
    }

    /* ===== STATE ===== */
    const S = { cat: '', gender: '', page: 1, per: 6 };
  let cart = [];
let appliedDiscount = 0;
let wish = new Set();
    let cur = null;
    let sel = { sizeId: null, colorId: null, variant: null, qty: 1 };

    async function loadCart() {
        try {
            const res = await fetch(CART_GET_URL, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Could not load cart.');
            const data = await res.json();

            cart = (data.items || []).map(item => {
                const product = PRODUCTS.find(p => p.variants?.some(v => String(v.id) === String(item.variant_id)));
                const variant = variantOf(product, item.variant_id);
                if (!product || !variant) return null;
                return { id: product.id, variantId: variant.id, size: variant.size, color: variant.color, qty: Number(item.quantity) };
            }).filter(Boolean);

            renderCart();
            syncBag(false);
        } catch (err) {
            console.error('Cart loading error:', err);
        }
    }

    /* ===== SHOP ===== */
    function renderShop() {
        const q = el('fSearch').value.trim().toLowerCase();
        const brand = el('fBrand').value;
        const pr = el('fPrice').value;
        const sort = el('fSort').value;

        const list = PRODUCTS.filter(p =>
            (!q || String(p.name).toLowerCase().includes(q)) &&
            (!S.cat || p.cat === S.cat) &&
            (!S.gender || p.gender === S.gender) &&
            (!brand || p.brand === brand) &&
            (!pr || (price(p) >= Number(pr.split('-')[0]) && price(p) <= Number(pr.split('-')[1])))
        );

        if (sort === 'asc')  list.sort((a, b) => price(a) - price(b));
        if (sort === 'desc') list.sort((a, b) => price(b) - price(a));
        if (sort === 'pop')  list.sort((a, b) => (b.pop || 0) - (a.pop || 0));
        if (sort === 'new')  list.sort((a, b) => b.id - a.id);

        const pages = Math.max(1, Math.ceil(list.length / S.per));
        S.page = Math.min(S.page, pages);
        const slice = list.slice((S.page - 1) * S.per, S.page * S.per);

        el('resultCount').textContent = `${list.length} ${list.length === 1 ? 'product' : 'products'}`;

        el('shopGrid').innerHTML = slice.length ? slice.map((p, i) => `
            <article class="product-card tilt is-visible" data-id="${esc(p.id)}" style="animation-delay:${i * 60}ms">
                <div class="product-image">
                    ${p.sale ? '<span class="product-tag hot">Sale</span>' : ''}
                    <button class="wish ${wish.has(String(p.id)) ? 'on' : ''}" data-wish="${esc(p.id)}" aria-label="Add to wishlist">♥</button>
                    <img src="${esc(thumb(p))}" alt="${esc(p.name)}" loading="lazy">
                    <button class="quick-add" type="button">View details +</button>
                </div>
                <div class="product-info">
                    <div><h3>${esc(p.name)}</h3><p>${esc(p.cat)} · ${esc(p.brand)}</p></div>
                    <span>${p.sale ? `<s style="color:var(--mute);font-size:12px">${money(p.price)}</s> ` : ''}${money(price(p))}</span>
                </div>
            </article>`).join('')
            : '<div class="empty"><h3>Nothing matches yet.</h3><p>Try removing a filter.</p></div>';

        el('pager').innerHTML = pages < 2 ? '' :
            `<button ${S.page === 1 ? 'disabled' : ''} data-p="${S.page - 1}">←</button>` +
            Array.from({ length: pages }, (_, i) => `<button class="${i + 1 === S.page ? 'on' : ''}" data-p="${i + 1}">${i + 1}</button>`).join('') +
            `<button ${S.page === pages ? 'disabled' : ''} data-p="${S.page + 1}">→</button>`;

        bindTilt();
    }

    el('chips').addEventListener('click', e => {
        const b = e.target.closest('.chip'); if (!b) return;
        S[b.dataset.k] = b.dataset.v; S.page = 1;
        $(`.chip[data-k="${b.dataset.k}"]`).forEach(c => c.classList.toggle('on', c === b));
        renderShop();
    });
    ['fSearch', 'fBrand', 'fPrice', 'fSort'].forEach(id => el(id).addEventListener('input', () => { S.page = 1; renderShop(); }));
    el('pager').addEventListener('click', e => {
        const b = e.target.closest('button'); if (!b || b.disabled) return;
        S.page = Number(b.dataset.p); renderShop(); el('shop').scrollIntoView({ behavior: 'smooth' });
    });
    $('.collection-card').forEach(c => c.addEventListener('click', () => {
        S.cat = c.dataset.cat; S.page = 1;
        $('.chip[data-k="cat"]').forEach(x => x.classList.toggle('on', x.dataset.v === S.cat));
        renderShop();
    }));
    el('shopGrid').addEventListener('click', e => {
        const w = e.target.closest('.wish');
        if (w) { e.stopPropagation(); toggleWish(w.dataset.wish); return; }
        const card = e.target.closest('.product-card');
        if (card) openProduct(card.dataset.id);
    });

    /* ===== OVERLAYS ===== */
    function open(id) {
        $('.panel.open').forEach(p => p.classList.remove('open'));
        el(id).classList.add('open'); el('overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
        if (id === 'cart') renderCart();
    }
    function closeAll() {
        $('.panel.open').forEach(p => p.classList.remove('open'));
        el('overlay').classList.remove('open'); document.body.style.overflow = '';
    }
    el('overlay').addEventListener('click', closeAll);
    $('[data-close]').forEach(b => b.addEventListener('click', closeAll));
    addEventListener('keydown', e => { if (e.key === 'Escape') closeAll(); });
    $('[data-open]').forEach(b => b.addEventListener('click', e => {
        if (!el(b.dataset.open)) return; /* panel not on this page: let the link work normally */
        e.preventDefault(); open(b.dataset.open);
    }));

    function toast(msg) {
        const t = el('toast'); t.textContent = msg; t.classList.add('show');
        clearTimeout(t._t); t._t = setTimeout(() => t.classList.remove('show'), 2200);
    }

    /* ===== PRODUCT DETAILS ===== */
    function openProduct(id) {
        cur = byId(id); if (!cur) return;
        sel = { sizeId: null, colorId: null, variant: null, qty: 1 };

        el('pdCat').textContent = cur.cat;
        el('pdName').textContent = cur.name;
        el('pdDesc').textContent = cur.desc || '';

        const images = cur.imgs || [];
        const showImage = src => {
            el('pdImg').src = src; el('pdImg').alt = cur.name;
            $('#pdThumbs img').forEach(img => img.classList.toggle('on', img.dataset.k === src));
        };
        el('pdThumbs').innerHTML = images.map(src => `<img data-k="${esc(src)}" src="${esc(src)}" alt="">`).join('');
        el('pdThumbs').onclick = e => { if (e.target.dataset.k) showImage(e.target.dataset.k); };
        images.length ? showImage(images[0]) : el('pdImg').removeAttribute('src');

        el('pdQty').textContent = 1;
        renderVariantOptions();
        open('product');
    }

    function renderVariantOptions() {
        const variants = cur.variants || [];
        const same = (a, b) => String(a) === String(b);

        const sizes = [...new Map(variants.filter(v => v.sizeId != null)
            .map(v => [String(v.sizeId), { id: v.sizeId, name: v.size, order: Number(v.sizeOrder || 0) }])).values()]
            .sort((a, b) => a.order - b.order);

        const colors = [...new Map(variants.filter(v => v.colorId != null)
            .map(v => [String(v.colorId), { id: v.colorId, name: v.color, hex: v.hexcode || '#cccccc' }])).values()];

        el('pdSizes').innerHTML = sizes.map(s => {
            const ok = variants.some(v => same(v.sizeId, s.id) && (sel.colorId === null || same(v.colorId, sel.colorId)) && Number(v.stock) > 0);
            return `<button type="button" class="size ${same(sel.sizeId, s.id) ? 'on' : ''}" data-size-id="${esc(s.id)}" ${ok ? '' : 'disabled'} style="${ok ? '' : 'opacity:.35;cursor:not-allowed'}">${esc(s.name)}</button>`;
        }).join('');

        el('pdColors').innerHTML = colors.map(c => {
            const ok = variants.some(v => same(v.colorId, c.id) && (sel.sizeId === null || same(v.sizeId, sel.sizeId)) && Number(v.stock) > 0);
            return `<button type="button" class="swatch ${same(sel.colorId, c.id) ? 'on' : ''}" data-color-id="${esc(c.id)}" title="${esc(c.name)}" aria-label="${esc(c.name)}" ${ok ? '' : 'disabled'} style="background:${esc(c.hex)};${ok ? '' : 'opacity:.3;cursor:not-allowed'}"></button>`;
        }).join('');

        sel.variant = variants.find(v => same(v.sizeId, sel.sizeId) && same(v.colorId, sel.colorId)) || null;
        el('pdPrice').textContent = money(sel.variant?.price != null ? sel.variant.price : price(cur));

        el('pdHint').textContent = !variants.length ? 'No variants available for this product.'
            : sel.variant ? (Number(sel.variant.stock) > 0 ? `${sel.variant.stock} available` : 'Out of stock')
            : 'Choose a size and color.';
    }

    el('pdSizes').addEventListener('click', e => {
        const b = e.target.closest('[data-size-id]'); if (!b || b.disabled) return;
        sel.sizeId = b.dataset.sizeId;
        const ok = (cur.variants || []).some(v => String(v.sizeId) === String(sel.sizeId) && String(v.colorId) === String(sel.colorId) && Number(v.stock) > 0);
        if (!ok) sel.colorId = null;
        sel.qty = 1; el('pdQty').textContent = 1;
        renderVariantOptions();
    });
    el('pdColors').addEventListener('click', e => {
        const b = e.target.closest('[data-color-id]'); if (!b || b.disabled) return;
        sel.colorId = b.dataset.colorId;
        const ok = (cur.variants || []).some(v => String(v.colorId) === String(sel.colorId) && String(v.sizeId) === String(sel.sizeId) && Number(v.stock) > 0);
        if (!ok) sel.sizeId = null;
        sel.qty = 1; el('pdQty').textContent = 1;
        renderVariantOptions();
    });

    el('pdMinus').onclick = () => { sel.qty = Math.max(1, sel.qty - 1); el('pdQty').textContent = sel.qty; };
    el('pdPlus').onclick = () => {
        const max = sel.variant ? Number(sel.variant.stock) : 10;
        sel.qty = Math.max(1, Math.min(10, max, sel.qty + 1)); el('pdQty').textContent = sel.qty;
    };

    /* ===== ADD TO CART (Laravel session) ===== */
    let busy = false;
    el('pdAdd').onclick = async () => {
        if (busy) return;
        if (!sel.variant) { el('pdHint').textContent = 'Please select an available size and color.'; return; }
        if (Number(sel.variant.stock) < sel.qty) { el('pdHint').textContent = 'Not enough stock available.'; return; }

        const inBag = cart.find(i => String(i.variantId) === String(sel.variant.id))?.qty || 0;
        if (inBag + sel.qty > Number(sel.variant.stock)) { el('pdHint').textContent = 'You cannot add more than the available stock.'; return; }

        busy = true;
        try {
            const result = await cartRequest(CART_ADD_URL, 'POST', { variant_id: sel.variant.id, quantity: sel.qty });
            const hit = cart.find(i => String(i.variantId) === String(sel.variant.id));
            hit ? hit.qty += sel.qty
                : cart.push({ id: cur.id, variantId: sel.variant.id, size: sel.variant.size, color: sel.variant.color, qty: sel.qty });
            syncBag(); toast(result.message || 'Added to your bag ✓'); open('cart');
        } catch (err) {
            el('pdHint').textContent = err.message;
        } finally { busy = false; }
    };

    /* ===== CART ===== */
    const itemPrice = item => {
        const p = byId(item.id), v = variantOf(p, item.variantId);
        return v?.price != null ? Number(v.price) : price(p);
    };
   const totals = () => {
    const sub = cart.reduce((s, i) => s + itemPrice(i) * i.qty, 0);
    return { sub, ship: 0 };
};
    function syncBag(animate = true) {
        const c = el('bagCount');
        c.textContent = cart.reduce((s, i) => s + i.qty, 0);
        if (animate) { c.classList.remove('pop'); void c.offsetWidth; c.classList.add('pop'); }
    }
    function renderCart() {
        const { sub, ship } = totals();
        el('cartItems').innerHTML = cart.length ? cart.map((item, idx) => {
            const p = byId(item.id); if (!p) return '';
            const pr = itemPrice(item);
            return `<div class="ci">
                <img src="${esc(thumb(p))}" alt="">
                <div>
                    <h4>${esc(p.name)}</h4>
                    <small>${esc(item.size)} · ${esc(item.color)} · ${money(pr)}</small>
                    <div class="qty"><button data-q="${idx}" data-d="-1">−</button><span>${item.qty}</span><button data-q="${idx}" data-d="1">+</button></div>
                    <button class="rm" data-rm="${idx}">Remove</button>
                </div>
                <b>${money(pr * item.qty)}</b>
            </div>`;
        }).join('') : '<div class="empty" style="padding:50px 0"><h3 style="font-size:28px">Your bag is empty.</h3><p>Find something you love.</p></div>';

       const discount = Number(appliedDiscount || 0);

el('cSub').textContent = money(sub);
el('cShip').textContent = ship ? money(ship) : 'Free';

el('discountRow').style.display = discount > 0 ? 'flex' : 'none';
el('cDiscount').textContent = '-' + money(discount);

el('cTotal').textContent = money(sub + ship - discount);
        el('freeNote').textContent = sub >= 100 ? '🎉 You get free shipping!' : `Add ${money(100 - sub)} more for free shipping`;
    }
    // Apply promo code
el('applyPromo').addEventListener('click', async () => {
    const code = el('promoCode').value.trim();
    const message = el('promoMessage');
    const button = el('applyPromo');

    if (!code) {
        message.textContent = 'Please enter a promo code.';
        message.style.color = '#dc2626';
        return;
    }

    button.disabled = true;
    button.textContent = 'Applying...';

    try {
        const result = await cartRequest(
            CART_APPLY_COUPON_URL,
            'POST',
            { code }
        );

      appliedDiscount = Number(result.discount || 0);

message.textContent =
    `${result.message} You saved ${money(appliedDiscount)}!`;

message.style.color = '#16a34a';

renderCart();

    } catch (error) {
        message.textContent = error.message;
        message.style.color = '#dc2626';

    } finally {
        button.disabled = false;
        button.textContent = 'Apply';
    }
});

    el('cartItems').addEventListener('click', async e => {
        const q = e.target.closest('[data-q]'), r = e.target.closest('[data-rm]');
        if (!q && !r || busy) return;
        const index = Number((q || r).dataset[q ? 'q' : 'rm']);
        const item = cart[index]; if (!item) return;

        busy = true;
        try {
            if (q) {
                const next = item.qty + Number(q.dataset.d);
                if (next < 1) return;
                const stock = Number(variantOf(byId(item.id), item.variantId)?.stock || 0);
                if (next > stock) { toast('Not enough stock available.'); return; }
                await cartRequest(CART_UPDATE_URL, 'PATCH', { variant_id: item.variantId, quantity: next });
                item.qty = next;
            } else {
                await cartRequest(CART_REMOVE_URL, 'DELETE', { variant_id: item.variantId });
                cart.splice(index, 1);
            }
            renderCart(); syncBag();
        } catch (err) {
            toast(err.message);
        } finally { busy = false; }
    });

    /* ===== CHECKOUT (demo) ===== */
    function updateCo() {
        const { sub, ship } = totals();
        const d = document.querySelector('[name=deliverymethod]:checked')?.value === 'express' ? 9 : 0;
        el('coTotal').textContent = money(sub + ship + d);
    }
    el('toCheckout').onclick = () => {
        if (!cart.length) return toast('Your bag is empty');
        updateCo(); open('checkout');
    };
    $('[name=deliverymethod]').forEach(r => r.addEventListener('change', updateCo));
    /* Checkout form now posts normally to route('checkout.store'). */

    /* ===== ACCOUNT (demo) ===== */
    el('acTabs')?.addEventListener('click', e => {
        const b = e.target.closest('.chip'); if (!b) return;
        $('#acTabs .chip').forEach(c => c.classList.toggle('on', c === b));
        $('.tabpane').forEach(p => p.classList.toggle('on', p.id === 'tab-' + b.dataset.tab));
    });
    $('#account form').forEach(f => f.addEventListener('submit', e => { e.preventDefault(); toast('Saved (demo)'); }));

    /* ===== WISHLIST ===== */
    const emptyWish = '<p style="color:var(--mute)">No saved items yet. Tap ♥ on a product.</p>';
    function toggleWish(id) {
        id = String(id);
        wish.has(id) ? wish.delete(id) : wish.add(id);
        $(`[data-wish="${id}"]`).forEach(b => b.classList.toggle('on', wish.has(id)));
        if (el('wishList')) el('wishList').innerHTML = wish.size ? [...wish].map(i => {
            const p = byId(i); if (!p) return '';
            return `<div class="order"><div>${esc(p.name)}<small>${money(price(p))}</small></div></div>`;
        }).join('') : emptyWish;
        toast(wish.has(id) ? 'Saved to your wishlist ♥' : 'Removed from wishlist');
    }
    if (el('wishList')) el('wishList').innerHTML = emptyWish;

    /* ===== PAGE EFFECTS ===== */
    const header = el('siteHeader'), bar = el('progress'), parallax = $('[data-parallax]');
    const onScroll = () => {
        const y = scrollY, max = document.documentElement.scrollHeight - innerHeight;
        header.classList.toggle('is-scrolled', y > 40);
        bar.style.transform = `scaleX(${max > 0 ? y / max : 0})`;
        if (!reduce) parallax.forEach(img => {
            const r = img.parentElement.getBoundingClientRect();
            img.style.transform = `translateY(${(r.top - innerHeight / 2) * -0.08}px)`;
        });
    };
    addEventListener('scroll', onScroll, { passive: true }); onScroll();

    const nav = el('mainNav');
    el('menuToggle').addEventListener('click', () => nav.classList.toggle('is-open'));
    $('a', nav).forEach(a => a.addEventListener('click', () => nav.classList.remove('is-open')));

    const io = new IntersectionObserver(es => es.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
    }), { threshold: .15 });
    $('.reveal').forEach(x => io.observe(x));

    $('[data-split]').forEach(h => {
        h.innerHTML = h.textContent.trim().split(/\s+/).map(w => `<span class="w">${w}</span>`).join(' ');
        const words = $('.w', h);
        const paint = () => {
            const r = h.getBoundingClientRect();
            const p = Math.min(1, Math.max(0, (innerHeight * .85 - r.top) / (r.height + innerHeight * .3)));
            words.forEach((w, i) => w.classList.toggle('on', i / words.length < p));
        };
        addEventListener('scroll', paint, { passive: true }); paint();
    });

    const cio = new IntersectionObserver(es => es.forEach(e => {
        if (!e.isIntersecting) return;
        const t = e.target, end = Number(t.dataset.count), t0 = performance.now();
        const tick = n => {
            const p = Math.min(1, (n - t0) / 1600);
            t.textContent = Math.round(end * (1 - Math.pow(1 - p, 4)));
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick); cio.unobserve(t);
    }), { threshold: .6 });
    $('[data-count]').forEach(x => cio.observe(x));

    const cards = $('.collection-card');
    cards.forEach(c => ['mouseenter', 'focus'].forEach(ev =>
        c.addEventListener(ev, () => cards.forEach(x => x.classList.toggle('active', x === c)))));

    function bindTilt() {
        if (reduce || !fine) return;
        $('.tilt').forEach(card => {
            if (card._t) return; card._t = 1;
            card.addEventListener('mousemove', e => {
                if (!card.classList.contains('is-visible')) return;
                const r = card.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
                card.style.transform = `perspective(900px) rotateY(${x * 8}deg) rotateX(${-y * 8}deg) translateY(-6px)`;
            });
            card.addEventListener('mouseleave', () => card.style.transform = '');
        });
    }

    /* ===== INITIALIZE ===== */
    renderShop();
    loadCart();

    /* ===== CURSOR, HERO + MAGNETIC EFFECTS ===== */
    if (!reduce && fine) {
        const cr = el('cursor');
        let cx = 0, cy = 0, tx = 0, ty = 0;
        addEventListener('mousemove', e => { tx = e.clientX; ty = e.clientY; cr.style.opacity = 1; });
        (function loop() { cx += (tx - cx) * .18; cy += (ty - cy) * .18; cr.style.transform = `translate(${cx}px,${cy}px)`; requestAnimationFrame(loop); })();
        document.addEventListener('mouseover', e => cr.classList.toggle('big', !!e.target.closest('a,button')));

        const floats = $('.float');
        el('hero')?.addEventListener('mousemove', e => {
            const x = e.clientX / innerWidth - .5, y = e.clientY / innerHeight - .5;
            floats.forEach(f => { const d = Number(f.dataset.depth); f.style.transform = `translate(${x * d}px,${y * d}px) rotate(${x * d / 6}deg)`; });
        });
        $('.magnetic').forEach(m => {
            m.addEventListener('mousemove', e => {
                const r = m.getBoundingClientRect();
                m.style.transform = `translate(${(e.clientX - r.left - r.width / 2) * .25}px,${(e.clientY - r.top - r.height / 2) * .35}px)`;
            });
            m.addEventListener('mouseleave', () => m.style.transform = '');
        });
    }
})();
</script>


</body>
</html>
