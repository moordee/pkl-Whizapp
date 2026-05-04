<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whizapp: Wishlist Board</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('logo/logo.png') }}" rel="icon" type="image/png">
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

        body.dark-mode {
            background: linear-gradient(180deg,
                    rgba(10, 8, 30, 1) 0%,
                    rgba(25, 20, 60, 1) 40%,
                    rgba(40, 35, 80, 1) 100%);
            color: #e0e0e0;
        }

        body.dark-mode .wishlist-card {
            background: rgba(30, 25, 60, 0.95);
            color: #e0e0e0;
        }

        body.dark-mode .product-name {
            color: #e0e0e0;
        }

        body.dark-mode .product-desc {
            color: #aaa;
        }

        .add-item-input::placeholder { color: #888; }

        body.dark-mode .board-title {
            color: #e0e0e0 !important;
        }
        body.dark-mode .footer {
            color: white !important;
        }
    </style>
</head>

<body class="{{ Auth::check() && Auth::user()->dark_mode ? 'dark-mode' : '' }}">

    <!-- ══ TOPBAR ══ -->
    <div class="topbar">
        <img src="https://img.icons8.com/ios-filled/30/ffffff/menu--v1.png" class="menu-toggle"
            onclick="toggleSidebar()">
        <h5 class="mb-0" style="font-family:'Nunito',sans-serif;font-weight:800;">Whizapp</h5>
        <div class="ms-auto">
            <button onclick="openBellModal()"
                    style="background:none;border:none;
                           cursor:pointer;padding:0;">
                <img src="{{ asset('icons/Doorbell.png') }}" width="50" height="30">
            </button>
        </div>
    </div>

    <div class="d-flex" style="min-height: calc(100vh - 60px);">

        <!-- ══ SIDEBAR ══ -->
        <div class="sidebar" id="sidebar">
            <a href="{{ route('profile') }}"><img src="{{ asset('icons/Registration.png') }}" width="27" height="27"> My Profile</a>
            <a href="{{ route('dashboard') }}"><img src="{{ asset('icons/ListView.png') }}" width="27" height="27"> Wishlist Boards</a>
            @unless($readOnly ?? false)
            <form action="{{ route('boards.share', $board) }}"
                  method="POST" class="m-0 p-0">
                @csrf
                <button type="submit"
                        style="background:none;border:none;width:100%;
                               display:flex;align-items:center;gap:12px;
                               padding:12px 20px;color:white;cursor:pointer;
                               font-family:'Nunito',sans-serif;
                               font-size:1rem;">
                    <img src="{{ asset('icons/95px_ForwardArrow.png') }}"
                         width="27" height="27"> Share Board
                </button>
            </form>
            @else
            <a href="#"><img src="{{ asset('icons/95px_ForwardArrow.png') }}" width="27" height="27"> Share Board</a>
            @endunless
            <a href="javascript:void(0)" onclick="openComingSoon()"><img src="{{ asset('icons/95px_Gift.png') }}" width="27" height="27"> Referral</a>
            <a href="javascript:void(0)" onclick="openComingSoon()"><img src="{{ asset('icons/Member.png') }}" width="27" height="27"> AI Assistant</a>
            <a href="javascript:void(0)" onclick="openComingSoon()"><img src="{{ asset('icons/DuplicateContacts.png') }}" width="27" height="27"> Contact Form</a>
            <a href="javascript:void(0)" onclick="openSettingsModal()"><img src="{{ asset('icons/Settings.png') }}" width="27" height="27"> Settings</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                @csrf
                <button type="submit"
                    style="background:none;border:none;width:100%;display:flex;align-items:center;gap:12px;padding:12px 20px;color:white;cursor:pointer;font-family:'Nunito',sans-serif;font-size:1rem;">
                    <img src="{{ asset('icons/LogoutRounded.png') }}" width="27" height="27"> Sign out
                </button>
            </form>
        </div>

        <!-- ══ CONTENT ══ -->
        <div class="content">

            <!-- ── Board Header ── -->
            <div class="board-header mt-2">
                <h2 class="board-title">{{ $board->name }}</h2>
            </div>

            <!-- ── Add Item Form ── -->
            @unless($readOnly ?? false)
                <form action="{{ route('items.store', $board) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <input type="url" name="item_url" id="item_url" placeholder="Paste product link here..." required
                            class="add-item-input"
                            style="padding:8px 14px;border-radius:10px;border:none;
                                  background:rgba(255,255,255,0.85);color:#333;
                                  outline:none;flex:1;min-width:250px;">
                        <input type="hidden" name="title" id="title">
                        <input type="hidden" name="price" id="price">
                        <input type="hidden" name="image_url" id="image_url">
                        <input type="hidden" name="source" id="source">
                        <button type="submit"
                            style="background:rgba(255,255,255,0.25);color:white;
                                   border:none;border-radius:10px;padding:8px 20px;
                                   font-weight:700;cursor:pointer;">
                            Add Item
                        </button>
                    </div>
                </form>
            @endunless

            <!-- ── Toolbar ── -->
            @unless($readOnly ?? false)
            <div class="content-toolbar">
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button class="btn-select" id="btnSelect" onclick="toggleSelectMode()">Select</button>
                    <button class="btn-bulk-delete" id="btnBulkDelete" onclick="deleteSelected()"
                        aria-label="Delete selected">
                        <img src="{{ asset('icons/Delete.png') }}" alt="Delete selected" />
                    </button>
                </div>
            </div>
            @endunless

            <!-- ── Wishlist Items ── -->
            @forelse($items as $item)
                <div class="wishlist-card" id="card-{{ $item->id }}">
                    <input type="checkbox" class="card-checkbox" id="chk-{{ $item->id }}" />
                    @unless($readOnly ?? false)
                        <form action="{{ route('items.destroy', $item) }}" method="POST"
                            style="position:absolute;top:12px;right:14px;
                                   background:none;border:none;padding:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" aria-label="Delete" style="position:static;">
                                <img src="{{ asset('icons/DeleteHitam.png') }}" alt="Delete" />
                            </button>
                        </form>
                    @endunless
                    <div class="product-img-wrap">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $item->title }}</div>
                        <div class="product-desc">
                            Source: {{ $item->source ?? '—' }}<br>
                            Price: Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
                        </div>
                        <div class="qty-control">
                            <button class="qty-btn" onclick="changeQty('qty-{{ $item->id }}', -1)">−</button>
                            <span class="qty-value" id="qty-{{ $item->id }}">1</span>
                            <button class="qty-btn" onclick="changeQty('qty-{{ $item->id }}', 1)">+</button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-white opacity-75">
                    No items yet. Paste a product link above to get started.
                </p>
            @endforelse

            <!-- ── Total Amount & Share Link ── -->
            @unless($readOnly ?? false)
                <div class="mt-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div style="background:rgba(255,255,255,0.15);
                                border-radius:12px;padding:12px 20px;">
                        <span style="font-size:0.85rem;opacity:0.8;">Total</span><br>
                        <strong style="font-size:1.3rem;">
                            Rp {{ number_format($items->sum('price'), 0, ',', '.') }}
                        </strong>
                    </div>
                    <div>
                        @if($board->share_token)
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <span style="font-size:0.85rem;opacity:0.8;">Share link:</span>
                                <input type="text" readonly value="{{ url('/shared/'.$board->share_token) }}"
                                    style="background:rgba(255,255,255,0.2);
                                           border:none;border-radius:8px;
                                           padding:5px 10px;color:white;
                                           font-size:0.85rem;min-width:280px;">
                            </div>
                        @endif
                        <form action="{{ route('boards.share', $board) }}" method="POST">
                            @csrf
                            <button type="submit"
                                style="background:rgba(255,255,255,0.2);
                                       color:white;border:none;border-radius:10px;
                                       padding:7px 18px;font-weight:600;cursor:pointer;
                                       font-size:0.9rem;">
                                {{ $board->share_token ? 'Regenerate Share Link' : 'Generate Share Link' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endunless

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

        function openBellModal() {
            document.getElementById('bellModal')
                .style.display = 'flex';
        }
        function closeBellModal() {
            document.getElementById('bellModal')
                .style.display = 'none';
        }
        function openComingSoon() {
            document.getElementById('comingSoonModal')
                .style.display = 'flex';
        }
        function closeComingSoon() {
            document.getElementById('comingSoonModal')
                .style.display = 'none';
        }
        function openSettingsModal() {
            document.getElementById('settingsModal')
                .style.display = 'flex';
        }
        function closeSettingsModal() {
            document.getElementById('settingsModal')
                .style.display = 'none';
        }

        document.getElementById('item_url')?.addEventListener('paste', function(e) {
            setTimeout(async () => {
                const url = e.target.value;
                if (!url) return;
                const res = await fetch('{{ route("prefetch") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ url })
                });
                const data = await res.json();
                if (!data.error) {
                    document.getElementById('title').value = data.title || '';
                    document.getElementById('price').value = data.price || '';
                    document.getElementById('image_url').value = data.image_url || '';
                    document.getElementById('source').value = data.source || '';
                }
            }, 100);
        });
    </script>

    <!-- Bell Modal -->
    <div id="bellModal"
         style="display:none;position:fixed;top:0;left:0;
                width:100%;height:100%;
                background:rgba(0,0,0,0.4);z-index:9999;
                align-items:center;justify-content:center;">
        <div style="background:white;border-radius:16px;
                    padding:32px 28px;min-width:280px;
                    text-align:center;color:#333;">
            <div style="font-size:2rem;margin-bottom:12px;">🔔</div>
            <h5 class="fw-bold">Nothing to see...yet.</h5>
            <p style="color:#888;font-size:0.9rem;
                      margin:8px 0 20px;">
                You have no notifications right now.
            </p>
            <button onclick="closeBellModal()"
                    style="background:#3d2fa0;color:white;
                           border:none;border-radius:8px;
                           padding:8px 24px;font-weight:600;
                           cursor:pointer;">
                OK
            </button>
        </div>
    </div>

    <!-- Coming Soon Modal -->
    <div id="comingSoonModal"
         style="display:none;position:fixed;top:0;left:0;
                width:100%;height:100%;
                background:rgba(0,0,0,0.4);z-index:9999;
                align-items:center;justify-content:center;">
        <div style="background:white;border-radius:16px;
                    padding:32px 28px;min-width:280px;
                    text-align:center;color:#333;">
            <div style="font-size:2rem;margin-bottom:12px;">🚧</div>
            <h5 class="fw-bold">Coming soon</h5>
            <p style="color:#888;font-size:0.9rem;
                      margin:8px 0 20px;">
                This feature is still in development. Stay tuned!
            </p>
            <button onclick="closeComingSoon()"
                    style="background:#3d2fa0;color:white;
                           border:none;border-radius:8px;
                           padding:8px 24px;font-weight:600;
                           cursor:pointer;">
                Got it
            </button>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settingsModal"
         style="display:none;position:fixed;top:0;left:0;
                width:100%;height:100%;
                background:rgba(0,0,0,0.4);z-index:9999;
                align-items:center;justify-content:center;">
        <div style="background:white;border-radius:16px;
                    padding:28px;min-width:320px;color:#333;">
            <h5 class="fw-bold mb-4">⚙️ Settings</h5>
            <div style="display:flex;align-items:center;
                        justify-content:space-between;
                        background:#f5f5f5;border-radius:12px;
                        padding:14px 18px;margin-bottom:20px;">
                <span style="font-weight:600;">Dark Mode</span>
                <form action="{{ route('profile.darkmode') }}"
                      method="POST">
                    @csrf
                    <button type="submit"
                        style="background:{{ Auth::user()->dark_mode
                               ? '#6c4ee0' : '#ddd' }};
                               color:{{ Auth::user()->dark_mode
                               ? 'white' : '#333' }};
                               border:none;border-radius:20px;
                               padding:6px 20px;font-weight:600;
                               cursor:pointer;min-width:60px;">
                        {{ Auth::user()->dark_mode ? 'On' : 'Off' }}
                    </button>
                </form>
            </div>
            <div class="d-flex justify-content-end">
                <button onclick="closeSettingsModal()"
                        style="background:#3d2fa0;color:white;
                               border:none;border-radius:8px;
                               padding:8px 24px;font-weight:600;
                               cursor:pointer;">
                    Close
                </button>
            </div>
        </div>
    </div>

</body>

</html>

