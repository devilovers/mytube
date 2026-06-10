<nav class="bg-pink-500 text-white px-8 py-4 flex justify-between items-center shadow-lg">

    <a href="/mytube/blush.php" class="text-3xl font-bold hover:opacity-90 transition">
        💖 MyTube V.1
    </a>

    <div class="flex items-center gap-3">

        <button
            id="themeBtn"
            class="bg-white text-pink-500 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
            🌙
        </button>

        <?php if(isset($_SESSION['babe_id'])): ?>

            <span class="font-semibold">
                Hi, <?= htmlspecialchars($_SESSION['babe_name']) ?> ✨
            </span>

            <a href="/mytube/pretty/profile.php"
               class="bg-white text-pink-500 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
               Profile
            </a>

            <a href="/mytube/pretty/sparkle.php"
               class="bg-white text-pink-500 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
               Upload
            </a>

            <a href="/mytube/glam/bye_babe.php"
               class="bg-white text-pink-500 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
               Logout
            </a>

        <?php else: ?>

            <a href="/mytube/glam/pinky.php"
               class="bg-white text-pink-500 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
               Register
            </a>

            <a href="/mytube/glam/darling.php"
               class="bg-white text-pink-500 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
               Login
            </a>

        <?php endif; ?>

    </div>

</nav>