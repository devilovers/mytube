<?php

include '../sugar/heartlink.php';

/*
|--------------------------------------------------------------------------
| DELETE VIDEO
|--------------------------------------------------------------------------
*/

if (
    isset($_GET['delete']) &&
    isset($_SESSION['babe_id'])
) {

    $delete_id = (int) $_GET['delete'];

    $stmt = mysqli_prepare(
        $heart,
        "DELETE FROM sparkles
         WHERE id = ?
         AND babe_id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $delete_id,
        $_SESSION['babe_id']
    );

    mysqli_stmt_execute($stmt);

    header("Location: ../blush.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| GET VIDEO
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id'])) {
    header("Location: ../blush.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $heart,
    "SELECT sparkles.*, babes.nama
     FROM sparkles
     JOIN babes
     ON sparkles.babe_id = babes.id
     WHERE sparkles.id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$video = mysqli_fetch_assoc($result);

if (!$video) {
    header("Location: ../blush.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| GET YOUTUBE VIDEO ID
|--------------------------------------------------------------------------
*/

preg_match(
    '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/',
    $video['youtube_url'],
    $matches
);

$video_id = $matches[1] ?? '';

?>

<?php include '../cotton/snippets/crown.php'; ?>

<title><?= htmlspecialchars($video['judul']) ?> • MyTube</title>

<body class="bg-pink-50 dark:bg-zinc-900 transition duration-300">

<?php include '../cotton/snippets/ribbon.php'; ?>

<div class="max-w-5xl mx-auto mt-10 px-6 mb-10">

    <!-- VIDEO PLAYER -->
    <div class="aspect-video rounded-2xl overflow-hidden shadow-lg bg-black">

        <iframe
            class="w-full h-full"
            src="https://www.youtube.com/embed/<?= htmlspecialchars($video_id) ?>"
            title="<?= htmlspecialchars($video['judul']) ?>"
            allowfullscreen>
        </iframe>

    </div>

    <!-- TITLE -->
    <h1 class="text-4xl font-bold mt-6 text-pink-500">
        <?= htmlspecialchars($video['judul']) ?>
    </h1>

    <!-- UPLOADER -->
    <p class="text-gray-500 dark:text-gray-400 mt-2">
        Uploaded by <?= htmlspecialchars($video['nama']) ?>
    </p>

    <!-- OWNER ACTIONS -->
    <?php if (
        isset($_SESSION['babe_id']) &&
        $_SESSION['babe_id'] == $video['babe_id']
    ): ?>

        <div class="mt-5 flex gap-3">

            <a
                href="vanity.php?id=<?= $video['id'] ?>"
                class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-xl font-semibold transition">
                ✏️ Edit
            </a>

            <a
                href="watching.php?delete=<?= $video['id'] ?>"
                onclick="return confirm('Yakin ingin menghapus video ini?');"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold transition">
                🗑️ Delete
            </a>

        </div>

    <?php endif; ?>

    <!-- DESCRIPTION -->
    <div class="mt-6 bg-white dark:bg-zinc-800 p-6 rounded-2xl shadow">

        <h2 class="text-xl font-bold text-pink-500 mb-3">
            Description
        </h2>

        <p class="dark:text-white whitespace-pre-line">
            <?= htmlspecialchars($video['deskripsi']) ?>
        </p>

    </div>

</div>

<?php include '../cotton/snippets/footerkiss.php'; ?>