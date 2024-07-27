<?php
include 'connect.php';

$id = $_GET['id'] ?? null;

//untuk tidak melanjutkan eksekusi jika suatu variabel yang diperlukan tidak tersedia atau belum diatur.
if (!isset($id)) {
    echo "ID web_berita tidak ditemukan.";
    exit;
}

$sql = "SELECT * FROM web_berita1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Berita tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['judul_berita']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar-button {
            position: relative;
        }

        .selectable-text {
            user-select: text;
        }

        .profile-button {
            position: fixed;
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


        .container::-webkit-scrollbar {
            display: none;
        }

        .container {
            white-space: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            width: 100%;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        ::-webkit-scrollbar {
            width: 9px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: teal;
            border-radius: 15px;
        }

        ::-webkit-scrollbar-track {
            background-color: white;
            width: 50px;
        }

        #header {
            transition: top 0.3s;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            overflow: hidden;
        }

        .overlay.open {
            opacity: 1;
        }

        .expanded-img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body>
    <!--header-->
    <header id="header" class="bg-[#00A587] shadow font-poppins fixed top-0 w-full z-50" style="background-color: #00A587; backdrop-filter: blur(5px);">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="md:flex md:items-center md:gap-12">
                    <a class="block text-teal-600" href="#">
                        <i class='bx bx-wink-smile text-5xl text-white'></i>
                        <span class="sr-only">Home</span>
                    </a>
                </div>
                <div class="hidden md:block">
                    <nav aria-label="Global">
                        <ul class="flex items-center gap-6 text-sm">
                            <li>
                                <a href="landingpage.php">
                                    <input type="hidden" name="toggle_click" value="home">
                                    <button type="submit" class="navbar-button text-green-800 transition text-white text-lg">Home</button>
                                </a>
                            </li>
                            <li>
                                <div class="profile-button">
                                    <a href="crud.php">
                                        <button type="button">
                                            <i class='bx bx-user-circle'></i> Profile
                                        </button>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <div class="block md:hidden">
                        <button class="rounded bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var header = document.getElementById('header');
            var lastScrollTop = 0;

            window.addEventListener('scroll', function() {
                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > lastScrollTop) {
                    header.style.top = '0';
                } else {
                    header.style.top = '-64px';
                }

                lastScrollTop = scrollTop;
            });
        });
    </script>

    <!--end header-->
    <a href="landingpage.php">
        <i class='bx bxs-chevron-left text-4xl pt-20 pl-16'></i>
    </a>
    <!--berita-->
    <div class="px-4 py-8">
        <div class="text-center cursor-pointer">
            <h1 class="text-3xl font-extrabold sm:text-xl w-sm">
                <?php echo htmlspecialchars($row['judul_berita']); ?>
            </h1>
        </div>
    </div>

    <a href="#" class="group block max-w-5xl mx-auto mt-0">
        <h2 class="mt-4"><?php echo htmlspecialchars($row['nama_penulis']); ?></h2>
        <div class="relative h-[450px] sm:h-[350px] mt-4">
            <div onclick="openImage('<?php echo htmlspecialchars($row['gambar_1']); ?>')" style="cursor: pointer;">
                <img src="<?php echo htmlspecialchars($row['gambar_1']); ?>" alt="img" class="absolute inset-0 h-full w-full object-cover rounded-lg transition duration-300 transform hover:scale-105" />
            </div>
        </div>

        <script>
            function openImage(imageUrl) {
                var overlay = document.createElement('div');
                overlay.classList.add('overlay');

                var img = document.createElement('img');
                img.src = imageUrl;
                img.classList.add('expanded-img');

                overlay.appendChild(img);

                document.body.appendChild(overlay);

                overlay.addEventListener('click', function() {
                    overlay.classList.remove('open');
                    setTimeout(function() {
                        document.body.removeChild(overlay);
                    }, 300);
                });

                setTimeout(function() {
                    overlay.classList.add('open');
                }, 50);
            }
        </script>


        <?php
        date_default_timezone_set('Asia/jakarta');
        ?>
        <div class="mt-3 mb-10 flex">
            <h3 class="text-sm text-gray-700 group-hover:underline group-hover:underline-offset-4">
                <?php
                $tanggal_penulisan = new DateTime($row['tanggal_penulisan']);
                echo htmlspecialchars($tanggal_penulisan->format('Y-m-d'));
                ?>
                <h3 class="text-sm text-gray-700 ml-1 mb-1.5 group-hover:underline group-hover:underline-offset-4">
                    <?php
                    echo date('H:i');
                    ?>
                </h3>
            </h3>
        </div>
        <div class="text-center text-justify mb-10 selectable-text cursor-text">
            <h3>
                <span class="font-bold"><?php echo htmlspecialchars($row['nama_penulis']); ?></span>
                <span><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></span>
            </h3>
        </div>
    </a>
    <br>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[120px_1fr] lg:gap-8">
        <div class="h-96 w-96 rounded-lg bg-gray-200 relative" style="margin-left: 24rem; width: 50rem;">
            <div class="absolute inset-0 flex justify-center">
                <p class="text-sm text-gray-400 mt-2">*iklan aja bosku</p>
            </div>
        </div>
    </div>

    <div class="ml-72   mb-6 mt-28 relative">
        <hr class="absolute h-12 border-r-4 border-green-400" style="left: -2rem; top:-10px;">
        <h4 class="text-base font-bold inline-block bg-white px-2 cursor-pointer">Baca Juga:</h4>
    </div>


    <div class="container flex mb-14 overflow-x-auto overflow-y-hidden mt-14">
        <article class="group max-w-md p-9">
            <img alt="" src="https://akcdn.detik.net.id/community/media/visual/2024/01/17/shin-tae-yong_169.jpeg?w=700&q=90" class="h-28 w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]" />

            <div class="p-4">
                <a href="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.bola.net%2Finggris%2Fmanchester-united-blokir-keinginan-alejandro-garnacho-perkuat-timnas-argentina-di-olimpiade-2-bcb140.html&psig=AOvVaw0jafH-ns92rZHnphObKavH&ust=1718248701345000&source=images&cd=vfe&opi=89978449&ved=0CAcQrpoMahcKEwjAjoStjdWGAxUAAAAAHQAAAAAQBA">
                    <h3 class="text-lg font-medium text-gray-900 text-justify">Manchester United Blokir Keinginan <br>Alejandro Garnacho
                        Perkuat Timnas <br> Argentina di Olimpiade 2024</h3>
                </a>

                <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae dolores, possimus
                    pariatur animi temporibus nesciunt praesentium dolore sed nulla ipsum eveniet corporis quidem,
                    mollitia itaque minus soluta, voluptates neque explicabo tempora nisi culpa eius atque
                    dignissimos. Molestias explicabo corporis voluptatem?
                </p>
            </div>
        </article>
        <br>
        <article class="group max-w-md p-9">
            <img alt="" src="https://akcdn.detik.net.id/community/media/visual/2024/01/17/shin-tae-yong_169.jpeg?w=700&q=90" class="h-28 w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]" />

            <div class="p-4">
                <a href="#">
                    <h3 class="text-lg font-medium text-gray-900">Indonesia Vs Irak: <br> Shin Tae-yong Sayangkan Kesalahan <br> Individu Garuda</h3>
                </a>

                <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur elit. Recusandae dolores, possimus
                    pariatur animi temporibus nesciunt praesentium dolore sed nulla ipsum eveniet corporis quidem,
                    mollitia itaque minus soluta, voluptates neque explicabo tempora nisi culpa eius atque
                    dignissimos. Molestias explicabo corporis voluptatem?
                </p>
            </div>
        </article>
        <br>
        <article class="group max-w-md p-9">
            <img alt="" src="https://akcdn.detik.net.id/community/media/visual/2024/06/06/indonesia-vs-irak-di-kualifikasi-piala-dunia-2026-2_169.jpeg?w=700&q=90" class="h-28 w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]" />

            <div class="p-4">
                <a href="#">
                    <h3 class="text-lg font-medium text-gray-900">Guardiola Dikabarkan Akan Hengkang, <br> Bos Man City Santa</h3>
                </a>

                <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae dolores, possimus
                    pariatur animi temporibus nesciunt praesentium dolore sed nulla ipsum eveniet corporis quidem,
                    mollitia itaque minus soluta, voluptates neque explicabo tempora nisi culpa eius atque
                    dignissimos. Molestias explicabo corporis voluptatem?
                </p>
            </div>
        </article>
        <article class="group max-w-md p-9">
            <img alt="" src="https://akcdn.detik.net.id/community/media/visual/2024/01/16/indonesia-vs-irak-2_169.jpeg?w=700&q=90" class="h-28 w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]" />

            <div class="p-4">
                <a href="#">
                    <h3 class="text-lg font-medium text-gray-900">Skenario Timnas Indonesia Lolos ke <br> Babak Ketiga Kualifikasi Piala Dunia <br> 2026</h3>
                </a>

                <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae dolores, possimus
                    pariatur animi temporibus nesciunt praesentium dolore sed nulla ipsum eveniet corporis quidem,
                    mollitia itaque minus soluta, voluptates neque explicabo tempora nisi culpa eius atque
                    dignissimos. Molestias explicabo corporis voluptatem?
                </p>
            </div>
        </article>
        <article class="group max-w-md p-9">
            <img alt="" src="https://akcdn.detik.net.id/community/media/visual/2024/06/06/romelu-lukaku-1_169.jpeg?w=700&q=90" class="h-28 w-full rounded-xl object-cover shadow-xl transition group-hover:grayscale-[50%]" />

            <div class="p-4">
                <a href="#">
                    <h3 class="text-lg font-medium text-gray-900">Chelsea Takkan Lagi Pinjamkan <br> Lukaku Musim Depan</h3>
                </a>

                <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae dolores, possimus
                    pariatur animi temporibus nesciunt praesentium dolore sed nulla ipsum eveniet corporis quidem,
                    mollitia itaque minus soluta, voluptates neque explicabo tempora nisi culpa eius atque
                    dignissimos. Molestias explicabo corporis voluptatem?
                </p>
            </div>
        </article>
    </div>


    <!--Footer container-->
    <footer class="flex flex-col items-center bg-teal-500 text-center text-surface w-800">
        <div class="container p-6">
            <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-6">
                <div class="mb-6 lg:mb-0">
                    <img src="https://cdn.vox-cdn.com/thumbor/ysAAKEgDzsYQOvJ0ZIG1FeUf5eQ=/0x62:4000x2729/1200x800/filters:focal(0x62:4000x2729)/cdn.vox-cdn.com/uploads/chorus_image/image/31053649/482053589.0.jpg   " class="w-full rounded-md shadow-lg" />
                </div>
                <div class="mb-6 lg:mb-0">
                    <img src="https://akcdn.detik.net.id/visual/2024/05/08/fbl-eur-c1-dortmund-psg_169.jpeg?w=400&q=90" class="w-full rounded-md shadow-lg" />
                </div>
                <div class="mb-6 lg:mb-0">
                    <img src="https://scorelyst.com/wp-content/uploads/2024/05/Borussia-Dortmund-vs-Real-Madrid.webp" class="w-full rounded-md shadow-lg" />
                </div>
                <div class="mb-6 lg:mb-0">
                    <img src="https://thumbor.prod.vidiocdn.com/DU5arDMONPxHiwspdvjMghixRPc=/filters:quality(70)/vidio-web-prod-video/uploads/video/image/8198898/promo-ucl-final-dortmund-vs-real-madrid-000177.jpg" class="w-full rounded-md shadow-lg" />
                </div>
                <div class="mb-6 lg:mb-0">
                    <img src="https://i.ytimg.com/vi/dpXdoFt5I-k/maxresdefault.jpg" class="w-full rounded-md shadow-lg" />
                </div>
                <div class="mb-6 lg:mb-0">
                    <img src="https://radarlebong.bacakoran.co/upload/a36454450c706ad64110fc52119d1a5b.jpeg" class="w-full rounded-md shadow-lg" />
                </div>
            </div>
        </div>

        <!--Copyright section-->
        <div class="px-4 py-8 sm:px-6 lg:px-8 mb-10"> <!-- Mengubah nilai py-16 menjadi py-8 -->
            <p class="mx-auto mt-6 max-w-xl text-center leading-relaxed text-white text-center">
                Sekian berita yang dapat kami sampaikan untuk hari ini saya Ikmal fairuz, pembawa acara di web pada sore hari ini pamit undur diri dan sampai jumpa pada waktu yang sama esok hari. Selamat sore
            </p>

            <ul class="mt-12 flex flex-wrap justify-center gap-6 md:gap-8 lg:gap-12">
                <li>
                    <a class="text-white transition hover:bg-gray-700/75 px-3 py-2.5 rounded font-bold" href="about.php"> About </a>
                </li>

                <li>
                    <a class="text-white transition hover:bg-gray-700/75 px-3 py-2.5 rounded font-bold" href="crud.php"> Data berita </a>
                </li>
            </ul>

            <div class="flex justify-center mt-6">
                <!-- Tombol berbagi Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://domainanda.com/berita.php?id=' . $id); ?>" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-blue-500 mx-2">
                    <i class='bx bxl-facebook-square text-3xl'></i>
                    <span class="sr-only">Bagikan ke Facebook</span>
                </a>

                <!-- Tombol berbagi Twitter -->
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('https://domainanda.com/berita.php?id=' . $id); ?>&text=<?php echo urlencode($row['judul_berita']); ?>" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-blue-500 mx-2">
                    <i class='bx bxl-twitter text-3xl'></i>
                    <span class="sr-only">Bagikan ke Twitter</span>
                </a>

                <!-- Tombol berbagi WhatsApp -->
                <a href="whatsapp://send?text=<?php echo urlencode($row['judul_berita'] . ' - https://chatgpt.com/c/9829253f-f47b-4ff0-bbee-57cb46a3cec6?model=auto' . $id); ?>" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-green-500 mx-2">
                    <i class='bx bxl-whatsapp text-3xl'></i>
                    <span class="sr-only">Bagikan ke WhatsApp</span>
                </a>
            </div>


            <ul class="mt-12 flex justify-center gap-6 md:gap-8">
                <li>
                    <a href="https://www.instagram.com/ikmlfrz/" rel="noreferrer" target="_blank" class="text-white transition hover:text-gray-700/75">
                        <span class="sr-only">Instagram</span>
                        <i class='bx bxl-instagram h-6 w-6'></i>
                    </a>
                </li>

                <li>
                    <a href="https://github.com/ikmalz/ikmalzgithub.io" rel="noreferrer" target="_blank" class="text-white transition hover:text-gray-700/75">
                        <span class="sr-only">GitHub</span>
                        <i class='bx bxl-github h-6 w-6'></i>
                    </a>
                </li>
            </ul>

        </div>

    </footer>
    <!--footer-->


</body>

</html>