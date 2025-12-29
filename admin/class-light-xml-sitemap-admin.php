<?php
/**
 * The admin-specific functionality of the plugin
 *
 * @link https://neoslab.com
 * @since 1.0.0
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/admin
*/

/**
 * Class `Light_XML_Sitemap_Admin`
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/admin
 * @author NeosLab <support@neoslab.com>
*/
class Light_XML_Sitemap_Admin
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
	 * @param string $pluginName the name of this plugin
	 * @param string $version the version of this plugin
	*/
	public function __construct($pluginName, $version)
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area
	 * @since 1.0.0
	*/
	public function enqueue_styles()
	{
		wp_register_style($this->pluginName.'-fontawesome', plugin_dir_url(__FILE__).'assets/fonts/fontawesome/css/all.min.css', array(), $this->version, 'all');
		wp_register_style($this->pluginName.'-dashboard', plugin_dir_url(__FILE__).'assets/styles/light-xml-sitemap-admin.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->pluginName.'-fontawesome');
		wp_enqueue_style($this->pluginName.'-dashboard');
	}

	/**
	 * Register the JavaScript for the admin area
	 * @since 1.0.0
	*/
	public function enqueue_scripts()
	{
		wp_register_script($this->pluginName.'-script', plugin_dir_url(__FILE__).'assets/javascripts/light-xml-sitemap-admin.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->pluginName.'-script');
	}

	/**
	 * Return the header
	*/
	public function return_plugin_header()
	{
		$html = '<div class="wpdx-header"><span class="header-icon"><i class="fas fa-sliders-h"></i></span> <span class="header-text">'.__('Light-XML Sitemap', 'light-xml-sitemap').'</span></div>';
		return $html;
	}

	/**
	 * Return the tabs menu
	*/
	public function return_tabs_menu($tab)
	{
		$link = admin_url('options-general.php');
		$list = array
		(
			array('tab1', 'light-xml-sitemap-admin', 'fa-cogs', __('Settings', 'light-xml-sitemap'))
		);

		$menu = null;
		foreach($list as $item => $value)
		{
			$html = array('div' => array('class' => array()), 'a' => array('href' => array()), 'i' => array('class' => array()), 'p' => array(), 'span' => array());
			$menu ='<div class="tab-label '.$value[0].' '.(($tab === $value[0]) ? 'active' : '').'"><a href="'.$link.'?page='.$value[1].'"><p><i class="fas '.$value[2].'"></i><span>'.$value[3].'</span></p></a></div>';
			echo wp_kses($menu, $html);
		}
	}

	/**
	 * Update `Options` on form submit
	*/
	public function return_update_options()
	{
		if((isset($_POST['lxs-update-option'])) && ($_POST['lxs-update-option'] === 'true')
		&& check_admin_referer('lxs-referer-form', 'lxs-referer-option'))
		{
			$types = array('posts', 'posttypes', 'pages', 'categories', 'tags', 'authors');
			foreach($types as $type)
			{
				if(isset($_POST['_light_xml_sitemap'][$type]))
				{
					$opts[$type] = 'on';
				}
			}

			$args = array
            (
            	'public' => true,
                '_builtin' => false
            );

            $posttypes = get_post_types($args, 'names', 'and');
            $loadtypes = false; 
            foreach($posttypes as $posttype) 
            {
				if((isset($_POST['_light_xml_sitemap'][$posttype])) && ((isset($opts['posttypes'])) && ($opts['posttypes'] === 'on')))
				{
					$opts[$posttype] = 'on';
					if($loadtypes === false)
					{
						$loadtypes = true; 
					}
				}
				else
				{
					$opts[$posttype] = 'off';
				}
			}

			if($loadtypes === false)
			{
				$opts['posttypes'] = 'off';
			}

			if(isset($_POST['_light_xml_sitemap']['name']))
			{
				$opts['name'] = sanitize_text_field($_POST['_light_xml_sitemap']['name']);
			}
			else
			{
				$opts['name'] = 'sitemap.xml';
			}

			$data = update_option('_light_xml_sitemap', $opts);
			header('location:'.admin_url('options-general.php?page=light-xml-sitemap-admin').'&output=updated');
			die();
		}
	}

	/**
	 * Return the `Options` page
	*/
	public function return_options_page()
	{
		$opts = get_option('_light_xml_sitemap');
		require_once plugin_dir_path(__FILE__).'partials/light-xml-sitemap-admin-options.php';
	}

	/**
	 * Return Backend Menu
	*/
	public function return_admin_menu()
	{
		add_options_page('Light-XML Sitemap', 'Light-XML Sitemap', 'manage_options', 'light-xml-sitemap-admin', array($this, 'return_options_page'));
	}
}

?>