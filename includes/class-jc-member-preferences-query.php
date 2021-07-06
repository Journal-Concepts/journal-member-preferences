<?php
/**
 * Sets up our My Account endpoint.
 *
 * @link       21applications.com
 * @since      1.0.0
 *
 * @package    JC_Member_Locker
 * @subpackage JC_Member_Locker/includes
 * @author     Roger Coathup <roger@21applications.com>
 */
class JC_Member_Locker_Query extends WC_Query {

	protected $url = 'member-preferences';
	protected $name = 'Member Locker';

	public function __construct() {

		$options = get_option( 'jc_optionslocker' );
		$this->url = isset( $options['url'] ) ? $options['url'] : 'member-preferences';
		$this->name = isset( $options['name'] ) ? $options['name'] : 'Member Locker';

		add_action( 'init', [ $this, 'add_endpoints' ] );

		if ( ! is_admin() ) {

			add_filter( 'query_vars', [ $this, 'add_query_vars' ], 0 );
			add_filter( 'woocommerce_get_query_vars', [ $this, 'add_jc_member_preferences_query_vars' ] );

			// Inserting your new tab/page into the My Account page.
			add_filter( 'woocommerce_endpoint_'  . $this->url . '_title', array($this, 'title'), 0);
			add_filter( 'woocommerce_account_menu_items', [ $this, 'add_menu_items' ] );
			add_action( 'woocommerce_account_' . $this->url . '_endpoint', [ $this, 'endpoint_content' ] );

		}

		$this->init_query_vars();

		
	}

	/**
	 * Init query vars by loading options.
	 *
	 * @since 2.0
	 */
	public function init_query_vars() {
		$this->query_vars = [
			$this->url => $this->url,
        ];
	}

	public function title() {
		return $this->name;
	}


    
    /**
	 * Check if the current query is for a type we want to override.
	 *
	 * @param  string $query_var the string for a query to check for
	 * @return bool
	 */
	protected function is_query( $query_var ) {
		global $wp;

		if ( is_main_query() && is_page() && isset( $wp->query_vars[ $query_var ] ) ) {
			$partner_program_query = true;
		} else {
			$partner_program_query = false;
		}

		return $partner_program_query;
	}

	/**
	 * Insert the new endpoint into the My Account menu.
	 *
	 * @param array $items
	 * @return array
	 */
	public function add_menu_items( $menu_items ) {

		// If the endpoint setting is empty, don't display it in line with core WC behaviour.
		if ( empty( $this->query_vars[$this->url] ) ) {
			return $menu_items;
		}

		if ( function_exists( 'array_insert_before' ) ) {
			$menu_items = array_insert_before( 'customer-logout', $menu_items, $this->url, $this->name );
		} else{
			$menu_items[$this->url] = $this->name;
		}


		$menu_items[$this->url] = $this->name;


		return $menu_items;
	}

	/**
	 * Endpoint HTML content.
	 *
	 * @param int $current_page
	 */
	public function endpoint_content( $current_page = 1 ) {

		do_action( 'jc_member_preferences', get_current_user_id() );

	}


	/**
	 * Hooks into `woocommerce_get_query_vars` to make sure query vars defined in
	 * this class are also considered `WC_Query` query vars.
	 *
	 * @param  array $query_vars
	 * @return array
	 * @since  2.3.0
	 */
	public function add_jc_member_preferences_query_vars( $query_vars ) {
		return array_merge( $query_vars, $this->query_vars );
	}

}
