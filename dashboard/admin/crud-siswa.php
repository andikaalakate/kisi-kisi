<?php
// Mulai sesi
session_start();

// Cek apakah sesi user tidak ada
if (!isset($_SESSION['role'])) {
    // Redirect ke halaman login jika sesi tidak ada
    header("Location: ../../login");
    exit();
}

// Cek apakah user memiliki role yang sesuai
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'super_admin' && $_SESSION['role'] !== 'admin')) {
    // Redirect atau tampilkan pesan error jika user tidak memiliki role yang sesuai
    echo "<script>alert('Anda tidak memiliki akses untuk melihat halaman ini.'); window.location.href = '../user/';</script>";
    exit();
}

include '../../config/koneksi.php';

// READ
// Query untuk menghitung total data dan halaman
$perPage = 5; // Jumlah data per halaman
$query = "SELECT COUNT(*) as total FROM siswa";
$totalData = mysqli_fetch_assoc(mysqli_query($koneksi, $query))['total']; // Total data
$lastPage = ceil($totalData / $perPage); // Hitung total halaman

// Ambil data siswa untuk halaman saat ini
$currentPage = $_GET['page'] ?? 1; // Halaman saat ini, defaultnya 1
$start = ($currentPage - 1) * $perPage; // Hitung index awal data
$query = "SELECT * FROM siswa LIMIT $start, $perPage";
$resultSiswa = mysqli_query($koneksi, $query);

// Inisialisasi nomor urut
$nomor = ($currentPage - 1) * $perPage + 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $jkelamin = $_POST['jkelamin'];
        $no_telp = $_POST['no_telp'];

        // Tambah kode_siswa
        $queryKode = "SELECT MAX(id) AS max_id FROM siswa";
        $resultKode = mysqli_query($koneksi, $queryKode);
        $rowKode = mysqli_fetch_assoc($resultKode);
        $idKode = $rowKode['max_id'] + 1;
        $kode_siswa = 'SIS' . str_pad($idKode, 5, '0', STR_PAD_LEFT);

        // Cek apakah data siswa sudah ada
        $queryValid = "SELECT * FROM siswa WHERE nama='$nama' AND kelas='$kelas' AND jkelamin='$jkelamin' AND no_telp='$no_telp'";
        $resultValid = mysqli_query($koneksi, $queryValid);
        if (mysqli_num_rows($resultValid) > 0) {
            // Jika data siswa sudah ada, tampilkan pesan error
            echo "<script>alert('Data siswa sudah ada.'); window.location.href = './crud-siswa.php';</script>";
            exit();
        }

        // Lakukan query insert ke database
        $query = "INSERT INTO siswa (kode_siswa, nama, kelas, jkelamin, no_telp) VALUES ('$kode_siswa', '$nama', '$kelas', '$jkelamin', '$no_telp')";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-siswa.php");
        exit();
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        // Lakukan query delete ke database
        $query = "DELETE FROM siswa WHERE id='$id'";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-siswa.php");
        exit();
    }
}

// $koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../../config/tailwind.config.js"></script>
    <style>
        /* Compiled dark classes from Tailwind */
        .dark .dark\:divide-gray-700> :not([hidden])~ :not([hidden]) {
            border-color: rgba(55, 65, 81);
        }

        .dark .dark\:bg-gray-50 {
            background-color: rgba(249, 250, 251);
        }

        .dark .dark\:bg-gray-100 {
            background-color: rgba(243, 244, 246);
        }

        .dark .dark\:bg-gray-600 {
            background-color: rgba(75, 85, 99);
        }

        .dark .dark\:bg-gray-700 {
            background-color: rgba(55, 65, 81);
        }

        .dark .dark\:bg-gray-800 {
            background-color: rgba(31, 41, 55);
        }

        .dark .dark\:bg-gray-900 {
            background-color: rgba(17, 24, 39);
        }

        .dark .dark\:bg-red-700 {
            background-color: rgba(185, 28, 28);
        }

        .dark .dark\:bg-green-700 {
            background-color: rgba(4, 120, 87);
        }

        .dark .dark\:hover\:bg-gray-200:hover {
            background-color: rgba(229, 231, 235);
        }

        .dark .dark\:hover\:bg-gray-600:hover {
            background-color: rgba(75, 85, 99);
        }

        .dark .dark\:hover\:bg-gray-700:hover {
            background-color: rgba(55, 65, 81);
        }

        .dark .dark\:hover\:bg-gray-900:hover {
            background-color: rgba(17, 24, 39);
        }

        .dark .dark\:border-gray-100 {
            border-color: rgba(243, 244, 246);
        }

        .dark .dark\:border-gray-400 {
            border-color: rgba(156, 163, 175);
        }

        .dark .dark\:border-gray-500 {
            border-color: rgba(107, 114, 128);
        }

        .dark .dark\:border-gray-600 {
            border-color: rgba(75, 85, 99);
        }

        .dark .dark\:border-gray-700 {
            border-color: rgba(55, 65, 81);
        }

        .dark .dark\:border-gray-900 {
            border-color: rgba(17, 24, 39);
        }

        .dark .dark\:hover\:border-gray-800:hover {
            border-color: rgba(31, 41, 55);
        }

        .dark .dark\:text-white {
            color: rgba(255, 255, 255);
        }

        .dark .dark\:text-gray-50 {
            color: rgba(249, 250, 251);
        }

        .dark .dark\:text-gray-100 {
            color: rgba(243, 244, 246);
        }

        .dark .dark\:text-gray-200 {
            color: rgba(229, 231, 235);
        }

        .dark .dark\:text-gray-400 {
            color: rgba(156, 163, 175);
        }

        .dark .dark\:text-gray-500 {
            color: rgba(107, 114, 128);
        }

        .dark .dark\:text-gray-700 {
            color: rgba(55, 65, 81);
        }

        .dark .dark\:text-gray-800 {
            color: rgba(31, 41, 55);
        }

        .dark .dark\:text-red-100 {
            color: rgba(254, 226, 226);
        }

        .dark .dark\:text-green-100 {
            color: rgba(209, 250, 229);
        }

        .dark .dark\:text-blue-400 {
            color: rgba(96, 165, 250);
        }

        .dark .group:hover .dark\:group-hover\:text-gray-500 {
            color: rgba(107, 114, 128);
        }

        .dark .group:focus .dark\:group-focus\:text-gray-700 {
            color: rgba(55, 65, 81);
        }

        .dark .dark\:hover\:text-gray-100:hover {
            color: rgba(243, 244, 246);
        }

        .dark .dark\:hover\:text-blue-500:hover {
            color: rgba(59, 130, 246);
        }

        /* Custom style */
        .header-right {
            width: calc(100% - 3.5rem);
        }

        .sidebar:hover {
            width: 16rem;
        }

        @media only screen and (min-width: 768px) {
            .header-right {
                width: calc(100% - 16rem);
            }
        }
    </style>
</head>

<body>
    <div x-data="setup()" :class="{ 'dark': isDark }">
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
            <!-- Header -->
            <?php include '../header.php' ?>
            <!-- ./Header -->

            <!-- Sidebar -->
            <?php include '../sidebar.php' ?>
            <!-- ./Sidebar -->

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64">
                <div class="container p-4">
                    <h1 class="text-2xl font-bold mb-4">CRUD Siswa</h1>
                    <!-- Form Create Siswa -->
                    <form method="post" class="mb-4 rounded text-black dark:text-white">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <input type="text" name="nama" placeholder="Nama" required class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                            <select name="jkelamin" id="jkelamin" class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                                <option value="pilih jkelamin" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <select name="kelas" id="kelas" class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                                <option value="pilih kelas" disabled selected>Pilih Kelas</option>
                                <?php
                                $queryKelas = "SELECT * FROM kelas";
                                $resultKelas = mysqli_query($koneksi, $queryKelas);

                                while ($row = mysqli_fetch_assoc($resultKelas)) {
                                ?>
                                    <option value="<?php echo $row['kode_kelas']; ?>"><?php echo $row['nama']; ?></option>
                                <?php } ?>
                            </select>
                            <input type="telp" name="no_telp" placeholder="No. Telp" required class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                        </div>
                        <button type="submit" name="submit" class="w-full p-4 mt-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded">Tambah Siswa</button>
                    </form>
                    <!-- End Form Create Siswa -->

                    <!-- Siswa List -->
                    <div class="text-gray-900 bg-gray-200 dark:bg-gray-900 dark:text-gray-100 rounded-md">
                        <div class="p-4 flex">
                            <h1 class="text-3xl">
                                Siswa
                            </h1>
                        </div>
                        <div class="px-3 py-4 flex justify-center">
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-md bg-white dark:bg-gray-800 shadow-md rounded mb-4">
                                    <tr class="border-b">
                                        <th class="text-left p-3 px-5">No</th>
                                        <th class="text-left p-3 px-5">Kode</th>
                                        <th class="text-left p-3 px-5">Nama</th>
                                        <th class="text-left p-3 px-5">Jenis Kelamin</th>
                                        <th class="text-left p-3 px-5">Kelas</th>
                                        <th class="text-left p-3 px-5">No. Telp</th>
                                        <th class="text-left"></th>
                                        <th class="text-left"></th>
                                    </tr>
                                    <tbody>
                                        <?php
                                        // Mengambil semua data kelas sebelum loop
                                        $queryKelasAll = "SELECT kode_kelas, nama FROM kelas";
                                        $resultKelasAll = mysqli_query($koneksi, $queryKelasAll);

                                        $kelasNames = [];
                                        while ($rowKelasAll = mysqli_fetch_assoc($resultKelasAll)) {
                                            $kelasNames[$rowKelasAll['kode_kelas']] = $rowKelasAll['nama'];
                                        }
                                        ?>

                                        <?php while ($siswa = mysqli_fetch_assoc($resultSiswa)) : ?>
                                            <tr class="border-b hover:bg-orange-100 bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-700">
                                                <td class="p-3 px-5 font-bold"><?php echo $nomor++; ?></td>
                                                <td class="p-3 px-5 font-bold"><?php echo $siswa['kode_siswa']; ?></td>
                                                <td class="p-3 px-5"><?php echo $siswa['nama']; ?></td>
                                                <td class="p-3 px-5"><?php echo ($siswa['jkelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan'; ?></td>
                                                <td class="p-3 px-5">
                                                    <?php
                                                    // Menggunakan array $kelasNames yang telah dibuat sebelumnya
                                                    echo isset($kelasNames[$siswa['kelas']]) ? $kelasNames[$siswa['kelas']] : 'Kelas tidak ditemukan';
                                                    ?>
                                                </td>
                                                <td class="p-3 px-5"><?php echo $siswa['no_telp']; ?></td>
                                                <td class="p-3">
                                                    <a href="edit-siswa.php?id=<?php echo $siswa['id']; ?>" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline w-full text-center">Edit</a>
                                                </td>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $siswa['id']; ?>">
                                                    <td class="p-3">
                                                        <button type="submit" name="delete" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline w-full">Delete</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div x-data="{ currentPage: <?php echo $currentPage; ?>, lastPage: <?php echo $lastPage; ?> }" class="text-center m-4 dark:text-black">
                                    <a x-bind:href="'?page=' + (currentPage > 1 ? currentPage - 1 : 1)" class="inline-block bg-gray-200 hover:bg-gray-300 rounded px-3 py-1 mr-2">
                                        <button @click="currentPage = currentPage > 1 ? currentPage - 1 : 1" class="focus:outline-none">Previous</button>
                                    </a>
                                    <span x-text="currentPage" class="mx-2 dark:text-white"></span>
                                    <a x-bind:href="'?page=' + (currentPage < lastPage ? currentPage + 1 : lastPage)" class="inline-block bg-gray-200 hover:bg-gray-300 rounded px-3 py-1 ml-2">
                                        <button @click="currentPage = currentPage < lastPage ? currentPage + 1 : lastPage" class="focus:outline-none">Next</button>
                                    </a>
                                </div>
                                <!-- End Pagination -->

                            </div>
                        </div>
                    </div>
                    <!-- End Siswa List -->
                </div>
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        const setup = () => {
            const getTheme = () => {
                if (window.localStorage.getItem('dark')) {
                    return JSON.parse(window.localStorage.getItem('dark'));
                }
                return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            const setTheme = (value) => {
                window.localStorage.setItem('dark', value);
            }

            return {
                loading: true,
                isDark: getTheme(),
                toggleTheme() {
                    this.isDark = !this.isDark;
                    setTheme(this.isDark);
                    document.documentElement.classList.toggle('dark', this.isDark);
                },
            }
        }
    </script>
</body>

</html>
<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>