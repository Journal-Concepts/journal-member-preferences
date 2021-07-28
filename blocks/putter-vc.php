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
		
				<a class="button" id="generate-report" href="#">Generate Report</a>
				<a class="button" id="redeem-covers" href="#">Redeem Covers</a>
				
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
