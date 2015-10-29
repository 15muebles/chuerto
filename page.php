<?php
get_header();
if ( is_bbpress() ) { $container_id = "id='foros' "; $content_class = "col-sm-12"; }
else { $container_class = ""; $content_class = "col-md-8 col-sm-9"; }
if ( have_posts() ) {
while ( have_posts() ) : the_post();

	$parent_tit = get_the_title();

	?>

<div <?php echo $container_id; ?>class="container-full">
<div class="container">
	<header class="row">
		<div class="col-md-12 col-sm-12">
			<h1 class="parent-tit"><?php echo $parent_tit; ?></h1>
		</div>
	</header>

	<section class="row page-desc">
		<div class="<?php echo $content_class; ?>">
			<?php the_content(); ?>
		</div>
	</section><!-- #<?php echo $parent_slug; ?> -->

</div><!-- .container -->
</div><!-- .container-full -->


<?php endwhile;
} // end if posts
?>

<?php get_footer(); ?>
