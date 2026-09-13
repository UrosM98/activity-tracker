<?php
/** @var bool $alreadyBought */
use App\Support\Csrf;
?>
<div class="card">
    <h1>Page A</h1>
    <?php if ($alreadyBought): ?>
        <p class="thankyou">Thank you!!!</p>
    <?php else: ?>
        <p>Click below to buy a cow.</p>
        <form method="post" action="/buyCow">
            <?= Csrf::field() ?>
            <button type="submit">Buy a cow</button>
        </form>
    <?php endif; ?>
</div>