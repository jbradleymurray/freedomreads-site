<?php snippet('header') ?>
<main>
<?php snippet('post-intro') ?>
<section class="content">  
  <?= $page->blocks()->toBlocks() ?>
  <div class="grid">
    <div class="content-text post-footer">  
      <h3>About Freedom Reads</h3>
      <?= $page->parent()->aboutfr()->kirbytext() ?>
    </div>
  </div>
<?php if ($page->contactinfo()->isNotEmpty()): ?>
  <div class="grid">
    <div class="content-text post-footer">
      <div class="contactinfo-list">
        <h3>For more information, please contact</h3>
        <?php  $contactinfos = $page->contactinfo()->toStructure();
        foreach ($contactinfos as $contact): ?>
          <div class="contactinfo">
            <?= $contact->name() ?><br>
            <?php e($contact->position()->isNotEmpty(), $contact->position().', ' ); ?>
            <?php e($contact->organization()->isNotEmpty(), $contact->organization())?><br>
            <?php e($contact->email()->isNotEmpty(), '<a href="mailto:'.$contact->email().'">'.$contact->email().'</a>')?><?php e($contact->phone()->isNotEmpty(), " | " . $contact->phone() ); ?>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
<?php endif ?>

</section>
<?php snippet('nav-more') ?>
</main>
<?php snippet('footer') ?>