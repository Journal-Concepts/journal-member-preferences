<?php

/**
 * The headcover block
 *
 * @link       21applications.com
 * @since      1.0.0
 *
 * @package    Journal_Member_Preferences
 * @subpackage Journal_Member_Preferences/blocks
 */

/**
 * The picks block.
 *
 * @package    Journal_Member_Preferences
 * @subpackage Journal_Member_Preferences/blocks
 * @author     Roger Coathup <roger@21applications.com>
 */
class JC_Member_Preferences_Headcover {


	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $version ) {

		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( 
			'journal-member-preferences-headcover', 
			plugin_dir_url( __FILE__ ) . 'js/headcover.js', 
			[
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-components',
				'wp-data'
			], 
			$this->version, 
			'all' 
		);

	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function register() {
		register_block_type('journal-member-preferences/headcover', array(
			'editor_script' => 'journal-member-preferences-headcover',
			'editor_style' => 'journal-member-preferences-headcover',
			'render_callback' => [$this, 'render' ],
			'attributes' => [
				'setPage' => [
					'type' => 'number',
					'default' => 0
				],
			]
		));
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $atts
	 * @return void
	 */
	public function render( $attr, $content ){

		$snake_attr = [];

		foreach ( $attr as $key => $value ) {
            $snake_key = $this->from_camel_case( $key );
            $snake_key = str_replace( 'custom_', '', $snake_key );

			$snake_attr[$snake_key] = $value;
		}

		if ( is_user_logged_in() ) {
			return $this->preference_form( $snake_attr );
		} else {
			return '';
		}
		
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $str
	 * @return void
	 */
	private function from_camel_case( $str ) {
		$str[0] = strtolower($str[0]);
		return preg_replace_callback(
			'/([A-Z])/', 
			function( $c ) { return "_" . strtolower( $c[1]);}, 
			$str);
	}

	/**
	 * [feature description]
	 * @param  [type] $attr [description]
	 * @return [type]       [description]
	 */
	public function preference_form( $attr ) {

		$defaults = [
			'set_page' => jc_get_option( 'headcover_redirect_page', false, 'preferences' )
		];

		$options = shortcode_atts( $defaults, $attr );

		wp_enqueue_style( 'journal-member-preferences-public' );
		ob_start();

		$user_id = get_current_user_id();

		$checked = 'tan';

		if ( $user_id ) {
			$preferred_type = get_user_meta( $user_id, 'jc_headcover', true );

			if ( $preferred_type ) {
				$checked = $preferred_type;
			}
		}
		?>

		<div class="headcover-block">
			<div class="inner-wrapper">

                <form class="headcover-preference" name="headcover_preference" method="post">

					<h4>Your selection:</h4>

                    <?php wp_nonce_field( 'jc-preference-headcover' );?>
					<div class="choices">
						<input type="radio" id="tan" name="headcover" value="tan" <?php 
						if ( !in_array( $checked, [ 'white', 'black' ] ) ) echo 'checked';?> />
						<label for="tan">Tan</label>
						<input type="radio" id="white" name="headcover" value="white" <?php 
						if ( $checked === 'white' ) echo 'checked';?>/>
						<label for="white">White</label>
						<input type="radio" id="black" name="headcover" value="black" <?php 
						if ( $checked === 'black' ) echo 'checked';?>/>
						<label for="black">Black</label>
					</div>
					<input type="hidden" name="headcover_selection" value=1/>
					<input type="hidden" name="set_page" value="<?php echo $options['set_page'];?>"/>
                    <input type="submit" class="button primary" value="Save Preference"/>
                </form>

			</div>
		</div>


		<?php

		$output = ob_get_clean();

		return $output;
	}

    /**
     * Undocumented function
     *
     * @return void
     */
    public function handle_submission() {

		
        if ( !isset( $_POST['headcover_selection']) ) {
			return;
		}

		if ( !(isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'jc-preference-headcover' ) ) ) {
			return;
		}

		if ( !is_user_logged_in() ) {
			return;
		}

		$user_id = get_current_user_id();

		// Set the data 
		update_user_meta( $user_id, 'jc_headcover', $_POST['headcover'] );

		$redirect_url =  get_permalink( $_POST['set_page'] );

		if ( $redirect_url ) {
			wp_redirect( add_query_arg( [ 'selection' => $_POST['headcover'] ], $redirect_url ) );
			exit;
		}
 
    }

}
