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

			<section class="featured">
				<h1><?php the_title(); ?></h1>
				<?php the_field('right_panel'); ?>
				<h4><?php the_date('j<\s\u\p\>S\<\/\s\u\p\> F Y'); ?></h4>
				<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
			</section>

			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<section>
				<?php the_content(''); ?>
			</section>
			<?php endwhile; endif; ?>

		</div>

<?php get_footer(); ?>