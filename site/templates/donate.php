<?php
session_start();
$nonce = $_SESSION['nonce'];
?>
<?php snippet('header') ?>
<main>
    <?php snippet('hero') ?>
    <?php snippet('page-intro', ['landing' => false]) ?>
    <section class="content">
        <div class="blocks grid">
            <?php snippet('form-donate') ?>
        </div>
        <div class="blocks">
            <?= $page->blocks()->toBlocks() ?>
        </div>
    </section>
</main>
<?php snippet('footer') ?>
