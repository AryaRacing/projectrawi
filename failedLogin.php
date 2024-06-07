<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Login</title>
</head>
<body>
    <h1>Login Failed</h1>
    <p>Anda telah salah memasukkan username atau password. Silakan coba lagi dalam 20 detik.</p>
    <p>Redirecting in <span id="countdown">20</span> seconds...</p>

    <script>
        // Countdown timer
        var countdown = 20;
        var countdownInterval = setInterval(function() {
            countdown--;
            document.getElementById('countdown').innerText = countdown;
            if (countdown == 0) {
                clearInterval(countdownInterval);
                window.location.href = 'index.php'; // Redirect ke halaman login setelah countdown selesai
            }
        }, 1000);
    </script>
</body>
</html>
