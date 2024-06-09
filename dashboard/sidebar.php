<?php
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$menu_items = [];
$menu_items1 = [];
if ($user_role == 'super_admin' || $user_role == 'admin') {
    $menu_items = [
        ['url' => '/akademik-andika/dashboard/admin/', 'label' => 'Dashboard', 'icon' => 'home-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-user.php', 'label' => 'User', 'icon' => 'people-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-siswa.php', 'label' => 'Siswa', 'icon' => 'people-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-guru.php', 'label' => 'Guru', 'icon' => 'people-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-kelas.php', 'label' => 'Kelas', 'icon' => 'people-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-mapel.php', 'label' => 'Mata Pelajaran', 'icon' => 'people-outline'],
    ];
} else {
    $menu_items = [
        ['url' => '/akademik-andika/dashboard/user/', 'label' => 'Dashboard', 'icon' => 'home-outline'],
    ];

    // Ambil kode kelas yang diajar oleh guru dari database
    $kode_guru = $_SESSION['username']; // Sesuaikan dengan session yang menyimpan kode guru
    $queryKelasGuru = "SELECT DISTINCT k.kode_kelas, k.nama FROM kelas k INNER JOIN guru_kelas gk ON k.kode_kelas = gk.kelas_kode WHERE gk.guru_kode = '$kode_guru'";
    $resultKelasGuru = mysqli_query($koneksi, $queryKelasGuru);
    
    $isFirst = true;
    while ($rowKelas = mysqli_fetch_assoc($resultKelasGuru)) {
        $url = '/akademik-andika/dashboard/user/kelas.php?kode_kelas=' . $rowKelas['kode_kelas'];
        if (isset($_GET['page'])) {
            $url .= '&page=' . $_GET['page'];
        } else if ($isFirst) {
            $isFirst = false;
        } else {
            $url .= '';
        }
        $menu_items1[] = ['url' => $url, 'label' => $rowKelas['nama'], 'icon' => 'people-outline'];
    }
}
?>

<div x-data="{ activePath: window.location.pathname + window.location.search, dropdownOpen: <?= in_array($_SERVER['REQUEST_URI'], array_column($menu_items1, 'url')) ? 'true' : 'false' ?> }" class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-blue-900 dark:bg-gray-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
    <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center h-8">
                    <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
                </div>
            </li>
            <?php foreach ($menu_items as $item) : ?>
                <li>
                    <a href="<?= $item['url']; ?>" @click="activePath = '<?= $item['url']; ?>'" :class="{ 'bg-blue-800 dark:bg-gray-600 border-blue-500 dark:border-gray-800 text-white-800': activePath === '<?= $item['url']; ?>' }" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <ion-icon name="<?= $item['icon']; ?>" class="w-7 h-7"></ion-icon>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate"><?= $item['label']; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php if ($user_role == 'guru') : ?>
                <li x-data="{ open: <?= in_array($_SERVER['REQUEST_URI'], array_column($menu_items1, 'url')) ? 'true' : 'false' ?> }">
                    <a href="#" @click="open = !open" @click.away="open = false" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <ion-icon name="folder-outline" class="w-7 h-7"></ion-icon>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Kelas</span>
                        <ion-icon name="chevron-down" class="ml-auto w-5 h-5" :class="{ 'transform rotate-180': open }"></ion-icon>
                    </a>
                    <ul x-show="open || <?= in_array($_SERVER['REQUEST_URI'], array_column($menu_items1, 'url')) || isset($_GET['page']) ? 'true' : 'false' ?>" @click.away="open = false" x-transition class="bg-blue-700 dark:bg-gray-800">
                        <?php foreach ($menu_items1 as $item) : ?>
                            <li>
                                <a href="<?= $item['url']; ?>" @click="activePath.split('?')[0] === '<?= $item['url']; ?>'" :class="{ 'bg-blue-800 dark:bg-gray-600 border-blue-500 dark:border-gray-800 text-white-800': activePath === '<?= $item['url']; ?>' }" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <ion-icon name="<?= $item['icon']; ?>" class="w-7 h-7"></ion-icon>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate"><?= $item['label']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>