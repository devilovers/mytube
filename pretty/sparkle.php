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
        '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/',
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

<body class="bg-pink-50 dark:bg-zinc-900 transition duration-300">

<?php include '../cotton/snippets/ribbon.php'; ?>

<div class="max-w-2xl mx-auto mt-10">

<div class="bg-white dark:bg-zinc-800 rounded-3xl shadow-lg p-8">

    <h1 class="text-3xl font-bold text-center text-pink-500">
        Upload Video ✨
    </h1>

    <p class="text-center text-gray-500 mt-2">
        Paste YouTube URL only 💖
    </p>

    <?php if($message): ?>

        <div class="mt-5 p-3 rounded-xl bg-pink-100 text-pink-700 text-center">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>

    <form method="POST" class="space-y-4 mt-6">

        <input
            type="url"
            name="youtube_url"
            placeholder="https://youtube.com/watch?v=..."
            required
            class="w-full p-3 rounded-xl border">

        <button
            type="submit"
            class="w-full bg-pink-500 hover:bg-pink-600 text-white p-3 rounded-xl font-semibold">
            Upload 💖
        </button>

    </form>

</div>
</div>

<?php include '../cotton/snippets/footerkiss.php'; ?>
