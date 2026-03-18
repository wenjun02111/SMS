<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Sales Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="login-root">
    <header class="login-header">
        <div class="login-header-left">
            <img src="{{ asset('sql-logo.png') }}" alt="SQL company logo" class="login-header-logo-img">
            <div class="login-logo-text">SQL Sales Management System</div>
        </div>
        <div class="login-header-right">
            <button class="login-help-link" type="button">Help</button>
            <button class="login-bell" type="button" aria-label="Notifications"><i class="bi bi-bell-fill" aria-hidden="true"></i></button>
        </div>
    </header>

    <main class="login-main">
        <div class="login-main-layout">
        <div class="login-book" id="loginBook">
            <button type="button" class="login-book-cover" id="loginBookCover" aria-label="Open login book">
                <div class="login-book-cover-inner">
                    <img src="{{ asset('sql-logo.png') }}" alt="" class="login-book-cover-logo">
                    <h1 class="login-book-cover-title">SQL Sales Management System</h1>
                    <p class="login-book-cover-subtitle">Admin Console</p>
                    <span class="login-book-cover-hint">Hover or click to open</span>
                </div>
            </button>

            <div class="login-book-pages">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('sql-logo.png') }}" alt="SQL logo" class="login-logo-img">
                <span class="login-logo-lms">SMS</span>
            </div>
            <p class="login-subtitle">Sales Management System</p>

            @if (!empty($show_register_passkey))
                {{-- After sign-in: stay on login page and show only register passkey; then redirect to dashboard --}}
                <div class="login-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <p class="login-passkey-note" style="margin-bottom: 1rem;">You're signed in. Register a passkey to use it next time, or skip to go to the dashboard.</p>
                    <button type="button" class="login-primary-btn" id="register-passkey-btn">
                        <i class="bi bi-shield-lock" aria-hidden="true"></i>
                        <span>Register passkey</span>
                    </button>
                    <p style="margin-top: 1rem; text-align: center;">
                        <a href="{{ $dashboard_url ?? '/admin/dashboard' }}" class="login-link-btn" style="font-size: 14px;">Skip, go to dashboard</a>
                    </p>
                </div>
            @else
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <label class="login-label">
                    Email
                    <div class="login-input-wrapper">
                        <span class="login-input-icon"><i class="bi bi-person-fill" aria-hidden="true"></i></span>
                        <input type="text" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                    </div>
                </label>
                <label class="login-label">
                    Password
                    <div class="login-input-wrapper">
                        <span class="login-input-icon"><i class="bi bi-lock-fill" aria-hidden="true"></i></span>
                        <input type="password" id="loginPassword" name="password" placeholder="********" required>
                        <button type="button" class="login-password-toggle" data-password-toggle data-target="loginPassword" aria-label="Show password" aria-pressed="false">
                            <i class="bi bi-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </label>

                @if (session('error'))
                    <div class="login-message login-error">{{ session('error') }}</div>
                @elseif (session('success'))
                    <div class="login-message login-success">{{ session('success') }}</div>
                @endif

                @if (session('show_reset_password') && old('email') && !session('success'))
                    <button
                        type="submit"
                        class="login-link-btn"
                        formaction="{{ route('password.forgot') }}"
                        formmethod="POST"
                        formnovalidate
                        style="text-align: left; padding-left: 0;"
                    >
                        Reset password
                    </button>
                @endif


                <button type="submit" class="login-primary-btn">Sign In -&gt;</button>

                <div class="login-divider"><span>OR</span></div>

                <button type="button" class="login-passkey-btn" id="login-passkey-btn">
                    <i class="bi bi-shield-lock" aria-hidden="true"></i>
                    <span>Login with passkey</span>
                </button>

                <p class="login-passkey-note">
                    <span class="login-passkey-note-line">Sign in with email and password.</span><br>
                    <span class="login-passkey-note-line">You can add a passkey after logging in.</span>
                </p>
            </form>
            @endif
        </div>
        <aside class="login-design-card is-candle" aria-label="Book design page">
            <div class="login-design-stage" aria-hidden="true">
                <div class="login-design-anim login-design-anim-cat">
                    <div class="login-cat-main">
                        <span class="login-cat-stand"></span>
                        <div class="login-cat">
                            <div class="login-cat-body"></div>
                            <div class="login-cat-head">
                                <div class="login-cat-ear"></div>
                                <div class="login-cat-ear"></div>
                            </div>
                            <div class="login-cat-face">
                                <div class="login-cat-nose"></div>
                                <div class="login-cat-whisker-container">
                                    <div class="login-cat-whisker"></div>
                                    <div class="login-cat-whisker"></div>
                                </div>
                                <div class="login-cat-whisker-container">
                                    <div class="login-cat-whisker"></div>
                                    <div class="login-cat-whisker"></div>
                                </div>
                            </div>
                            <div class="login-cat-tail-container">
                                <div class="login-cat-tail">
                                    <div class="login-cat-tail">
                                        <div class="login-cat-tail">
                                            <div class="login-cat-tail">
                                                <div class="login-cat-tail">
                                                    <div class="login-cat-tail">
                                                        <div class="login-cat-tail"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="login-design-anim login-design-anim-candle">
                    <div class="login-candle-wrapper">
                        <div class="login-candles">
                            <div class="login-light-wave"></div>
                            <div class="login-candle1">
                                <div class="login-candle1-body">
                                    <div class="login-candle1-eyes">
                                        <span class="login-candle1-eyes-one"></span>
                                        <span class="login-candle1-eyes-two"></span>
                                    </div>
                                    <div class="login-candle1-mouth"></div>
                                </div>
                                <div class="login-candle1-stick"></div>
                            </div>

                            <div class="login-candle2">
                                <div class="login-candle2-body">
                                    <div class="login-candle2-eyes">
                                        <div class="login-candle2-eyes-one"></div>
                                        <div class="login-candle2-eyes-two"></div>
                                    </div>
                                </div>
                                <div class="login-candle2-stick"></div>
                            </div>
                            <div class="login-candle2-fire"></div>
                            <div class="login-candle-smoke-one"></div>
                            <div class="login-candle-smoke-two"></div>
                        </div>
                        <div class="login-candle-floor"></div>
                    </div>
                </div>
            </div>
        </aside>
            </div>
        </div>
        </div>
    </main>
</div>

<script>
(function () {
    function initPasswordToggles() {
        document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var targetId = btn.getAttribute('data-target');
                if (!targetId) return;
                var input = document.getElementById(targetId);
                if (!input) return;
                var icon = btn.querySelector('i');
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-pressed', show ? 'true' : 'false');
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                if (icon) {
                    icon.classList.toggle('bi-eye', !show);
                    icon.classList.toggle('bi-eye-slash', show);
                }
            });
        });
    }

    initPasswordToggles();

    var loginBook = document.getElementById('loginBook');
    var loginBookCover = document.getElementById('loginBookCover');
    var loginDesignCard = loginBook ? loginBook.querySelector('.login-design-card') : null;
    var loginArtInterval = null;
    if (loginBook && loginBookCover) {
        function startRightArtLoop() {
            if (!loginDesignCard || loginArtInterval) return;
            loginArtInterval = window.setInterval(function () {
                loginDesignCard.classList.toggle('is-candle');
            }, 7000);
        }

        loginBookCover.addEventListener('click', function () {
            loginBook.classList.add('is-open');
            startRightArtLoop();
        });

        loginBook.addEventListener('mouseenter', startRightArtLoop);
    }

    var loginError = document.querySelector('.login-message.login-error');
    if (loginError) {
        var errorText = (loginError.textContent || '').toLowerCase();
        if (errorText.indexOf('invalid email or password') !== -1) {
            setTimeout(function () {
                loginError.style.transition = 'opacity 180ms ease';
                loginError.style.opacity = '0';
                setTimeout(function () {
                    loginError.style.display = 'none';
                }, 180);
            }, 3000);
        }
    }

    if (!window.PublicKeyCredential) {
        var lp = document.getElementById('login-passkey-btn');
        if (lp) { lp.disabled = true; lp.title = 'Passkeys not supported in this browser'; }
        var rp = document.getElementById('register-passkey-btn');
        if (rp) { rp.disabled = true; rp.title = 'Passkeys not supported in this browser'; }
        return;
    }

    function base64urlToBuffer(base64url) {
        var base64 = base64url.replace(/-/g, '+').replace(/_/g, '/');
        var pad = base64.length % 4;
        if (pad) base64 += new Array(5 - pad).join('=');
        var bin = atob(base64);
        var buf = new Uint8Array(bin.length);
        for (var i = 0; i < bin.length; i++) buf[i] = bin.charCodeAt(i);
        return buf.buffer;
    }

    function bufferToBase64url(buffer) {
        var bytes = new Uint8Array(buffer);
        var bin = '';
        for (var i = 0; i < bytes.length; i++) bin += String.fromCharCode(bytes[i]);
        var base64 = btoa(bin);
        return base64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
    }

    function transformGetOptions(options) {
        var pk = options.publicKey;
        pk.challenge = base64urlToBuffer(pk.challenge);
        if (pk.allowCredentials && pk.allowCredentials.length) {
            pk.allowCredentials = pk.allowCredentials.map(function (c) {
                return { type: 'public-key', id: base64urlToBuffer(c.id), transports: c.transports || [] };
            });
        }
        return options;
    }

    var loginPasskeyBtn = document.getElementById('login-passkey-btn');
    if (loginPasskeyBtn) {
    loginPasskeyBtn.addEventListener('click', function () {
        var btn = this;
        btn.disabled = true;
        fetch('{{ route("passkey.auth.options") }}', { method: 'GET', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
            .then(function (r) { return r.json(); })
            .then(function (options) {
                return navigator.credentials.get({ publicKey: transformGetOptions(options).publicKey });
            })
            .then(function (cred) {
                if (!cred) return Promise.reject(new Error('No credential returned'));
                return fetch('{{ route("passkey.auth.verify") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        id: bufferToBase64url(cred.rawId),
                        clientDataJSON: bufferToBase64url(cred.response.clientDataJSON),
                        authenticatorData: bufferToBase64url(cred.response.authenticatorData),
                        signature: bufferToBase64url(cred.response.signature),
                        userHandle: cred.response.userHandle ? bufferToBase64url(cred.response.userHandle) : null
                    })
                });
            })
            .then(function (r) { return r.json().then(function (data) { return { ok: r.ok, data: data }; }); })
            .then(function (result) {
                if (result.ok && result.data.redirect) {
                    window.location.href = result.data.redirect;
                } else {
                    alert(result.data.error || 'Passkey sign-in failed.');
                    btn.disabled = false;
                }
            })
            .catch(function (err) {
                alert(err.message || 'Passkey sign-in failed.');
                btn.disabled = false;
            });
    });
    }

    // Register passkey (after sign-in, still on login page)
    var registerPasskeyBtn = document.getElementById('register-passkey-btn');
    if (registerPasskeyBtn) {
        var dashboardUrl = '{{ $dashboard_url ?? "" }}';
        function base64urlToBuffer(base64url) {
            var base64 = base64url.replace(/-/g, '+').replace(/_/g, '/');
            var pad = base64.length % 4;
            if (pad) base64 += new Array(5 - pad).join('=');
            var bin = atob(base64);
            var buf = new Uint8Array(bin.length);
            for (var i = 0; i < bin.length; i++) buf[i] = bin.charCodeAt(i);
            return buf.buffer;
        }
        function bufferToBase64url(buffer) {
            var bytes = new Uint8Array(buffer);
            var bin = '';
            for (var i = 0; i < bytes.length; i++) bin += String.fromCharCode(bytes[i]);
            return btoa(bin).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
        }
        function transformCreateOptions(options) {
            var pk = options.publicKey;
            pk.challenge = base64urlToBuffer(pk.challenge);
            pk.user.id = base64urlToBuffer(pk.user.id);
            if (pk.excludeCredentials && pk.excludeCredentials.length) {
                pk.excludeCredentials = pk.excludeCredentials.map(function (c) {
                    return { type: 'public-key', id: base64urlToBuffer(c.id), transports: c.transports || [] };
                });
            }
            return options;
        }
        registerPasskeyBtn.addEventListener('click', function () {
            var btn = this;
            var nickname = prompt('Name this passkey (e.g. "My laptop"):', 'Device');
            if (nickname === null) return;
            nickname = nickname.trim() || 'Device';
            btn.disabled = true;
            var token = document.querySelector('input[name="_token"]').value;
            fetch('{{ route("passkey.register.options") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token },
                credentials: 'same-origin',
                body: JSON.stringify({})
            })
            .then(function (r) {
                return r.text().then(function (text) {
                    var data = null;
                    try { data = text ? JSON.parse(text) : {}; } catch (e) { data = {}; }
                    return { ok: r.ok, status: r.status, data: data };
                });
            })
            .then(function (result) {
                if (!result.ok) {
                    alert((result.data && result.data.error) ? result.data.error : 'Could not start registration.');
                    btn.disabled = false;
                    return;
                }
                return navigator.credentials.create({ publicKey: transformCreateOptions(result.data).publicKey });
            })
            .then(function (cred) {
                if (!cred) return Promise.reject(new Error('No credential created'));
                return fetch('{{ route("passkey.register.verify") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        nickname: nickname,
                        clientDataJSON: bufferToBase64url(cred.response.clientDataJSON),
                        attestationObject: bufferToBase64url(cred.response.attestationObject)
                    })
                });
            })
            .then(function (r) { return r.json().then(function (data) { return { ok: r.ok, data: data }; }); })
            .then(function (result) {
                if (result.ok && result.data.success) {
                    window.location.href = dashboardUrl || '/admin/dashboard';
                } else {
                    alert(result.data && result.data.error ? result.data.error : 'Registration failed.');
                    btn.disabled = false;
                }
            })
            .catch(function (err) {
                alert(err.message || 'Registration failed.');
                btn.disabled = false;
            });
        });
    }
})();
</script>
</body>
</html>
