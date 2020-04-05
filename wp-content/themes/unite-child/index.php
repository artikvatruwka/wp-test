<?php
get_header();

$posts = get_real_estates();
?>
<div id="primary" class="content-area col-sm-12 col-md-8">
    <main id="main" class="site-main" role="main">
		<?php if ($posts) : ?>
			<?php print_posts($posts) ?>
		<?php endif; ?>
    </main>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

