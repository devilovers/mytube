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

<body class="bg-gradient-to-br from-pink-50 to-white dark:from-zinc-950 dark:to-zinc-900 h-screen text-zinc-800 dark:text-zinc-100 transition-colors duration-500 antialiased flex flex-col justify-between selection:bg-pink-500 selection:text-white overflow-hidden">

    <div class="w-full z-50">
        <?php include '../cotton/snippets/ribbon.php'; ?>
    </div>

    <main class="flex-1 flex items-center justify-center p-6 w-full relative">
        
        <div class="max-w-md w-full">
            <div class="bg-white/80 dark:bg-zinc-800/60 rounded-3xl shadow-xl hover:shadow-2xl border border-zinc-100 dark:border-zinc-700/30 p-8 backdrop-blur-xl transition-all duration-300 transform hover:-translate-y-1">

                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold tracking-tight text-pink-500 drop-shadow-sm">
                        Welcome Back 💖
                    </h1>
                    <p class="text-xs font-semibold text-zinc-400 dark:text-zinc-500 mt-2 tracking-wide uppercase">
                        Please login to your account
                    </p>
                </div>

                <?php if($message): ?>
                    <div class="mb-6 p-3.5 rounded-2xl bg-rose-50 dark:bg-rose-950/30 text-rose-500 border border-rose-100 dark:border-rose-950/50 text-center font-bold text-xs tracking-wide animate-pulse">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-5">

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 pl-1">Email Address</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-zinc-400 dark:text-zinc-500 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                                </svg>
                            </span>
                            <input
                                type="email"
                                name="email"
                                placeholder="example@gmail.com"
                                required
                                class="w-full p-3.5 pl-12 rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-900/50 focus:bg-white dark:focus:bg-zinc-900 text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600 focus:outline-none focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all duration-300 text-sm font-medium">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 pl-1">Password</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-zinc-400 dark:text-zinc-500 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            
                            <input
                                id="passwordInput"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                class="w-full p-3.5 pl-12 pr-12 rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-900/50 focus:bg-white dark:focus:bg-zinc-900 text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600 focus:outline-none focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500 transition-all duration-300 text-sm font-medium">
                            
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                id="toggleBtn"
                                class="absolute right-4 text-zinc-400 hover:text-pink-500 dark:text-zinc-500 dark:hover:text-pink-400 focus:outline-none select-none transition-colors duration-200">
                                <svg id="eyeShowIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeHideIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white p-3.5 rounded-2xl font-bold text-sm tracking-wide shadow-lg shadow-pink-500/20 hover:shadow-pink-500/30 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 mt-2">
                        Login 💕
                    </button>

                </form>

                <div class="text-center mt-6 pt-4 border-t border-zinc-100 dark:border-zinc-700/50">
                    <p class="text-xs font-semibold text-zinc-400 dark:text-zinc-500">
                        Don't have an account? 
                        <a href="/mytube/glam/pinky.php" class="text-pink-500 hover:text-pink-600 font-bold ml-1 transition-colors">Register here</a>
                    </p>
                </div>

            </div>
        </div>

    </main>

    <div class="w-full z-50">
        <?php include '../cotton/snippets/footerkiss.php'; ?>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeShowIcon = document.getElementById('eyeShowIcon');
            const eyeHideIcon = document.getElementById('eyeHideIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeShowIcon.classList.add('hidden');
                eyeHideIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeShowIcon.classList.remove('hidden');
                eyeHideIcon.classList.add('hidden');
            }
        }
    </script>

</body>