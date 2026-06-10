<?php

include 'sugar/heartlink.php';

$query = mysqli_query(
    $heart,
    "SELECT sparkles.*, babes.nama
     FROM sparkles
     JOIN babes
     ON sparkles.babe_id = babes.id
     ORDER BY sparkles.created_at DESC"
);

?>

<?php include 'cotton/snippets/crown.php'; ?>

<title>MyTube</title>

<body class="bg-pink-50 dark:bg-zinc-900 transition duration-300">

<?php include 'cotton/snippets/ribbon.php'; ?>

<section class="text-center mt-12 px-6">

    <h2 class="text-5xl font-bold text-pink-600 dark:text-pink-400">
        Welcome to MyTube
    </h2>

    <p class="mt-4 text-gray-600 dark:text-gray-300 text-lg">
        by Nur Islami Sabila
    </p>

</section>

<section class="max-w-7xl mx-auto px-6 mt-12 mb-12">

    <h3 class="text-2xl font-bold text-pink-500 mb-6">
        Latest Videos ✨
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <?php while($video = mysqli_fetch_assoc($query)): ?>

            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition">

                <a href="pretty/watching.php?id=<?= $video['id'] ?>">

                    <img
                        src="<?= htmlspecialchars($video['thumbnail']) ?>"
                        class="w-full h-52 object-cover">

                </a>

                <div class="p-4">

                    <h4 class="font-bold text-lg dark:text-white">
                        <?= htmlspecialchars($video['judul']) ?>
                    </h4>

                    <p class="text-sm text-gray-500 mt-2">
                        by <?= htmlspecialchars($video['nama']) ?>
                    </p>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</section>

<?php include 'cotton/snippets/footerkiss.php'; ?>