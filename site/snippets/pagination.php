<nav class="nav-pagination">
  <ul>
    <?php if ($pagination->hasPrevPage()): ?>
    <li>
      <a href="<?= $pagination->prevPageURL() ?>">←</a>
    </li>
    <?php endif ?>

    <?php foreach ($pagination->range(12) as $r): ?>
    <li>
      <a<?= $pagination->page() === $r ? ' aria-current="page"' : '' ?> href="<?= $pagination->pageURL($r) ?>">
        <?= $r ?>
      </a>
    </li>
    <?php endforeach ?>

    <?php if ($pagination->hasNextPage()): ?>
    <li>
      <a href="<?= $pagination->nextPageURL() ?>">→</a>
    </li>
    <?php endif ?>
  </ul>
</nav>