<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Log module
 * @author Ramon Leenders | www.ramon-leenders.nl
 */
class Admin extends Admin_Controller
{
    protected $section = 'posts';
    protected $insert_batch = array();
    protected $current_batch_number = 1;
    protected $current_batch_size = 0;
    protected $error_headers = array();
    protected $notices = array();
    protected $cms_version = 1.0;

    public function __construct()
    {
        parent::__construct();
        $this->load->config('log_c');
        $this->load->model(array('log_m'));
        $this->load->language(array('log'));
        $this->load->library(array('form_validation', 'zip'));
        $this->load->helper(array('file', 'byte_size', 'error_header', 'html', 'cms_version'));
        $this->cms_version = cms_version(CMS_VERSION);
    }

    public function index()
    {
        $total_rows = $this->log_m->count_all_results('log');
        $pagination = create_pagination('admin/' . $this->module . '/index', $total_rows);
        $this->template
            ->set('logs', $this->log_m->limit($pagination['limit'])->get_many_by())
            ->set('physical_files', $this->_get_log_files())
            ->set('pagination', $pagination)
            ->build('admin/index');
    }

    public function action()
    {
        switch ($this->input->post('btnAction'))
        {
            case 'delete':
                role_or_die($this->module, 'delete_live');
                $this->delete();
                break;
            case 'resync':
                $this->resync($this->input->post('action_to'));
            default:
                redirect('admin/' . $this->module);
                break;
        }
    }

    public function delete($id = 0)
    {
        $ids = ($id) ? array($id) : $this->input->post('action_to');
        if (!empty($ids)) {
            $post_titles = array();
            foreach ($ids as $id) {
                // Get the current page so we can grab the id too
                if ($post = $this->log_m->get($id)) {
                    $this->log_m->delete($id);
                    // Wipe cache for this model, the content has changed
                    $this->metrocache->delete('log_m');
                    $post_titles[] = $post->name;
                }
            }
        }
        // Some logs have been deleted
        if (!empty($post_titles)) {
            if (count($post_titles) == 1) {
                $this->session->set_flashdata('success', sprintf($this->lang->line('log.delete_success'), $post_titles[0]));
            }
            else {
                $this->session->set_flashdata('success', sprintf($this->lang->line('log.mass_delete_success'), implode('", "', $post_titles)));
            }
        }
        else {
            $this->session->set_flashdata('notice', lang('log.delete_error'));
        }
        redirect('admin/' . $this->module);
    }

    public function truncate()
    {
        $this->db->truncate('log');
        $this->session->set_flashdata('success', $this->lang->line('log.delete_all_success'));
        redirect('admin/' . $this->module);
    }

    private function _process_insert_batch()
    {
        if (!empty($this->insert_batch)) {
            foreach ($this->insert_batch as $batch) {
                $this->db->insert_batch('log', $batch);
            }
        }
    }

    public function resync($id = 0)
    {
        if (!is_array($id)) {
            $id OR redirect('admin/' . $this->module);
            $log = $this->log_m->get($id);
            if ($log) {
                $file_path = $log->relative_path . $log->name;
                // Get the file information
                $file_info = get_file_info($file_path);
                // If there is information
                if ($file_info) {
                    // We want our file to be beneath the maximum log size
                    if ($file_info['size'] < $this->settings->maximum_log_size) {
                        $data = array(
                            'data'       => str_replace('<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\'); ?>', '', read_file($file_path)),
                            'created_on' => now(),
                            'size'       => $file_info['size']
                        );
                        $this->db->where('id', $id)->update('log', $data);
                        $this->session->set_flashdata('success', sprintf($this->lang->line('log.resync_success'), $log->name));
                    }
                    else {
                        $this->session->set_flashdata('notice', sprintf($this->lang->line('log.resync_too_large'), $log->name));
                    }
                }
                else {
                    $this->session->set_flashdata('error', sprintf($this->lang->line('log.resync_error'), $log->name));
                }
            }
            else {
                $this->session->set_flashdata('error', sprintf($this->lang->line('log.resync_not_exists'), $id));
            }
        }
        else {
            $database_ids = array();
            $messages     = array(
                'error'     => array(),
                'success'   => array(),
                'too_large' => array(),
            );
            $logs         = $this->log_m->get_many_by(array('where_in' => array('id', $id)));
            if ($logs) {
                foreach ($logs as $log) {
                    $database_ids[] = $log->id;
                    $file_path      = $log->relative_path . $log->name;
                    // Get the file information
                    $file_info = get_file_info($file_path);
                    // If there is information
                    if ($file_info) {
                        // We want our file to be beneath the maximum log size
                        if ($file_info['size'] < $this->settings->maximum_log_size) {
                            $data = array(
                                'data'       => str_replace('<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\'); ?>', '', read_file($file_path)),
                                'created_on' => now(),
                                'size'       => $file_info['size']
                            );
                            $this->db->where('id', $log->id)->update('log', $data);
                            $messages['success'][] = $log->name;
                        }
                        else {
                            $messages['too_large'][] = $log->name;
                        }
                    }
                }
            }
            $messages['error'] = array_diff($id, $database_ids);
            foreach ($messages as $type => $values) {
                if (!empty($values)) {
                    switch ($type) {
                        case 'error':
                            $this->session->set_flashdata('error', sprintf($this->lang->line('log.resync_not_exists_multiple'), implode(',', $values)));
                            break;
                        case 'success':
                            $this->session->set_flashdata('success', sprintf($this->lang->line('log.resync_success_multiple'), implode(',', $values)));
                            break;
                        case 'too_large':
                            $this->session->set_flashdata('notice', sprintf($this->lang->line('log.resync_too_large_multiple'), implode(',', $values)));
                            break;
                    }
                }
            }
        }
        (isset($_SERVER["HTTP_REFERER"])) ? (redirect($_SERVER["HTTP_REFERER"])) : (redirect('admin/' . $this->module));
    }

    private function _get_log_files()
    {
        return get_dir_file_info($this->settings->log_directory);
    }

    public function sync_all()
    {
        $i     = 0;
        $cfg = config_item('sync_all_limit');
        $limit = &$cfg;
        // A zero as limit is unlimited, so make sure to use it
        $unlimited = ($limit == 0) ? (true) : (false);
        $logs      = $this->_get_log_files();
        if (!empty($logs) && array_key_exists('index.html', $logs)) {
            // Unset this stupid file
            unset($logs['index.html']);
        }
        if (!empty($logs)) {
            ksort($logs);
            // The last one should be the latest so reverse the array
            $logs = array_reverse($logs);
            // Loop all the log files
            foreach ($logs as $key => $file) {
                // If we don't do umlimited synchronizing and we've reached the limit, break
                if (!$unlimited && $i >= $limit) {
                    break;
                }
                $this->_process_log($file);
                $i++;
            }
            // Process the insert batch
            $this->_process_insert_batch();
            if (!empty($this->notices)) {
                $this->session->set_flashdata('notice', sprintf($this->lang->line('log.sync_too_big_notices'), implode(', ', $this->notices)));
            }
            else {
                $this->session->set_flashdata('success', $this->lang->line('log.sync_success'));
            }
        }
        else {
            $this->session->set_flashdata('notice', $this->lang->line('log.no_logs'));
        }
        redirect('admin/' . $this->module);
    }

    private function _process_log($file)
    {
        // The file is not in our database yet, woheoeooeee
        if (!$this->db->where('name', $file['name'])->get('log')->result()) {
            if ($file['size'] < $this->settings->maximum_log_size) {
                // If our current batch's size plus the log file size exceeds the max
                if (($this->current_batch_size + $file['size']) >= $this->settings->maximum_batch_size) {
                    // Next batch
                    $this->current_batch_number++;
                    // New current batch size
                    $this->current_batch_size = $file['size'];
                }
                else {
                    $this->current_batch_size += $file['size'];
                }
                $this->insert_batch[$this->current_batch_number][] = $this->_sync_file($file);
            }
            else {
                $this->notices[] = $file['name'];
            }
        }
        // The file already exists...
        else {
            $this->db->where('name', $file['name'])->update('log', $this->_sync_file($file));
        }
    }

    private function _sync_file($file)
    {
        $file_path = $file['relative_path'] . $file['name'];
        return array_merge(
            $file,
            array(
                'data'       => str_replace('<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\'); ?>', '', read_file($file_path)),
                'created_on' => now()
            )
        );
    }

    public function sync_log_files()
    {
        if ($this->input->post('logs') && $this->input->post('action')) {
            // All the available logs
            $available_logs = $this->_get_log_files();
            // For each sent log file
            foreach ($this->input->post('logs') as $file) {
                // Check if it's (still) available in the directory
                if (array_key_exists($file['value'], $available_logs)) {
                    switch ($this->input->post('action')) {
                        case 'del_physical':
                            // throw away this file pleeease!
                            unlink($this->settings->log_directory . $file['value']);
                            break;
                        case 'sync':
                            $this->_process_log($available_logs[$file['value']]);
                            break;
                        case 'download':
                            $downloads[] = $file['value'];
                            break;
                    }
                }
            }
            switch ($this->input->post('action')) {
                case 'del_physical':
                    echo json_encode(
                        array(
                            'message' => lang('log.delete_physical_seccess'),
                            'status'  => 'success'
                        )
                    );
                    break;
                case 'sync':
                    // Process the insert batch
                    $this->_process_insert_batch();
                    if (!empty($this->notices)) {
                        echo json_encode(
                            array(
                                'message' => sprintf($this->lang->line('log.sync_too_big_notices'), implode(', ', $this->notices)),
                                'status'  => 'notice'
                            )
                        );
                    }
                    else {
                        echo json_encode(
                            array(
                                'message' => $this->lang->line('log.sync_success'),
                                'status'  => 'success'
                            )
                        );
                    }
                    break;
                case 'download':
                    $this->session->set_userdata('log_zip', serialize($downloads));
                    $url = (isset($downloads) && !empty($downloads)) ? (array('url' => 'admin/' . $this->module . '/download_log_zip/')) : (array());
                    echo json_encode(
                        array_merge(array(
                                'message' => $this->lang->line('log.download_success'),
                                'status'  => 'success',
                            ), $url
                        )
                    );
                    break;
            }
        }
        else {
            echo json_encode(
                array(
                    'count'   => 0,
                    'message' => $this->lang->line('log.select_log_files_error'),
                )
            );
        }
    }

    public function download_log_zip()
    {
        if ($this->session->userdata('log_zip')) {
            // Unserialize to get allt he names of the log files
            $logs = unserialize($this->session->userdata('log_zip'));
            if ($logs) {
                foreach ($logs as $log) {
                    // Read every file
                    $this->zip->read_file($this->settings->log_directory . $log);
                }
                $this->load->helper('string');
                // Add a random string, in order to get different filenames
                $this->zip->download('logs_' . SITE_REF . '_' . format_date(now()) . random_string('alnum', 16) . '.zip');
            }
        }
        $this->session->unset_userdata('log_zip');
    }

    private function _set_error_count($error)
    {
        $error_slug = strtolower(url_title(trim($error)));
        if (isset($this->error_headers[$error_slug])) {
            $this->error_headers[$error_slug]++;
        }
        else {
            $this->error_headers[$error_slug] = 1;
        }
    }

    public function preview($id = 0)
    {
        $id OR redirect('admin/' . $this->module);
        $this->load->library('table');
        $header_images = array(
            'unable-to-load-the-requested-class' => APPPATH . 'modules/' . $this->module . '/img/class-not-found.png',
            'severity-notice'                    => APPPATH . 'modules/' . $this->module . '/img/severity-notice.gif',
            'severity-warning'                   => APPPATH . 'modules/' . $this->module . '/img/severity-warning.gif',
            'page-missing'                       => APPPATH . 'modules/' . $this->module . '/img/page-missing.png',
            'query-error'                        => APPPATH . 'modules/' . $this->module . '/img/query-error.png',
            'invalid-query'                      => APPPATH . 'modules/' . $this->module . '/img/invalid-query.png',
            'other'                              => APPPATH . 'modules/' . $this->module . '/img/other.gif',
            'unable-to-select-database'          => APPPATH . 'modules/' . $this->module . '/img/unable-to-select-database.png'
        );
        $log           = $this->log_m->get($id);
        $log or redirect('admin/' . $this->module);
        $tmpl = array('table_open' => '<table border="0" cellpadding="0" cellspacing="0" class="log_errors responsive table table-hover table-striped table-bordered">');
        $this->table->set_template($tmpl);
        $this->table->set_heading(lang('log.date_label'), lang('log.header_label'), lang('log.error_label'));
        // Get all lines, by splitting them on the newline
        $data_lines     = array_filter(preg_split('/\r\n|\r|\n/', $log->data));
        $explode_string = ' --> ';
        foreach ($data_lines as $line) {
            $explodables = substr_count($line, $explode_string);
            switch ($explodables) {
                // Only one explode string
                case 1:
                    list($date, $error) = explode($explode_string, str_replace('ERROR - ', '', $line));
                    if (is_array($exploded_error = explode(':', $error))) {
                        switch (count($exploded_error)) {
                            // No real reason stated for the error, so simply categorize it in other
                            case 1:
                                $this->table->add_row(format_date(strtotime($date), 'G:i:s'), error_header('Other', $header_images), $error);
                                $this->_set_error_count('Other');
                                break;
                            // We have anything other than 1 (proabably 2..)
                            default:
                                $this->table->add_row(format_date(strtotime($date), 'G:i:s'), error_header($exploded_error[0], $header_images), $exploded_error[1]);
                                $this->_set_error_count($exploded_error[0]);
                                break;
                        }
                    }
                    break;
                // We have two of these arrows -->
                case 2:
                    list($date, $header, $error) = explode($explode_string, str_replace('ERROR - ', '', $line));
                    $this->table->add_row(format_date(strtotime($date), 'G:i:s'), error_header($header, $header_images), $error);
                    $this->_set_error_count($header);
                    break;
            }
        }
        // Sort the errors alphabetical please
        ksort($this->error_headers);
        $log_errors            = $this->table->generate();
        $total_errors          = 0;
        $different_error_types = count($this->error_headers);
        foreach ($this->error_headers as $key => $value) {
            $label   = (lang('log.' . $key . '_label') != '') ? (lang('log.' . $key . '_label')) : ($key);
            $icon    = (isset($header_images[$key])) ? (img(
                array(
                    'src'   => $header_images[$key],
                    'title' => lang('log.' . $key . '_label'),
                )
            )) : (null);
            $anchors = array(
                anchor('#', lang('log.first_occurence_label'), 'class="' . $key . '" rel="first"'),
                anchor('#', lang('log.last_occurence_label'), 'class="' . $key . '" rel="last"')
            );
            // If we only have on, the first is the same as the last one
            if ($value == 1) {
                unset($anchors[1]);
            }
            // If the different error types equals one, the first occurence is at the top already
            if ($different_error_types == 1) {
                unset($anchors[0]);
            }
            $errors_overview[] = array(
                form_checkbox($key, false, true),
                $icon . $label,
                $value,
                (!empty($anchors)) ? ('<span class="actions">' . implode(', ', $anchors) . '</span>') : (null)
            );
            // We want the total amount, pleaaase
            $total_errors += $value;
        }
        $errors_overview[] = array(null, lang('log.total_counted_errors'), $total_errors, null);
        $tmpl              = array('table_open' => '<table border="0" cellpadding="0" cellspacing="0" class="errors_overview responsive table table-hover table-striped table-bordered">');
        $this->table->set_template($tmpl);
        $this->table->set_heading(array('', lang('log.error_header_label'), lang('log.number_of_occurences_label'), lang('log.actions_label')));
        $errors_overview = $this->table->generate($errors_overview);
        if ($this->cms_version >= 1.0) {
            $this->template
                ->append_js('module::jquery.scrollintoview.min.js')
                ->append_js('module::jNotify.jquery.js')
                ->append_js('module::log.preview.js')
                ->append_css('module::log.preview.css')
                ->append_css('module::jNotify.jquery.css');
        }
        else {
            $this->template
                ->append_metadata(js('jquery.scrollintoview.min.js', $this->module))
                ->append_metadata(js('jNotify.jquery.js', $this->module))
                ->append_metadata(js('log.preview.js', $this->module))
                ->append_metadata(css('log.preview.css', $this->module))
                ->append_metadata(css('jNotify.jquery.css', $this->module));
        }

        $this->template
            ->set('log', $log)
            ->set('log_errors', $log_errors)
            ->set('total_errors', $total_errors)
            ->set('errors_overview', $errors_overview)
            ->set('physical_files', $this->_get_log_files())
            ->append_metadata('<script type="text/javascript">
        var finishedScrolling = "' . lang('log.finished_scrolling') . '";
        </script>')
            ->build('admin/preview');
    }

}
