<?php
/**
 * The Sidebar containing the 468x60 banners on the home page.
 */
?>

<?php if ( is_active_sidebar( 'widebanner-1' ) ) : ?>
	<!-- 468x80 ad banners side by side -->
	<div id="bratach" class="grid_12 clearfix">
		<?php dynamic_sidebar( 'widebanner-1' ); ?>
		<?php dynamic_sidebar( 'widebanner-2' ); ?>
	</div><!-- #bratach .grid_12 -->

<?php endif; ?>