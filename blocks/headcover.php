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
			'attributes' => []
		));
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $atts
	 * @return void
	 */
	public function render( $attr, $content ){

		if ( is_user_logged_in() ) {
			return $this->preference_form();
		} else {
			return '';
		}
		
	}

	/**
	 * [feature description]
	 * @param  [type] $attr [description]
	 * @return [type]       [description]
	 */
	public function preference_form() {

        wp_enqueue_script( 'holdon' );
        wp_enqueue_style( 'holdon' );
        wp_enqueue_script( 'journal-member-preferences-public' );
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

				<div class="message callout alert" style="display: none;">&nbsp;</div>
				
                <form class="headcover-preference" name="headcover_preference">

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
                    <input type="submit" class="button" value="Save Preference"/>
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

        $response = new WP_Ajax_Response;

        // Add nonce check
        if ( !check_ajax_referer( 'jc-preference-headcover', 'nonce', false ) ) {
            // Failed
            $response->add( [
                'data' => 'error',
                'supplemental' => [
                    'message' => __( 'Problem selecting headcover color', 'journal-member-preferences' ),
                ],
            ] );

            $response->send();
            exit();

        }

		if ( !is_user_logged_in() ) {

			$response->add( [
                'data' => 'error',
                'supplemental' => [
                    'message' => __( 'You need to be logged in to select your headcover color', 'journal-member-preferences' ),
                ],
            ] );

            $response->send();
            exit();
		}



		$user_id = get_current_user_id();

		// Set the data 
		update_user_meta( $user_id, 'jc_headcover', $_POST['headcover'] );

		$response->add( [
			'data' => 'success',
			'supplemental' => [
				'message' => sprintf('Your preferred headcover color has been set to <strong>%1$s</strong>.<br/>If you would like to change this, please <a href="%2$s">click here</a>', $_POST['headcover'], get_permalink() )
			],
		] );

		$response->send();
		exit(); 
 
    }

}
