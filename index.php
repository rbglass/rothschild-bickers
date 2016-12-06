<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>

		<div id="wrapper">
			<section>
				<?php
				if ( has_post_thumbnail() ) {
				$thumbnail_id = get_post_thumbnail_id( $post->ID );
				// Generate an <img> tag with srcset/sizes attributes.
				echo rwp_img( $thumbnail_id );
				}
				?>
			</section>

			<?php if( get_field('right_panel') ): ?>
			<section class="featured">
				<?php the_field('right_panel'); ?>
			</section>
			<?php endif; ?>

			<?php if( get_field('activate_content') ): ?>
			<div class="row">
				<section>
					<?php the_content(); ?>
				</section>
			</div>
			<?php endif; ?>
		</div>
		
<?php get_footer(); ?>
