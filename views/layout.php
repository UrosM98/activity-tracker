<?php
/** @var string $content */
/** @var string $title */

use App\Core\Auth;

$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="/page-a">Activity Tracker</a>
    <nav>
        <?php if ($user !== null): ?>
            <a href="/page-a">Page A</a>
            <a href="/page-b">Page B</a>
            <?php if (Auth::isAdmin()): ?>
                <a href="/stat">Stats</a>
                <a href="/reports">Reports</a>
            <?php endif; ?>
            <span class="who"><?= htmlspecialchars($user['email'], ENT_QUOTES) ?></span>
            <form method="post" action="/logout" style="display:inline">
                <button type="submit">Logout</button>
            </form>
        <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <?= $content ?>
</main>
</body>
</html>