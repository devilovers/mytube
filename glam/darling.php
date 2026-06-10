<?php

include '../sugar/heartlink.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare(
        $heart,
        "SELECT * FROM babes WHERE email = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        if (
            password_verify(
                $password,
                $user['password']
            )
        ) {

            $_SESSION['babe_id'] = $user['id'];
            $_SESSION['babe_name'] = $user['nama'];

            header("Location: ../blush.php");
            exit;
        }
    }

    $message = "Wrong email or password 💔";
}

?>

<?php include '../cotton/snippets/crown.php'; ?>

<title>Login • MyTube</title>

<body class="bg-pink-50 dark:bg-zinc-900 transition duration-300">

<?php include '../cotton/snippets/ribbon.php'; ?>

<div class="max-w-md mx-auto mt-20">

    <div class="bg-white dark:bg-zinc-800 rounded-3xl shadow-lg p-8">

        <h1 class="text-3xl font-bold text-center text-pink-500">
            Welcome Back 💖
        </h1>

        <?php if($message): ?>

            <div class="mt-5 p-3 rounded-xl bg-red-100 text-red-600 text-center">
                <?= $message ?>
            </div>

        <?php endif; ?>

        <form method="POST" class="mt-6 space-y-4">

            <input
                type="email"
                name="email"
                placeholder="Email Address"
                required
                class="w-full p-3 rounded-xl border">

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
                class="w-full p-3 rounded-xl border">

            <button
                type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white p-3 rounded-xl font-semibold">
                Login 💕
            </button>

        </form>

    </div>

</div>

<?php include '../cotton/snippets/footerkiss.php'; ?>