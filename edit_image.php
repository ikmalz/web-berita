<?php
include "connect.php";

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "SELECT * FROM web_berita1 WHERE id='$id'";
  $result = mysqli_query($conn, $query);

  if (!$result) {
    die("Query Error: " . mysqli_errno($conn) . " - " . mysqli_error($conn));
  }

  $data = mysqli_fetch_assoc($result);

  if (!$data) {
    echo "<script>alert('Data tidak ditemukan pada database');window.location='crud.php';</script>";
  }
} else {
  echo "<script>alert('Masukkan ID.');window.location='crud.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Edit Berita</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="overflow-hidden">
  <header class="bg-[#00A587] shadow font-poppins">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="md:flex md:items-center md:gap-12">
          <a class="block text-teal-600" href="#">
            <i class='bx bx-wink-smile text-5xl text-white'></i>
          </a>
        </div>
      </div>
    </div>
  </header>
  <div class="flex min-h-screen items-center justify-center pb-20">
    <div class="bg-[#1C1D33] text-white p-6 rounded-lg shadow-md w-full max-w-lg">
      <button>
        <a href="crud.php">
          <h2 class="text-2xl font-bold mb-6 text-3xl"><i class='bx bxs-chevron-left-circle'></i> Edit Berita</h2>
        </a>
      </button>
      <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <div class="mb-4">
          <label for="judul" class="block text-xs font-medium text-white">Judul</label>
          <input type="text" name="judul" id="judul" value="<?php echo $data['judul_berita']; ?>" class="mt-1 p-2 bg-[#46435F] w-full rounded-md text-xs">
        </div>

        <div>
          <label for="tanggal" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Tanggal</label>
          <input type="date" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d', strtotime($data['tanggal_penulisan'])); ?>" class="bg-gray-50 text-xs border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
          </div>

        <div class="mb-4">
          <label for="pengarang" class="block text-xs font-medium text-white">penulis</label>
          <input type="text" name="pengarang" id="pengarang" value="<?php echo $data['nama_penulis']; ?>" class="mt-1 text-xs p-2 w-full bg-[#46435F] rounded-md">
        </div>

        <div class="mb-4">
          <label for="deskripsi" class="block text-sm font-medium text-white">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" class="mt-1 p-2 w-full bg-[#46435F] rounded-md text-sm"><?php echo $data['deskripsi']; ?></textarea>
        </div>


        <div class="mb-4">
          <label for="foto" class="block text-sm font-medium text-white">Foto</label>
          <input type="file" name="foto" id="foto" class="mt-1 p-2 w-full bg-[#46435F] rounded-md">
          <img src="<?php echo $data['gambar_1']; ?>" alt="" class="h-20 mt-2">
        </div>

        <div class="flex justify-end">
          <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>