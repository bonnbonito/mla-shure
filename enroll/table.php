<?php

function create_table_enroll() {
    global $wpdb;
    $table_name = $wpdb->prefix . "enroll";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
      id bigint(20) NOT NULL AUTO_INCREMENT,
      course_tree bigint(20) NOT NULL,
      user_id bigint(20) NOT NULL,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      receipt varchar(55) NOT NULL,
      price varchar(55) NOT NULL,
      UNIQUE KEY id (id)
      ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

add_action( 'init', 'create_table_enroll', 1 );
