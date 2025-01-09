<html>
    <body>
        <h2>Logout</h2>
        <?php if (isset($error) && $error): ?>
            <p style="color: red;"><?= esc($error) ?></p>
        <?php endif; ?>
        <form action="ammar/logout" method="POST">
            <button type="submit">Logout</button>
        </form>
    </body>
</html>
