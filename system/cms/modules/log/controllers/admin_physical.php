<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Log module
 * @author Ramon Leenders | www.ramon-leenders.nl
 */
class Admin_Physical extends Admin_Controller
{

    protected $section = 'physical';
    protected $cms_version = 1.0;

    public function __construct()
    {
        parent::__construct();
        $this->load->config('log_c');
        $this->load->model(array('log_m'));
        $this->load->language(array('log'));
        $this->load->helper(array('file', 'byte_size', 'error_header', 'html', 'cms_version'));
        $this->cms_version = cms_version(CMS_VERSION);
    }

    public function index()
    {
        $directory_size = 0;
        foreach ($this->_get_log_files() as $log) {
            $directory_size += $log['size'];
        }
        if ($this->cms_version >= 1.0) {
            $this->template
                ->append_js('module::jquery.dynatree.js')
                ->append_js('module::jNotify.jquery.js')
                ->append_js('module::log.physical.index.js')
                ->append_css('module::skin/ui.dynatree.css')
                ->append_css('module::jNotify.jquery.css')
                ->append_css('module::log.physical.index.css');
        }
        else {
            $this->template
                ->append_metadata(js('jquery-ui.custom.js', $this->module))
                ->append_metadata(js('jquery.dynatree.js', $this->module))
                ->append_metadata(js('jNotify.jquery.js', $this->module))
                ->append_metadata(js('log.physical.index.js', $this->module))
                ->append_metadata(css('skin/ui.dynatree.css', $this->module))
                ->append_metadata(css('jNotify.jquery.css', $this->module))
                ->append_metadata(css('log.physical.index.css', $this->module));
        }
        $this->template
            ->set('directory_size', $directory_size)
            ->build('admin/physical/index');
    }

    public function selected_error()
    {
        echo json_encode(
            array(
                'errorLine' => lang('log.no_logs_selected')
            )
        );
    }

    public function log_files()
    {
        // Get all the logs, the last should be the latest so reverse the array
        $logs = $this->_get_log_files();
        if (!empty($logs) && array_key_exists('index.html', $logs)) {
            // Unset this stupid file
            unset($logs['index.html']);
        }
        $json = array(
            'title'        => 'logs',
            'isFolder'     => true,
            'children'     => array(),
            'expand'       => true,
            'unselectable' => true,
            'hideCheckbox' => true
        );
        if (!empty($logs)) {
            $exists = array();
            foreach ($this->log_m->get_all_names() as $database_log) {
                $exists[] = $database_log->name;
            }
            ksort($logs);
            $logs = array_reverse($logs);
            foreach ($logs as $log) {
                $class = (in_array($log['name'], $exists)) ? ('saved-in-database') : (null);
                $class .= ($log['size'] > $this->settings->maximum_log_size) ? ('oversized') : (null);
                $json['children'][] = array(
                    'title'    => $log['name'] . '<span class="date">' . format_date($log['date'], 'd-m-Y') . '</span><span class="size">' . byte_size($log['size']) . '</span>',
                    'key'      => $log['name'],
                    'size'     => $log['size'],
                    'addClass' => $class,
                );
            }
        }
        else {
            $json['title'] = $json['title'] . lang('log.empty_log_directory');
        }
        echo json_encode($json);
    }

    private function _get_log_files()
    {
        return get_dir_file_info($this->settings->log_directory);
    }
}