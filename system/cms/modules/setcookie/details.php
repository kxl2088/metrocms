<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Setcookie extends Module {

    public $version = '1.0.0';

    public function info() {
        return array(
            'name' => array(
                'en' => 'Set Cookie',
                'br' => 'Gerar Cookie',
            ),
            'description' => array(
                'en' => 'Set a cookie called default_setcookie with a serialized data array by ajax or by the plugin use.',
                'br' => 'Gere um cookie chamado default_setcookie com uma array de dados serializada através do ajax ou pelo uso do plugin.'
            ),
            'frontend' => TRUE,
            'backend' => FALSE,
            'menu' => FALSE
        );
    }

    public function install() {
        return TRUE;
    }

    public function uninstall() {
        return TRUE;
    }

    public function upgrade($old_version) {
        return TRUE;
    }
}

/* End of file details.php */
