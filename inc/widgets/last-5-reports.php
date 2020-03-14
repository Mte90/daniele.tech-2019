<?php

class Last_Reports_Widget extends WPH_Widget {

    /**
     * Initialize the widget
     *
     * @return void
     */
    public function __construct() {
        // Configure widget array
        $args = array(
            'label'       => __( 'Last Reports', 'understrap' ),
            'description' => __( 'Last 5 FOSS Reports', 'understrap' ),
            'slug'        => 'last-reports'
        );

        // Configure the widget fields
        // Example for: Title ( text ) and Amount of posts to show ( select box )
        $args[ 'fields' ] = array(
            // Title field
            array(
                'name'  => __( 'Title', 'understrap' ),
                'id'    => 'title',
                'type'  => 'text',
                'class' => 'widefat',
                'std'   => __( 'Last FOSS reports', 'understrap' ),
            ),
        );
        // Create widget
        $this->create_widget( $args );
    }

    /**
     * Output function
     *
     * @param array $args     The argument shared to the output from WordPress.
     * @param array $instance The settings saved.
     *
     * @return void
     */
    public function widget( $args, $instance ) {
        $out  = $args[ 'before_widget' ];
        $out .= $args[ 'before_title' ];
		$out .= __( $instance[ 'title' ], 'understrap' );
		$out .= $args[ 'after_title' ];

		$out     .= '<ul>';
		$wpq      = array(
			'cat'            => '272',
			'posts_per_page' => 7,
			'lang'           => 'en',
			'order'          => 'DESC',
			'orderby'        => 'date',
		);
		$catquery = new WP_Query( $wpq );
		while ( $catquery->have_posts() ) {
			$catquery->the_post();
			$out .= '<li><a href="' . get_the_permalink() . '">' . str_replace( 'My free software and open source activities of ' , '', get_the_title() ) . '</a></li>' . "\n";
		};
		$out .= '</ul>';

		$out .= '<span class="btn btn-success archive"><a href="' . get_category_link( 272 ) . '">' . __( 'Archive', 'understrap' ) . '</a></span>' . "\n";

		$out .= $args[ 'after_widget' ];
		echo $out;
	}

}

// Register widget
if ( !function_exists( 'load_last_reports' ) ) {

	/**
	 * Initialize the widget
	 *
	 * @return void
	 */
	function load_last_reports() {
		register_widget( 'Last_Reports_Widget' );
	}

	add_action( 'widgets_init', 'load_last_reports', 1 );
}
