<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Module_Blacklist extends Module {

    public $version = '1.1.0';

    public function info() {
        return array(
            'name' => array(
                'en' => 'Blacklist',
                'br' => 'Lista Negra',
            ),
            'description' => array(
                'en' => 'MetroCMS module to blacklist ip addresses.',
                'br' => 'Módulo MetroCMS para bloqueio de visualização do site por endereço IP. '
            ),
            'frontend' => FALSE,
            'backend' => TRUE,
            'menu' => 'utilities',
            'shortcuts' => array(
                'create' => array(
                    'name' => 'blacklist:create',
                    'uri' => 'admin/blacklist/create',
                    'class' => 'add'
                ),
            )
        );
    }

    public function install() {
        $this->uninstall();

        $tables = array(
            'blacklist' => array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => '11',
                    'auto_increment' => TRUE,
                    'primary' => TRUE
                ),
                'ip' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '15'
                ),
                'reason' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '250',
                    'default' => ''
                ),
            )
        );


        if ($this->install_tables($tables)) {
            return TRUE;
        }
    }

    public function uninstall() {
        $this->dbforge->drop_table('blacklist'); {
            return TRUE;
        }
    }

    public function upgrade($old_version) {
        // Your Upgrade Logic
        if (version_compare($this->version, $old_version, '>')) {
            $field = array(
                'reason' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '250',
                    'default' => ''
                    ));
        }
        $this->dbforge->add_column('blacklist', $field);


        return TRUE;
    }
}

/* End of file details.php */
