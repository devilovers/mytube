<?php

include '../sugar/heartlink.php';

if (!isset($_SESSION['babe_id'])) {
    header("Location: ../glam/darling.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare(
    $heart,
    "SELECT *
     FROM sparkles
     WHERE id = ?
     AND babe_id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $id,
    $_SESSION['babe_id']
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$video = mysqli_fetch_assoc($result);

if (!$video) {
    header("Location: ../blush.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);

    $stmt = mysqli_prepare(
        $heart,
        "UPDATE sparkles
         SET judul = ?, deskripsi = ?
         WHERE id = ?
         AND babe_id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssii",
        $judul,
        $deskripsi,
        $id,
        $_SESSION['babe_id']
    );

    mysqli_stmt_execute($stmt);

    $message = "Video updated successfully 💖";

    $video['judul'] = $judul;
    $video['deskripsi'] = $deskripsi;
}

?>

<?php include '../cotton/snippets/crown.php'; ?>

<title>Edit Video</title>

<body class="bg-pink-50 dark:bg-zinc-900">

<?php include '../cotton/snippets/ribbon.php'; ?>

<div class="max-w-2xl mx-auto mt-10">

    <div class="bg-white dark:bg-zinc-800 p-8 rounded-3xl shadow-lg">

        <h1 class="text-3xl font-bold text-pink-500 text-center">
            Edit Video ✨
        </h1>

        <?php if($message): ?>

            <div class="mt-4 p-3 bg-pink-100 text-pink-700 rounded-xl">
                <?= $message ?>
            </div>

        <?php endif; ?>

        <form method="POST" class="mt-6 space-y-4">

            <input
                type="text"
                name="judul"
                value="<?= htmlspecialchars($video['judul']) ?>"
                required
                class="w-full p-3 rounded-xl border">

            <textarea
                name="deskripsi"
                rows="5"
                class="w-full p-3 rounded-xl border"><?= htmlspecialchars($video['deskripsi']) ?></textarea>

            <button
                type="submit"
                class="w-full bg-pink-500 text-white p-3 rounded-xl">
                Save Changes 💖
            </button>

        </form>

    </div>

</div>

<?php include '../cotton/snippets/footerkiss.php'; ?>