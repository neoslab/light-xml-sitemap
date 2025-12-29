<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link https://neoslab.com
 * @since 1.0.0
 * @package Light_XML_Sitemap
 *
 * @wordpress-plugin
 * Plugin Name: Light-XML Sitemap
 * Plugin URI: https://wordpress.org/plugins/light-xml-sitemap/
 * Description: Light-XML Sitemap dynamically creates dynamic XML Sitemap that comply with Google, Bing, Yahoo! and Ask.com Sitemap protocol.
 * Version: 2.3.6
 * Author: NeosLab
 * Author URI: https://neoslab.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: light-xml-sitemap
 * Domain Path: /languages
*/

/**
 * If this file is called directly, then abort
*/
if(!defined('WPINC'))
{
	die;
}

/**
 * Currently plugin version
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions
*/
define('LIGHT_XML_SITEMAP_VERSION', '2.3.6');

/**
 * The code that runs during plugin activation
 * This action is documented in includes/class-light-xml-sitemap-activator.php
*/
function activate_light_xml_sitemap()
{
	require_once plugin_dir_path(__FILE__).'includes/class-light-xml-sitemap-activator.php';
	Light_XML_Sitemap_Activator::activate();
}

/**
 * The code that runs during plugin deactivation
 * This action is documented in includes/class-light-xml-sitemap-deactivator.php
*/
function deactivate_light_xml_sitemap()
{
	require_once plugin_dir_path(__FILE__).'includes/class-light-xml-sitemap-deactivator.php';
	Light_XML_Sitemap_Deactivator::deactivate();
}

/**
 * Activation/deactivation hook
*/
register_activation_hook(__FILE__, 'activate_light_xml_sitemap');
register_deactivation_hook(__FILE__, 'deactivate_light_xml_sitemap');

/**
 * The core plugin class that is used to define internationalization
 * admin-specific hooks, and public-facing site hooks
*/
require plugin_dir_path(__FILE__).'includes/class-light-xml-sitemap-core.php';

/**
 * Begins execution of the plugin
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle
 * @since 1.0.0
*/
function run_light_xml_sitemap()
{
	$plugin = new Light_XML_Sitemap();
	$plugin->run();
}

/**
 * Run plugin
*/
run_light_xml_sitemap();

?>