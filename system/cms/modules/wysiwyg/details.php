<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Widgets Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Widgets
 */
class Module_WYSIWYG extends Module
{

        public $version = '1.0.0';

        public function info()
        {
                return array(
                    'name' => array(
                        'en' => 'WYSIWYG',
                        'br' => 'WYSIWYG',
                    ),
                    'description' => array(
                        'en' => 'Provides the WYSIWYG editor for MetroCMS powered by CKEditor.',                        
                        'br' => 'Fornece um editor WYSIWYG para o MetroCMS, powered by CKEditor.',
                    ),
                    'frontend' => false,
                    'backend' => false,
                );
        }

        public function install()
        {
                $this->db->insert('settings', array(
                    'slug' => 'ckeditor_config',
                    'title' => 'CKEditor Config',
                    'description' => 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>',
                    'type' => 'textarea',
                    'default' => '',
                    'value' => "{{# this is a wysiwyg-simple editor customized for the blog module (it allows images to be inserted) #}}\n$('textarea#intro.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['metroimages'],\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	extraPlugins: 'metroimages',\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}',\n\tprotectedSource: /{{(\s)?.[^}]+(\s)?}}/g\n});\n\n{{# this is the config for all wysiwyg-simple textareas #}}\n$('textarea.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}',\n\tprotectedSource: /{{(\s)?.[^}]+(\s)?}}/g\n});\n\n{{# and this is the advanced editor #}}\n$('textarea.wysiwyg-advanced').ckeditor({\n	toolbar: [\n		['Maximize'],\n		['metroimages', 'metrofiles'],\n		['Cut','Copy','Paste','PasteFromWord'],\n		['Undo','Redo','-','Find','Replace'],\n		['Link','Unlink'],\n		['Table','HorizontalRule','SpecialChar'],\n		['Bold','Italic','StrikeThrough'],\n		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],\n		['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],\n		['ShowBlocks', 'RemoveFormat', 'Source']\n	],\n	extraPlugins: 'metroimages,metrofiles',\n	width: '99%',\n	height: 400,\n	dialog_backgroundCoverColor: '#000',\n	removePlugins: 'elementspath',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}',\n\tprotectedSource: /{{(\s)?.[^}]+(\s)?}}/g\n});",
                    'options' => '',
                    'is_required' => 1,
                    'is_gui' => 1,
                    'module' => 'wysiwyg',
                    'order' => 970,
                ));

                return true;
        }

        public function uninstall()
        {
                // This is a core module, lets keep it around.
                return false;
        }

        public function upgrade($old_version)
        {
                return true;
        }

}
