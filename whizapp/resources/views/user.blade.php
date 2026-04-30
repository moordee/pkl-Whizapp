<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whizapp: User Profile</title>

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
    </style>
</head>

<body>

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
            <a href="#"><img src="icons/LogoutRounded.png" width="27" height="27"> Log out</a>
        </div>

        <div class="content mt-4">
            <div class="row mb-4">
                <div class="col-md-2 text-center">
                    <input type="file" id="upload" hidden onchange="previewImage(event)">

                    <!-- DEFAULT FOTO (tidak random lagi) -->
                    <img src="img/ibu.jpg" class="profile-img" id="profilePreview"
                        onclick="document.getElementById('upload').click()">
                </div>

                <div class="col-md-10 d-flex flex-column justify-content-center ps-5 ">
                    <h3 class="fw-bold">Alinika Prisella Maheswari</h3>
                    <p class="text-light">alinika_sella@gmail.com</p>
                </div>
            </div>

            <div class="row g-3 flex-column">
                <div class="col-12">
                    <label>Full Name</label>
                    <input type="text" class="form-control" value="Alinika Prisella Maheswari">
                </div>

                <div class="col-12">
                    <label>Email</label>
                    <input type="email" class="form-control" value="alinika_sella@gmail.com">
                </div>

                <div class="col-12">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" value="+62 8512-3011-9557">
                </div>

                <div class="col-12">
                    <label>Gender</label>
                    <input type="text" class="form-control" value="Perempuan">
                </div>

                <div class="col-12">
                    <label>Address</label>
                    <textarea class="form-control" rows="2">Jl. Merdeka No. 10, Bandung, Jawa Barat, 40111</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="footer text-black" ">
        Made with 🤍 by @SANA
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("hide");
        }

        // PREVIEW + SIMPAN FOTO
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgData = reader.result;

                document.getElementById('profilePreview').src = imgData;

                // simpan ke localStorage
                localStorage.setItem('profileImage', imgData);
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // AMBIL SAAT REFRESH
        window.onload = function() {
            const savedImage = localStorage.getItem('profileImage');
            if (savedImage) {
                document.getElementById('profilePreview').src = savedImage;
            }
        }
    </script>

</body>

</html>
