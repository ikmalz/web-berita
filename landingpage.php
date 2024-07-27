<?php
include "connect.php";

$showModal = false;
$searchQuery = '';

if (isset($_GET['edit'])) {
    $imageId = $_GET['edit'];
    $showModal = true;
}

if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM web_berita1 WHERE judul_berita LIKE '%$searchQuery%' ORDER BY id ASC";
} else {
    $sql = "SELECT * FROM web_berita1 ORDER BY id ASC";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Error: " . mysqli_errno($conn) . " - " . mysqli_error($conn));
}

$noResultsFound = mysqli_num_rows($result) === 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .navbar-button {
            position: relative;
        }

        .eye-icon-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .image-container:hover .eye-icon-container {
            opacity: 1;
        }

        .eye-icon {
            font-size: 2rem;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]:checked+label .eye-icon {
            opacity: 1;
        }

        label {
            display: block;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .icon-container {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.14s ease-in-out;
        }

        .image-container:hover .overlay {
            opacity: 1;
        }

        .image-container a img:hover {
            transform: scale(1.1);
            /* Efek membesar saat hover */
        }

        .image-container {
            border-bottom: 1px solid #E5E7EB;
            /* Warna garis dan ketebalan dapat disesuaikan */
            padding-bottom: 20px;
            /* Spasi antara setiap item */
            margin-bottom: 20px;
            /* Spasi bawah untuk item terakhir */
        }

        .profile-button {
            position: absolute;
            top: 10px;
            right: 20px;
            z-index: 1000;
        }

        .profile-button button {
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .profile-button button i {
            margin-right: 5px;
        }

        .small-image {
            height: 20vh;
        }

        @media (min-width: 640px) {
            .small-image {
                height: 25vh;
            }
        }

        @media (min-width: 1024px) {
            .small-image {
                height: 30vh;
            }
        }

        .dissolve {
            animation: dissolve 0.5s forwards;
        }

        @keyframes dissolve {
            to {
                opacity: 0;
                transform: scale(0.8);
            }
        }

        /* Loading animation styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            display: none;
            /* Hidden by default */
        }

        .spinner {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #00A587;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <header class="bg-[#00A587] shadow font-poppins">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Home Button -->
                <div class="flex items-center">
                    <a class="block text-teal-600" href="#">
                        <i class='bx bx-wink-smile text-5xl text-white'></i>
                        <span class="sr-only">Home</span>
                    </a>
                    <button type="submit" class="navbar-button text-gray-500 transition font-bold text-lg ml-4">Home</button>
                </div>
                <!-- Search Form -->
                <div class="flex items-center">
                    <form action="" method="GET" class="flex items-center" id="searchForm">
                        <input type="text" name="search" placeholder="Cari judul berita..." class="px-4 py-2 border rounded-md">
                        <button type="submit" class="ml-2 px-4 py-2 bg-teal-600 text-white rounded-md">Cari</button>
                    </form>
                </div>
            </div>
            <div class="profile-button">
                <a href="crud.php">
                    <button type="button">
                        <i class='bx bx-user-circle'></i> Profile <!-- Ganti dengan ikon yang diinginkan -->
                    </button>
                </a>
            </div>
        </div>
    </header>

    <div class="flex justify-center mt-4 text-lg text-gray-500">
        <span id="waktu-saat-ini">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $nama_hari = array(
                'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
            );
            $hari_ini = $nama_hari[date('w')];
            $waktu_jakarta = date('d F Y H:i:s');
            echo "Waktu saat ini: $hari_ini, $waktu_jakarta";
            ?>
        </span>
    </div>

    <script>
        function updateClock() {
            var now = new Date();
            var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][now.getDay()];
            var waktu = now.getDate() + ' ' + ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][now.getMonth()] + ' ' + now.getFullYear() + ' ' + now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes() + ':' + (now.getSeconds() < 10 ? '0' : '') + now.getSeconds();
            document.getElementById('waktu-saat-ini').textContent = "Waktu saat ini: " + hari + ", " + waktu;
        }

        setInterval(updateClock, 1000);

        updateClock();
    </script>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <div class="container mx-auto mt-20 font-poppins border-black">
    <?php
        if (mysqli_num_rows($result) > 0) {
        ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="image-container relative" style="text-align: center;">
                        <a href="eyes.php?id=<?php echo $row['id']; ?>" style="display: inline-block; width: 100%; max-width: 350px;">
                            <img alt="img" src="<?php echo $row['gambar_1']; ?>" style="width: 100%; height: auto; object-fit: cover; border-radius: 8px; transition: transform 0.3s; display: block;" />
                        </a>
                        <div class="text-content" style="text-align: left; padding-top: 5px; width:85%; padding-left:80px;">
                            <p style="margin-top: 4px; font-size: 14px; font-weight: bold;">
                                <?php echo $row['nama_penulis']; ?>
                            </p>
                            <p style="margin-top: 8px; text-align: justify; font-size: 15px; line-height: 1.4;">
                                <?php echo $row['judul_berita']; ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>


        <?php } else { ?>
            <div class="text-center text-gray-500">
                <p>Maaf, belum ada berita.</p>
            </div>
        <?php } ?>
    </div>


    <script>
        // Show loading overlay on form submit
        document.getElementById('searchForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        });

        document.getElementById('loginLink').addEventListener('click', function(event) {
            event.preventDefault();
            document.body.classList.add('dissolve');
            setTimeout(function() {
                window.location.href = event.target.href;
            }, 900);
        });
    </script>
</body>

</html>