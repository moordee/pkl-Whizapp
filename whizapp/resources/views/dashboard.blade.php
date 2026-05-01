@auth
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Whizapp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #1a1a1a;
            color: white;
        }
        .sidebar {
            background: #2a2a2a;
            min-height: 100vh;
            padding: 20px 0;
        }
        .search-box {
            display: flex;
            align-items: center;
            background: #2a2a2a;
            border-radius: 8px;
            padding: 8px 12px;
            gap: 10px;
        }
        .search-box input {
            background: #3a3a3a;
            border: none;
            color: white;
            outline: none;
        }
        .search-box input::placeholder {
            color: #888;
        }
        .search-box img {
            width: 20px;
            height: 20px;
        }
        .card-item {
            background: #2a2a2a;
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .card-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(255, 255, 255, 0.1);
        }
        .img-placeholder {
            background: #1a1a1a;
            border-radius: 8px;
            min-height: 120px;
            align-content: flex-start;
        }
        .img-placeholder img {
            object-fit: cover;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar a:hover {
            background: #3a3a3a;
        }
        .sidebar a img {
            width: 27px;
            height: 27px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-12 col-md-2 sidebar">
                <a href="{{ route('dashboard') }}">
                    <img src="icons/GridRounded.png" width="27" height="27"> Wishlist Board
                </a>
                <a href="{{ route('profile') }}">
                    <img src="icons/ProfileRounded.png" width="27" height="27"> Profile
                </a>
                <a href="{{ route('dashboard') }}">
                    <img src="icons/DarkModeRounded.png" width="27" height="27"> Dark Mode
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none;border:none;display:flex;align-items:center;gap:12px;padding:12px 20px;color:white;width:100%;">
                        <img src="icons/LogoutRounded.png" width="27" height="27"> Sign out
                    </button>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-md-10 p-4">
                <div class="mb-4">
                    <h2 class="mb-1 fw-bold">My Wishlist</h2>
                    <h2 class="mb-0 fw-bold">Board</h2>
                </div>

                <form action="{{ route('boards.search') }}" method="GET" class="search-box mb-4">
                    <input type="text" name="query" placeholder="Search" value="{{ $query ?? '' }}">
                    <img src="https://img.icons8.com/ios-filled/50/search.png">
                </form>

                <form action="{{ route('boards.store') }}" method="POST" class="mb-3 d-flex gap-2">
                    @csrf
                    <input type="text" name="name" class="form-control w-auto" placeholder="New board name" required>
                    <button type="submit" class="btn btn-light fw-bold">+ Create</button>
                </form>

                <div class="row g-4">
                    @forelse($boards as $board)
                        <div class="col-6 col-md-3">
                            <a href="{{ route('boards.show', $board->slug) }}" class="text-decoration-none text-dark">
                                <div class="card-item">
                                    <div class="img-placeholder d-flex flex-wrap p-1 gap-1">
                                        @foreach($board->thumbnailImages() as $img)
                                            <img src="{{ $img }}" style="width:48%;height:55px;object-fit:cover;border-radius:6px;">
                                        @endforeach
                                    </div>
                                    <div class="small text-muted mt-2">Rp {{ number_format($board->totalAmount(), 0, ',', '.') }}</div>
                                    <strong>{{ $board->name }}</strong>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-white">You have no boards yet. Create one to get started.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@else
    {{ redirect()->route('login') }}
@endauth
