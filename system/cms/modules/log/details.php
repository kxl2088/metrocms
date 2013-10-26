<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Log module
 * @author Ramon Leenders | www.ramon-leenders.nl
 */
class Module_Log extends Module
{
    public $version = '1.1.0';
    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Logs',
                'br' => 'Logs',
            ),
            'description' => array(
                'en' => 'Creates viewable error reports of your log files.',
                'br' => 'Cria um relatório de seus arquivos de logs.',
            ),
	    'extra' => array(
		'sections_icon' => 'icon-warning-sign',
	    ),
            'frontend' => FALSE,
            'backend' => TRUE,
            'skip_xss' => TRUE,
            'menu' => 'utilities',
            'sections' => array(
                'posts' => array(
                    'name' => 'log.posts_title',
                    'uri' => 'admin/log',
                    'shortcuts' => array(
                        array(
                            'name' => 'log.truncate_logs',
                            'uri' => 'admin/log/truncate',
                        ),
                        array(
                            'name' => 'log.sync_logs',
                            'uri' => 'admin/log/sync_all',
                            'class' => 'confim'
                        ),
                    ),
                ),
                'physical' => array(
                    'name' => 'log.physical_title',
                    'uri' => 'admin/log/physical',
                ),
            ),
        );
    }

    public function install()
    {
        $this->dbforge->drop_table('log');
        
        $table = array(
            'log' => array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
                'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'default' => null),
                'data' => array('type' => 'LONGBLOB', 'null' => true, 'default' => null),
                'size' => array('type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => null),
                'server_path' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'default' => null),
                'relative_path' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'default' => null),
                'date' => array('type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => null),
                'created_on' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'default' => 0),
            )
        );
        
        if (! $this->install_tables($table)) {
            
            return FALSE;
            
        }
        
        return TRUE;
    }

    public function uninstall()
    {
        return TRUE;
    }

    public function upgrade($old_version)
    {
        // Your Upgrade Logic
        return TRUE;
    }
}

/* End of file details.php */