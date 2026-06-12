<?php

include '../sugar/heartlink.php';

if (!isset($_SESSION['babe_id'])) {
    header("Location: ../glam/darling.php");
    exit;
}

$user_id = $_SESSION['babe_id'];

$stmt = mysqli_prepare(
    $heart,
    "SELECT * FROM babes WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$user_result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($user_result);

$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search !== '') {
    $search_param = "%" . $search . "%";
    $stmt = mysqli_prepare(
        $heart,
        "SELECT *
         FROM sparkles
         WHERE babe_id = ? AND judul LIKE ?
         ORDER BY created_at DESC"
    );
    mysqli_stmt_bind_param(
        $stmt,
        "is",
        $user_id,
        $search_param
    );
} else {
    $stmt = mysqli_prepare(
        $heart,
        "SELECT *
         FROM sparkles
         WHERE babe_id = ?
         ORDER BY created_at DESC"
    );
    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $user_id
    );
}

mysqli_stmt_execute($stmt);

$videos = mysqli_stmt_get_result($stmt);

$total_video = mysqli_num_rows($videos);

?>

<?php include '../cotton/snippets/crown.php'; ?>

<title>My Profile • MyTube</title>

<body class="bg-gradient-to-br from-pink-50 to-white dark:from-zinc-950 dark:to-zinc-900 min-h-screen text-zinc-800 dark:text-zinc-100 transition-colors duration-500 antialiased flex flex-col justify-between selection:bg-pink-500 selection:text-white">

    <div class="w-full z-50">
        <?php include '../cotton/snippets/ribbon.php'; ?>
    </div>

    <main class="flex-1 max-w-6xl w-full mx-auto px-6 py-12 relative">
        
        <div class="bg-white/80 dark:bg-zinc-800/60 rounded-3xl shadow-xl hover:shadow-2xl border border-zinc-100 dark:border-zinc-700/30 p-8 backdrop-blur-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex flex-col sm:flex-row items-center gap-8 text-center sm:text-left">
                
                <div class="w-28 h-28 rounded-3xl bg-gradient-to-tr from-pink-500 to-rose-400 flex items-center justify-center text-5xl text-white shadow-lg shadow-pink-500/20 transform hover:rotate-6 transition-transform duration-300 select-none">
                    💖
                </div>

                <div class="space-y-2 flex-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-pink-50 dark:bg-pink-950/30 text-pink-500 font-bold text-xs uppercase tracking-wider border border-pink-100 dark:border-pink-950/50">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-500 animate-pulse"></span> Member Account
                    </span>
                    <h1 class="text-4xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500 drop-shadow-sm">
                        <?= htmlspecialchars($user['nama']) ?>
                    </h1>
                    <p class="text-sm font-medium text-zinc-400 dark:text-zinc-500 tracking-wide">
                        <?= htmlspecialchars($user['email']) ?>
                    </p>
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-2 bg-zinc-100 dark:bg-zinc-900/50 px-4 py-2 rounded-2xl border border-zinc-200/50 dark:border-zinc-700/30 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            🎥 Total uploads: <span class="text-pink-500 font-extrabold"><?= $total_video ?></span>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <section class="max-w-xl mr-auto mt-10">
            <form method="GET" action="" class="relative flex items-center bg-white/80 dark:bg-zinc-800/80 p-2 rounded-2xl shadow-md border border-zinc-100 dark:border-zinc-700/30 backdrop-blur-md">
                <input 
                    type="text" 
                    name="search" 
                    value="<?= htmlspecialchars($search) ?>" 
                    placeholder="Search my videos..." 
                    class="w-full pl-4 pr-12 py-2.5 rounded-xl bg-transparent focus:outline-none text-sm font-medium">
                <button 
                    type="submit" 
                    class="absolute right-3 p-2 rounded-xl bg-pink-500 text-white hover:bg-pink-600 active:scale-95 transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </section>

        <div class="mt-14 mb-8 flex items-center justify-between border-b border-zinc-200/60 dark:border-zinc-800 pb-4">
            <h2 class="text-2xl font-black tracking-tight text-pink-500 drop-shadow-sm flex items-center gap-2">
                <?= $search !== '' ? 'Search Results' : 'My Videos' ?> <span class="text-zinc-400 dark:text-zinc-600 text-lg font-normal">(<?= $total_video ?>)</span> ✨
            </h2>
        </div>

        <?php mysqli_data_seek($videos, 0); ?>

        <?php if($total_video > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php while($video = mysqli_fetch_assoc($videos)): ?>
                    <div class="group bg-white/80 dark:bg-zinc-800/40 rounded-3xl overflow-hidden shadow-md hover:shadow-xl border border-zinc-100 dark:border-zinc-800/50 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between backdrop-blur-sm">
                        
                        <a href="watching.php?id=<?= $video['id'] ?>" class="block relative overflow-hidden aspect-video w-full bg-pink-500 flex items-center justify-center transition-all duration-300 select-none">
                            
                            <?php 
                                $loveSeed = isset($video['id']) ? (int)$video['id'] % 4 : rand(0, 3);
                                
                                if ($loveSeed === 0): 
                            ?>
                                <svg class="w-14 h-14 text-white transform group-hover:scale-110 transition duration-500 filter drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>

                            <?php elseif ($loveSeed === 1): ?>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-14 h-14 text-white transform group-hover:scale-110 transition duration-500 filter drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <svg class="w-6 h-6 text-pink-200 absolute -top-1 -right-2 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12l-1.5-4.5L3 6l4.5-1.5L9 0l1.5 4.5L15 6l-4.5 1.5L9 12z"/>
                                    </svg>
                                </div>

                            <?php elseif ($loveSeed === 2): ?>
                                <svg class="w-14 h-14 text-white animate-pulse transform group-hover:scale-110 transition duration-500 filter drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>

                            <?php else: ?>
                                <div class="relative w-16 h-16 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white absolute bottom-1 left-1 transform group-hover:translate-x-1 transition duration-500 filter drop-shadow-sm" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <svg class="w-8 h-8 text-pink-200/90 absolute top-1 right-1 transform group-hover:-translate-y-1 transition duration-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        </a>

                        <div class="p-5 flex-1 flex flex-col justify-between gap-2">
                            <h3 class="font-bold text-sm tracking-tight text-zinc-800 dark:text-zinc-100 line-clamp-2 group-hover:text-pink-500 transition-colors duration-200">
                                <a href="watching.php?id=<?= $video['id'] ?>">
                                    <?= htmlspecialchars($video['judul']) ?>
                                </a>
                            </h3>
                            
                            <div class="flex items-center justify-between pt-2 border-t border-zinc-100 dark:border-zinc-800/50 mt-auto">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">MyTube Studio</span>
                                <span class="text-pink-500 text-xs">💓</span>
                            </div>
                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16 bg-white/40 dark:bg-zinc-800/20 rounded-3xl border border-dashed border-zinc-200 dark:border-zinc-800 max-w-md mx-auto p-8">
                <div class="text-4xl mb-3 select-none">🎬</div>
                <h3 class="font-bold text-zinc-700 dark:text-zinc-300 tracking-tight">No videos found</h3>
                <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1 mb-5">
                    <?= $search !== '' ? 'We couldn\'t find any match for your search.' : 'Share your first sparkle moment with the community.' ?>
                </p>
                <a href="<?= $search !== '' ? 'profile.php' : '/mytube/pretty/sparkle.php' ?>" class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white px-5 py-2.5 rounded-2xl font-bold text-xs tracking-wide shadow-md shadow-pink-500/10 hover:shadow-pink-500/20 active:scale-95 transition-all duration-300">
                    <?= $search !== '' ? 'Clear Search 🔄' : 'Upload First Video 🚀' ?>
                </a>
            </div>
        <?php endif; ?>

    </main>

    <div class="w-full z-50">
        <?php include '../cotton/snippets/footerkiss.php'; ?>
    </div>

</body>