<?php

GFForms::include_feed_addon_framework();

class GFFollowUpBoss extends GFFeedAddOn {

	protected $_version = GF_FUB_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'gffub';
	protected $_path = 'gffub/gffub.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms FUB Integration';
	protected $_short_title = 'FUB Integration';

	private static $_instance = null;

	/**
	 * Get an instance of this class.
	 *
	 * @return GFFollowUpBoss
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFFollowUpBoss();
		}

		return self::$_instance;
	}

	private function __clone() {
	} /* do nothing */

	/**
	 * Handles anything which requires early initialization.
	 */
	// public function pre_init() {
	// 	parent::pre_init();

	// 	if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
	// 		require_once( 'includes/class-gf-field-quiz.php' );

	// 		add_filter( 'gform_export_field_value', array( $this, 'display_export_field_value' ), 10, 4 );
	// 	}
	// }

	/**
	 * Handles hooks and loading of language files.
	 */
	public function init() {
		parent::init();

		// # FRONTEND FUNCTIONS 
		// add_filter( 'gform_submit_button', array( $this, 'form_submit_button' ), 10, 2 );

		// # SIMPLE CONDITION EXAMPLE 
		// add_action( 'gform_after_submission', array( $this, 'after_submission' ), 10, 2 );
	}

	/**
	 * Initialize the admin specific hooks.
	 */
	public function init_admin() {
		parent::init_admin();

		// add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	public function admin_enqueue_scripts() {
		// do something
	}


	// # SCRIPTS & STYLES --------------------------------------------------------------------------------------

	/**
	 * Return the scripts which should be enqueued.
	 *
	 * @return array
	 */
	public function scripts() {
		$scripts = array(
			array(
				'handle'  => 'bootstrap',
				'src'     => $this->get_base_url() . '/js/bootstrap.min.js',
				'version' => '5.3.1',
				'deps'    => array( 'jquery' ),
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_page' ),
					)
				)
			),

		);

		return array_merge( parent::scripts(), $scripts );
	}

	/**
	 * Return the stylesheets which should be enqueued.
	 *
	 * @return array
	 */
	public function styles() {
		$styles = array(
			array(
				'handle'  => 'bootstrap',
				'src'     => $this->get_base_url() . '/css/bootstrap.min.css',
				'version' => '5.3.1',
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_page' ),
					)
				)
			),
			array(
				'handle'  => 'gffub_page_settings_css',
				'src'     => $this->get_base_url() . '/css/gffub-page-settings.css',
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_page' ),
					)
				)
			)
		);

		return array_merge( parent::styles(), $styles );
	}


	// # ADMIN FUNCTIONS --------------------------------------------------------------------------------------

	/**
	 * Creates a custom page for this add-on.
	 */
	public function plugin_page() {
		?>
		<div class="wrap">
			<p><a href="<?php echo admin_url('admin.php?page=gf_settings&subview=gfspamrules'); ?>">Edit Settings</a></p>

			<p class="my-4 lead"><strong>Instructions</strong></p>

			<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>

			<div id="description-message-container">
				<div class="container">
					<div class="row">
						<div class="col">
						</div>
					</div>
				</div>
			</div>
		</div><!-- .wrap -->
		<?php
	}

	/**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {
		return array(
			array(
				'title'  => esc_html__( $this->_short_title.' Settings', 'gffub' ),
				'fields' => array(
					array(
						'name'              => 'gffub-apikey',
						'label'             => esc_html__( 'FUB API Key', 'gffub' ),
						// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
						'description' => '<p>' . sprintf( esc_html__( 'Create a new API key to connect with your Follow Up Boss account. For step-by-step instructions, %1$sclick here.%2$s', 'gffub' ), '<a href="https://help.followupboss.com/hc/en-us/articles/360014289393-API-Key" target="_blank">', '</a>' ) . '</p>',
						'type'              => 'text',
						'class'             => 'small',
						'feedback_callback' => array( $this, 'is_valid_setting' ),
					),
					array(
						'name'    => 'gffub-pixel',
						'label'   => esc_html__( 'FUB Pixel Code', 'gffub' ),
						// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
						'description' => '<p>' . sprintf( esc_html__( 'Paste your Pixel Tracking Code below, but only if you haven\'t already added it to your site via another method. Be sure to turn on the option, "Enable form capture and creating new leads in FUB". For step-by-step instructions, %1$sclick here.%2$s', 'gffub' ), '<a href="https://help.followupboss.com/hc/en-us/articles/360037775174-Follow-Up-Boss-Pixel-Overview" target="_blank">', '</a>' ) . '</p>',
						'type'    => 'textarea',
						'class'   => 'medium',
					),
				)
			)
		);
	}
	

	/**
	 * Define dashicons
	 */
	public function get_app_menu_icon() {
		return $this->get_base_url() . '/img/gf-fub.svg';
	}
	public function get_menu_icon() {
		return $this->get_base_url() . '/img/gf-fub.svg';
	}

	/**
	 * Configures the settings which should be rendered on the feed edit page in the Form Settings > Simple Feed Add-On area.
	 *
	 * @return array
	 */
	public function feed_settings_fields() {
		return array(
			array(
				'title'  => esc_html__( 'Simple Feed Settings', 'gffub' ),
				'fields' => array(
					array(
						'label'   => esc_html__( 'Feed name', 'gffub' ),
						'type'    => 'text',
						'name'    => 'feedName',
						'class'   => 'small',
					),
					array(
						'name'      => 'mappedFields',
						'label'     => esc_html__( 'Map form fields to your Follow Up Boss contacts:', 'gffub' ),
						// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
						'description' => '<p>' . sprintf( esc_html__( 'These fields help ensure the accuracy of FUB Lead Dedpulication. For more info, %1$sclick here.%2$s', 'gffub' ), '<a href="https://help.followupboss.com/hc/en-us/articles/11460704008855-Lead-Deduplication" target="_blank">', '</a>' ) . '</p>',
						'type'      => 'field_map',
						'field_map' => array(
							array(
								'name'     => 'name',
								'label'    => esc_html__( 'Name', 'gffub' ),
								'required' => 0,
								'field_type' => array( 'name', 'hidden' ),
							),
							array(
								'name'       => 'email',
								'label'      => esc_html__( 'Email', 'gffub' ),
								'required'   => 0,
								'field_type' => array( 'email', 'hidden' ),
							),
							array(
								'name'       => 'phone',
								'label'      => esc_html__( 'Phone', 'gffub' ),
								'required'   => 0,
								'field_type' => 'phone',
							),
						),
					),
					array(
						'name'    => 'source',
						'type'    => 'text',
						'class'   => 'medium merge-tag-support mt-position-right mt-hide_all_fields',
						'label'   => esc_html__( 'Lead Source', 'gffub' ),
						// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
						'description' => '<p>' . sprintf( esc_html__( 'Type any custom Lead Source and/or utilize Gravity Forms Merge Tags.', 'gffub' ) ) . '</p>',
					),
					array(
						'name'    => 'tags',
						'type'    => 'text',
						'class'   => 'medium merge-tag-support mt-position-right mt-hide_all_fields',
						'label'   => esc_html__( 'Tags', 'gffub' ),
						// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
						'description' => '<p>' . sprintf( esc_html__( 'Type any tags and/or utilize Gravity Forms Merge Tags. Must be a comma separated list (e.g. new lead, My Tag, web source).', 'gffub' ) ) . '</p>',
					),
					array(
						'name'           => 'condition',
						'label'          => esc_html__( 'Condition', 'gffub' ),
						'type'           => 'feed_condition',
						'checkbox_label' => esc_html__( 'Enable Condition', 'gffub' ),
						'instructions'   => esc_html__( 'Process this simple feed if', 'gffub' ),
					),
				),
			),
		);
	}

	/**
	 * Configures which columns should be displayed on the feed list page.
	 *
	 * @return array
	 */
	public function feed_list_columns() {
		return array(
			'feedName'  => esc_html__( 'Name', 'gffub' ),
			// 'mytextbox' => esc_html__( 'My Textbox', 'gffub' ),
		);
	}

	/**
	 * Format the value to be displayed in the mytextbox column.
	 *
	 * @param array $feed The feed being included in the feed list.
	 *
	 * @return string
	 */
	public function get_column_value_mytextbox( $feed ) {
		return '<b>' . rgars( $feed, 'meta/mytextbox' ) . '</b>';
	}

	/**
	 * Prevent feeds being listed or created if an api key isn't valid.
	 *
	 * @return bool
	 */
	public function can_create_feed() {

		// Get the plugin settings.
		$settings = $this->get_plugin_settings();

		// Access a specific setting e.g. an api key
		$key = rgar( $settings, 'apiKey' );

		return true;
	}



	// # FEED PROCESSING -----------------------------------------------------------------------------------------------

	/**
	 * Process the feed e.g. subscribe the user to a list.
	 *
	 * @param array $feed The feed object to be processed.
	 * @param array $entry The entry object currently being processed.
	 * @param array $form The form object currently being processed.
	 *
	 * @return bool|void
	 */
	public function process_feed( $feed, $entry, $form ) {
		$feedName  = $feed['meta']['feedName'];
		$mytextbox = $feed['meta']['mytextbox'];
		$checkbox  = $feed['meta']['mycheckbox'];

		// Retrieve the name => value pairs for all fields mapped in the 'mappedFields' field map.
		$field_map = $this->get_field_map_fields( $feed, 'mappedFields' );

		// Loop through the fields from the field map setting building an array of values to be passed to the third-party service.
		$merge_vars = array();
		foreach ( $field_map as $name => $field_id ) {

			// Get the field value for the specified field id
			$merge_vars[ $name ] = $this->get_field_value( $form, $entry, $field_id );

		}

		// Send the values to the third-party service.
	}



	// # HELPERS / CALLBACKS --------------------------------------------------------------------------------------

	/**
	 * The feedback callback for the 'mytextbox' setting on the plugin settings page and the 'mytext' setting on the form settings page.
	 *
	 * @param string $value The setting value.
	 *
	 * @return bool
	 */
	public function is_valid_setting( $value ) {
		return strlen( $value ) < 10;
	}


}
