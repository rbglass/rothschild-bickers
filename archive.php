<?php get_header(); ?>

		<div id="wrapper">
			<section>
				<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				<?php the_content(''); ?>
				<?php endwhile; endif; ?>
			</section>

			<section id="blog">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>

				<div class="post">
					<a href="<?php the_permalink(); ?>">
					<div class="fade">
						<?php the_post_thumbnail('small-thumb',array('title' => "")); ?>
						<div class="details"></div>
					</div>
					</a>
					
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<h4><?php the_time('j<\s\u\p\>S\<\/\s\u\p\> F Y') ?></h4>
				</div>

				<?php endwhile; ?>
			</section>

			<section>
				<div class="pagination"><?php rb_pagination('»', '«'); ?></div>
			</section>

		<?php endif; ?>
		</div>

<?php get_footer(); ?>