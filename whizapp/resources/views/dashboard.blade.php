<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Whizapp: Dashboard</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .card-item {
            background: #f2f2f2;
            color: #333;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }

        .img-placeholder {
            height: 120px;
            background: #ddd;
            border-radius: 10px;
        }

        .content {
            flex-grow: 1;
        }

        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            padding: 20px;
            color: #eee;
        }

        /* SEARCH STYLE */
        .search-box {
            position: relative;
            width: 600px;
            margin-top: -10px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 40px 10px 15px;
            border-radius: 10px;
            border: none;
            outline: none;
            background: #e6e6e6;
            color: #333;
            font-size: 14px;
        }

        .search-box img {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1050;
                background: rgba(63, 43, 150, 0.95);
                height: 100%;
                left: -250px;
            }

            .sidebar.show {
                left: 0;
            }

            .search-box {
                width: 180px;
                /* lebih kecil di HP */
            }
        }

        body.dark-mode {
            background: linear-gradient(180deg,
                    rgba(10, 8, 30, 1) 0%,
                    rgba(25, 20, 60, 1) 40%,
                    rgba(40, 35, 80, 1) 100%);
            color: #e0e0e0;
        }

        body.dark-mode .card-item {
            background: rgba(30, 25, 60, 0.95);
            color: #e0e0e0;
        }

        body.dark-mode .board-title,
        body.dark-mode .card-item strong,
        body.dark-mode .card-item .small {
            color: #e0e0e0 !important;
        }
        body.dark-mode footer,
        body.dark-mode .footer {
            color: white !important;
        }
    </style>
</head>

<body class="{{ Auth::check() && Auth::user()->dark_mode ? 'dark-mode' : '' }}">

    <!-- NAVBAR -->
    <div class="topbar">
        <img src="https://img.icons8.com/ios-filled/30/ffffff/menu--v1.png" class="menu-toggle"
            onclick="toggleSidebar()">
        <h5 class="mb-0 fw-bold" style="font-family:'Nunito',sans-serif;font-weight:800;">Whizapp</h5>
        <div class="ms-auto">
            <button onclick="openBellModal()"
                    style="background:none;border:none;
                           cursor:pointer;padding:0;">
                <img src="{{ asset('icons/Doorbell.png') }}" width="50" height="30">
            </button>
        </div>
    </div>

    <div class="d-flex" style="min-height: calc(100vh - 60px);">

        <div class="sidebar" id="sidebar">
            <a href="{{ route('profile') }}"><img src="{{ asset('icons/Registration.png') }}" width="27" height="27"> My Profile</a>
            <a href="{{ route('dashboard') }}"><img src="{{ asset('icons/ListView.png') }}" width="27" height="27"> Wishlist Boards</a>
            <a href="javascript:void(0)" onclick="openShareModal()"><img src="{{ asset('icons/95px_ForwardArrow.png') }}" width="27" height="27"> Share Board</a>
            <a href="javascript:void(0)" onclick="openComingSoon()"><img src="{{ asset('icons/95px_Gift.png') }}" width="27" height="27"> Referral</a>
            <a href="javascript:void(0)" onclick="openComingSoon()"><img src="{{ asset('icons/Member.png') }}" width="27" height="27"> AI Assistant</a>
            <a href="javascript:void(0)" onclick="openComingSoon()"><img src="{{ asset('icons/DuplicateContacts.png') }}" width="27" height="27"> Contact Form</a>
            <a href="javascript:void(0)" onclick="openSettingsModal()"><img src="{{ asset('icons/Settings.png') }}" width="27" height="27"> Settings</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                @csrf
                <button type="submit"
                    style="background:none;border:none;width:100%;
                           display:flex;align-items:center;gap:12px;
                           padding:12px 20px;color:white;cursor:pointer;
                           font-family:'Nunito',sans-serif;font-size:1rem;">
                    <img src="{{ asset('icons/LogoutRounded.png') }}" width="27" height="27"> Sign out
                </button>
            </form>
        </div>

        <!-- CONTENT -->
        <div class="content p-4 w-100">

            <div class="mb-4">

                <!-- BARIS 1 -->
                <h2 class="mb-1 fw-bold">My Wishlist</h2>

                <!-- BARIS 2 -->
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold">Board</h2>

                    <form action="{{ route('boards.search') }}" method="GET" class="search-box">
                        <input type="text" name="query" placeholder="Search" value="{{ $query ?? '' }}">
                        <img src="https://img.icons8.com/ios-filled/50/search.png">
                    </form>
                </div>

            </div>

            <form action="{{ route('boards.store') }}" method="POST" class="d-flex gap-2 mb-4">
                @csrf
                <input type="text" name="name" placeholder="New board name..." required
                    style="padding:10px 15px;border-radius:10px;border:none;
                           outline:none;background:#e6e6e6;color:#333;
                           font-size:14px;flex:1;max-width:300px;">
                <button type="submit"
                    style="background:#e6e6e6;color:#333;
                           border:none;border-radius:10px;padding:10px 20px;
                           font-weight:700;cursor:pointer;">
                    + Create
                </button>
            </form>

            <form action="" method="POST" id="delete-board-form"
                  class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" id="btn-delete-board"
                        onclick="openDeleteModal()"
                        style="background:rgba(255,255,255,0.25);
                               color:white;border:none;border-radius:10px;
                               padding:8px 20px;font-weight:700;
                               cursor:pointer;">
                    Delete Board
                </button>
            </form>

            <div class="row g-4">

                @forelse($boards as $board)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('boards.show', $board->slug) }}" class="text-decoration-none">
                            <div class="card-item">
                                <div class="img-placeholder">
                                    @php $images = $board->thumbnailImages(); @endphp
                                    @if($images)
                                        <img src="{{ $images }}" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
                                    @endif
                                </div>
                                <div class="small text-muted mt-2">{{ $board->totalAmount() }}</div>
                                <strong class="text-dark">{{ $board->name }}</strong>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-white opacity-75">
                            No boards found. Create your first board to get started!
                        </p>
                    </div>
                @endforelse

            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="text-black">
        Made with 🤍 by @SANA
    </footer>

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

    <!-- Delete Board Modal -->
    <div id="deleteBoardModal"
         style="display:none;position:fixed;top:0;left:0;
                width:100%;height:100%;
                background:rgba(0,0,0,0.5);z-index:9999;
                align-items:center;justify-content:center;">
        <div style="background:white;border-radius:16px;
                    padding:28px;min-width:320px;color:#333;">
            <h5 class="fw-bold mb-3">Select Board to Delete</h5>
            <div id="board-radio-list" class="mb-3">
                @foreach($boards as $board)
                <div class="form-check">
                    <input class="form-check-input" type="radio"
                           name="delete_board"
                           value="{{ route('boards.destroy', $board) }}"
                           id="del-{{ $board->id }}">
                    <label class="form-check-label"
                           for="del-{{ $board->id }}">
                        {{ $board->name }}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button onclick="closeDeleteModal()"
                        style="background:#eee;border:none;
                               border-radius:8px;padding:7px 18px;
                               cursor:pointer;">
                    Cancel
                </button>
                <button onclick="confirmDeleteBoard()"
                        style="background:#d33;color:white;
                               border:none;border-radius:8px;
                               padding:7px 18px;cursor:pointer;">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Share Board Modal -->
    <div id="shareBoardModal"
         style="display:none;position:fixed;top:0;left:0;
                width:100%;height:100%;
                background:rgba(0,0,0,0.5);z-index:9999;
                align-items:center;justify-content:center;">
        <div style="background:white;border-radius:16px;
                    padding:28px;min-width:320px;color:#333;">
            <h5 class="fw-bold mb-3">Share a Board</h5>
            <p style="font-size:0.9rem;color:#666;">
                Select a board:
            </p>
            <form id="share-board-form" method="POST">
                @csrf
                <select id="share-board-select"
                        class="form-control mb-3">
                    <option value="">-- Select Board --</option>
                    @foreach($boards as $board)
                    <option
                      value="{{ route('boards.share', $board) }}">
                        {{ $board->name }}
                    </option>
                    @endforeach
                </select>
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button"
                            onclick="closeShareModal()"
                            style="background:#eee;border:none;
                                   border-radius:8px;
                                   padding:7px 18px;cursor:pointer;">
                        Cancel
                    </button>
                    <button type="button"
                            onclick="confirmShare()"
                            style="background:#3d2fa0;color:white;
                                   border:none;border-radius:8px;
                                   padding:7px 18px;cursor:pointer;">
                        Get Link
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("hide");
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
        function openDeleteModal() {
            document.getElementById('deleteBoardModal')
                .style.display = 'flex';
        }
        function closeDeleteModal() {
            document.getElementById('deleteBoardModal')
                .style.display = 'none';
        }
        function confirmDeleteBoard() {
            const selected = document.querySelector(
                'input[name="delete_board"]:checked');
            if (!selected) {
                alert('Please select a board first.');
                return;
            }
            const form = document.getElementById('delete-board-form');
            form.action = selected.value;
            form.submit();
        }
        function openShareModal() {
            document.getElementById('shareBoardModal')
                .style.display = 'flex';
        }
        function closeShareModal() {
            document.getElementById('shareBoardModal')
                .style.display = 'none';
        }
        function confirmShare() {
            const select = document.getElementById(
                'share-board-select');
            if (!select.value) {
                alert('Please select a board first.');
                return;
            }
            const form = document.getElementById('share-board-form');
            form.action = select.value;
            form.submit();
        }
    </script>

</body>

</html>
