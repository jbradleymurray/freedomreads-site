<nav class="nav-global" data-nav="menu">
  <div class="wrapper-fullmenu">
    <div class="menu-group">
    <?php 
      $items = $site->children()->not([$site->children()->template('home'), $site->children()->findBy('slug','donate'), $site->children()->findBy('slug','home')])->listed() ;
      $last  = $items->last(); ?>
    <?php foreach ($items as $item):?>
      <div class="menu-item">
        <a <?php e($item->isOpen(), 'aria-current="page"') ?> href="<?= $item->url() ?>">
          <?= $item->title()->esc() ?>
        </a>
        <ul class="submenu-item">
          <?php if ($item->children()->count() > 0): ?>
              <?php foreach ($item->children()->listed() as $subitem): ?>
                <li>
                  <a <?php e($subitem->isOpen(), 'aria-current="page"') ?> href="<?= $subitem->url() ?>"><?= $subitem->title()->esc() ?></a>
                </li>
              <?php endforeach ?>
          <?php endif ?>
          <!-- <?php if($item == $last): ?>
            <div class="othermenu-item">
              <a href="<?= $site->url()?>/donate" class="btn-nofill">Donate</a>
              <a href="<?= $site->url()?>/news/newsletter/#signup" class="btn-nofill">Subscribe</a>
            </div>
          <?php endif ?> -->
        </ul>
      </div>
    <?php endforeach ?>
    <div class="nav-form-subsribe">
      <?php snippet('form-signup', ['form_id' => 'nav']); ?>
    </div>
   </div>
   <form id="search-bar" class="searchfield nav-search" action="<?= page('search')->url() ?>" method="get">
     <input type="search" placeholder="Search" aria-label="Search" name="q" >
     <button type="submit" value="Search">
     <svg class="icon-search" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
         <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0724 6.06878C14.721 8.28818 14.2583 11.4238 12.0389 13.0724C9.81947 14.721 6.68385 14.2583 5.03526 12.0389C3.38667 9.81947 3.84939 6.68385 6.06878 5.03526C8.28818 3.38667 11.4238 3.84939 13.0724 6.06878ZM14.1821 15.84C14.1634 15.8541 14.1447 15.8681 14.1259 15.8821C10.3548 18.6833 5.02683 17.897 2.22559 14.1259C-0.575644 10.3548 0.210604 5.02683 3.98173 2.22559C7.75286 -0.575645 13.0808 0.210605 15.8821 3.98173C17.9399 6.75211 18.0617 10.3627 16.4863 13.1945L22.8445 19.5526L20.3696 22.0275L14.1821 15.84Z"/>
     </svg></button>
   </form>
</div>
<div class="wrapper-menubar">
    <div class="nav-title">
      <a class="menu-home navpage-homepage" href="<?= $site->url() ?>">
       <span class="desktop"><?= $site->title()->esc() ?></span>
       <span class="mobile">FR</span>
      </a>
      <?php if ($page->parents()): ?>
        <?php foreach ($page->parents()->listed()->flip() as $parent): ?>
         <div class="breadcrumb navpage-parent"><a href="<?= $parent->url() ?>"><?= $parent->title() ?></a></div>
         <?php endforeach ?>
      <?php endif ?>
      <?php if ($page->title() !== "home" && !str_contains($page->template(), 'news-post')): ?>
        <div class="breadcrumb navpage-current"><?= $page->title() ?></div>
      <?php endif ?>
    </div>
    <div class="other-group">
      <a class="menu-donate" <?php if($page->slug() == 'donate'):?>aria-current="page"<?php endif ?> href="<?= $site->url();?>/donate">Donate</a>
      <div class="menu-search" id="search-button">
        <svg class="icon-search" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0724 6.06878C14.721 8.28818 14.2583 11.4238 12.0389 13.0724C9.81947 14.721 6.68385 14.2583 5.03526 12.0389C3.38667 9.81947 3.84939 6.68385 6.06878 5.03526C8.28818 3.38667 11.4238 3.84939 13.0724 6.06878ZM14.1821 15.84C14.1634 15.8541 14.1447 15.8681 14.1259 15.8821C10.3548 18.6833 5.02683 17.897 2.22559 14.1259C-0.575644 10.3548 0.210604 5.02683 3.98173 2.22559C7.75286 -0.575645 13.0808 0.210605 15.8821 3.98173C17.9399 6.75211 18.0617 10.3627 16.4863 13.1945L22.8445 19.5526L20.3696 22.0275L14.1821 15.84Z"/>
        </svg>
      </div>
      <div id="menu-toggle">
        <div class="btn-line"></div>
        <div class="btn-line"></div>
        <div class="btn-line"></div>
      </div>
    </div>
  </div>
</nav>