<?php

include '../sugar/heartlink.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $check = mysqli_query(
        $heart,
        "SELECT id FROM babes WHERE email='$email'"
    );

    if (mysqli_num_rows($check) > 0) {

        $message = "Email already registered 💔";

    } else {

        $secret = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        mysqli_query(
            $heart,
            "INSERT INTO babes(nama,email,password)
             VALUES('$nama','$email','$secret')"
        );

        $message = "Account created successfully 💖";
    }
}
?>

<?php include '../cotton/snippets/crown.php'; ?>

<title>Register • MyTube</title>

<body class="bg-pink-50 dark:bg-zinc-900 transition duration-300">

<?php include '../cotton/snippets/ribbon.php'; ?>

<div class="max-w-md mx-auto mt-20">

    <div class="bg-white dark:bg-zinc-800 rounded-3xl shadow-lg p-8">

        <h1 class="text-3xl font-bold text-center text-pink-500">
            Create Account ✨
        </h1>

        <?php if($message): ?>

            <div class="mt-5 p-3 rounded-xl bg-pink-100 text-pink-700 text-center">
                <?= $message ?>
            </div>

        <?php endif; ?>

        <form method="POST" class="mt-6 space-y-4">

            <input
                type="text"
                name="nama"
                placeholder="Your Name"
                required
                class="w-full p-3 rounded-xl border focus:outline-none focus:border-pink-500">

            <input
                type="email"
                name="email"
                placeholder="Email Address"
                required
                class="w-full p-3 rounded-xl border focus:outline-none focus:border-pink-500">

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
                class="w-full p-3 rounded-xl border focus:outline-none focus:border-pink-500">

            <button
                type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white p-3 rounded-xl font-semibold">
                Join MyTube 💖
            </button>

        </form>

        <p class="text-center mt-5 text-gray-500 dark:text-gray-300">
            Already have an account?
            <a href="darling.php"
               class="text-pink-500 font-semibold">
                Login
            </a>
        </p>

    </div>

</div>

<?php include '../cotton/snippets/footerkiss.php'; ?>