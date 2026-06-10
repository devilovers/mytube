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

mysqli_stmt_execute($stmt);

$videos = mysqli_stmt_get_result($stmt);

$total_video = mysqli_num_rows($videos);

?>

<?php include '../cotton/snippets/crown.php'; ?>

<title>My Profile • MyTube</title>

<body class="bg-pink-50 dark:bg-zinc-900 transition duration-300">

<?php include '../cotton/snippets/ribbon.php'; ?>

<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="bg-white dark:bg-zinc-800 rounded-3xl shadow-lg p-8">

        <div class="flex items-center gap-6">

            <div class="w-24 h-24 rounded-full bg-pink-500 flex items-center justify-center text-4xl text-white">
                💖
            </div>

            <div>

                <h1 class="text-3xl font-bold text-pink-500">
                    <?= htmlspecialchars($user['nama']) ?>
                </h1>

                <p class="text-gray-500">
                    <?= htmlspecialchars($user['email']) ?>
                </p>

                <p class="mt-2 font-semibold text-pink-500">
                    <?= $total_video ?> Video Uploaded
                </p>

            </div>

        </div>

    </div>

    <h2 class="text-2xl font-bold text-pink-500 mt-10 mb-6">
        My Videos ✨
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <?php mysqli_data_seek($videos, 0); ?>

        <?php while($video = mysqli_fetch_assoc($videos)): ?>

            <div class="bg-white dark:bg-zinc-800 rounded-2xl overflow-hidden shadow-lg hover:scale-105 transition">

                <a href="watching.php?id=<?= $video['id'] ?>">

                    <img
                        src="<?= htmlspecialchars($video['thumbnail']) ?>"
                        class="w-full h-52 object-cover">

                </a>

                <div class="p-4">

                    <h3 class="font-bold dark:text-white">
                        <?= htmlspecialchars($video['judul']) ?>
                    </h3>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</div>

<?php include '../cotton/snippets/footerkiss.php'; ?>