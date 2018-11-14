<?php

// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

class wpb_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

// Base ID of your widget
            'wpb_widget',

// Widget name will appear in UI
            __('Тестовый виджет', 'wpb_widget_domain'),

// Widget description
            array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
        $meta_value = get_post_meta( get_the_ID() );
        echo "<h2>$title</h2>";
// Checks and displays the retrieved value
        if( !empty( $meta_value ) ) {

            echo '<div itemprop="name"><h1>'.$meta_value["meta-name"][0].'</h1></div>
                  <div itemprop="description">'.$meta_value["meta-description"][0].'</div>
                   <a itemprop="image" href=​"../">
                     <img src='.$meta_value["meta-image"][0].' title="Кровать Мелисса с мягкой спинкой">
                   </a>
                  <div> '.$meta_value["meta-price"][0].'</div>
                <div>'.$meta_value["meta-priceCurrency"][0].'</div>';
        }
    }

// Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wpb_widget_domain' );
        }
// Widget admin form
        ?>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Шорткод : [myshortcode]' ); ?></label>
        <?php
    }

// Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here

//---------------end wiget -----------------//