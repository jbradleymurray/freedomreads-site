<?php snippet('header') ?>
<?php 
function groupResults( $results ){
  $groups = $results->group(function($item) {
    $groupkey = "";
    if( $item->parent() ){
      $groupkey = $item->parent()->title();
    }else{
      $groupkey = $item->title();
    }
    return $groupkey;
  });

  $order = ['freedom library', 'showing up', 'blog', 'newsletter', 'press releases', 'shibumi', 'people', 'about', 'news'];
  $groupArray = $groups->toArray();
  $sorted = [];
  foreach( $order as $parent ){
    if( array_key_exists( $parent, $groupArray )){
      $sorted[$parent] = $groupArray[ $parent ];
    }
  }
  return $sorted;
}

function extractContext($text, $searchTerm) {
    $position = stripos($text, $searchTerm);
    if ($position === false) {
        return false;
    }
    // Find word boundaries before the search term
    $contextStart = max(0, $position - 50);
    $wordBoundaryStart = strrpos(substr($text, 0, $contextStart), ' ');
    $contextStart = ($wordBoundaryStart !== false) ? $wordBoundaryStart + 1 : 0;
    
    // Find word boundaries after the search term
    $contextEnd = min($position + strlen($searchTerm) + 50, strlen($text));
    $wordBoundaryEnd = strpos($text, ' ', $contextEnd);
    $contextEnd = ($wordBoundaryEnd !== false) ? $wordBoundaryEnd : strlen($text);
    
    // Extract the context
    $context = substr($text, $contextStart, $contextEnd - $contextStart);
        
    $context = preg_replace_callback('/' . preg_quote($searchTerm, '/') . '/i', function($match) {
        return '<span class="searchterm-highlight">' . $match[0] . '</span>';
    }, $context);
    
    return $context;
}

function getResultText($text, $query){
  $cleantext = Str::unhtml($text);

  $excerpt = "";
  $matching = stripos($cleantext, $query);
  if( $matching || $matching === 0 ){    
    $excerpt = $cleantext;
    $context = extractContext($cleantext, $query);
    if ($context) {
      $excerpt = $context;
    }else{
      $excerpt = "Search term not found in text.";
    }
  }
  return $excerpt;
}

//Add image caption matches
$files = $site->index()->files();
$fileresults = $files->search($query);
foreach( $fileresults as $file ){
  if( $file->caption() ){
    if( Str::contains($file->caption(), $query, true)){
      $parent = $file->parent();
      if( !$results->has($parent) ){
        $results->append($parent);
      }
    }
  } 
}
?>


<?php $groupresults = groupResults( $results ); ?>
<main>
<section class="grid results-grid">  
  <div class="results-list">
    <h1>Search Results</h1>
    <?php if ( count($results) == 0 ):?>
      <p class="results-none">We’re sorry, no pages matched your search. Please try something else.</p>
    <?php else:?>
      <?php snippet('search-list', ['groups' => $groupresults ]) ?>
    <?php endif;?>
  </div>
  <div class="results-toc">
    <form id="search-page" class="searchfield">
      <input type="search" placeholder="Search" aria-label="Search" name="q" value="<?= html($query) ?>">
      <button type="submit" value="Search">
      <svg id="search-icon" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0724 6.06878C14.721 8.28818 14.2583 11.4238 12.0389 13.0724C9.81947 14.721 6.68385 14.2583 5.03526 12.0389C3.38667 9.81947 3.84939 6.68385 6.06878 5.03526C8.28818 3.38667 11.4238 3.84939 13.0724 6.06878ZM14.1821 15.84C14.1634 15.8541 14.1447 15.8681 14.1259 15.8821C10.3548 18.6833 5.02683 17.897 2.22559 14.1259C-0.575644 10.3548 0.210604 5.02683 3.98173 2.22559C7.75286 -0.575645 13.0808 0.210605 15.8821 3.98173C17.9399 6.75211 18.0617 10.3627 16.4863 13.1945L22.8445 19.5526L20.3696 22.0275L14.1821 15.84Z"/>
      </svg></button>
    </form>
    <?php if($groupresults): ?>
    <?php foreach ($groupresults as $groupname => $items):
      ?>
      <a href="#anchor-<?= Str::slug($groupname) ?>" class="result-group"> <?=$groupname ?> (<?= count($items) ?>)</a>
    <?php endforeach ?>
    <?php endif ?>
  </div>
</section>
</main>
<?php snippet('footer') ?>