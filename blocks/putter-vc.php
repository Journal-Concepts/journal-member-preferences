<?php

/**
 * The putter-vc block
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
class JC_Member_Preferences_Putter_VC {

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
			'journal-member-preferences-putter-vc', 
			plugin_dir_url( __FILE__ ) . 'js/putter-vc.js', 
			[
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-components',
			], 
			$this->version, 
			'all' 
		);

		$protocol = isset( $_SERVER["HTTPS"]) ? 'https://' : 'http://';

		$params = array(
			'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
		);

		wp_register_script( 'jc-putter-vc-front', plugin_dir_url( __FILE__ ) . 'js/putter-vc-front.js', array( 'jquery', 'holdon' ), 1, true );
		wp_localize_script( 'jc-putter-vc-front' , 'jc_async_reports' , $params );

	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function register() {
		register_block_type('journal-member-preferences/putter-vc', array(
			'editor_script' => 'journal-member-preferences-putter-vc',
			'editor_style' => 'journal-member-preferences-putter-vc',
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

		wp_enqueue_script( 'holdon' );
		wp_enqueue_style( 'holdon' );
		wp_enqueue_script( 'jc-async-report-vc' );
		wp_enqueue_script( 'jc-putter-vc-front' );

		ob_start();

		?>
		
		<div class="async-report-vc" data-base-action=jc_putter_cover_report>
		
			<div class="control">
		
				<a class="button" id="generate-report" href="#">Generate Report</a><br/>
				<a class="button" id="generate-report-six" href="#">Generate Report - Entitlement 6</a>

				<form id="redeem-covers" name="redeem-covers" method="post">
					<?php wp_nonce_field( 'jc-preference-redeem-covers' );?>

					<div class="choices">
						<input type="radio" id="blade" name="redeem" value="blade" checked/>
						<label for="blade">Blade</label>
						<input type="radio" id="mallet" name="redeem" value="mallet"/>
						<label for="mallet">Mallet</label>
						<input type="radio" id="square-mallet" name="redeem" value="square-mallet"/>
						<label for="square-mallet">Square Mallet</label>
						<input type="radio" id="no-preference" name="redeem" value="no-preference"/>
						<label for="no-preference">No preference</label>
					</div>

					<div class="no-preference" style="display:none">
						<p>Redeem no preference for</p>
						<div class="no-preference-choices">
							<input type="radio" id="no-preference-blade" name="no-preference-choice" value="blade" checked/>
							<label for="no-preference-blade">Blade</label>
							<input type="radio" id="no-preference-mallet" name="no-preference-choice" value="mallet"/>
							<label for="no-preference-mallet">Mallet</label>
							<input type="radio" id="no-preference-square-mallet" name="no-preference-choice" value="square-mallet"/>
							<label for="no-preference-square-mallet">Square Mallet</label>
						</div>
						<label for="cutoff">Cut off date</label>
						<input type="date" name="cutoff" class="cutoff"/>
					</div>

					<div class="blade-levels">
						<p>Number of blade covers to redeem</p>
						<div>
							<label>Black<input type="number" id="blade-black" name="blade-black"/></label>
							<label>White<input type="number" id="blade-white" name="blade-white"/></label>
							<label>Green<input type="number" id="blade-green" name="blade-green"/></label>
						</div>
						<p>Blade variation IDs</p>
						<div>
							<label>Black ID<input type="text" id="blade-black-id" name="blade-black-id" 
								readonly="readonly" value="<?php echo jc_get_option( 'blade_black_id', false, 'preferences' )?>"/></label>
							<label>White ID<input type="text" id="blade-white-id" name="blade-white-id"
								readonly="readonly" value="<?php echo jc_get_option( 'blade_white_id', false, 'preferences' )?>"/></label>
							<label>Green ID<input type="text" id="blade-green-id" name="blade-green-id"
								readonly="readonly" value="<?php echo jc_get_option( 'blade_green_id', false, 'preferences' )?>"/></label>
						</div>
					</div>

					<div class="mallet-levels" style="display:none">
						<p>Number of mallet covers to redeem</p>
						<div>
							<label>Black<input type="number" id="mallet-black" name="mallet-black"/></label>
							<label>White<input type="number" id="mallet-white" name="mallet-white"/></label>
							<label>Tan<input type="number" id="mallet-tan" name="mallet-tan"/></label>
						</div>
						<p>Mallet variation IDs</p>
						<div>
							<label>Black ID<input type="text" id="mallet-black-id" name="mallet-black-id"
								readonly="readonly" value="<?php echo jc_get_option( 'mallet_black_id', false, 'preferences' )?>"/></label>
							<label>White ID<input type="text" id="mallet-white-id" name="mallet-white-id"
								readonly="readonly" value="<?php echo jc_get_option( 'mallet_white_id', false, 'preferences' )?>"/></label>
							<label>Tan ID<input type="text" id="mallet-tan-id" name="mallet-tan-id"
								readonly="readonly" value="<?php echo jc_get_option( 'mallet_tan_id', false, 'preferences' )?>"/></label>
						</div>
					</div>


					<div class="square-mallet-levels" style="display:none">
						<p>Number of square-mallet covers to redeem</p>
						<div>
							<label>Black<input type="number" id="square-mallet-black" name="square-mallet-black"/></label>
							<label>White<input type="number" id="square-mallet-white" name="square-mallet-white"/></label>
							<label>Green<input type="number" id="square-mallet-green" name="square-mallet-green"/></label>
						</div>
						<p>Square Mallet variation IDs</p>
						<div>
							<label>Black ID<input type="text" id="square-mallet-black-id" name="square-mallet-black-id" 
								readonly="readonly" value="<?php echo jc_get_option( 'square_mallet_black_id', false, 'preferences' )?>"/></label>
							<label>White ID<input type="text" id="square-mallet-white-id" name="square-mallet-white-id"
								readonly="readonly" value="<?php echo jc_get_option( 'square_mallet_white_id', false, 'preferences' )?>"/></label>
							<label>Green ID<input type="text" id="square-mallet-green-id" name="square-mallet-green-id"
								readonly="readonly" value="<?php echo jc_get_option( 'square_mallet_green_id', false, 'preferences' )?>"/></label>
						</div>
					</div>

					<input type="submit" class="button" value="Redeem covers"/>
				</form>
				
			</div>
		
			<div class="reports">

				<h4>Status reports</h4>
				<?php

				$reports = journal_get_all_async_reports( 'putter-cover' );
				$template_loader = new TSJ_Subscriptions_Template_Loader;
		
				if ( is_array( $reports ) ) {
					foreach ( $reports as $report ) {
		
						$template_data = [ 
							'report' => $report,
							'report_type' => 'putter-cover'
						];
		
						$template_loader->set_template_data( $template_data );
						$template_loader->get_template_part( 'async-report' );
					}
				}
				?>

				<h4>Redemption reports</h4>
				<?php

				$reports = journal_get_all_async_reports( 'putter-cover-redemption' );
				$template_loader = new TSJ_Subscriptions_Template_Loader;

				if ( is_array( $reports ) ) {
					foreach ( $reports as $report ) {

						$template_data = [ 
							'report' => $report,
							'report_type' => 'putter-cover-redemption'
						];

						$template_loader->set_template_data( $template_data );
						$template_loader->get_template_part( 'async-report' );
					}
				}
				?>
			</div>
		</div>
	
		<?php
		return ob_get_clean();
	}

}
