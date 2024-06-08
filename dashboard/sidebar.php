<?php
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$menu_items = [];
if ($user_role == 'super_admin' || $user_role == 'admin') {
    $menu_items = [
        ['url' => '/akademik-andika/dashboard/admin/', 'label' => 'Dashboard', 'icon' => 'home-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-user.php', 'label' => 'User', 'icon' => 'people-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-siswa.php', 'label' => 'Siswa', 'icon' => 'people-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-guru.php', 'label' => 'Guru', 'icon' => 'people-outline'],
        ['url' => '/akademik-andika/dashboard/admin/crud-kelas.php', 'label' => 'Kelas', 'icon' => 'people-outline'],
    ];
} else {
    $menu_items = [
        ['url' => '/akademik-andika/dashboard/user/', 'label' => 'Dashboard', 'icon' => 'home-outline'],
    ];
}
?>

<div x-data="{ activePath: window.location.pathname }" class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-blue-900 dark:bg-gray-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
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
            <!-- <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center h-8">
                    <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Admin</div>
                </div>
            </li> -->
        </ul>
    </div>
</div>