<script>
const btn = document.getElementById("themeBtn");

if(btn){

    function updateIcon() {
        btn.textContent =
            document.documentElement.classList.contains("dark")
            ? "☀️"
            : "🌙";
    }

    updateIcon();

    btn.addEventListener("click", () => {

        document.documentElement.classList.toggle("dark");

        if (document.documentElement.classList.contains("dark")) {
            localStorage.theme = "dark";
        } else {
            localStorage.theme = "light";
        }

        updateIcon();
    });
}
</script>

</body>
</html>