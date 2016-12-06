<?php
/*
Template Name: Thumbnails
*/
?>

<?php get_header(); ?>

		<div id="wrapper">
			<div class="row">
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
			</div>

			<div class="row">
				<section>
					<?php $temp_query = $wp_query; ?>
					<?php $parent = $post->ID; ?>
					<?php query_posts('posts_per_page=100&post_type=page&orderby=menu_order&post_parent='.$parent); while (have_posts()) : the_post(); ?>

						<div class="thumb">
							<a href="<?php the_permalink(); ?>">
							<div class="fade">
								<?php the_post_thumbnail('small-thumb', array( 'class'	=> "rwp-not-responsive")); ?>
								<div class="details">
								</div>
							</div>
							<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							</a>
						</div>

					<?php endwhile; ?>
					<?php wp_reset_query() ?>
				</section>
			</div>

			<?php if( get_field('activate_content') ): ?>
			<div class="row">
				<section>
					<?php the_content(); ?>
				</section>
			</div>
			<?php endif; ?>
		</div>

<?php get_footer(); ?>