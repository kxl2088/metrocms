<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Files module
 *
 * @author  MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Files
 */
class Module_Files extends Module
{

	public $version = '2.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Files',
				'br' => 'Arquivos',
			),
			'description' => array(
				'en' => 'Manages files and folders for your site.',
				'br' => 'Permite gerenciar facilmente os arquivos de seu site.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'content',
			'roles' => array(
				'wysiwyg', 'upload', 'download_file', 'edit_file', 'delete_file', 'create_folder', 'set_location', 'synchronize', 'edit_folder', 'delete_folder'
			)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('files');
		$this->dbforge->drop_table('file_folders');

		$tables = array(
			'files' => array(
				'id' => array('type' => 'CHAR', 'constraint' => 15, 'primary' => true,),
				'folder_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1,),
				'type' => array('type' => 'ENUM', 'constraint' => array('a', 'v', 'd', 'i', 'o'), 'null' => true, 'default' => null,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'filename' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'path' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'description' => array('type' => 'TEXT',),
				'extension' => array('type' => 'VARCHAR', 'constraint' => 10,),
				'mimetype' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'keywords' => array('type' => 'CHAR', 'constraint' => 32, 'default' => ''),
				'width' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'height' => array('type' => 'INT', 'constraint' => 5, 'null' => true,),
				'filesize' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'alt_attribute' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'download_count' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'date_added' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'sort' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
			'file_folders' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'parent_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => 0,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'location' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'local',),
				'remote_container' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'date_added' => array('type' => 'INT', 'constraint' => 11,),
				'sort' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'hidden' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}
                
                $this->db->insert('file_folders', array(
                    'id' => 1,
                    'parent_id' => 0,
                    'slug' => 'usuarios',
                    'name' => 'Usuários',
                    'location' => 'local',
                    'remote_container' => '',
                    'date_added' => time(),
                    'sort' => time()
                ));
                
                $this->db->insert('file_folders', array(
                    'id' => 2,
                    'parent_id' => 0,
                    'slug' => 'blog',
                    'name' => 'Blog',
                    'location' => 'local',
                    'remote_container' => '',
                    'date_added' => time(),
                    'sort' => time()
                ));
                
                $this->db->insert('file_folders', array(
                    'id' => 3,
                    'parent_id' => 2,
                    'slug' => 'galerias-blog',
                    'name' => 'Galerias Blog',
                    'location' => 'local',
                    'remote_container' => '',
                    'date_added' => time(),
                    'sort' => time()
                ));
                                
		// Install the settings
		$settings = array(
			array(
				'slug' => 'files_cache',
				'title' => 'Files Cache',
				'description' => 'When outputting an image via site.com/files what shall we set the cache expiration for?',
				'type' => 'select',
				'default' => '480',
				'value' => '480',
				'options' => '0=no-cache|1=1-minute|60=1-hour|180=3-hour|480=8-hour|1440=1-day|43200=30-days',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 986,
			),
			array(
				'slug' => 'files_enabled_providers',
				'title' => 'Enabled File Storage Providers',
				'description' => 'Which file storage providers do you want to enable? (If you enable a cloud provider you must provide valid auth keys below',
				'type' => 'checkbox',
				'default' => '0',
				'value' => '0',
				'options' => 'amazon-s3=Amazon S3|rackspace-cf=Rackspace Cloud Files',
				'is_required' => false,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 994,
			),
			array(
				'slug' => 'files_s3_access_key',
				'title' => 'Amazon S3 Access Key',
				'description' => 'To enable cloud file storage in your Amazon S3 account provide your Access Key. <a href="https://aws-portal.amazon.com/gp/aws/securityCredentials#access_credentials">Find your credentials</a>',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 993,
			),
			array(
				'slug' => 'files_s3_secret_key',
				'title' => 'Amazon S3 Secret Key',
				'description' => 'You also must provide your Amazon S3 Secret Key. You will find it at the same location as your Access Key in your Amazon account.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 992,
			),
			array(
				'slug' => 'files_s3_geographic_location',
				'title' => 'Amazon S3 Geographic Location',
				'description' => 'Either US or EU. If you change this you must also change the S3 URL.',
				'type' => 'radio',
				'default' => 'US',
				'value' => 'US',
				'options' => 'US=United States|EU=Europe',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 991,
			),
			array(
				'slug' => 'files_s3_url',
				'title' => 'Amazon S3 URL',
				'description' => 'Change this if using one of Amazon\'s EU locations or a custom domain.',
				'type' => 'text',
				'default' => 'http://{{ bucket }}.s3.amazonaws.com/',
				'value' => 'http://{{ bucket }}.s3.amazonaws.com/',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 991,
			),

			array(
				'slug' => 'files_cf_username',
				'title' => 'Rackspace Cloud Files Username',
				'description' => 'To enable cloud file storage in your Rackspace Cloud Files account please enter your Cloud Files Username. <a href="https://manage.rackspacecloud.com/APIAccess.do">Find your credentials</a>',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 990,
			),
			array(
				'slug' => 'files_cf_api_key',
				'title' => 'Rackspace Cloud Files API Key',
				'description' => 'You also must provide your Cloud Files API Key. You will find it at the same location as your Username in your Rackspace account.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 989,
			),
			array(
				'slug' => 'files_upload_limit',
				'title' => 'Filesize Limit',
				'description' => 'Maximum filesize to allow when uploading. Specify the size in MB. Example: 5',
				'type' => 'text',
				'default' => '5',
				'value' => '5',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 987,
			),
                        array(
				'slug' => 'files_wm_force_use',
				'title' => 'Force Watermark Use',
				'description' => 'Set it to force watermark when uploading images on files module.',
				'type' => 'radio',
				'default' => 'no',
				'value' => '',
				'options' => 'yes=Yes|no=No',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 986,
			),
                        array(
				'slug' => 'files_wm_type',
				'title' => 'Watermark Type',
				'description' => 'Sets the type of watermarking that should be used.',
				'type' => 'select',
				'default' => 'text',
				'value' => '',
				'options' => 'text=Text|overlay=Overlay',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 985,
			),
                        array(
				'slug' => 'files_wm_text',
				'title' => 'Watermark Text',
				'description' => 'The text you would like shown as the watermark. Typically this will be a copyright notice.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 984,
			),
                        array(
				'slug' => 'files_wm_font_path',
				'title' => 'Watermark Font Path',
				'description' => 'The server path to the True Type Font you would like to use or the True Type Font ID on files module. If you do not use this option, the native GD font will be used.',
				'type' => 'text',
				'default' => './system/codeigniter/fonts/texb.ttf',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 983,
			),
                        array(
				'slug' => 'files_wm_font_size',
				'title' => 'Watermark Font Size',
				'description' => 'The size of the text. Note: If you are not using the True Type option above, the number is set using a range of 1 - 5. Otherwise, you can use any valid pixel size for the font you\'re using.',
				'type' => 'text',
				'default' => '16',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 982,
			),
                        array(
				'slug' => 'files_wm_font_color',
				'title' => 'Watermark Font Color',
				'description' => 'The font color, specified in hex. Note, you must use the full 6 character hex value (ie, 993300), rather than the three character abbreviated version (ie fff).',
				'type' => 'text',
				'default' => 'ffffff',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 981,
			),
                        array(
				'slug' => 'files_wm_shadow_color',
				'title' => 'Watermark Font Shadow Color',
				'description' => 'The color of the drop shadow, specified in hex. If you leave this blank a drop shadow will not be used. Note, you must use the full 6 character hex value (ie, 993300), rather than the three character abbreviated version (ie fff).',
				'type' => 'text',
				'default' => '000000',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 980,
			),
                        array(
				'slug' => 'files_wm_shadow_distance',
				'title' => 'Watermark Font Shadow Distance',
				'description' => 'The distance (in pixels) from the font that the drop shadow should appear.',
				'type' => 'text',
				'default' => '3',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 979,
			),
                        array(
				'slug' => 'files_wm_padding',
				'title' => 'Watermark Padding',
				'description' => 'The amount of padding, set in pixels, that will be applied to the watermark to set it away from the edge of your images.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 978,
			),
                        array(
				'slug' => 'files_wm_vrt_alignment',
				'title' => 'Watermark Vertical Alignment',
				'description' => 'Sets the vertical alignment for the watermark image.',
				'type' => 'select',
				'default' => 'bottom',
				'value' => '',
				'options' => 'top=Top|middle=Middle|bottom=Bottom',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 977,
			),
                        array(
				'slug' => 'files_wm_hor_alignment',
				'title' => 'Watermark Horizontal Alignment',
				'description' => 'Sets the horizontal alignment for the watermark image.',
				'type' => 'select',
				'default' => 'bottom',
				'value' => '',
				'options' => 'left=Left|center=Center|right=Right',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 976,
			),
                        array(
				'slug' => 'files_wm_hor_offset',
				'title' => 'Watermark Horizontal Offset',
				'description' => 'You may specify a horizontal offset (in pixels) to apply to the watermark position. The offset normally moves the watermark to the right, except if you have your alignment set to "right" then your offset value will move the watermark toward the left of the image.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 975,
			),
                        array(
				'slug' => 'files_wm_vrt_offset',
				'title' => 'Watermark Vertical Offset',
				'description' => 'You may specify a vertical offset (in pixels) to apply to the watermark position. The offset normally moves the watermark down, except if you have your alignment set to "bottom" then your offset value will move the watermark toward the top of the image.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 974,
			),
                        array(
				'slug' => 'files_wm_overlay_path',
				'title' => 'Watermark Overlay Image',
				'description' => 'The server path to the image you wish to use as your watermark or the file image ID on files module. Required only if you are using the overlay method.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 973,
			),
                        array(
				'slug' => 'files_wm_opacity',
				'title' => 'Watermark Overlay Opacity',
				'description' => 'Image opacity. You may specify the opacity (i.e. transparency) of your watermark image. This allows the watermark to be faint and not completely obscure the details from the original image behind it. A 50% opacity is typical.',
				'type' => 'text',
				'default' => '50',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 972,
			),
                        array(
				'slug' => 'files_wm_x_transp',
				'title' => 'Watermark Overlay X-Transparent',
				'description' => 'If your watermark image is a PNG or GIF image, you may specify a color on the image to be "transparent". This setting (along with the next) will allow you to specify that color. This works by specifying the "X" and "Y" coordinate pixel (measured from the upper left) within the image that corresponds to a pixel representative of the color you want to be transparent.',
				'type' => 'text',
				'default' => '4',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 971,
			),
                        array(
				'slug' => 'files_wm_y_transp',
				'title' => 'Watermark Overlay Y-Transparent',
				'description' => 'Along with the previous setting, this allows you to specify the coordinate to a pixel representative of the color you want to be transparent.',
				'type' => 'text',
				'default' => '4',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'files',
				'order' => 970,
			),
		);

		foreach ($settings as $setting)
		{
			if ( ! $this->db->insert('settings', $setting))
			{
				return false;
			}
		}

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
