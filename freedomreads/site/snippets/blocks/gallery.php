<div class="block-carousel block-wrapper">
   <div class="carousel">
         <?php
          $count = 1 ;
            $images =  $block->images()->toFiles();
         foreach($images as $image): {
            $count ++;
            }?>
            <div id="slide-<?= $count ?>" class="slide-item">
                  <figure> 
                     <img src="<?= $image->url() ?>"  alt="<?= $image->alt() ?>"> 
                     <figcaption class="caption"><?= $image->caption()->kirbytextinline() ?> <?php e($image->credit()->isNotEmpty(), '(Photo: '.$image->credit()->kirbytextinline().')') ?></figcaption>
                  </figure>
            </div>
         <?php endforeach ?>
   </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<?= js([
		'assets/js/slick.js'
	]) ?>
<script>
       $(document).on('ready', function() {
      
            $('.carousel').slick({
               dots: true,
               arrows: false,
               centerMode: true,
               centerPadding: '200px',
               slidesToShow: 1,

               responsive: [
                  {
                     breakpoint: 3000,
                     settings: {
                     centerPadding: '400px',
                     slidesToShow: 1
                     }
                  },
                  {
                     breakpoint: 1460,
                     settings: {
                     centerPadding: '200px',
                     slidesToShow: 1
                     }
                  },
                 
                  {
                     breakpoint: 1024,
                     settings: {
                     centerPadding: '150px',
                     slidesToShow: 1
                     }
                  },
                  {
                     breakpoint: 768,
                     settings: {
                     centerPadding: '100px',
                     slidesToShow: 1
                     }
                  },
                  {
                     breakpoint: 480,
                     settings: {
                     centerPadding: '24px',
                     slidesToShow: 1
                     }
                  }
               ]
            });
      });

</script>		

