<?php

require_once( get_template_directory() . '/inc/ajax.php' );
require_once( get_template_directory() . '/inc/terms-in-comments.php' );
require_once( get_template_directory() . '/inc/mentions.php' );

add_action( 'wp_enqueue_scripts', 'participe_styles' );
function participe_styles() {

	wp_register_style( 'p2', get_template_directory_uri().'/style.css' );
	wp_register_style( 'participe', get_stylesheet_uri(), array('p2') );

	wp_enqueue_style( 'p2' );
	wp_enqueue_style( 'participe' );

}

class Participe_P2_Mentions extends P2_Mentions {

    function load_users() {

        // Cache the user information.
		if ( ! empty( $this->users ) )
	 		return $this->users;

        global $wp_query;

        $users = array();

        // Get the last active users only for the queried posts
        foreach( $wp_query->posts as $p ) {
            $users[] = $p->post_author;
            $args = array(
                'post_id' => $p->ID,
                'number' => 10
            );
            foreach( get_comments( $args ) as $c ) {
                $users[] = $c->user_id;
            }
        }

        foreach( $users as $user ) {
            if ( $u = get_user_by( 'id', $user ) ) {
                $this->users[ $u->data->ID ] = $u->data;
                $this->names[ $u->data->ID ] = $u->user_nicename;
            }
        }

		return $this->users;

    }

}

add_filter( 'p2_add_component_mentions', 'participe_add_component_mentions' );
function participe_add_component_mentions() {
    return 'Participe_P2_Mentions';
}
