<?php
include "connect.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="relative">
    <a href="landingpage.php" class="absolute top-0 left-0 mt-4 ml-4">
        <i class='bx bxs-chevron-left text-4xl text-black'></i>
    </a>
    <section class="bg-gray-100 min-h-screen flex items-center">
        <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                <div class="max-w-lg mx-auto md:mx-0">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">tentang saya</h2>
                    <p class="mt-4 text-gray-600 text-sm">Sejak duduk di bangku Sekolah Menengah Kejuruan (SMK), saya telah memiliki minat yang kuat dalam dunia pemrograman. Ketika masih di SMK, saya mengambil jurusan yang berkaitan dengan teknologi informasi, di mana saya belajar dasar-dasar pemrograman, pengembangan perangkat lunak, dan teknologi jaringan komputer.</p>
                </div>
                <div class="mt-12 md:mt-0 mx-auto md:mx-0">
                    <img src="https://images.unsplash.com/photo-1531973576160-7125cd663d86" alt="About Us Image" class="object-cover rounded-lg shadow-md">
                </div>
            </div>
        </div>
    </section>
</body>
</html>
