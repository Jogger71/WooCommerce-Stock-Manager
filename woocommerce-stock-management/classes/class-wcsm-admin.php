<?php

/**
 * WooCommerce Stock Management Admin Class
 * @since 1.0.0
 */

if ( ! class_exist( 'WCSM_Admin' ) ) {
    class WCSM_Admin {

        public function __construct() {
            //  Add all the needed actions to create the admin pages
            add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
        }

	    public function add_admin_menus() {
		    add_menu_page(
			    'Stock Overview',
			    'WC Stock Manager',
			    'manage_options',
			    'wscm-stocks',
			    array( $this, 'wscm_admin_overview' )
		    );

		    add_submenu_page(
			    'wscm-stocks',
			    'Stock Overview',
			    'Overview',
			    'manage_options',
			    'wscm-stocks',
			    array( $this, 'wscm_admin_overview' )
		    );

		    add_submenu_page(
			    'wscm-stocks',
			    'Update Stock',
			    'Update Stock',
			    'manage_options',
			    'wscm-update-stocks',
			    array( $this, 'wscm_admin_updates' )
		    );

		    add_submenu_page(
			    'wscm-stocks',
			    'Stock Taking',
			    'Stock Take',
			    'manage_options',
			    'wscm-stock-take',
			    array( $this, 'wscm_admin_stock_take' )
		    );
	    }

	    public function wscm_admin_overview() {
		    include( ABSPATH . '');
	    }

	    public function wscm_admin_updates() {

	    }

	    public function wscm_admin_stock_take() {

	    }
    }
}