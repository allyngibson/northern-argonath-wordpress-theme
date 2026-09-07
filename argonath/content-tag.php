<?php
/**
 * The template used for displaying post content in tag.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
	<header>
		<div class="post-meta top-meta">
			<?php if ( argo_has_custom_taxonomy(get_the_ID()) ): ?>
				<ul class="labels clearfix">
					<?php argo_the_post_labels( get_the_ID() ); ?>
				</ul>
			<?php endif; ?>  

			<ul class="meta-gestures clearfix">
				<li><?php argo_posted_on(); ?></li>
				<li class="meta-comments"><span class="comments-link"><?php comments_popup_link( 'Comment', '<strong>1</strong> Comment', '<strong>%</strong> Comments' ); ?></span></li>
			</ul>
		</div><!-- /.post-meta -->
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!-- / entry header -->
		
	<div class="entry-summary">
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="imgl">
			<?php if ( has_post_thumbnail()) : ?>
				<?php the_post_thumbnail( 'thumbnail' ); ?></a>
			<?php elseif ( in_category( 'twitter' )) : ?>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/twitter150.jpg" height="150" width="150" />
			<?php else : ?>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/default150.jpg" height="150" width="150" />
			<?php endif; ?>
		</a><!-- .imgl -->
		<?php the_content_limit(400, '<span class="readmore">'.__("Continue Reading &raquo;")."</span>"); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-<?php the_ID(); ?> -->