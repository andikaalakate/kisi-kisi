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
$query = "SELECT COUNT(*) as total FROM guru";
$totalData = mysqli_fetch_assoc(mysqli_query($koneksi, $query))['total']; // Total data
$lastPage = ceil($totalData / $perPage); // Hitung total halaman

// Ambil data guru untuk halaman saat ini
$currentPage = $_GET['page'] ?? 1; // Halaman saat ini, defaultnya 1
$start = ($currentPage - 1) * $perPage; // Hitung index awal data
$query = "SELECT * FROM guru LIMIT $start, $perPage";
$resultGuru = mysqli_query($koneksi, $query);

// Inisialisasi nomor urut
$nomor = ($currentPage - 1) * $perPage + 1;

// Untuk create
$queryKelas = "SELECT * FROM kelas";
$resultKelas = mysqli_query($koneksi, $queryKelas);

// Untuk Read and Edit
// Ambil data kelas dari database
$kelasResult = mysqli_query($koneksi, "SELECT kode_kelas FROM kelas");

// Array untuk menyimpan kode_kelas
$kelasList = [];
while ($kelasRow = mysqli_fetch_assoc($kelasResult)) {
    $kelasList[] = $kelasRow['kode_kelas'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $mapel = $_POST['mapel'];
        $jkelamin = $_POST['jkelamin'];
        $no_telp = $_POST['no_telp'];
        $alamat = $_POST['alamat'];
        $kelas = $_POST['kelas'];

        $kelas_json = json_encode($kelas);

        // Tambah kode_guru
        $queryKode = "SELECT MAX(id) AS max_id FROM guru";
        $resultKode = mysqli_query($koneksi, $queryKode);
        $rowKode = mysqli_fetch_assoc($resultKode);
        $idKode = $rowKode['max_id'] + 1;
        $kode_guru = 'GUR' . str_pad($idKode, 5, '0', STR_PAD_LEFT);

        // // Cek apakah data siswa sudah ada
        // $queryValid = "SELECT * FROM guru WHERE nama='$nama' AND mapel='$mapel' AND no_telp='$no_telp'";
        // $resultValid = mysqli_query($koneksi, $queryValid);
        // if (mysqli_num_rows($resultValid) > 0) {
        //     // Jika data siswa sudah ada, tampilkan pesan error
        //     echo "<script>alert('Data siswa sudah ada.'); window.location.href = './crud-guru.php';</script>";
        //     exit();
        // }

        // Lakukan query insert ke database
        $query = "INSERT INTO guru (kode_guru, nama, mapel, kelas, jkelamin, no_telp, alamat) VALUES ('$kode_guru', '$nama', '$mapel', '$kelas_json', '$jkelamin', '$no_telp', '$alamat')";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-guru.php");
        exit();
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $mapel = $_POST['mapel'];
        $jkelamin = $_POST['jkelamin'];
        $no_telp = $_POST['no_telp'];
        $alamat = $_POST['alamat'];
        $kelas = $_POST['kelas'] ?? []; // Menggunakan array kosong jika $_POST['kelas'] tidak ada

        $kelas_json = json_encode($kelas, true);


        // // Cek apakah data siswa sudah ada
        // $queryValid = "SELECT * FROM guru WHERE id='$id' AND nama='$nama' AND mapel='$mapel' AND no_telp='$no_telp'";
        // $resultValid = mysqli_query($koneksi, $queryValid);
        // if (mysqli_num_rows($resultValid) > 0) {
        //     // Jika data siswa sudah ada, tampilkan pesan error
        //     echo "<script>alert('Data siswa sudah ada.'); window.location.href = './crud-guru.php';</script>";
        //     exit();
        // }

        // Lakukan query update ke database
        $query = "UPDATE guru SET nama='$nama', mapel='$mapel', kelas='$kelas_json', jkelamin='$jkelamin', no_telp='$no_telp', alamat='$alamat' WHERE id='$id'";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-guru.php");
        exit();
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        // Lakukan query delete ke database
        $query = "DELETE FROM guru WHERE id='$id'";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-guru.php");
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
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet" />
    <link href="../../assets/css/multi-select.css" rel="stylesheet" />
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
                    <h1 class="text-2xl font-bold mb-4">CRUD Guru</h1>
                    <!-- Form Create Guru -->
                    <form method="post" class="mb-4 rounded text-black dark:text-white">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 ">
                            <input type="text" name="nama" placeholder="Nama" required class="rounded px-2 py-1 bg-slate-50 dark:bg-gray-900">
                            <?php
                            $mapel = ['IPA', 'IPS', 'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'PKN', 'Sejarah', 'Informatika', 'Pemrograman', 'Jaringan', 'Penjas', 'SBK', 'Konsentrasi Keahlian', 'Pendidikan Agama'];
                            ?>

                            <select name="mapel" id="mapel" class="rounded px-2 py-1 bg-slate-50 dark:bg-gray-900">
                                <option value="pilih mapel" disabled selected>Pilih Mata Pelajaran</option>
                                <?php foreach ($mapel as $mata_pelajaran) { ?>
                                    <option value="<?php echo $mata_pelajaran; ?>"><?php echo $mata_pelajaran; ?></option>
                                <?php } ?>
                            </select>

                            <select name="kelas" data-placeholder="Pilih Kelas" multiple data-multi-select autocomplete="off" class="rounded px-2 py-1 bg-slate-50 dark:bg-gray-900 block w-full cursor-pointer focus:outline-none">
                                <?php
                                if ($resultKelas->num_rows > 0) {
                                    while ($row = $resultKelas->fetch_assoc()) {
                                        // echo '<option value="" selected disabled>Pilih Kelas</option>';
                                        echo '<option value="' . $row['kode_kelas'] . '">' . $row['kode_kelas'] . ' ' . $row['nama'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Tidak ada kelas</option>';
                                }
                                ?>
                            </select>

                            <select name="jkelamin" id="jkelamin" class="rounded px-2 py-1 bg-slate-50 dark:bg-gray-900">
                                <option value="pilih jkelamin" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <input type="telp" name="no_telp" placeholder="No. Telp" required class="rounded px-2 py-1 bg-slate-50 dark:bg-gray-900">
                            <textarea name="alamat" placeholder="Alamat" required class="rounded px-2 py-1 bg-slate-50 dark:bg-gray-900"></textarea>
                        </div>
                        <button type="submit" name="submit" class="bg-gray-900 mt-4 w-full hover:bg-gray-800 text-white font-bold p-4 rounded">Tambah Guru</button>
                    </form>
                    <!-- End Form Create Guru -->

                    <!-- Guru List -->
                    <div class="text-gray-900 bg-gray-200 dark:bg-gray-900 dark:text-gray-100 rounded-md">
                        <div class="p-4 flex">
                            <h1 class="text-3xl">
                                Guru
                            </h1>
                        </div>
                        <div class="px-3 py-4 flex justify-center">
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-md bg-white dark:bg-gray-800 shadow-md rounded mb-4">
                                    <tr class="border-b">
                                        <th class="text-left p-3 px-5">No</th>
                                        <th class="text-left p-3 px-5">Kode</th>
                                        <th class="text-left p-3 px-5">Nama</th>
                                        <th class="text-left p-3 px-5">Mapel</th>
                                        <th class="text-left p-3 px-5">Kelas</th>
                                        <th class="text-left p-3 px-5">Jenis Kelamin</th>
                                        <th class="text-left p-3 px-5">No. Telp</th>
                                        <th class="text-left p-3 px-5">Alamat</th>
                                        <th class="text-left"></th>
                                        <th class="text-left"></th>
                                    </tr>
                                    <tbody>
                                        <?php while ($guru = mysqli_fetch_assoc($resultGuru)) : ?>
                                            <tr class="border-b hover:bg-orange-100 bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-700">
                                                <td class="p-3 px-5 font-bold"><?php echo $nomor++; ?></td>
                                                <td class="p-3 px-5 font-bold"><?php echo $guru['kode_guru']; ?></td>
                                                <td class="p-3 px-5"><input type="text" name="nama" value="<?php echo $guru['nama']; ?>" class="bg-transparent"></td>
                                                <td class="p-3 px-5">
                                                    <?php echo $guru['mapel']; ?>
                                                </td>
                                                <td class="p-3 px-8">
                                                    <?php
                                                    $kelasGuru = json_decode($guru['kelas'], true);
                                                    $kelasNames = [];

                                                    // Mengambil nama kelas dari tabel kelas untuk setiap kode_kelas dalam array $kelasGuru
                                                    foreach ($kelasGuru as $kodeKelas) {
                                                        // Misalkan Anda memiliki koneksi database yang telah dibuat sebelumnya
                                                        $query = "SELECT nama FROM kelas WHERE kode_kelas = '$kodeKelas'";
                                                        $result = mysqli_query($koneksi, $query);

                                                        if ($result) {
                                                            $row = mysqli_fetch_assoc($result);
                                                            $namaKelas = $row['nama'];
                                                            $kelasNames[] = $namaKelas;
                                                        }
                                                    }

                                                    // Menampilkan nama kelas dengan menggunakan span dan memberikan margin kanan
                                                    foreach ($kelasNames as $index => $namaKelas) {
                                                        echo '<span>' . $namaKelas . '</span>';
                                                        // Jika bukan kelas terakhir, tambahkan koma dan spasi
                                                        if ($index < count($kelasNames) - 1) {
                                                            echo ', ';
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <td class="p-3 px-5">
                                                    <?php echo ($guru['jkelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan' ?>
                                                </td>
                                                <td class="p-3 px-5">
                                                    <?php echo $guru['no_telp']; ?>
                                                </td>
                                                <td class="p-3 px-5">
                                                    <?php echo $guru['alamat']; ?>
                                                </td>
                                                <td class="p-3">
                                                    <a href="edit-guru.php?id=<?php echo $guru['id']; ?>" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline w-full text-center">Edit</a>
                                                </td>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $guru['id']; ?>">
                                                    <td class="p-3">
                                                        <button type="submit" name="delete" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline w-full">Delete</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div x-data="{ currentPage: <?php echo $currentPage; ?>, lastPage: <?php echo $lastPage; ?> }" class="text-center m-8 dark:text-black">
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
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="../../assets/js/multi-select.js" defer></script>

</body>

</html>
<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>