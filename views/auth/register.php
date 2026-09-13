<?php
use App\Support\Csrf;
?>
<div class="card">
    <h1>Register</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>

    <form method="post" action="/register">
        <?= Csrf::field() ?>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="6">

        <button type="submit">Create account</button>
    </form>

    <p>Already have an account? <a href="/login">Login</a></p>
</div>