<?php
class Apex_Menu {
	protected $slug = 'apex-menu';
	protected $assets_url;

	public function __construct($assets_url){
		$this->assets_url = $assets_url;
		add_action('admin_menu', array($this,'add_menu'));
		add_action('admin_enqueue_scripts', array($this,'register_assets'));
	}

	public function add_menu(){
		add_menu_page(
			__('Apex Menu', 'apex-menu'),
			__('Apex Menu', 'apex-menu'),
			'manage_options',
			$this->slug,
			array( $this, 'render_admin')
		);
	}

	public function register_assets(){
		wp_register_script($this->slug,$this->assets_url . '/js/admin.js', array('jquery'));
		wp_register_style($this->slug,$this->assets_url . '/css/admin.css' );
		wp_localize_script($this->slug, 'APEX', array(
			'settings' => array(
				'saved' => __('Settings Saved', 'apex-menu'),
				'error' => __('Error', 'apex-menu')
			),
			'api' => array(
				'url' => esc_url_raw( rest_url('apex-api/v1/settings') ),
				'nonce' => wp_create_nonce('wp_rest')
			)
		));
	}

	public function enqueue_assets(){
		if( !wp_script_is($this->slug, 'registered')){
			$this->register_assets();
		}
		wp_enqueue_script($this->slug);
		wp_enqueue_style($this->slug);
	}

	public function render_admin(){
		$this->enqueue_assets();
		?>
			<form id="apex-form" action="<?php echo esc_url(home_url('/admin.php')) ?>">
				<h2>Rest API Settings Page</h2>
				<p>Lorem ipsum dolor sit.</p>
				<div id="feedback"></div>
				<div>
					<label for="industry"><?php esc_html_e('Industry', 'apex-menu'); ?></label>
					<input type="text" name="industry" id="industry" />
				</div>
				<br/>
				<div>
					<label for="amount"><?php esc_html_e('Amount', 'apex-menu'); ?></label>
					<input type="text" name="amount" id="amount" />
				</div>
				<?php submit_button(__('Save', 'apex-menu')); ?>
			</form>
		<?php
	}
}