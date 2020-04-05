<?php
$post->meta = get_post_meta($post->ID);
if (isset($post->meta['_agency'][0]))
	$post->meta += array('agency' => [0 => get_post($post->meta['_agency'][0])->post_title]);

?>
<article>
	<h2><a href='<?= get_post_permalink($post->ID)?>'><?= $post->post_title ?></a></h2>
	<?php if (isset($post->meta->cost_of[0])) : ?>
		<h3 class="cost-of"><?= $post->meta->cost_of[0] ?></h3>
	<?php endif?>
	<?php
	print_attributes(
		$post->meta,
		[
			'adress' => 'Adress',
			'area' => 'Area',
			'living_area' => 'Living area',
			'floor' => 'Floor',
			'agency' => 'Agency'
		]);
	?>
</article>
