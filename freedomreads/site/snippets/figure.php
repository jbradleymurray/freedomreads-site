<?php 
$imgSize = '2000'; //default

if ($size == 'thumb'){
	$img = $image->thumb(([
		'width'   => 300,
		'format'	=>'webp'
	]))->url();
}else{
	$imgSize = $size;
	$img = $image->thumb(([
		'crop'  	=> false,
		'width'   => $imgSize,
		'format'	=>'webp'
	]))->url();
}
?>
<figure>
<picture>
	<img
			alt="<?php if($image->alt()->isNotEmpty()): echo esc($image->alt(), 'attr'); endif ?>"
			title="<?php if($image->caption()->isNotEmpty()): echo esc($image->caption(), 'attr'); endif ?>"
			src="<?= $img ?>"
	>
</picture>
<?php if ( $size !== 'thumb' && $image->caption()->isNotEmpty()): ?>
<figcaption><?= $image->caption()->kirbytextinline() ?><?php e($image->credit()->isNotEmpty(), '(Photo: '.$image->credit()->kirbytextinline().')') ?>
</figcaption>
<?php endif?>
</figure>