<?php
/**
 * Adds Agency_Widget widget.
 */
class Agency_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'agency_widget',
			'Agencies',
			array( 'description' => __( 'A Agency Widget', 'text_domain' ), )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$query = new WP_Query(['post_type' => 'agency']);
		$agencies = $query->posts;

		?>
        <select class="form-control" id="agency-widget">
            <option value="">All</option>
            <?php foreach ($agencies as $agency) : ?>
            <option value=<?=$agency->ID ?>><?= $agency->post_title?></option>
            <?php endforeach; ?>
        </select>
        <?php
		echo $after_widget;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}