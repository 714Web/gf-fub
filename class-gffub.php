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

		add_action ( 'wp_head', array( $this, 'add_fub_pixel') );
	}

	/**
	 * Initialize the admin specific hooks.
	 */
	public function init_admin() {
		parent::init_admin();

		// add_action ( 'wp_head', 'add_fub_pixel' );
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
						'admin_page' => array( 
							'plugin_page',
							'plugin_settings'
						),
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
						'admin_page' => array( 
							'plugin_page',
							'plugin_settings'
						),
					)
				)
			),
			array(
				'handle'  => 'gffub_plugin_page',
				'src'     => $this->get_base_url() . '/css/gffub-plugin-page.css',
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_page' ),
					)
				)
			),
			array(
				'handle'  => 'gffub_plugin_settings',
				'src'     => $this->get_base_url() . '/css/gffub-plugin-settings.css',
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_settings' ),
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
	public function plugin_page_disabled() {
		$data = array(
            "source" => 'gf-fub',
            "person" => array(
                "name" 		=> 'Jim Bob',
                "emails" 	=> array(
					array(
						"value" => 'jimbob@aol.com'
					)
				),
                "phones"	 => array(
					array(
						"value" => '865-555-1212'
					)
				),
                "tags" => array('tag1','tag2')
            ),
        );

		$response = $code = '';
		// $response = $this->send_to_fub( $data, 'POST', 'events' );
		// $response = $this->send_to_fub( array(), 'GET', 'people' );
		$code = $this->send_to_fub( array(), 'GET', 'identity' );
		// $code = $code['statusCode'];
		?>
		<div class="wrap">
			<p><a href="<?php echo admin_url('admin.php?page=gf_settings&subview='.$this->_slug); ?>">Edit Settings</a></p>

			<div class="alert alert-danger px-3 w-25" role="alert"><h4 class="alert-heading mb-0">Test Mode</h4></div>

			<div id="universal-message-container">
				<div class="container">
					<div class="row">
						<div class="col">
							Code: <br><pre><?php print_r($code); ?></pre>
							<br>
							Response: <br><pre><?php print_r($response); ?></pre>
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
						// 'validation_callback' => array( $this, 'is_valid_setting' ),
					),
					array(
						'name'    => 'gffub-pixel',
						'label'   => esc_html__( 'FUB Pixel Code', 'gffub' ),
						// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
						'description' => '<p>' . sprintf( esc_html__( 'Paste your Pixel Tracking Code below, but only if you haven\'t already added it to your site by another method. In your FUB account be sure to turn on the option, "Enable form capture and creating new leads in FUB". For step-by-step instructions, %1$sclick here.%2$s', 'gffub' ), '<a href="https://help.followupboss.com/hc/en-us/articles/360037775174-Follow-Up-Boss-Pixel-Overview" target="_blank">', '</a>' ) . '</p>',
						'type'    => 'textarea',
						'class'   => 'large',
						'validation_callback' => array( $this, 'prevent_error' ),
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
		);
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
		$key = rgar( $settings, 'gffub-apikey' );

		if ( empty($key) ) {
			return false;
		}

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
		$feedName  	= $feed['meta']['feedName'];
		$source  	= $feed['meta']['source'];
		$tags_csv 	= $feed['meta']['tags'];
		$tags 		= preg_split('/, ?/',$tags_csv);

		// Retrieve the name => value pairs for all fields mapped in the 'mappedFields' field map.
		$field_map = $this->get_field_map_fields( $feed, 'mappedFields' );

		// Loop through the fields from the field map setting building an array of values to be passed to the third-party service.
		$merge_vars = array();
		foreach ( $field_map as $name => $field_id ) {
			// Get the field value for the specified field id
			$merge_vars[ $name ] = $this->get_field_value( $form, $entry, $field_id );
		}

		// Send the values to the third-party service.
		
        $data = array(
            "source" => $source,
            "person" => array(
                "name" 		=> $merge_vars['name'],
                "emails" 	=> array(
					array(
						"value" => $merge_vars['email']
					)
				),
                "phones"	 => array(
					array(
						"value" => $merge_vars['phone']
					)
				),
                "tags" => $tags,
            ),
        );

		// https://docs.followupboss.com/reference/people-post
		// 
		// "The best way to send leads into Follow Up Boss ... 
		// is to use event notifications (POST /v1/events)."
		//
		// Also...
		//
		// "Source Information Can Only Be Set on Creation. The 
		// source and sourceUrl fields can only be set once on 
		// the creation of a person."
		$result = $this->send_to_fub( $data, 'POST', 'events' );
		GFCommon::log_debug( __METHOD__ . '(): FUB Response - '.print_r( $result, true ) );
	}

	public function send_to_fub( $data, $method='GET', $endpoint='identity' ) {
		$code = 000;
		$result = array();
		$headers = array(
			'Content-Type: application/json',
			'X-System: 714Web',
			'X-System-Key: 4086a077f73e3c56e3760c975655889d',
		);
		$settings 	= $this->get_plugin_settings();
		$apiKey 	= rgar( $settings, 'gffub-apikey' );

        // init cURL
        $ch = curl_init('https://api.followupboss.com/v1/'.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // make API call
        $response = curl_exec($ch);
        if ($response === false) {
            exit('cURL error: ' . curl_error($ch) . "\n");
        }

        // check HTTP status code
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code == 201) {
            GFCommon::log_debug( __METHOD__ . '(): Code 201 - New contact created.' );
        } elseif ($code == 200) {
            GFCommon::log_debug( __METHOD__ . '(): Code 200 - Existing contact updated.' );
        } else {
            GFCommon::log_debug( __METHOD__ . '(): Code '.$code.' - Error.' );
        }

        // dump response
        if ($response) {
            $response = json_decode( $response, true );
			$result = array_merge( $response, array('statusCode' => $code) );
        }
		return $result;
	}


	public function add_fub_pixel() {
		// Get the plugin settings.
		$settings = $this->get_plugin_settings();

		// Access a specific setting e.g. an api key
		$pixel = rgar( $settings, 'gffub-pixel' );

		if ( $pixel ) {
			echo $pixel;
		}
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
		// Get the plugin settings.
		$settings = $this->get_plugin_settings();

		// Access a specific setting e.g. an api key
		$key = rgar( $settings, 'gffub-apikey' );

		// Don't validate if no API Key
		if ( empty($key) ) {
			return;
		}
		
		$identity = $this->send_to_fub( array(), 'GET', 'identity' );
		$code = $identity['statusCode'];
		
		$result = ($code == 200) ? true : false;

		if ( $result ) {
			$heading = 'Connected!';
			$alert_type = 'success';
			$msg = '<p>Account: <code>'.$identity['account']['id'].'</code> &nbsp; Domain: <code>'.$identity['account']['domain'].'</code> &nbsp; Account Owner: <code>'.$identity['account']['owner']['name'].'</code></p>';
			
			if ( $identity['account']['owner']['email'] !== $identity['user']['email'] ) {
				$msg .= '<hr><p class="mb-0">This API Key was created by <code>'.$identity['user']['name'].'</code> <em style="font-weight: bold;">(If this FUB user is deleted, this API Key will no longer work.)</em></p>';
			} else {
				$msg .= '<hr><p class="mb-0">This API Key was created by the Account Owner: <code>'.$identity['account']['owner']['email'].'</code>.</p>';
			}
		} else {
			$heading = 'Not Connected.';
			$alert_type = 'danger';
			$msg .= '<p class="mb-0">This API Ket is NOT VALID. Please <a href="https://help.followupboss.com/hc/en-us/articles/360014289393-API-Key" target="_blank" class="alert-link">create a new one</a> using an admin user or the account owner.</p>';
		}
		
		echo '<div class="alert alert-'.$alert_type.' px-3" role="alert"><h4 class="alert-heading">'.$heading.'</h4>'.$msg.'</div>';

		return $result;
	}

	/**
	 * Prevent error:
	 *
	 * "The text you have entered is not valid. For security reasons, some characters are not allowed. Fix it"
	 * x
	 */
	public function prevent_error( $value ) {
		return $value;
	}

}
