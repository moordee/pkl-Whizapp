<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Discover Whizapp</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS v5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <link href="logo/logo.png" rel="icon" type="image/png">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');

        * {
            font-family: 'Nunito', sans-serif;
        }

        body {
            background: linear-gradient(180deg,
                    rgba(63, 43, 150, 1) 0%,
                    rgba(100, 100, 200, 1) 40%,
                    rgba(168, 192, 255, 1) 100%);
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
        }

        /* ── Navbar ── */
        .navbar {
            background: rgba(50, 35, 130, 0.55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(165, 145, 145, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-logo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .navbar-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-nav {
            color: white !important;
            font-weight: 600;
            background: transparent;
            border: none;
            padding: 6px 14px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .btn-nav:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* ── Hero Section ── */
        .hero {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 20px 80px;
            box-sizing: border-box;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0 auto;
            max-width: 400px;
            line-height: 1.7;
        }

        /* ── Features Section ── */
        .features {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 20px;
            box-sizing: border-box;
        }

        .features h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .features .desc {
            font-size: 0.95rem;
            opacity: 0.85;
            max-width: 540px;
            margin: 0 auto 48px;
            line-height: 1.6;
        }

        /* Feature boxes */
        .feature-boxes {
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            width: 100%;
            max-width: 900px;
        }

        .feature-box {
            width: 180px;
            height: 180px;
            background: #7D74F4;
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .feature-box:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-icon img,
        .feature-icon svg {
            width: 100%;
            height: 100%;
        }

        .feature-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: white;
            text-align: center;
        }

        /* ── Footer ── */
        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.25);
            padding: 20px;
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* ── Modal shared styles ── */
        .modal-content {
            border-radius: 18px;
            border: none;
            background: linear-gradient(160deg,
                    rgba(90, 70, 190, 1) 0%,
                    rgba(140, 140, 230, 1) 60%,
                    rgba(180, 210, 255, 1) 100%);
            color: white;
            padding: 10px;
        }

        .modal-header {
            border-bottom: none;
            justify-content: center;
            padding-bottom: 0;
        }

        .modal-title {
            font-size: 2rem;
            font-weight: 800;
        }

        .modal-body {
            padding: 24px 32px;
        }

        .modal-footer {
            border-top: none;
            justify-content: center;
            padding-top: 0;
            padding-bottom: 20px;
            font-size: 0.9rem;
        }

        .modal-footer a {
            color: white;
            font-weight: 700;
            text-decoration: underline;
            cursor: pointer;
        }

        .modal-footer a:hover {
            opacity: 0.8;
        }

        .modal-body label {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 6px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .modal-body .form-control {
            border-radius: 12px;
            border: none;
            background: white;
            padding: 12px 16px;
            font-size: 1rem;
            color: #333;
            box-shadow: none;
        }

        .modal-body .form-control:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.4);
        }

        .btn-auth {
            background: #192F9D;
            color: white;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 0.08em;
            border: none;
            border-radius: 40px;
            padding: 12px 48px;
            transition: background 0.2s, transform 0.15s;
            display: block;
            margin: 8px auto 0;
        }

        .btn-auth:hover {
            background: #1a3ab5;
            transform: translateY(-1px);
        }

        .btn-close-modal {
            position: absolute;
            top: 16px;
            right: 20px;
            background: transparent;
            border: none;
            color: white;
            font-size: 1.4rem;
            cursor: pointer;
            opacity: 0.7;
            line-height: 1;
        }

        .btn-close-modal:hover {
            opacity: 1;
        }
    </style>
</head>

<body>

    <!-- ══════════════ NAVBAR ══════════════ -->
    <header>
        <nav class="navbar fixed-top">
            <div class="container-fluid px-4">

                <a class="navbar-brand" href="#">
                    <div class="navbar-logo">
                        <img id="navbar-logo-img" src="logo/logo.png" alt="Logo" />
                    </div>
                    Whizapp
                </a>

                <div class="d-flex gap-1">
                    <button class="btn-nav" data-bs-toggle="modal" data-bs-target="#signInModal">
                        Sign in
                    </button>
                    <button class="btn-nav" data-bs-toggle="modal" data-bs-target="#signUpModal">
                        Sign up
                    </button>
                </div>

            </div>
        </nav>
    </header>

    <!-- ══════════════ MAIN ══════════════ -->
    <main>

        <!-- Hero -->
        <section class="hero">
            <h1>Add your wishlist items<br>to Whizapp</h1>
            <p>Gather all your favorite items in one place.<br>Plan your next check out.</p>
        </section>

        <!-- Features -->
        <section class="features">
            <h1>Enjoy many features</h1>
            <p class="desc">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pretium risus erat,
                et lobortis dui commodo eget. Proin venenatis rhoncus ipsum, viverra hendrerit
                lorem egestas at.
            </p>

            <div class="feature-boxes">

                <!-- Box 1: Add Wishlist -->
                <div class="feature-box">
                    <div class="feature-icon">
                        <img src="icons/255px_AddShoppingCart.png" alt="Add Wishlist" />
                    </div>
                    <span class="feature-label">Add Wishlist</span>
                </div>

                <!-- Box 2: Share Wishlist -->
                <div class="feature-box">
                    <div class="feature-icon">
                        <img src="icons/210px_ForwardArrow.png" alt="Share Wishlist" />
                    </div>
                    <span class="feature-label">Share Wishlist</span>
                </div>

                <!-- Box 3: Referral -->
                <div class="feature-box">
                    <div class="feature-icon">
                        <img src="icons/210px_Gift.png" alt="Referral" />
                    </div>
                    <span class="feature-label">Referral</span>
                </div>

                <!-- Box 4: AI Integration -->
                <div class="feature-box">
                    <div class="feature-icon">
                        <img src="icons/Ai.png" alt="AI Integration" />
                    </div>
                    <span class="feature-label">AI Integration</span>
                </div>

            </div>
        </section>

    </main>

    <!-- ══════════════ FOOTER ══════════════ -->
    <footer class="text-black">
        Made with 🤍 by @SANA
    </footer>


    <!-- ══════════════ MODAL: SIGN IN ══════════════ -->
    <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative">

                <button class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">✕</button>

                <div class="modal-header">
                    <h5 class="modal-title" id="signInModalLabel">Sign in</h5>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="signInUsername">Username</label>
                        <input type="text" class="form-control" id="signInUsername" placeholder="Username" />
                    </div>
                    <div class="mb-3">
                        <label for="signInEmail">E-Mail</label>
                        <input type="email" class="form-control" id="signInEmail" placeholder="E-Mail" />
                    </div>
                    <div class="mb-4">
                        <label for="signInPassword">Password</label>
                        <input type="password" class="form-control" id="signInPassword" placeholder="Password" />
                    </div>

                    <button class="btn-auth">SIGN IN</button>
                </div>

                <div class="modal-footer" style="color: black;">
                    Don't have an account?&nbsp;
                    <a id="goToSignUp">Sign up now.</a>
                </div>

            </div>
        </div>
    </div>


    <!-- ══════════════ MODAL: SIGN UP ══════════════ -->
    <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative">

                <button class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">✕</button>

                <div class="modal-header">
                    <h5 class="modal-title" id="signUpModalLabel">Sign up</h5>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="signUpUsername">USERNAME</label>
                        <input type="text" class="form-control" id="signUpUsername" placeholder="Username" />
                    </div>
                    <div class="mb-3">
                        <label for="signUpEmail">EMAIL</label>
                        <input type="email" class="form-control" id="signUpEmail" placeholder="E-Mail" />
                    </div>
                    <div class="mb-4">
                        <label for="signUpPassword">PASSWORD</label>
                        <input type="password" class="form-control" id="signUpPassword" placeholder="Password" />
                    </div>

                    <button class="btn-auth">SIGN UP</button>
                </div>

                <div class="modal-footer" style="color: black;">
                    Already have an account?&nbsp;
                    <a id="goToSignIn">Sign in.</a>
                </div>

            </div>
        </div>
    </div>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        const signInModal = new bootstrap.Modal(document.getElementById('signInModal'));
        const signUpModal = new bootstrap.Modal(document.getElementById('signUpModal'));

        document.getElementById('goToSignUp').addEventListener('click', () => {
            signInModal.hide();
            document.getElementById('signInModal').addEventListener('hidden.bs.modal', () => {
                signUpModal.show();
            }, { once: true });
        });

        document.getElementById('goToSignIn').addEventListener('click', () => {
            signUpModal.hide();
            document.getElementById('signUpModal').addEventListener('hidden.bs.modal', () => {
                signInModal.show();
            }, { once: true });
        });
    </script>

</body>

</html>
