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

// Inisialisasi nomor urut
$nomor = 1;

// Ambil ID dari URL
$id = $_GET['id'];

$query = "SELECT * FROM siswa WHERE id = $id";
$resultSiswa = mysqli_query($koneksi, $query);

// Periksa apakah data ditemukan
if (mysqli_num_rows($resultSiswa) > 0) {
    $siswa = mysqli_fetch_assoc($resultSiswa);
} else {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $jurusan = $_POST['jurusan'];
        $jkelamin = $_POST['jkelamin'];
        $no_telp = $_POST['no_telp'];

        // Cek apakah data siswa sudah ada
        $query = "SELECT * FROM siswa WHERE nama='$nama' AND kelas='$kelas' AND jurusan='$jurusan' AND jkelamin='$jkelamin' AND no_telp='$no_telp'";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result) > 0) {
            // Jika data siswa sudah ada, tampilkan pesan error
            echo "<script>alert('Data siswa sudah ada.'); window.location.href = './crud-siswa.php';</script>";
            exit();
        }

        // Lakukan query update ke database
        $query = "UPDATE siswa SET nama='$nama', kelas='$kelas', jurusan='$jurusan', jkelamin='$jkelamin', no_telp='$no_telp' WHERE id='$id'";
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
                    <h1 class="text-2xl font-bold mb-4">CRUD User</h1>

                    <form method="post" class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded text-black dark:text-white shadow-lg">
                        <input type="text" hidden name="id" value="<?php echo $siswa['id'] ?>">
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                            <div class="flex flex-col">
                                <label for="nama" class="mb-2 font-semibold">Nama</label>
                                <input type="text" id="nama" name="nama" value="<?php echo $siswa['nama'] ?>" placeholder="Username" required class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col">
                                <label for="jkelamin" class="mb-2 font-semibold">Jenis Kelamin</label>
                                <select name="jkelamin" id="jkelamin" class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="L" <?php echo ($siswa['jkelamin'] == 'L') ? 'selected' : ''; ?>>Laki-Laki</option>
                                    <option value="P" <?php echo ($siswa['jkelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="kelas" class="mb-2 font-semibold">Kelas</label>
                                <select name="kelas" id="kelas" class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="10" <?php echo ($siswa['kelas'] == '10') ? 'selected' : ''; ?>>X (10)</option>
                                    <option value="11" <?php echo ($siswa['kelas'] == '11') ? 'selected' : ''; ?>>XI (11)</option>
                                    <option value="12" <?php echo ($siswa['kelas'] == '12') ? 'selected' : ''; ?>>XII (12)</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="jurusan" class="mb-2 font-semibold">Jurusan</label>
                                <select name="jurusan" id="jurusan" class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="RPL" <?php echo ($siswa['jurusan'] == 'RPL') ? 'selected' : ''; ?>>Rekayasa Perangkat Lunak</option>
                                    <option value="TJKT" <?php echo ($siswa['jurusan'] == 'TJKT') ? 'selected' : ''; ?>>Teknik Jaringan Komputer dan Telekomunikasi</option>
                                    <option value="MPLB" <?php echo ($siswa['jurusan'] == 'MPLB') ? 'selected' : ''; ?>>Manajemen Perkantoran dan Layanan Bisnis</option>
                                    <option value="PM" <?php echo ($siswa['jurusan'] == 'PM') ? 'selected' : ''; ?>>Pemasaran</option>
                                    <option value="AKL" <?php echo ($siswa['jurusan'] == 'AKL') ? 'selected' : ''; ?>>Akuntansi dan Keuangan Lembaga</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="no_telp" class="mb-2 font-semibold">No. Telp</label>
                                <input type="telp" value="<?php echo $siswa['no_telp']; ?>" id="no_telp" name="no_telp" class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <button type="submit" name="update" class="w-full p-4 mt-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded">Update Siswa</button>
                    </form>

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