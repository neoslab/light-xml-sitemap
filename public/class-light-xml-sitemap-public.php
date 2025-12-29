<?php
/**
 * The public-facing functionality of the plugin
 *
 * @link https://neoslab.com
 * @since 1.0.0
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/public
*/

/**
 * Class `Light_XML_Sitemap_Public`
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/public
 * @author NeosLab <support@neoslab.com>
*/
class Light_XML_Sitemap_Public
{
	/**
	 * The ID of this plugin
	 * @since 1.0.0
	 * @access private
	 * @var string $pluginName the ID of this plugin
	*/
	private $pluginName;

	/**
	 * The version of this plugin
	 * @since 1.0.0
	 * @access private
	 * @var string $version the current version of this plugin
	*/
	private $version;

	/**
	 * Initialize the class and set its properties
	 * @since 1.0.0
	 * @param string $pluginName the name of the plugin
	 * @param string $version the version of this plugin
	*/
	public function __construct($pluginName, $version)
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site
	 * @since 1.0.0
	*/
	public function enqueue_styles()
	{
		wp_enqueue_style( $this->pluginName, plugin_dir_url(__FILE__).'assets/styles/light-xml-sitemap-public.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site
	 * @since 1.0.0
	*/
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->pluginName, plugin_dir_url(__FILE__).'assets/javascripts/light-xml-sitemap-public.min.js', array('jquery'), $this->version, false);
	}

	/**
	 * Return the `front-end` output
	*/
	public function return_frontend_output()
	{
		global $wpdb;
		$opts = get_option('_light_xml_sitemap');
		require_once plugin_dir_path(__FILE__).'partials/light-xml-sitemap-public-display.php';
	}
}

?>