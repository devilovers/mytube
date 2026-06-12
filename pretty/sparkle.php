<?php

include '../sugar/heartlink.php';

if (!isset($_SESSION['babe_id'])) {
    header("Location: ../glam/darling.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $youtube_url = trim($_POST['youtube_url']);

    $video_id = '';

    if (preg_match(
        '/(?:youtube\.com\\/watch\\?v=|youtu\.be\\/)([^&]+)/',
        $youtube_url,
        $matches
    )) {
        $video_id = $matches[1];
    }

    if ($video_id) {

        $oembed_url =
            "https://www.youtube.com/oembed?url=" .
            urlencode($youtube_url) .
            "&format=json";

        $response = @file_get_contents($oembed_url);

        if ($response) {

            $data = json_decode($response, true);

            $judul = $data['title'] ?? 'Untitled Video';

        } else {

            $judul = 'Untitled Video';
        }

        $thumbnail =
            "https://img.youtube.com/vi/" .
            $video_id .
            "/hqdefault.jpg";
        $deskripsi =
            "Video imported automatically from YouTube 💖";

        $stmt = mysqli_prepare(
            $heart,
            "INSERT INTO sparkles
            (babe_id, judul, deskripsi, youtube_url, thumbnail)
            VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "issss",
            $_SESSION['babe_id'],
            $judul,
            $deskripsi,
            $youtube_url,
            $thumbnail
        );

        if (mysqli_stmt_execute($stmt)) {

            $message = "Video uploaded successfully 💖";

        } else {

            $message = "Database error 💔";
        }

    } else {

        $message = "Invalid YouTube URL 💔";
    }
}

?>

<?php include '../cotton/snippets/crown.php'; ?>

<title>Upload Video • MyTube</title>

<body class="bg-gradient-to-br from-pink-50 to-white dark:from-zinc-950 dark:to-zinc-900 min-h-screen text-zinc-800 dark:text-zinc-100 transition-colors duration-500 antialiased flex flex-col justify-between selection:bg-pink-500 selection:text-white">

    <div class="w-full z-50">
        <?php include '../cotton/snippets/ribbon.php'; ?>
    </div>

    <main class="flex-1 flex items-center justify-center p-6 w-full max-w-2xl mx-auto relative">
        
        <div class="w-full bg-white/80 dark:bg-zinc-800/60 rounded-3xl shadow-xl hover:shadow-2xl border border-zinc-100 dark:border-zinc-700/30 p-8 sm:p-10 backdrop-blur-xl transition-all duration-300 transform hover:-translate-y-1">
            
            <div class="text-center space-y-2">
                <div class="inline-flex p-3 bg-pink-500/10 dark:bg-pink-500/20 text-pink-500 rounded-2xl mb-2 animate-bounce">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500 drop-shadow-sm">
                    UPLOAD VIDEO
                </h1>
                <p class="text-sm font-medium text-zinc-400 dark:text-zinc-500 tracking-wide">
                    Paste YouTube URL only 💖
                </p>
            </div>

            <?php if($message): ?>
                <?php 
                    $isSuccess = (strpos($message, 'successfully') !== false);
                    $bannerClass = $isSuccess 
                        ? 'bg-emerald-50 dark:bg-emerald-950/30 border-emerald-200 dark:border-emerald-900/50 text-emerald-600 dark:text-emerald-400' 
                        : 'bg-rose-50 dark:bg-rose-950/30 border-rose-200 dark:border-rose-900/50 text-rose-600 dark:text-rose-400';
                ?>
                <div class="mt-6 p-4 rounded-2xl border <?= $bannerClass ?> text-center font-semibold text-sm shadow-sm backdrop-blur-md animate-fade-in flex items-center justify-center gap-2">
                    <span><?= htmlspecialchars($message) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5 mt-8">

                <div class="relative group/input">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-400 group-focus-within/input:text-pink-500 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <input
                        type="url"
                        name="youtube_url"
                        placeholder="https://youtube.com/watch?v=..."
                        required
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-zinc-200 dark:border-zinc-700/60 bg-zinc-50/50 dark:bg-zinc-900/40 text-zinc-800 dark:text-zinc-100 font-medium placeholder-zinc-400 dark:placeholder-zinc-600 focus:outline-none focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 dark:focus:border-pink-500 transition-all duration-300">
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white py-4 rounded-2xl font-bold tracking-wide shadow-md shadow-pink-500/10 hover:shadow-lg hover:shadow-pink-500/20 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2">
                    <span>UPLOAD</span> 
                </button>

            </form>

        </div>

    </main>

    <div class="w-full z-50">
        <?php include '../cotton/snippets/footerkiss.php'; ?>
    </div>

</body>