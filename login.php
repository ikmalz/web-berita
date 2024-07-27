<?php
include "connect-login.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
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
    </style>
</head>

<body>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-10 w-auto" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcuJQyfnMnMPhYZApg0wQIK48w94-nzFEG8Q&s" alt="Workflow">
            <div class="mt-6 flex items-center justify-between">
                <a id="loginlink" href="landingpage.php" class="text-gray-900 text-3xl leading-9 font-extrabold">
                    <i class='bx bx-chevron-left'></i>
                </a>
                <h2 class="text-center text-3xl leading-9 font-extrabold text-gray-900">Login</h2>
                <div></div> <!-- Placeholder to balance the layout -->
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form method="post" action="connect-login.php">
                    <div>
                        <!-- input email -->
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Masukan Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="email" name="email" placeholder="Contoh@gmail.com" type="email" required="" value="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            <div class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <!-- input password -->
                        <label for="password" class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="password" name="password" type="password" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" value="1" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                            <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">Ingat saya</label>
                        </div>

                        <div class="text-sm leading-5">
                            <a href="register.php" class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                Register </a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <input type="hidden" name="action" value="login">
                            <button type="submit" class="w-full flex justify-center hover:bg-gray-700 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Masuk </button>
                        </span>
                    </div>
                </form>
                <?php
                if (isset($error)) {
                    echo "<p class='mt-6 text-center text-red-500'>$error</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
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