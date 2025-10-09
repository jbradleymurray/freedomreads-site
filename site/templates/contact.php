<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
  <div class="grid">
    <?php $contacts = $page->contacts()->toStructure();
      foreach ($contacts as $contact): ?>
        <div class="contact-item">
          <h2 class="header"><?= $contact->department() ?></h2>
          <p><a href="mailto:<?= $contact->email() ?>"><?= $contact->email() ?></a></p>
        </div>
    <?php endforeach; ?>

    <div class="contact-press">
      <h2 class="header">Press</h2>
      <?= $page->presscontact()->kirbytext() ?>
      <a href="<?= $site->url();?>/news/press-kit" class="btn-page">Press Kit</a>
    </div>

    <div class="contact-general">
      <h2 class="header">Address</h2>
      <div class="info">
        <strong>Freedom Reads</strong>
        <?= $page->address()->kirbytext() ?></div>
    </div>
  </div>
</section>

</main>
<?php snippet('footer') ?>