<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whizapp: Wishlist Board</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            color: white;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .topbar {
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid rgb(255, 255, 255);
        }

        .menu-toggle {
            cursor: pointer;
            margin-right: 15px;
        }

        .sidebar {
            width: 250px;
            padding: 20px 0;
            transition: 0.3s;
            position: relative;
            min-height: calc(100vh - 60px);
        }

        .sidebar::after {
            content: "";
            position: absolute;
            top: 0px;
            bottom: 0px;
            right: 0;
            width: 1px;
            background: rgb(255, 255, 255);
        }

        .sidebar.hide {
            margin-left: -250px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .content {
            flex: 1;
            padding: 20px 30px 30px 30px;
            overflow-y: auto;
        }

        /* ── Board Header ── */
        .board-header {
            margin-bottom: 24px;
        }

        .board-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: white;
        }

        /* ── Wishlist Card ── */
        .wishlist-card {
            background: rgba(240, 235, 255, 0.92);
            border-radius: 20px;
            color: #222;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            margin-bottom: 20px;
        }

        /* Product image placeholder */
        .product-img-wrap {
            flex-shrink: 0;
            width: 140px;
            height: 140px;
            border-radius: 14px;
            background: rgba(200, 190, 240, 0.35);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Product info */
        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #1a1a2e;
        }

        .product-desc {
            font-size: 0.88rem;
            color: #444;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        /* Quantity control */
        .qty-control {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .qty-btn {
            background: none;
            border: none;
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            cursor: pointer;
            line-height: 1;
            padding: 0 4px;
            transition: color 0.15s;
        }

        .qty-btn:hover {
            color: #6c4ee0;
        }

        .qty-value {
            font-size: 1rem;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
            color: #222;
        }

        /* Delete button (top-right) */
        .btn-delete {
            position: absolute;
            top: 12px;
            right: 14px;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .btn-delete:hover {
            opacity: 1;
        }

        .btn-delete img,
        .btn-delete svg {
            width: 20px;
            height: 20px;
        }

        /* ── Content toolbar ── */
        .content-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn-select {
            background: #3d2fa0;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 7px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-select:hover {
            background: #4e3dbf;
        }

        .btn-select.active {
            background: #6c4ee0;
        }

        /* Bulk delete — hidden by default */
        .btn-bulk-delete {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            opacity: 0.85;
            display: none;
            transition: opacity 0.2s;
        }

        .btn-bulk-delete:hover {
            opacity: 1;
        }

        .btn-bulk-delete img,
        .btn-bulk-delete svg {
            width: 22px;
            height: 22px;
            filter: brightness(10);
        }

        /* Checkbox on card — hidden by default */
        .card-checkbox {
            display: none;
            position: absolute;
            top: 12px;
            right: 14px;
            width: 22px;
            height: 22px;
            cursor: pointer;
            accent-color: #6c4ee0;
        }

        /* In select mode: show checkbox, hide individual delete */
        body.select-mode .card-checkbox {
            display: block;
        }

        body.select-mode .btn-delete {
            display: none;
        }

        body.select-mode .btn-bulk-delete {
            display: block;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 10px;
            border-top: 1px solid rgb(255, 255, 255);
            font-size: 14px;
            color: black;
        }
    </style>
</head>

<body>

    <!-- ══ TOPBAR ══ -->
    <div class="topbar">
        <img src="https://img.icons8.com/ios-filled/30/ffffff/menu--v1.png" class="menu-toggle"
            onclick="toggleSidebar()">
        <h5 class="mb-0">Whizapp</h5>
        <div class="ms-auto">
            <img src="icons/Doorbell.png" width="50" height="30">
        </div>
    </div>

    <div class="d-flex" style="min-height: calc(100vh - 60px);">

        <!-- ══ SIDEBAR ══ -->
        <div class="sidebar" id="sidebar">
            <a href="/profile"><img src="icons/Registration.png" width="27" height="27"> My Profile</a>
            <a href="#"><img src="icons/ListView.png" width="27" height="27"> Wishlist Board</a>
            <a href="#" class="ps-5"><img src="icons/90px_AddShoppingCart.png" width="27" height="27"> Add</a>
            <a href="#" class="ps-5"><img src="icons/Delete.png" width="27" height="27"> Delete</a>
            <a href="#"><img src="icons/95px_ForwardArrow.png" width="27" height="27"> Share Wishlist</a>
            <a href="#"><img src="icons/95px_Gift.png" width="27" height="27"> Referral</a>
            <a href="#"><img src="icons/Member.png" width="27" height="27"> AI Integration</a>
            <a href="#"><img src="icons/DuplicateContacts.png" width="27" height="27"> Contact Form</a>
            <a href="#"><img src="icons/Settings.png" width="27" height="27"> Settings</a>
            <a href="#"><img src="icons/LogoutRounded.png" width="27" height="27"> Sign out</a>
        </div>

        <!-- ══ CONTENT ══ -->
        <div class="content">

            <!-- ── Board Header ── -->
            <div class="board-header mt-2">
                <h2 class="board-title">My Wishlist Board</h2>
            </div>

            <!-- ── Toolbar ── -->
            <div class="content-toolbar">
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button class="btn-select" id="btnSelect" onclick="toggleSelectMode()">Select</button>
                    <button class="btn-bulk-delete" id="btnBulkDelete" onclick="deleteSelected()"
                        aria-label="Delete selected">
                        <img src="icons/Delete.png" alt="Delete selected" />
                    </button>
                </div>
            </div>

            <!-- ── Wishlist Card 1 ── -->
            <div class="wishlist-card" id="card-1">
                <input type="checkbox" class="card-checkbox" id="chk-1" />
                <button class="btn-delete" onclick="removeCard('card-1')" aria-label="Delete">
                    <img src="icons/DeleteHitam.png" alt="Delete" />
                </button>
                <div class="product-img-wrap">
                    <img src="img/produk.png" alt="Product Image" id="product-img-1" />
                </div>
                <div class="product-info">
                    <div class="product-name">Nama Produk</div>
                    <div class="product-desc">
                        Deskripsi produk ada di sini.<br>
                        Vibe: —<br>
                        Keunggulan: —
                    </div>
                    <div class="qty-control">
                        <button class="qty-btn" onclick="changeQty('qty-1', -1)">−</button>
                        <span class="qty-value" id="qty-1">1</span>
                        <button class="qty-btn" onclick="changeQty('qty-1', 1)">+</button>
                    </div>
                </div>
            </div>

            <!-- ── Wishlist Card 2 ── -->
            <div class="wishlist-card" id="card-2">
                <input type="checkbox" class="card-checkbox" id="chk-2" />
                <button class="btn-delete" onclick="removeCard('card-2')" aria-label="Delete">
                    <img src="icons/DeleteHitam.png" alt="Delete" />
                </button>
                <div class="product-img-wrap">
                    <img src="img/produk.png" alt="Product Image" id="product-img-2" />
                </div>
                <div class="product-info">
                    <div class="product-name">Nama Produk</div>
                    <div class="product-desc">
                        Deskripsi produk ada di sini.<br>
                        Vibe: —<br>
                        Keunggulan: —
                    </div>
                    <div class="qty-control">
                        <button class="qty-btn" onclick="changeQty('qty-2', -1)">−</button>
                        <span class="qty-value" id="qty-2">1</span>
                        <button class="qty-btn" onclick="changeQty('qty-2', 1)">+</button>
                    </div>
                </div>
            </div>

            <!--
          ══ TAMBAH CARD BARU ══
          Untuk menambah item wishlist baru, copy blok .wishlist-card di atas,
          ganti id card (misal card-3), id qty (qty-3), dan isi src gambar + teks produk.
        -->

        </div><!-- /content -->
    </div>

    <!-- ══ FOOTER ══ -->
    <div class="footer text-black">
        Made with 🤍 by @SANA
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("hide");
        }

        // ── Qty: minimum 1 ──
        function changeQty(id, delta) {
            const el = document.getElementById(id);
            let val = parseInt(el.textContent) + delta;
            if (val < 1) val = 1;
            el.textContent = val;
        }

        // ── Hapus satu card ──
        function removeCard(id) {
            const card = document.getElementById(id);
            if (card) card.remove();
        }

        // ── Toggle select mode ──
        let selectMode = false;

        function toggleSelectMode() {
            selectMode = !selectMode;
            const btn = document.getElementById('btnSelect');

            if (selectMode) {
                document.body.classList.add('select-mode');
                btn.textContent = 'Cancel';
                btn.classList.add('active');
                document.querySelectorAll('.card-checkbox').forEach(cb => cb.checked = false);
            } else {
                document.body.classList.remove('select-mode');
                btn.textContent = 'Select';
                btn.classList.remove('active');
                document.querySelectorAll('.card-checkbox').forEach(cb => cb.checked = false);
            }
        }

        // ── Hapus semua card yang dicentang ──
        function deleteSelected() {
            const checked = document.querySelectorAll('.card-checkbox:checked');
            if (checked.length === 0) return;
            checked.forEach(cb => {
                const card = cb.closest('.wishlist-card');
                if (card) card.remove();
            });
            if (document.querySelectorAll('.wishlist-card').length === 0) {
                toggleSelectMode();
            }
        }
    </script>

</body>

</html>
