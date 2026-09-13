<?php
use App\Support\Csrf;
?>
<div class="card">
    <h1>Page B</h1>
    <p>Click to download file</p>
    <form method="post" action="/download">
        <?= Csrf::field() ?>
        <button type="submit">Download</button>
    </form>
</div>