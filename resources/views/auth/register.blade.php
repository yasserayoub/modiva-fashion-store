<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Modiva Store</title>
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
                <h2><span class="line"><em>Find</em></span><span class="line"><em class="grad">your</em></span><span class="line"><em>style.</em></span></h2>
                <p>Create an account to save favorites, track orders and check out in seconds.</p>
            </div>

            <img class="float f1" src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=600&q=85" alt="">
            <img class="float f2" src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=500&q=85" alt="">
            <div class="sticker">JOIN<br>MODIVA</div>
        </aside>

        {{-- Form --}}
        <main class="auth-main">
            <div class="auth-form">
                <a href="{{ route('home') }}" class="back">← Back to store</a>

                <h1>Create account.</h1>
                <p class="subtitle">Create your account and discover your style.</p>

                <form action="{{ route('register.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstname">First name</label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                   placeholder="First name" autocomplete="given-name" required
                                   class="@error('firstname') invalid @enderror">
                            @error('firstname')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last name</label>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                                   placeholder="Last name" autocomplete="family-name" required
                                   class="@error('lastname') invalid @enderror">
                            @error('lastname')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="Your email" autocomplete="email" required
                               class="@error('email') invalid @enderror">
                        @error('email')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone number <span class="opt">(optional)</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               placeholder="Your phone number" autocomplete="tel"
                               class="@error('phone') invalid @enderror">
                        @error('phone')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="pw">
                            <input type="password" id="password" name="password"
                                   placeholder="Create a password" autocomplete="new-password" required
                                   class="@error('password') invalid @enderror">
                            <button type="button" class="pw-toggle" data-target="password" aria-label="Show password">Show</button>
                        </div>
                        <div class="meter" id="meter" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
                        <small class="meter-text" id="meterText"></small>
                        @error('password')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm password</label>
                        <div class="pw">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   placeholder="Repeat your password" autocomplete="new-password" required>
                            <button type="button" class="pw-toggle" data-target="password_confirmation" aria-label="Show password">Show</button>
                        </div>
                        <small class="error" id="matchError" hidden>Passwords don't match yet.</small>
                    </div>

                    <button type="submit" class="submit"><b>Create account</b><span>↗</span></button>
                </form>

                <p class="auth-switch">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </p>
            </div>
        </main>
    </div>

    <script>
        (() => {
            const $ = id => document.getElementById(id);

            // Show / hide password buttons
            document.querySelectorAll('.pw-toggle').forEach(btn => btn.addEventListener('click', () => {
                const input = $(btn.dataset.target), show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.textContent = show ? 'Hide' : 'Show';
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            }));

            // Password strength meter (visual hint only; real rules stay on the server)
            const pw = $('password'), meter = $('meter'), text = $('meterText');
            const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
            pw.addEventListener('input', () => {
                const v = pw.value;
                let score = 0;
                if (v.length >= 8) score++;
                if (/[a-z]/.test(v) && /[A-Z]/.test(v)) score++;
                if (/\d/.test(v)) score++;
                if (/[^A-Za-z0-9]/.test(v) || v.length >= 12) score++;
                if (!v) score = 0;
                meter.dataset.score = score;
                text.textContent = labels[score];
            });

            // Live "passwords match" hint
            const confirm = $('password_confirmation'), matchError = $('matchError');
            const check = () => { matchError.hidden = !confirm.value || confirm.value === pw.value; };
            confirm.addEventListener('input', check); pw.addEventListener('input', check);
        })();
    </script>
</body>
</html>
