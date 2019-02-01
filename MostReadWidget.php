<?php

/**
 * Adds Most_Read_Widget widget.
 */
class Most_Read_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			esc_html__('Articoli più letti', 'text_domain'), // Name
			array('description' => esc_html__('Widget degli articoli più letti. Da usare solo nelle pagine di tipo post (articolo)', 'text_domain'),) // Args
		);
	}


	public function widget($args, $instance) {
		if (is_single()) {
			$category = get_the_category();
			//print_r ($category);
			$category_id = $category[0]->cat_ID;
			echo $args['before_widget'];
			echo $args['before_title'];
			echo "<h2 class='title-most'>Articoli più letti in  " . $category[0]->cat_name . "</h2>";
			echo $args['after_title'];
			$query_args = array(
				'cat' => $category_id,
				'meta_key' => 'post_views_count',
				'orderby' => 'meta_value_num',
				'posts_per_page' => $instance['number_posts']
			);
			$query = new WP_Query($query_args);
			while($query->have_posts()) : $query->the_post();
			?>
			<div style="position: relative;">
				<div style="position: absolute;">
					<a href="<?php the_permalink(); ?>">
						<img class="thumb-widget" src="<?php if (has_post_thumbnail()) {
						 echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); 
						} else {
							echo get_template_directory_uri() . '/images/no-thumb/td_80x60.png';
						}
							 
						?>"></a>
				</div>
				<div class="most-read-row">
					
					<a href="<?php the_permalink(); ?>">
						<?php echo wp_trim_words(get_the_title(), $instance['number_words']); ?>
					</a>
				</div>
				
			</div>
			<hr class="divisor-post">
			<?php
			endwhile;
			
			echo $args['after_widget'];
		}
	}

	
	public function form($instance) {
		if (isset($instance['number_posts'])) {
			$num = $instance['number_posts'];
		} else {
			$num = 5;
		}
		
		if (isset($instance['number_words'])) {
			$num_words = $instance['number_words'];
		} else {
			$num_words = 10;
		}
		// print_r ($instance);
		// Widget admin form
		?>
		<p>Usa questo widget solo nelle pagine di tipo post. In tutte le altre pagine non verrà mostrato.</p>
		<label><?php _e('Numero di posts da visualizzare:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" type="number" value="<?php echo $num; ?>" />
		
		<label><?php _e('Numero di parole da visualizzare per titolo:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('number_words'); ?>" name="<?php echo $this->get_field_name('number_words'); ?>" type="number" value="<?php echo $num_words; ?>" />
		
		<?php 
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['number_posts'] = (!empty($new_instance['number_posts'])) ? strip_tags($new_instance['number_posts']) : 5;
		$instance['number_words'] = (!empty($new_instance['number_words'])) ? strip_tags($new_instance['number_words']) : 10;
		return $instance;
	}

}
