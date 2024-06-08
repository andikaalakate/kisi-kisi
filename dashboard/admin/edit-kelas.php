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

$query = "SELECT * FROM kelas WHERE id = $id";
$resultKelas = mysqli_query($koneksi, $query);

// Periksa apakah data ditemukan
if (mysqli_num_rows($resultKelas) > 0) {
    $kelas = mysqli_fetch_assoc($resultKelas);
} else {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $tahun_mulai = $_POST['tahun_mulai'];
        $tahun_berakhir = $_POST['tahun_berakhir'];

        $ta = $tahun_mulai . '-' . $tahun_berakhir;

        // Cek apakah kelas sudah ada di database
        $queryValid = "SELECT * FROM kelas WHERE nama='$nama' AND ta='$ta' AND id != '$id'";
        $resultValid = mysqli_query($koneksi, $queryValid);
        if (mysqli_num_rows($resultValid) > 0) {
            echo "<script>alert('Kelas sudah ada di database.'); window.location.href = './crud-kelas.php';</script>";
            exit();
        }

        // Lakukan query update ke database
        $query = "UPDATE kelas SET nama='$nama', ta='$ta' WHERE id='$id'";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-kelas.php");
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
                    <h1 class="text-2xl font-bold mb-4">CRUD Kelas</h1>
                    <?php
                    list($ta_mulai, $ta_berakhir) = explode('-', $kelas['ta']);
                    ?>
                    <form method="post" class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 rounded text-black dark:text-white shadow-lg">
                        <input type="text" hidden name="id" value="<?php echo $kelas['id'] ?>">
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                            <div class="flex flex-col">
                                <label for="nama" class="mb-2 font-semibold">Nama Kelas</label>
                                <input type="text" id="nama" name="nama" value="<?php echo $kelas['nama'] ?>" placeholder="nama" required class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col">
                                <label for="tahun_mulai" class="mb-2 font-semibold">Tahun Mulai</label>
                                <input type="number" id="tahun_mulai" name="tahun_mulai" value="<?php echo $ta_mulai ?>" min="2000" max="<?php echo date('Y'); ?>" placeholder="Tahun Mulai" required class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col">
                                <label for="tahun_berakhir" class="mb-2 font-semibold">Tahun Berakhir</label>
                                <input type="number" id="tahun_berakhir" min="<?php echo $ta_mulai; ?>" max="<?php echo date('Y'); ?>" name="tahun_berakhir" value="<?php echo $ta_berakhir; ?>" placeholder="Tahun Berakhir" required class="rounded px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <button type="submit" name="update" class="w-full p-4 mt-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded">Update Kelas</button>
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

    <script>
        // Ambil semua elemen input tahun mulai dan tahun berakhir
        var tahunMulaiInputs = document.querySelectorAll('input[name="tahun_mulai"]');
        var tahunBerakhirInputs = document.querySelectorAll('input[name="tahun_berakhir"]');

        // Tambahkan event listener untuk setiap input tahun mulai
        tahunMulaiInputs.forEach(function(tahunMulaiInput, index) {
            // Ketika nilai input tahun mulai berubah
            tahunMulaiInput.addEventListener('change', function() {
                // Set nilai min pada input tahun berakhir terkait
                tahunBerakhirInputs[index].min = tahunMulaiInput.value;
                // Reset nilai input tahun berakhir jika nilainya lebih kecil dari tahun mulai yang baru
                if (parseInt(tahunBerakhirInputs[index].value) < parseInt(tahunMulaiInput.value)) {
                    tahunBerakhirInputs[index].value = tahunMulaiInput.value;
                }
            });
        });
    </script>
</body>

</html>
<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>