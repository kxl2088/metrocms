<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_blog_and_wysiwyg extends CI_Migration {

	public function up()
	{
                $this->db->update('settings', array('value' => "{{# this is a wysiwyg-simple editor customized for the blog module (it allows images to be inserted) #}}\n$('textarea#intro.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['metroimages'],\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	extraPlugins: 'metroimages',\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}',\n\tprotectedSource: /{{(\s)?.[^}]+(\s)?}}/g\n});\n\n{{# this is the config for all wysiwyg-simple textareas #}}\n$('textarea.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}',\n\tprotectedSource: /{{(\s)?.[^}]+(\s)?}}/g\n});\n\n{{# and this is the advanced editor #}}\n$('textarea.wysiwyg-advanced').ckeditor({\n	toolbar: [\n		['Maximize'],\n		['metroimages', 'metrofiles'],\n		['Cut','Copy','Paste','PasteFromWord'],\n		['Undo','Redo','-','Find','Replace'],\n		['Link','Unlink'],\n		['Table','HorizontalRule','SpecialChar'],\n		['Bold','Italic','StrikeThrough'],\n		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],\n		['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],\n		['ShowBlocks', 'RemoveFormat', 'Source']\n	],\n	extraPlugins: 'metroimages,metrofiles',\n	width: '99%',\n	height: 400,\n	dialog_backgroundCoverColor: '#000',\n	removePlugins: 'elementspath',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}',\n\tprotectedSource: /{{(\s)?.[^}]+(\s)?}}/g\n});"), array('slug' => 'ckeditor_config'));
                
                $this->db->set(array(
                                    'slug' => 'blog_enable_gallery',
                                    'title' => 'Enable blog gallery',
                                    'description' => 'Enable to use a gallery in the blog posts.',
                                    'type' => 'radio',
                                    'default' => '0',
                                    'value' => '',
                                    'options' => '1=Yes|0=No',
                                    'is_required' => 1,
                                    'is_gui' => 1,
                                    'module' => 'blog',
                                    'order' => 996,
                    )); 
                $this->db->insert('settings'); 
                
                return true;
	}

	public function down()
	{                
		return true;
	}
}