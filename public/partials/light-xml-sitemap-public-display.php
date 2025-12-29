<?php
/**
 * Provide a public-facing view for the plugin
 * This file is used to markup the admin-facing aspects of the plugin
 *
 * @link https://neoslab.com
 * @since 1.0.0
 *
 * @package Light_XML_Sitemap
 * @subpackage Light_XML_Sitemap/admin/partials
*/

if(get_option('blog_public') == '1')
{
    $maintenance = get_option('_maintenance_work');
    if((!isset($maintenance['status'])) || ($maintenance['status'] !== 'on'))
    {
        $sitemap = get_site_url().'/'.$opts['name'];
        if((isset($_SERVER['HTTP_HOST'])) && (isset($_SERVER['REQUEST_URI'])))
        {
            $request = sanitize_url((is_ssl() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

            /**
             * Build index sitemap
            */
            if($request === $sitemap)
            {    
                /**
                 * Load Header
                */
                header("Content-type: text/xml");

                /**
                 * Build XML string
                */
                $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
                $xml.= '<?xml-stylesheet type="text/xsl" href="'.plugin_dir_url(__FILE__).'light-xml-sitemap-public-siteindex.xsl"?>'."\n";
                $xml.= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

                if((isset($opts['posts'])) && ($opts['posts'] === 'on'))
                {
                    $query = "SELECT COUNT(*) FROM `".$wpdb->posts."` WHERE `post_type` = 'post' AND `post_status` = 'publish'";
                    $count = $wpdb->get_var($query);

                    if($count > 0)
                    {
                        $s = ($count/1000)+1;
                        for($i = 1; $i <= $s; $i++)
                        {
                            $xml.= '<sitemap>'."\n";
                            $xml.= '<loc>'.get_site_url().'/sitemap-posts-'.$i.'.xml</loc>'."\n";
                            $xml.= '</sitemap>'."\n";
                        }        
                    }
                }

                $args = array('public' => true, '_builtin' => false);
                $posttypes = get_post_types($args, 'names', 'and');
                foreach($posttypes as $posttype) 
                {
                    if((isset($opts[$posttype])) && ($opts[$posttype] === 'on'))
                    {
                        $query = "SELECT COUNT(*) FROM `".$wpdb->posts."` WHERE `post_type` = '".$posttype."' AND `post_status` = 'publish'";
                        $count = $wpdb->get_var($query);

                        if($count > 0)
                        {
                            $s = ($count/1000)+1;
                            for($i = 1; $i <= $s; $i++)
                            {
                                $xml.= '<sitemap>'."\n";
                                $xml.= '<loc>'.get_site_url().'/sitemap-'.$posttype.'-'.$i.'.xml</loc>'."\n";
                                $xml.= '</sitemap>'."\n";
                            }        
                        }
                    }
                }

                if((isset($opts['pages'])) && ($opts['pages'] === 'on'))
                {
                    $query = "SELECT COUNT(*) FROM `".$wpdb->posts."` WHERE `post_type` = 'page' AND `post_status` = 'publish'";
                    $count = $wpdb->get_var($query);

                    if($count > 0)
                    {
                        $s = ($count/1000)+1;
                        for($i = 1; $i <= $s; $i++)
                        {
                            $xml.= '<sitemap>'."\n";
                            $xml.= '<loc>'.get_site_url().'/sitemap-pages-'.$i.'.xml</loc>'."\n";
                            $xml.= '</sitemap>'."\n";
                        }        
                    }
                }

                if((isset($opts['categories'])) && ($opts['categories'] === 'on'))
                {
                    $query = "SELECT COUNT(*) FROM `".$wpdb->posts."` WHERE `post_type` = 'post' AND `post_status` = 'publish'";
                    $count = $wpdb->get_var($query);

                    if($count > 0)
                    {
                        $xml.= '<sitemap>'."\n";
                        $xml.= '<loc>'.get_site_url().'/sitemap-categories.xml</loc>'."\n";
                        $xml.= '</sitemap>'."\n";      
                    }
                }

                if((isset($opts['tags'])) && ($opts['tags'] === 'on'))
                {
                    $query = "SELECT COUNT(*) FROM `".$wpdb->posts."` WHERE `post_type` = 'post' AND `post_status` = 'publish'";
                    $count = $wpdb->get_var($query);

                    if($count > 0)
                    {
                        $xml.= '<sitemap>'."\n";
                        $xml.= '<loc>'.get_site_url().'/sitemap-tags.xml</loc>'."\n";
                        $xml.= '</sitemap>'."\n";      
                    }
                }

                if((isset($opts['authors'])) && ($opts['authors'] === 'on'))
                {
                    $xml.= '<sitemap>'."\n";
                    $xml.= '<loc>'.get_site_url().'/sitemap-authors.xml</loc>'."\n";
                    $xml.= '</sitemap>'."\n";
                }

                $xml.= '</sitemapindex>'."\n";
                echo $xml;
                exit();
            }

            /**
             * Build posts sitemap
            */
            if((preg_match("/sitemap-posts-([0-9]+).xml$/i", $request, $match)) 
            && ((isset($opts['posts'])) && ($opts['posts'] === 'on')))
            {
                /**
                 * Check if the page number is specified
                */
                $sitemap = (isset($match[1]) && is_numeric($match[1]) ? $match[1] : 1);
                $sitemap = esc_sql($sitemap);

                /**
                 * Number of results to show on page
                */
                $items = 1000;

                /**
                 * Calcul page
                */
                $calc = ($sitemap - 1) * $items;
                $calc = esc_sql($calc);

                /**
                 * Query Posts
                */
                $sql = "SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_type` = 'post' AND `post_status` = 'publish' ORDER BY `ID` DESC LIMIT ".$calc.", ".$items;
                $res = $wpdb->get_results($sql);
        
                if(!empty($res))
                {
                    /**
                     * Load Header
                    */
                    header("Content-type: text/xml");
                    
                    /**
                     * Build XML string
                    */
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
                    $xml.= '<?xml-stylesheet type="text/xsl" href="'.plugin_dir_url(__FILE__).'light-xml-sitemap-public-sitemap.xsl"?>'."\n";
                    $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'."\n";

                    foreach($res as $row)
                    {
                        if(has_post_thumbnail($row->ID))
                        {
                            $src = wp_get_attachment_image_src(get_post_thumbnail_id($row->ID), 'thumbnail');
                        }

                        $datetime = str_replace(' ', 'T', esc_attr($row->post_modified)).'+00:00';
                        $xml.= '<url>'."\n";
                        $xml.= '<loc>'.get_permalink($row->ID).'</loc>'."\n";
                        $xml.= '<lastmod>'.esc_attr($datetime).'</lastmod>'."\n";
                        $xml.= '<changefreq>hourly</changefreq>'."\n";
                        $xml.= '<priority>0.99</priority>'."\n";

                        if(isset($src[0]))
                        {
                            $xml.= '<image:image>'."\n";
                            $xml.= '<image:loc>'.esc_attr($src[0]).'</image:loc>'."\n";
                            $xml.= '<image:caption></image:caption>'."\n";
                            $xml.= '<image:title>'.esc_attr($row->title).'</image:title>'."\n";
                            $xml.= '</image:image>'."\n";
                        }

                        $xml.= '</url>'."\n";
                    }

                    $xml.= '</urlset>'."\n";
                    echo $xml;
                    exit();
                }
            }

            /**
             * Build custom types sitemap
            */
            if(preg_match("/sitemap-([a-z]+)-([0-9]+).xml$/i", $request, $match))
            {
                if((isset($opts[$match[1]])) && ($opts[$match[1]] === 'on'))
                {
                    /**
                     * Check if the page number is specified
                    */
                    $sitemap = (isset($match[2]) && is_numeric($match[2]) ? $match[2] : 1);
                    $sitemap = esc_sql($sitemap);

                    /**
                     * Number of results to show on page
                    */
                    $items = 1000;

                    /**
                     * Calcul page
                    */
                    $calc = ($sitemap - 1) * $items;
                    $calc = esc_sql($calc);

                    /**
                     * Query Posts
                    */
                    $sql = "SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_type` = '".$match[1]."' AND `post_status` = 'publish' ORDER BY `ID` DESC LIMIT ".$calc.", ".$items;
                    $res = $wpdb->get_results($sql);
                
                    if(!empty($res))
                    {
                        /**
                         * Load Header
                        */
                        header("Content-type: text/xml");
                        
                        /**
                         * Build XML string
                        */
                        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
                        $xml.= '<?xml-stylesheet type="text/xsl" href="'.plugin_dir_url(__FILE__).'light-xml-sitemap-public-sitemap.xsl"?>'."\n";
                        $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

                        foreach($res as $row)
                        {
                            $datetime = str_replace(' ', 'T', esc_attr($row->post_modified)).'+00:00';
                            $xml.= '<url>'."\n";
                            $xml.= '<loc>'.get_permalink($row->ID).'</loc>'."\n";
                            $xml.= '<lastmod>'.esc_attr($datetime).'</lastmod>'."\n";
                            $xml.= '<changefreq>hourly</changefreq>'."\n";
                            $xml.= '<priority>0.99</priority>'."\n";
                            $xml.= '</url>'."\n";
                        }

                        $xml.= '</urlset>'."\n";
                        echo $xml;
                        exit();
                    }
                }
            }

            /**
             * Build pages sitemap
            */
            if((preg_match("/sitemap-pages-([0-9]+).xml$/i", $request, $match)) 
            && ((isset($opts['pages'])) && ($opts['pages'] === 'on'))) 
            {
                /**
                 * Check if the page number is specified
                */
                $sitemap = (isset($match[1]) && is_numeric($match[1]) ? $match[1] : 1);
                $sitemap = esc_sql($sitemap);

                /**
                 * Number of results to show on page
                */
                $items = 1000;

                /**
                 * Calcul page
                */
                $calc = ($sitemap - 1) * $items;
                $calc = esc_sql($calc);

                /**
                 * Query Posts
                */
                if(defined('ICL_SITEPRESS_VERSION')) 
                {
                    $deflang = apply_filters('wpml_default_language', NULL);
                    $sql = $wpdb->prepare
                    (
                        "SELECT p.* FROM {$wpdb->prefix}posts p 
                        INNER JOIN {$wpdb->prefix}icl_translations t 
                        ON p.ID = t.element_id 
                        WHERE p.post_type = 'page' AND p.post_status = 'publish' 
                        AND t.language_code = %s 
                        ORDER BY p.ID DESC 
                        LIMIT %d, %d",
                        $deflang, $calc, $items
                    );
                } 
                else 
                {
                    $sql = $wpdb->prepare
                    (
                        "SELECT * FROM {$wpdb->prefix}posts 
                        WHERE post_type = 'page' AND post_status = 'publish' 
                        ORDER BY ID DESC 
                        LIMIT %d, %d",
                        $calc, $items
                    );
                }

                $res = $wpdb->get_results($sql);
                if(!empty($res)) 
                {
                    /**
                     * Load Header
                    */
                    header("Content-type: text/xml");

                    /**
                     * Build XML string
                    */
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
                    $xml.= '<?xml-stylesheet type="text/xsl" href="'.plugin_dir_url(__FILE__).'light-xml-sitemap-public-sitemap.xsl"?>'."\n";
                    $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

                    if(defined('ICL_SITEPRESS_VERSION')) 
                    {
                        global $sitepress;
                        $languages = apply_filters('wpml_active_languages', NULL, ['skip_missing' => 0]);
                    }

                    $seen = [];
                    foreach($res as $row) 
                    {
                        $defperm = get_permalink($row->ID);
                        if(in_array($defperm, $seen)) 
                        {
                            continue;
                        }
                        
                        $seen[] = $defperm;
                        $datetime = str_replace(' ', 'T', $row->post_modified).'+00:00';

                        $xml.= '<url>'."\n";
                        $xml.= '<loc>'.esc_url($defperm).'</loc>'."\n";

                        if(!empty($languages)) 
                        {
                            $curlang = apply_filters('wpml_current_language', NULL);
                            foreach($languages as $langcode => $langinfo) 
                            {
                                $transid = apply_filters('wpml_object_id', $row->ID, 'page', false, $langcode);
                                if($transid) 
                                {
                                    do_action('wpml_switch_language', $langcode);
                                    $transperm = get_permalink($transid);
                                    $xml.= '<xhtml:link rel="alternate" hreflang="'.esc_attr($langcode).'" href="'.esc_url($transperm).'"/>'."\n";
                                }
                            }

                            do_action('wpml_switch_language', $curlang);
                            $xml.= '<xhtml:link rel="alternate" hreflang="x-default" href="'.esc_url($defperm).'"/>'."\n";
                        }

                        $xml.= '<lastmod>'.esc_attr($datetime).'</lastmod>'."\n";
                        $xml.= '<changefreq>hourly</changefreq>'."\n";
                        $xml.= '<priority>0.99</priority>'."\n";
                        $xml.= '</url>'."\n";
                    }

                    $xml.= '</urlset>'."\n";
                    echo $xml;
                    exit();
                }
            }

            /**
             * Build categories sitemap
            */
            if(($request === get_site_url().'/sitemap-categories.xml') 
            && ((isset($opts['categories'])) && ($opts['categories'] === 'on')))
            {
                /**
                 * Query Categories
                */
                $cats = get_categories();
                if(!empty($cats))
                {
                    /**
                     * Load Header
                    */
                    header("Content-type: text/xml");

                    /**
                     * Get Datetime
                    */
                    $datetime = date('Y-m-d').'T'.date('H:i:s').'+00:00';

                    /**
                     * Build XML string
                    */
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
                    $xml.= '<?xml-stylesheet type="text/xsl" href="'.plugin_dir_url(__FILE__).'light-xml-sitemap-public-sitemap.xsl"?>'."\n";
                    $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

                    foreach($cats as $cat)
                    {
                        $datetime = date('Y-m-d').'T'.date('H:i:s').'+00:00';
                        $xml.= '<url>'."\n";
                        $xml.= '<loc>'.get_category_link($cat->term_id).'</loc>'."\n";
                        $xml.= '<lastmod>'.esc_attr($datetime).'</lastmod>'."\n";
                        $xml.= '<changefreq>monthly</changefreq>'."\n";
                        $xml.= '<priority>0.70</priority>'."\n";
                        $xml.= '</url>'."\n";
                    }

                    $xml.= '</urlset>'."\n";
                    echo $xml;
                    exit();
                }
            }

            /**
             * Build tags sitemap
            */
            if(($request === get_site_url().'/sitemap-tags.xml')
            && ((isset($opts['tags'])) && ($opts['tags'] === 'on')))
            {
                /**
                 * Query Tags
                */
                $tags = get_tags();
                if(!empty($tags))
                {
                    /**
                     * Load Header
                    */
                    header("Content-type: text/xml");

                    /**
                     * Get Datetime
                    */
                    $datetime = date('Y-m-d').'T'.date('H:i:s').'+00:00';

                    /**
                     * Build XML string
                    */
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
                    $xml.= '<?xml-stylesheet type="text/xsl" href="'.plugin_dir_url(__FILE__).'light-xml-sitemap-public-sitemap.xsl"?>'."\n";
                    $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

                    foreach($tags as $tag)
                    {
                        $datetime = date('Y-m-d').'T'.date('H:i:s').'+00:00';
                        $xml.= '<url>'."\n";
                        $xml.= '<loc>'.get_tag_link($tag->term_id).'</loc>'."\n";
                        $xml.= '<lastmod>'.esc_attr($datetime).'</lastmod>'."\n";
                        $xml.= '<changefreq>monthly</changefreq>'."\n";
                        $xml.= '<priority>0.70</priority>'."\n";
                        $xml.= '</url>'."\n";
                    }

                    $xml.= '</urlset>'."\n";
                    echo $xml;
                    exit();
                }
            }

            /**
             * Build authors sitemap
            */
            if(($request === get_site_url().'/sitemap-authors.xml') 
            && ((isset($opts['authors'])) && ($opts['authors'] === 'on')))
            {
                /**
                 * Query Authors
                */
                $users = get_users();
                if(!empty($users))
                {
                    /**
                     * Load Header
                    */
                    header("Content-type: text/xml");

                    /**
                     * Get Datetime
                    */
                    $datetime = date('Y-m-d').'T'.date('H:i:s').'+00:00';

                    /**
                     * Build XML string
                    */
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
                    $xml.= '<?xml-stylesheet type="text/xsl" href="'.plugin_dir_url(__FILE__).'light-xml-sitemap-public-sitemap.xsl"?>'."\n";
                    $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

                    foreach($users as $user)
                    {
                        $datetime = date('Y-m-d').'T'.date('H:i:s').'+00:00';
                        $xml.= '<url>'."\n";
                        $xml.= '<loc>'.get_site_url().'/author/'.$user->display_name.'/</loc>'."\n";
                        $xml.= '<lastmod>'.esc_attr($datetime).'</lastmod>'."\n";
                        $xml.= '<changefreq>monthly</changefreq>'."\n";
                        $xml.= '<priority>0.70</priority>'."\n";
                        $xml.= '</url>'."\n";
                    }

                    $xml.= '</urlset>'."\n";
                    echo $xml;
                    exit();
                }
            }
        }
    }
}

?>