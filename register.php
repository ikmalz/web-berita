<?php
include "connect-login.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-white">
    <section class="bg-white">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-black">
                <img class="w-8 h-8 mr-2" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcuJQyfnMnMPhYZApg0wQIK48w94-nzFEG8Q&s" alt="logo">
            </a>
            <div class="w-full p-6 bg-white rounded-lg shadow sm:max-w-md">
                <div class="mt-6 flex items-center justify-between">
                    <a href="login.php" class="text-black text-3xl leading-9 font-bold">
                        <i class='bx bx-chevron-left'></i>
                    </a>
                    <h2 class="text-center text-3xl leading-9 font-extrabold text-black">Register</h2>
                    <div></div> <!-- Placeholder to balance the layout -->
                </div>
                <?php if ($error) : ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" action="login.php" method="post">
                <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                        <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="username" required="">
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Masukkan Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Contoh@gmail.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Masukan password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                    </div>
                    <div>
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="newsletter" aria-describedby="newsletter" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300" required="">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="newsletter" class="font-light text-gray-500">Saya <a class="font-medium text-primary-600 hover:underline" href="#">Menerima syarat dan ketentuan yang berlaku👌</a></label>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="register"> <!-- Tambahkan input hidden untuk action -->
                    <button type="submit" name="action" value="register" class="w-full text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">kirim</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
