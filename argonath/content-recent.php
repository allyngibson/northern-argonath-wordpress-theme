<?php
/**
 * The template used for displaying recent blurbs in home.php
 */
?>

<article id="post-<?php the_ID(); ?>" class="grid_4 <?php echo $position; ?> clear">
	<div class="imgholder">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		<?php if ( has_post_thumbnail()) : ?>
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		<?php else : ?>
			<img src="<?php bloginfo('template_url'); ?>/img/default80.jpg" />
		<?php endif; ?>
		</a>
	</div><!-- .imgholder -->
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?></a>
	<?php the_content_limit(70, '<span class="readmore">'.__("Continue Reading &raquo;")."</span>"); ?>
</article><!-- #post-<?php the_ID(); ?> -->