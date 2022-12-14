<?php

namespace SayHello\ShpGantrischBase;

class Plugin
{
	private static $instance;
	public $name = '';
	public $prefix = '';
	public $version = '';
	public $file = '';

	/**
	 * Loads and initializes the provided classes.
	 *
	 * @param $classes
	 */
	private function loadClasses($classes)
	{
		foreach ($classes as $class) {
			$class_parts = explode('\\', $class);
			$class_short = end($class_parts);
			$class_set   = $class_parts[count($class_parts) - 2];

			if (!isset(PLUGIN_NAME_get_instance()->{$class_set}) || !is_object(PLUGIN_NAME_get_instance()->{$class_set})) {
				PLUGIN_NAME_get_instance()->{$class_set} = new \stdClass();
			}

			if (property_exists(PLUGIN_NAME_get_instance()->{$class_set}, $class_short)) {
				wp_die(sprintf(__('A problem has ocurred in the Theme. Only one PHP class named ā%1$sā may be assigned to the ā%2$sā object in the Theme.', 'sht'), $class_short, $class_set), 500);
			}

			PLUGIN_NAME_get_instance()->{$class_set}->{$class_short} = new $class();

			if (method_exists(PLUGIN_NAME_get_instance()->{$class_set}->{$class_short}, 'run')) {
				PLUGIN_NAME_get_instance()->{$class_set}->{$class_short}->run();
			}
		}
	}

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 *
	 * @param  string $file The file from which the class is being instantiated.
	 * @return object       The class instance.
	 */
	public static function getInstance($file)
	{
		if (!isset(self::$instance) && !(self::$instance instanceof Plugin)) {
			self::$instance = new Plugin;

			if (!function_exists('get_plugin_data')) {
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			$data = get_plugin_data($file);

			self::$instance->name = $data['Name'];
			self::$instance->prefix = 'PLUGIN_NAME';
			self::$instance->version = $data['Version'];
			self::$instance->file = $file;

			self::$instance->run();
		}
		return self::$instance;
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 */
	private function run()
	{
		$this->loadClasses(
			[
				Blocks\MyFirstBlock\Block::class,
			]
		);

		add_action('plugins_loaded', [$this, 'loadPluginTextdomain']);
	}

	/**
	 * Load translation files from the indicated directory.
	 */
	public function loadPluginTextdomain()
	{
		load_plugin_textdomain('PLUGIN_NAME', false, dirname(plugin_basename($this->file)) . '/languages');
	}
}
