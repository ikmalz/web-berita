<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include "connect.php";

$user_id = null;
$username = '';


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  $query = "SELECT username FROM users1 WHERE id = $user_id";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
  }
} else {
  header("Location: login.php");
  exit();
}


if (isset($_GET['action']) && $_GET['action'] === 'toggleModal') {
  $showModal = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
    }

    #editForm {
      display: none;
      justify-content: center;
      /* Center horizontally */
      align-items: center;
    }

    body.modal-open {
      overflow: hidden;
    }

    .navbar-button {
      position: relative;
    }

    .modal {
      display: <?php echo $showModal ? 'block' : 'none'; ?>;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      animation: fadeIn 0.3s ease;
    }

    .modal-content {
      margin: 10% auto;
      padding: 20px;
      border-radius: 5px;
      width: 50%;
      max-width: 500px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes fadeOut {
      from {
        opacity: 1;
      }

      to {
        opacity: 0;
      }
    }

    .modal.fade-out {
      animation: fadeOut 0.3s ease;
    }

    ::-webkit-scrollbar {
      width: 12px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background: gray;
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .alert {
      border: 1px solid;
      padding: 10px 15px;
      margin-bottom: 10px;
      border-radius: 4px;
    }

    .alert-success {
      background-color: gray;
      border-color: #badbcc;
      color: #0f5132;
    }

    .alert-info {
      background-color: #d1ecf1;
      border-color: #bbe1eb;
      color: #0c5460;
    }

    .alert-danger {
      background-color: #f8d7da;
      border-color: #f5c6cb;
      color: #721c24;
    }
  </style>

  </style>
</head>

<body>
  <header class="bg-[#00A587] shadow font-poppins">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="md:flex md:items-center md:gap-12">
          <a class="block text-teal-600" href="#">
            <i class='bx bx-wink-smile text-5xl text-white'></i>
          </a>
        </div>
        <div class="hidden md:block">
          <nav aria-label="Global">
            <ul class="flex items-center gap-6 text-sm">
              <li>
                <a href="landingpage.php" class="items-center">
                  <input type="hidden" name="toggle_click" value="home">
                  <button type="submit" class="navbar-button items-center hover:text-gray-500 text-white transition text-lg font-bold <?php echo isset($clickedItems['home']) ? 'underline-clicked' : ''; ?>">Home</button>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="flex items-center gap-4">
          <?php
          if (isset($_SESSION['user_id'])) {
            echo '
           <form action="connect-login.php" method="post" class="sm:flex sm:gap-4">
                <button type="submit" name="action" value="logout" onclick="return confirm(\'Apakah Anda yakin akan logout?\')" class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow transition hover:text-gray-500/75"> Logout </button>
            </form>';
          } else {
            echo '
           <div class="sm:flex sm:gap-4">
                <a class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow transition hover:text-gray-500/75" href="login.php"> Login </a>
           </div>';
          }
          ?>

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


  <div class="flex flex-col items-center gap-4 px-4 py-2 text-black" style="margin-top: 2rem;">
    <div class="flex items-center gap-2">
      <div class="relative">
        <i class='bx bx-user-circle text-7xl'></i>
      </div>
      <div class="flex flex-col items-center">
        <div class="flex items-center">
          <span class="block font-semibold text-2xl"><?php echo htmlspecialchars($username); ?></span>
        </div>
      </div>
    </div>
  </div>

  <div class="flex min-h-screen items-center justify-center relative">
    <div class="flex flex-col items-center justify-center min-h-[450px] w-full max-w-7xl px-4 sm:px-6 lg:px-8 mt-[-220px]">
      <div class="flex justify-between w-full mb-4 items-center">
        <a href="?action=tambah">
          <i class='bx bx-plus-circle text-4xl text-green-600 cursor-pointer'></i>
        </a>
      </div>
      <div class="w-full mb-4 relative">
        <div class="flex">
          <input type="text" id="searchInput" placeholder="Cari judul berita..." class="w-full px-4 py-2 border border-gray-300 rounded-l-lg">
          <button id="searchButton" class="bg-[#00A587] text-white px-4 py-2 rounded-r-lg">
            <i class='bx bx-search-alt text-xl'></i>
          </button>
        </div>
        <div id="searchHistory" class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-b-lg shadow-md hidden z-10"></div>
      </div>
      <div class="overflow-x-auto relative shadow-md sm:rounded-lg w-full max-h-[500px]">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-fixed">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0 z-10">
            <tr>
              <th class="py-3 px-6 w-10">No</th>
              <th scope="col" class="py-3 px-6 w-24">
                <div class="flex items-center">
                  <i class='bx bx-image text-xl text-gray-700 cursor-pointer mr-2'></i>
                  <span>Foto</span>
                </div>
              </th>
              <th scope="col" class="py-3 px-6 w-1/4">Judul</th>
              <th scope="col" class="py-3 px-6 w-1/3">Teks Berita</th>
              <th scope="col" class="py-3 px-6 text-center w-24">Aksi</th>
            </tr>
          </thead>
          <tbody id="newsTableBody">
            <?php
            $query = "SELECT * FROM web_berita1";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
              $nomor = 1;
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700'>";
                echo "<td class='py-4 px-6'>" . $nomor . "</td>";
                echo "<td class='py-4 px-6'><img src='" . $row['gambar_1'] . "' alt='Foto Berita' class='w-16 h-16 object-cover'></td>";
                echo "<td class='py-4 px-6'>" . htmlspecialchars($row['judul_berita']) . "</td>";
                echo "<td class='py-4 px-6 truncate'>" . htmlspecialchars($row['deskripsi']) . "</td>";
                echo "<td class='py-4 px-6 text-center'>
                                  <div class='flex justify-center'>
                                    <a href='edit_image.php?id=" . $row['id'] . "' class='text-blue-600 hover:text-blue-900 mr-2'>
                                      <i class='bx bxs-edit'></i>
                                    </a>
                                    <form method='POST' action='delete_image.php'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <button type='submit' onclick='return confirm(\"Are you sure you want to delete this item?\")' class='text-red-600 hover:text-red-900'>
                                    <i class='bx bxs-trash'></i>
                                    </button>
                                    </form>
                                  </div>
                                </td>";
                echo "</tr>";
                $nomor++;
              }
            } else {
              echo "<tr><td colspan='6' class='text-center py-4'>No news available</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const searchButton = document.getElementById('searchButton');
      const newsTableBody = document.getElementById('newsTableBody');

      searchButton.addEventListener('click', function() {
        const searchText = searchInput.value.trim().toLowerCase();
        if (searchText !== '') {
          // Add search history functionality here if needed

          // Perform search
          filterTable(searchText);
        }
      });

      function filterTable(searchText) {
        const rows = newsTableBody.getElementsByTagName('tr');
        let found = false;

        for (let i = 0; i < rows.length; i++) {
          const titleCell = rows[i].getElementsByTagName('td')[2];
          if (titleCell) {
            const titleText = titleCell.textContent.toLowerCase();
            if (titleText.includes(searchText)) {
              rows[i].style.transition = 'background-color 1s';
              rows[i].style.backgroundColor = 'white';
              if (!found) {
                rows[i].scrollIntoView({
                  behavior: 'smooth',
                  block: 'center'
                });
                found = true;
              }
              // Set a timeout to remove the highlight after 1 second
              setTimeout(() => {
                rows[i].style.backgroundColor = '';
              }, 1000);
            } else {
              rows[i].style.backgroundColor = '';
            }
          }
        }
      }
    });
  </script>

  <?php
  if (isset($_GET['pesan'])) {
    $pesan = $_GET['pesan'];
    if ($pesan == "input") {
      echo "<p class='alert-success'>Data berhasil di input.</p>";
    } else if ($pesan == "update") {
      echo "<p class='alert-info'>Data berhasil di update.</p>";
    } else if ($pesan == "hapus") {
      echo "<p class='alert-danger'>Data berhasil di hapus.</p>";
    } else if ($pesan == "error") {
      echo "<p class='alert-danger'>Terjadi kesalahan saat menghapus data.</p>";
    } else if ($pesan == "invalid_id") {
      echo "<p class='alert-danger'>ID tidak valid.</p>";
    }
  }
  ?>


  <footer class="bg-gray-900 py-5 w-full bottom-0" style="margin-bottom: -12rem;">
    <p class="text-center text-gray-400">&copy; 2024 tugas web berita ikmal fairuz.</p>
  </footer>


  <!-- Modal toggle -->
  <div class="flex justify-center m-5">
    <a href="?action=<?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ? 'toggleModal' : 'edit'; ?>" id="updateProductButton" class="block text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="button" onclick="toggleModal()">
      <?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ? 'Edit Product' : 'Update Product'; ?>
    </a>
  </div>

  <!-- Main modal -->
  <div id="myModal" class="modal" style="<?php echo $showModal ? '' : 'display: none;'; ?>">
    <div class="modal-content" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 999;">
      <span class="close" onclick="closeModal()">&times;</span>
      <div class="relative p-4 rounded-lg shadow dark:bg-gray-800 sm:p-5 mb-96">
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ? 'Edit Product' : 'Tambah Product'; ?>
          </h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal()">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <form action="connect.php" enctype="multipart/form-data" method="post">
          <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div>
              <label for="berita" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berita</label>
              <input type="text" name="berita" id="berita" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Judul berita">
            </div>
            <div>
              <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
              <input type="date" name="tanggal" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tanggal">
            </div>
            <div class="sm:col-span-2">
              <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
              <textarea name="description" id="description" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Deskripsi berita"></textarea>
            </div>
            <div class="sm:col-span-2">
              <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unggah Foto</label>
              <input type="file" name="image" id="image" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
              Update product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleModal() {
      var modal = document.getElementById('myModal');
      var displayValue = modal.style.display;
      if (displayValue === 'none' || displayValue === '') {
        modal.style.display = 'block';
        setTimeout(function() {
          modal.classList.add('fade-in');
        }, 50);
      } else {
        modal.classList.remove('fade-in');
        setTimeout(function() {
          modal.style.display = 'none';
        }, 300);
      }
    }

    function closeModal() {
      var modal = document.getElementById('myModal');
      modal.classList.remove('fade-in');
      setTimeout(function() {
        modal.style.display = 'none';
      }, 300);
    }
  </script>

</body>

</html>