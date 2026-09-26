<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login — Fibro Admin</title>
    <link rel="icon" href="/images/fibro-symbol-refined.png">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="admin-login-wrap">
        <div class="admin-login-card">
            <img class="admin-login-logo" src="{{ asset('images/fibro-official-logo.png') }}" alt="Fibro Laminates">
            <h1>Website administration</h1>
            <p class="login-sub">Sign in to manage your website</p>

            @if($errors->any())
                <div class="admin-login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="admin-form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" class="admin-input"
                           value="{{ old('email') }}" placeholder="admin@fibrolaminates.com" required autofocus>
                </div>
                <div class="admin-form-group">
                    <label for="password">Password</label>
                    <div style="position:relative">
                        <input type="password" id="password" name="password" class="admin-input"
                               placeholder="••••••••" required style="padding-right:44px">
                        <button type="button" id="toggle-password" aria-label="Show password"
                                style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--admin-text-muted);padding:6px;cursor:pointer;display:flex;align-items:center;border-radius:4px"
                                onmouseover="this.style.color='var(--admin-text)'" onmouseout="this.style.color='var(--admin-text-muted)'">
                            <svg id="icon-eye" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="icon-eye-off" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>
                <div class="admin-form-group" style="display:flex;align-items:center;gap:8px">
                    <input type="checkbox" id="remember" name="remember" style="accent-color:var(--admin-accent)">
                    <label for="remember" style="margin:0;cursor:pointer">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const iconEye = document.getElementById('icon-eye');
            const iconEyeOff = document.getElementById('icon-eye-off');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconEye.style.display = 'none';
                iconEyeOff.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                iconEye.style.display = 'block';
                iconEyeOff.style.display = 'none';
            }
        });
    </script>
</body>
</html>
