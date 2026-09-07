<?php
/**
 * The template used for displaying featured post content in home.php
 */
?>

<article id="post-<?php the_ID(); ?>" class="grid_3">
	<div class="bratach">
		<?php if ( has_post_thumbnail()) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
			<?php the_post_thumbnail( 'featured', array('alt' => ''.get_the_title().'') ); ?>
		<?php else : ?>
			<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img src="<?php bloginfo('template_url'); ?>/img/default210.jpg" />
		<?php endif; ?>
			</a>
	</div>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<?php the_content_limit(150,"Continue Reading &rarr;"); ?>
</article><!-- #post-<?php the_ID(); ?> -->