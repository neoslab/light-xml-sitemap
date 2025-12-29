<?php
if((isset($_GET['output'])) && ($_GET['output'] === 'updated'))
{
    $notice = array('success', __('Your settings have been successfully updated.', 'light-xml-sitemap'));
}
?>
<div class="wrap">
    <section class="wpdx-wrapper">
        <div class="wpdx-container">
            <div class="wpdx-tabs">
                <?php echo $this->return_plugin_header(); ?>
                <main class="tabs-main">
                    <?php echo $this->return_tabs_menu('tab1'); ?>
                    <section class="tab-section">
                        <?php if(get_option('blog_public') != '1') { ?>
                        <div class="wpdx-notice wrong">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo _e('Your current <b>Search engine visibility</b> is set to discourage search engines from indexing this site. In order for the sitemap to be displayed publicly you need to modify your <a href="'.get_admin_url().'options-reading.php">reading settings</a> now.', 'maintenance-work'); ?></span>
                        </div>
                        <?php } ?>
                        <?php if(isset($notice)) { ?>
                        <div class="wpdx-notice <?php echo esc_attr($notice[0]); ?>">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo esc_attr($notice[1]); ?></span>
                        </div>
                        <?php } ?>
                        <form method="POST">
                            <input type="hidden" name="lxs-update-option" value="true" />
                            <?php wp_nonce_field('lxs-referer-form', 'lxs-referer-option'); ?>
                            <div class="wpdx-form">
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Include Posts', 'light-xml-sitemap'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <div class="onoffswitch">
                                        <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[posts]" class="onoffswitch-checkbox" <?php if((isset($opts['posts'])) && ($opts['posts'] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                        <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <small><?php echo _e('Do you want to include the posts into the sitemap.', 'light-xml-sitemap'); ?></small>
                                </div>
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Include Custom Post Types', 'light-xml-sitemap'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <div class="onoffswitch">
                                        <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[posttypes]" class="onoffswitch-checkbox input-posttypes" <?php if((isset($opts['posttypes'])) && ($opts['posttypes'] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                        <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <small><?php echo _e('Do you want to include the posts into the sitemap.', 'light-xml-sitemap'); ?></small>
                                </div>
                                <div id="handler-posttypes" class="subfield <?php if((isset($opts['posttypes'])) && ($opts['posttypes'] === 'on')) { echo 'show'; } ?>">
                                    <?php
                                    $args = array('public' => true, '_builtin' => false);
                                    $posttypes = get_post_types($args, 'names', 'and'); 
                                    foreach($posttypes as $posttype) 
                                    {
                                        ?>
                                        <div class="field">
                                            <?php $fieldID = uniqid(); ?>
                                            <span class="label"><?php echo sprintf(__('Include %s.'), ucwords($posttype)); ?><span class="redmark">(<span>*</span>)</span></span>
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[<?php echo $posttype; ?>]" class="onoffswitch-checkbox" <?php if((isset($opts[$posttype])) && ($opts[$posttype] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                                <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                            <small><?php echo _e('Do you want to include the pages into the sitemap.', 'light-xml-sitemap'); ?></small>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Include Pages', 'light-xml-sitemap'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <div class="onoffswitch">
                                        <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[pages]" class="onoffswitch-checkbox" <?php if((isset($opts['pages'])) && ($opts['pages'] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                        <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <small><?php echo _e('Do you want to include the pages into the sitemap.', 'light-xml-sitemap'); ?></small>
                                </div>
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Include Categories', 'light-xml-sitemap'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <div class="onoffswitch">
                                        <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[categories]" class="onoffswitch-checkbox" <?php if((isset($opts['categories'])) && ($opts['categories'] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                        <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <small><?php echo _e('Do you want to include the categories into the sitemap.', 'light-xml-sitemap'); ?></small>
                                </div>
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Include Tags', 'light-xml-sitemap'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <div class="onoffswitch">
                                        <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[tags]" class="onoffswitch-checkbox" <?php if((isset($opts['tags'])) && ($opts['tags'] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                        <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <small><?php echo _e('Do you want to include the tags into the sitemap.', 'light-xml-sitemap'); ?></small>
                                </div>
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Include Author', 'light-xml-sitemap'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <div class="onoffswitch">
                                        <input type="checkbox" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[authors]" class="onoffswitch-checkbox" <?php if((isset($opts['authors'])) && ($opts['authors'] === 'on')) { echo esc_attr('checked="checked"'); } ?>/>
                                        <label class="onoffswitch-label" for="<?php echo esc_attr($fieldID); ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <small><?php echo _e('Do you want to include the authors into the sitemap.', 'light-xml-sitemap'); ?></small>
                                </div>
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Sitemap Name', 'light-xml-sitemap'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <input type="text" id="<?php echo esc_attr($fieldID); ?>" name="_light_xml_sitemap[name]" placeholder="<?php echo _e('Enter the sitemap name', 'light-xml-sitemap'); ?>" value="<?php if(isset($opts['name'])) { echo esc_attr($opts['name']); } ?>" autocomplete="OFF" required="required"/>
                                    <small><?php echo _e('Set an alternative name for the sitemap index (Leave empty to use the default: sitemap.xml).', 'light-xml-sitemap'); ?></small>
                                </div>
                                <div class="form-footer">
                                    <input type="submit" class="button button-primary button-theme" style="height:45px;" value="<?php _e('Update Settings', 'light-xml-sitemap'); ?>">
                                </div>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
        </div>
    </section>
</div>