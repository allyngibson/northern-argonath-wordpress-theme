<?php
/**
 * The template used for displaying homepage post content in the main area
 */

global $position;
?>

<article id="post-<?php the_ID(); ?>" class="grid_4 <?php echo $position; ?> clear">
	<div class="imgholder">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		<?php if ( has_post_thumbnail()) : ?>
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		<?php else : ?>
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/default150.jpg" />
		<?php endif; ?>
		</a>
	</div><!-- .imgholder -->
	<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?></a></h3>
	<?php the_content_limit(70, '<span class="readmore">'.__("Continue Reading &rarr;")."</span>"); ?>
</article><!-- #post-<?php the_ID(); ?> -->
