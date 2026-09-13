<?php
/** @var string|null $error */
use App\Support\Csrf;
?>
<div class="card">
    <h1>Login</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>

    <form method="post" action="/login">
        <?= Csrf::field() ?>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>No account? <a href="/register">Register</a></p>
</div>