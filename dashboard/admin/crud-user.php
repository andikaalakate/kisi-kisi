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
$query = "SELECT COUNT(*) as total FROM admin";
$totalData = mysqli_fetch_assoc(mysqli_query($koneksi, $query))['total']; // Total data
$lastPage = ceil($totalData / $perPage); // Hitung total halaman

// Ambil data admin untuk halaman saat ini
$currentPage = $_GET['page'] ?? 1; // Halaman saat ini, defaultnya 1
$start = ($currentPage - 1) * $perPage; // Hitung index awal data
$query = "SELECT * FROM admin LIMIT $start, $perPage";
$resultAdmin = mysqli_query($koneksi, $query);

// Inisialisasi nomor urut
$nomor = ($currentPage - 1) * $perPage + 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $name = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = md5($_POST['password']);

        // Cek apakah username/email sudah ada di database
        $query = "SELECT * FROM admin WHERE username='$name' OR email='$email'";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Username/email sudah ada di database.'); window.location.href = './crud-user.php';</script>";
            exit();
        }

        // Lakukan query insert ke database
        $query = "INSERT INTO admin (username, email, role, password) VALUES ('$name', '$email', '$role', '$password')";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-user.php");
        exit();
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Cek apakah username/email sudah ada di database
        $query = "SELECT * FROM admin WHERE username='$name' OR email='$email' AND id != '$id'";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Username/email sudah ada di database.'); window.location.href = './crud-user.php';</script>";
            exit();
        }

        // Lakukan query update ke database
        $query = "UPDATE admin SET username='$name', email='$email', role='$role' WHERE id='$id'";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-user.php");
        exit();
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        // Lakukan query delete ke database
        $query = "DELETE FROM admin WHERE id='$id'";
        mysqli_query($koneksi, $query);

        // Refresh halaman agar perubahan terlihat
        header("Location: ./crud-user.php");
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
                    <!-- Form Create User -->
                    <form method="post" class="mb-4 rounded text-black dark:text-white">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <input type="text" name="username" placeholder="Username" required class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                            <input type="email" name="email" placeholder="Email" required class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                            <select name="role" id="name" class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                                <option value="user" selected>User</option>
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                            <input type="password" name="password" placeholder="Password" required class="rounded px-2 py-1 bg-white dark:bg-gray-900">
                        </div>
                        <button type="submit" name="submit" class="w-full p-4 mt-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded">Tambah User</button>
                    </form>

                    <!-- User List -->
                    <div class="text-gray-900 bg-gray-200 dark:bg-gray-900 dark:text-gray-100 rounded-md">
                        <div class="p-4 flex">
                            <h1 class="text-3xl">
                                User
                            </h1>
                        </div>
                        <div class="px-3 py-4 flex justify-center">
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-md bg-white dark:bg-gray-800 shadow-md rounded mb-4">
                                    <tr class="border-b">
                                        <th class="text-left p-3 px-5">No</th>
                                        <th class="text-left p-3 px-5">Username</th>
                                        <th class="text-left p-3 px-5">Email</th>
                                        <th class="text-left p-3 px-5">Role</th>
                                        <th class="text-left"></th>
                                        <th class="text-left"></th>
                                    </tr>
                                    <tbody>
                                        <?php while ($admin = mysqli_fetch_assoc($resultAdmin)) : ?>
                                            <tr class="border-b hover:bg-orange-100 bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-700">
                                                <td class="p-3 px-5 font-bold"><?php echo $nomor++; ?></td>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
                                                    <td class="p-3 px-5"><input type="text" name="username" value="<?php echo $admin['username']; ?>" class="bg-transparent"></td>
                                                    <td class="p-3 px-5"><input type="text" name="email" value="<?php echo $admin['email']; ?>" class="bg-transparent"></td>
                                                    <td class="p-3 px-5">
                                                        <select name="role" class="bg-gray-800 text-white">
                                                            <option value="user" <?php echo ($admin['role'] == 'user') ? 'selected' : ''; ?>>user</option>
                                                            <option value="admin" <?php echo ($admin['role'] == 'admin') ? 'selected' : ''; ?>>admin</option>
                                                            <option value="super_admin" <?php echo ($admin['role'] == 'super_admin') ? 'selected' : ''; ?>>super_admin</option>
                                                        </select>
                                                    </td>
                                                    <td class="p-3 px-5"><input type="password" name="password" value="<?php echo $admin['password']; ?>" class="bg-transparent"></td>
                                                    <td class="p-3">
                                                        <button type="submit" name="update" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline w-full">Save</button>
                                                    </td>
                                                </form>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
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
                            </div>
                        </div>
                    </div>
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