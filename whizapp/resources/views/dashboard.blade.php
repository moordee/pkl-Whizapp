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
    </style>
</head>

<body>

    <!-- NAVBAR -->
   <div class="topbar">
        <img src="https://img.icons8.com/ios-filled/30/ffffff/menu--v1.png" class="menu-toggle"
            onclick="toggleSidebar()">
        <h5 class="mb-0 fw-bold">Whizapp</h5>
        <div class="ms-auto">
            <img src="icons/Doorbell.png" width="50" height="30">
        </div>
    </div>

    <div class="d-flex" style="min-height: calc(100vh - 60px);">

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
        <!-- CONTENT -->
        <div class="content p-4 w-100">

            <div class="mb-4">

                <!-- BARIS 1 -->
                <h2 class="mb-1 fw-bold">My Wishlist</h2>

                <!-- BARIS 2 -->
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold">Board</h2>

                    <div class="search-box">
                        <input type="text" placeholder="Search">
                        <img src="https://img.icons8.com/ios-filled/50/search.png">
                    </div>
                </div>

            </div>

            <div class="row g-4">

                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card-item">
                        <div class="img-placeholder"></div>
                        <div class="small text-muted mt-2">Price</div>
                        <strong>Stuff</strong>
                    </div>
                </div>



            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="text-black">
        Made with 🤍 by @SANA
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("hide");
        }
    </script>

</body>

</html>
