<?php
class snapchatwidget extends WP_Widget {

	function __construct() {

		parent::__construct('snapchatwidget',__( SW_NAME, SW_DOMAIN ), array( 'description' => __( SW_DESC, SW_DOMAIN ), ) );

	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {

		$title = apply_filters( 'snapchatwidget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		$text   = $instance['text'];

		// This is where you run the code and display the output
		if( $instance['image'] ){

			if( '' != $instance['post_link'] ){
				$link_int_val =  (int)  $instance['post_link'] ;

				if( 0 != $link_int_val && is_int ( $link_int_val ) ){
					$post_link = esc_url( get_permalink( (int) $instance['post_link'] ) );
				}
				else{
					$post_link = esc_url( $instance['post_link'] );
				}

			}
			$widget_output = NULL;
			if( isset( $post_link ) && '' != $post_link )
				$widget_output.= '<a href="'.$post_link.'" target="'.($instance['link_target']?'_blank':'').'">';
			
			$widget_output.= '<img src="'.esc_url($instance['image']).'" alt="Snapchat Snapcode" style="min-width: 1.3in; max-width: 1.6in; height: auto;"/>';

			if( isset( $post_link ) && '' != $post_link )
				$widget_output.= '</a>';

			

			echo apply_filters($widget_output,$widget_output);
			if (!empty($text))
     		 echo '<p>'. $text .'</p>';
		}
		
		echo $args['after_widget'];

	}
			
	// Widget Backend 
	public function form( $instance ) {
	
		$title = ( isset( $instance['title'] ) ) ? $instance['title'] : '';
		$image = ( isset( $instance['image'] ) ? $instance['image'] : '' );
		$text = ( isset( $instance['text'] ) ? $instance['text'] : '' );
		$post_link = ( isset( $instance['post_link'] ) ? $instance['post_link'] : '' );
		$link_target = ( isset( $instance['link_target'] ) ? $instance['link_target'] : '' );
		$instance['text'] = strip_tags($new_instance['text']);
		
		// Widget admin form
		?>
	
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Snapcode image:'); ?> <span title="<?php _e('Upload your snapcode.png here.'); ?>">?</span></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>" />
				<span class="submit">
					<input type="button" name="submit" id="submit" class="button delete button-primary SW-upload_image_button" value="Select image">
				</span>
			</p>
			 <p>
          <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Custom text (Optional)'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
        </p>

			<p>
				<label for="<?php echo $this->get_field_id( 'post_link' ); ?>"><?php _e( 'Link (Optional)'); ?> <span  title="<?php _e('When someone clicks on your snapcode they will go to the given link.'); ?>">?</span></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'post_link' ); ?>" name="<?php echo $this->get_field_name( 'post_link' ); ?>" type="text" value="<?php echo esc_attr( $post_link ); ?>" />
			</p>

			<p>
				<input type="checkbox" value="1" class="checkbox" id="<?php echo $this->get_field_id( 'link_target' ); ?>" name="<?php echo $this->get_field_name( 'link_target' ); ?>" <?php echo ( '' != $link_target)?'checked="checked"':''; ?>  >
				<label for="<?php echo $this->get_field_id( 'link_target' ); ?>"><?php _e( 'Open link in new window/ tab'); ?></label>
			</p>
			<em>Go to https://accounts.snapchat.com/accounts/snapcodes to get your snapcode.</em>


	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? esc_url( strip_tags( $new_instance['image'] ) ) : '';
		$instance['post_link'] = ( ! empty( $new_instance['post_link'] ) ) ?  strip_tags( $new_instance['post_link'] ): '';
		$instance['link_target'] = ( $new_instance['link_target'] ) ?  'on' : '';
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		return $instance;
	}
} # END: Class snapchatwidget