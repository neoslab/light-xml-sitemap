<?php
/**
 * Fired during plugin deactivation
 *
 * @link https://neoslab.com
 * @since 1.0.0
 *
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/includes
*/

/**
 * Class `Light_XML_Sitemap_Deactivator`
 * This class defines all code necessary to run during the plugin's deactivation
 * @since 1.0.0
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/includes
 * @author NeosLab <support@neoslab.com>
*/
class Light_XML_Sitemap_Deactivator
{
	/**
	 * Deactivate plugin
	 * @since 1.0.0
	*/
	public static function deactivate()
	{
		$option = delete_option('_light_xml_sitemap');
	}
}

?>