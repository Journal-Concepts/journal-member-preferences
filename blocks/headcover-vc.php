<?php

/**
 * The headcover-vc block
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
class JC_Member_Preferences_Headcover_VC {

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
			'journal-member-preferences-headcover-vc', 
			plugin_dir_url( __FILE__ ) . 'js/headcover-vc.js', 
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

		wp_register_script( 'jc-headcover-vc-front', plugin_dir_url( __FILE__ ) . 'js/headcover-vc-front.js', array( 'jquery', 'holdon' ), 1, true );
		wp_localize_script( 'jc-headcover-vc-front' , 'jc_async_reports' , $params );

	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function register() {
		register_block_type('journal-member-preferences/headcover-vc', array(
			'editor_script' => 'journal-member-preferences-headcover-vc',
			'editor_style' => 'journal-member-preferences-headcover-vc',
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
		wp_enqueue_script( 'jc-headcover-vc-front' );

		ob_start();

		?>
		
		<div class="async-report-vc" data-base-action=jc_headcover_report>
		
			<div class="control">
		
				<a class="button" id="generate-headcover-report" href="#">Generate Status Report</a>
				<a class="button" id="generate-headcover-report-renewals" href="#">Generate Report - Post 2023-02-12</a>
				<hr/>

				<form id="redeem-headcovers" name="redeem-headcovers" method="post">
					<?php wp_nonce_field( 'jc-preference-redeem-headcovers' );?>

					<div class="choices">
						<input type="radio" id="preference" name="redeem" value="preference" checked/>
						<label for="preference">Preference stated</label>
						<input type="radio" id="no-preference" name="redeem" value="no-preference"/>
						<label for="no-preference">No preference</label>
					</div>

					<div class="no-preference" style="display:none">
						<label for="cutoff">Cut off date</label>
						<input type="date" name="cutoff" class="cutoff"/>
					</div>

					<div class="levels">
						<p>Number of covers to redeem</p>
						<div>
							<label>Tan<input type="number" id="tan" name="tan"/></label>
							<label>White<input type="number" id="white" name="white"/></label>
							<label>Black<input type="number" id="black" name="black"/></label>
						</div>
						<p>Variation IDs</p>
						<div>
							<label>Tan ID<input type="text" id="tan-id" name="tan-id" 
								readonly="readonly" value="<?php echo jc_get_option( 'headcover_tan_id', false, 'preferences' )?>"/></label>
							<label>White ID<input type="text" id="white-id" name="white-id"
								readonly="readonly" value="<?php echo jc_get_option( 'headcover_white_id', false, 'preferences' )?>"/></label>
							<label>Black ID<input type="text" id="black-id" name="black-id"
								readonly="readonly" value="<?php echo jc_get_option( 'headcover_black_id', false, 'preferences' )?>"/></label>
						</div>
					</div>

					<input type="submit" class="button" value="Redeem covers"/>
				</form>
				
			</div>
			<hr/>
		
			<h3>Status reports</h3>
			<div class="reports">
				<?php

				$reports = journal_get_all_async_reports( 'headcover' );
				$template_loader = new TSJ_Subscriptions_Template_Loader;
		
				if ( is_array( $reports ) ) {
					foreach ( $reports as $report ) {
		
						$template_data = [ 
							'report' => $report,
							'report_type' => 'headcover'
						];
		
						$template_loader->set_template_data( $template_data );
						$template_loader->get_template_part( 'async-report' );
					}
				}
				?>
			</div>

			<h3>Redemption reports</h3>
			<div class="reports">
				<?php

				$reports = journal_get_all_async_reports( 'headcover-redemption' );
				$template_loader = new TSJ_Subscriptions_Template_Loader;

				if ( is_array( $reports ) ) {
					foreach ( $reports as $report ) {

						$template_data = [ 
							'report' => $report,
							'report_type' => 'headcover-cover-redemption'
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
