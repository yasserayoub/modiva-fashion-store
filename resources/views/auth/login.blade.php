<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Modiva Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-container">

        {{-- Brand panel --}}
        <aside class="auth-side" aria-hidden="true">
            <div class="blob b1"></div><div class="blob b2"></div><div class="blob b3"></div>
            <a href="{{ route('home') }}" class="auth-logo">Modiva<i>.</i></a>

            <div class="auth-side-content">
                <h2><span class="line"><em>Wear</em></span><span class="line"><em class="grad">your</em></span><span class="line"><em>identity.</em></span></h2>
                <p>Sign in to track orders, save favorites and check out faster.</p>
            </div>

            <img class="float f1" src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=85" alt="">
            <img class="float f2" src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=500&q=85" alt="">
            <div class="sticker">NEW<br>DROP</div>
        </aside>

        {{-- Form --}}
        <main class="auth-main">
            <div class="auth-form">
                <a href="{{ route('home') }}" class="back">← Back to store</a>

                <h1>Welcome back.</h1>
                <p class="subtitle">Sign in to continue shopping.</p>

                @if (session('status'))
                    <div class="alert ok">{{ session('status') }}</div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="Your email" autocomplete="email" required autofocus
                               class="@error('email') invalid @enderror">
                        @error('email')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="pw">
                            <input type="password" id="password" name="password"
                                   placeholder="Your password" autocomplete="current-password" required
                                   class="@error('password') invalid @enderror">
                            <button type="button" class="pw-toggle" id="pwToggle" aria-label="Show password">Show</button>
                        </div>
                        @error('password')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="submit"><b>Sign in</b><span>↗</span></button>
                </form>

                <p class="auth-switch">
                    Don't have an account?
                    <a href="{{ route('register') }}">Create account</a>
                </p>
            </div>
        </main>
    </div>

    <script>
        (() => {
            const pw = document.getElementById('password'), t = document.getElementById('pwToggle');
            t.addEventListener('click', () => {
                const show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                t.textContent = show ? 'Hide' : 'Show';
                t.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        })();
    </script>
</body>
</html>
