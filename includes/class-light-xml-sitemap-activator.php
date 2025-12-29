<?php
/**
 * Fired during plugin activation
 *
 * @link https://neoslab.com
 * @since 1.0.0
 *
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/includes
*/

/**
 * Class `Light_XML_Sitemap_Activator`
 * This class defines all code necessary to run during the plugin's activation
 * @since 1.0.0
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/includes
 * @author NeosLab <support@neoslab.com>
*/
class Light_XML_Sitemap_Activator
{
	/**
	 * Activate plugin
	 * @since 1.0.0
	*/
	public static function activate()
	{
		$option = add_option('_light_xml_sitemap', false);
		$opts = array('posts' => 'on', 'pages' => 'on', 'name' => 'sitemap.xml');
		$data = update_option('_light_xml_sitemap', $opts);
	}
}

?>