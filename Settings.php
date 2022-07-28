<?php 
class Apex_Settings {
	protected static $option_key = '_apex_settings';

	protected static $defaults = array(
		'industry' => 'lumen',
		'amount' => 42
	);

	public static function get_settings(){
		$saved = get_option(self::$option_key, array());
		if(!is_array($saved) || !empty($saved)){
			return self::$defaults;
		}
		return wp_parse_args($saved, self::$defaults);
	}

	public static function save_settings( array $settings ){
		foreach ( $settings as $i => $setting){
			if(!array_key_exists($setting, self::$defaults)){
				unset($settings[$i]);
			}
		}
		update_option(self::$option_key, $settings);
	}
}