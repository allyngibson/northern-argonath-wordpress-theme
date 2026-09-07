<?php
/**
 * The Sidebar containing the single widget area.
 */
?>
<div class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-single' ) )
		the_widget( 'Argo_hosts_Widget', array( 'title' => 'Blog Hosts' ) ); ?>
	<?php if ( is_active_sidebar( 'banner-1' ) ) : ?>
	<div class="row1">
		<?php dynamic_sidebar( 'banner-1' ); ?>
		<?php dynamic_sidebar( 'banner-2' ); ?>
	</div><!-- .row1 -->
		<?php if ( is_active_sidebar( 'banner-3' ) ) : ?>
		<div class="row2">
			<?php dynamic_sidebar( 'banner-3' ); ?>
			<?php dynamic_sidebar( 'banner-4' ); ?>
		</div><!-- .row2 -->
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'banner-5' ) ) : ?>
		<div class="row3">
			<?php dynamic_sidebar( 'banner-5' ); ?>
			<?php dynamic_sidebar( 'banner-6' ); ?>
		</div><!-- .row3 -->
		<?php endif; ?>
	<?php else : ?>
		<?php dynamic_sidebar( 'banner-home' ); ?>
	<?php endif; ?>
</div><!-- #main .widget-area -->