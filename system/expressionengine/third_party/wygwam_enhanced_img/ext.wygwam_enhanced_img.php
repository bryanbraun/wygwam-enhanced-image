<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Wygwam Enhanced Image
 *
 * @package     ExpressionEngine
 * @subpackage  Add-ons
 * @category    Extension
 * @author      Nathan Doyle
 * @copyright   Copyright (c) 2015, Nathan Doyle
 * @link        http://github.com/Natetronn/wygwam_enhanced_image
 * @license     http://github.com/Natetronn/wygwam_enhanced_image/license.txt
 */

class Wygwam_enhanced_img_ext
{

    private static $_included_resources = FALSE;

    var $name           = 'Wygwam Enhanced Image';
    var $version        = '0.3';
    var $description    = '';
    var $docs_url       = 'http://github.com/Natetronn/wygwam_enhanced_image';
    var $settings_exist = 'y';

    /**
     * Set our hooks
     * @var array
     */
    private $_hooks = array(
        'wygwam_config',
    );

    /**
     * The Constructor
     * @param string $settings
     */
    public function __construct($settings = '')
    {
        $this->settings = $settings;
        $this->theme_url    = defined( 'URL_THIRD_THEMES' )
                            ? URL_THIRD_THEMES . 'wygwam_enhanced_img/'
                            : ee()->config->item('theme_folder_url') . 'third_party/wygwam_enhanced_img/';
    }

    /**
     * Activate our extension
     * @return mixed
     */
    public function activate_extension()
    {

        $this->settings = array(
            'imageresponsive'   => FALSE,
            'inline_or_class'   => "inline",
            'captioned_class'   => "image-captioned",
            'align_classes'     => "'image-left', 'image-center', 'image-right'",
        );

        foreach ($this->_hooks as $hook)
        {
            ee()->db->insert('extensions', array(
                'class'    => get_class($this),
                'method'   => $hook,
                'hook'     => $hook,
                'settings' => serialize($this->settings),
                'priority' => 10,
                'version'  => $this->version,
                'enabled'  => 'y'
            ));
        }
    }

    /**
     * Update extension
     * @param  [type] $current
     * @return [type]
     */
    public function update_extension($current = NULL)
    {
        return FALSE;
    }

    /**
     * Disable extension
     * @return [type]
     */
    public function disable_extension()
    {
        ee()->db->where('class', get_class($this))->delete('extensions');
    }

    /**
     * Settings
     * @return array
     */
    public function settings()
    {
        $settings = array();

        $settings['imageresponsive'] = array('r', array(FALSE => "Non-Responsive", TRUE => "Responsive"), FALSE);
        $settings['inline_or_class'] = array('r', array('inline' => "Inline", 'class' => "Class"), 'inline');
        $settings['captioned_class'] = array('i', '', "image-captioned");
        $settings['align_classes']  = array('i', '', "'image-left', 'image-center', 'image-right'");

        return $settings;
    }

    public function wygwam_config($config, $settings)
    {

        $imageresponsive    = $this->settings['imageresponsive'];

        if (($last_call = ee()->extensions->last_call) !== FALSE)
        {
            $config = $last_call;
        }

        // Add our plugin to CKEditor
        if (!empty($config['extraPlugins']))
        {
            $config['extraPlugins'] .= ',';
        }

        $config['extraPlugins'] .= 'image2';

        if ($imageresponsive == TRUE)
        {
            $config['extraPlugins'] .= ',imageresponsive';
        }

        $this->_include_resources();

        return $config;
    }

    /**
     * Include all our resources
     * @return string
     */
    private function _include_resources()
    {
        $plugins            = '';
        $inline_or_class    = $this->settings['inline_or_class'];
        $captioned_class    = $this->settings['captioned_class'];
        $align_classes      = $this->settings['align_classes'];
        $imageresponsive    = $this->settings['imageresponsive'];

        if ($inline_or_class == "class")
        {
            $align_classes = "CKEDITOR.config.image2_alignClasses = [ $align_classes ];";
            $captioned_class = "CKEDITOR.config.image2_captionedClass = '".$captioned_class."';";
        }
        else
        {
            $captioned_class = "";
            $align_classes = "";
        }


        // Is this the first time we've been called?
        if (!self::$_included_resources)
        {
            // Tell CKEditor where to find our plugins
            $plugin_names = array('dialogui','dialog','lineutils','clipboard','widget','image2');

            foreach ($plugin_names as $name)
            {
                $plugins .= "CKEDITOR.plugins.addExternal('".$name."', '".$this->theme_url.$name."/');".NL."";
            }

            if ($imageresponsive == TRUE)
            {
                $plugins .= "CKEDITOR.plugins.addExternal('imageresponsive', '".$this->theme_url."imageresponsive/');";
            }

            // Tell CKEditor where to find our plugin
            ee()->cp->add_to_foot('
                <script type="text/javascript">
                    '.$plugins.'
                    '.$align_classes.'
                    '.$captioned_class.'
                </script>
            ');

            // Don't do that again
            self::$_included_resources = TRUE;
        }
    }
}
