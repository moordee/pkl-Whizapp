<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whizapp: User Profile</title>

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
            padding: 10px 30px 30px 30px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .form-control {
            border-radius: 10px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            border-top: 1px solid rgb(255, 255, 255);
            font-size: 14px;
        }

        body.dark-mode {
            background: linear-gradient(180deg,
                rgba(10,8,30,1) 0%,
                rgba(25,20,60,1) 40%,
                rgba(40,35,80,1) 100%);
            color: #e0e0e0;
        }
        body.dark-mode .form-control {
            background: rgba(255,255,255,0.1);
            color: #e0e0e0;
            border-color: rgba(255,255,255,0.2);
        }
        body.dark-mode .footer {
            color: white !important;
        }
        #save-btn:hover {
            background: white !important;
            color: #3d2fa0 !important;
        }
        html { scroll-behavior: smooth; }
    </style>
</head>

<body class="{{ Auth::check() && Auth::user()->dark_mode ? 'dark-mode' : '' }}">

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
            <a href="#"><img src="{{ asset('icons/95px_ForwardArrow.png') }}" width="27" height="27"> Share Board</a>
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

        <div class="content mt-4">
            <div class="row mb-4">
                <div class="col-md-2 text-center">
                    <input type="file" id="upload" hidden onchange="previewImage(event)">
                    <img src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : asset('img/defaultByStephanieEdwards.png') }}" class="profile-img" id="profilePreview"
                        onclick="document.getElementById('upload').click()">
                </div>

                <div class="col-md-10 d-flex flex-column justify-content-center ps-5">
                    <h3 class="fw-bold">{{ $user->name }}</h3>
                    <p class="text-light">{{ $user->email }}</p>
                </div>
            </div>

            <form action="{{ route('profile') }}" method="POST" id="profile-form" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row g-3 flex-column">
                    <div class="col-12">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                    </div>

                    <div class="col-12">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                    </div>

                    <div class="col-12">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone ?? '' }}">
                    </div>

                    <div class="col-12">
                        <label>Gender</label>
                        <input type="text" class="form-control" name="gender" value="{{ $user->gender ?? '' }}">
                    </div>

                    <div class="col-12">
                        <label>Address</label>
                        <textarea class="form-control" rows="2" name="address">{{ $user->address ?? '' }}</textarea>
                    </div>

                    <div class="col-12">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="col-12">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>

                    <div class="col-12 mt-3">
                        <button id="save-btn" class="fw-bold px-4"
                            style="display:none;background:#3d2fa0;color:white;border:none;border-radius:8px;padding:8px 24px;font-weight:600;cursor:pointer;" type="submit">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="footer text-black">Made with 🤍 by @SANA</div>

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
            <h5 class="fw-bold mb-4">Settings</h5>
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

    <script>
    function toggleSidebar() {
        document.getElementById("sidebar")
            .classList.toggle("hide");
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const imgData = reader.result;
            document.getElementById('profilePreview').src
                = imgData;
            localStorage.setItem('profileImage', imgData);
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    window.onload = function() {
        const savedImage = localStorage.getItem('profileImage');
        if (savedImage) {
            document.getElementById('profilePreview').src
                = savedImage;
        }
    }

    document.querySelectorAll(
        '#profile-form input, #profile-form textarea'
    ).forEach(el => {
        el.addEventListener('input', () => {
            document.getElementById('save-btn')
                .style.display = 'block';
        });
    });

    // Store original form values to detect changes
    const profileForm = document.getElementById('profile-form');
    const originalFormData = {};
    document.querySelectorAll('#profile-form input, #profile-form textarea').forEach(el => {
        originalFormData[el.name] = el.value;
    });

    // Reset button on successful form submission
    profileForm.addEventListener('submit', () => {
        setTimeout(() => {
            document.getElementById('save-btn').style.display = 'none';
        }, 500);
    });

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
    </script>

</body>

</html>
