<?php
/**
 * The template used for displaying featured image content in home.php
 */
?>

<li id="post-<?php the_ID(); ?>" class="featured_slide_Image">
	<?php if ( has_post_thumbnail()) : ?>
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'banner', array('alt' => ''.get_the_title().'') ); ?></a>
	<?php endif; ?>
	<div class="introtext">
		<h2><?php the_title(); ?></h2>
		<?php the_excerpt(); ?>
	</div><!-- .introtext -->
</li><!-- #post-<?php the_ID(); ?> -->