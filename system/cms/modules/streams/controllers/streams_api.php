<?php defined('BASEPATH') or exit('No direct script access allowed');

class Streams_api extends Public_Controller {
    
    public function __construct()
    {
            parent::__construct();
     
            $this->load->helper('streams/streams');
            $this->lang->load('streams/streams');
    }

    public function index($actions = FALSE)
    {
        $request = $this->input->post() ? $this->input->post() : $this->input->get();
        $actions = $actions ? $actions : $this->uri->segment(2);
        
        if($actions == 'tests')
        {
            exit($this->tests());
        }
        
        $xml_header = "Content-type: text/xml; charset=utf-8";
        $json_header = "Content-type: application/json; charset=utf-8";
        
        //Set header content type
        switch ($request['type'])
        {
            case 'json': 
                header($json_header);
                $data_type = 'json';
            break;
            case 'xml': 
                header($xml_header);
                $data_type = 'xml';
            break;
            default: 
                header($xml_header);
                $data_type = 'xml';
        }
        
        //Set valid actions
        switch ($actions)
        {
            case 'get': $action = 'select'; break;
            case 'put': $action = 'insert'; break;
            case 'upd': $action = 'update'; break;
            case 'del': $action = 'delete'; break;
            default: $action = 'invalid';
        }
        
        //build actions
        if( $request && $actions && $action != 'invalid' )
        {
            if( (isset($request['stream_slug']) && !empty($request['stream_slug'])) )
            {
                if( (isset($request['token']) && !empty($request['token'])) )
                {
                    //check if then toke is valid
                    if( check_api_key($request['token']) )
                    {
                        //check if the token is expired
                        if( !check_expiration_api($request['token']) )
                        {
                            exit(call_user_func('convert_array_to_' . $data_type, array('error' => 106, 'reason' => lang('streams:token_expired'))));
                        }
                        else if( !check_api_permission($request['token'], $request['stream_slug'], $action) )
                        {
                            exit(call_user_func('convert_array_to_' . $data_type, array('error' => 107, 'reason' => lang('streams:access_denied_no_permissions'))));
                        } 
                        
                        $building = build_requests($request, $action);
                        
                        if( !$building )
                        {
                            exit(call_user_func('convert_array_to_' . $data_type, array('error' => 108, 'reason' => lang('streams:invalid_query'))));
                        }
                        else
                        {                     
                            exit(call_user_func('convert_array_to_' . $data_type, array('error' => 0, 'reason' => lang('streams:access_successfully'), 'data' => $building)));
                        }
                        
                    }
                    else
                    {
                        exit(call_user_func('convert_array_to_' . $data_type, array('error' => 105, 'reason' => lang('streams:invalid_token'))));
                    }
                }
                else
                {
                    exit(call_user_func('convert_array_to_' . $data_type, array('error' => 104, 'reason' => lang('streams:no_api_selected'))));
                }
            }
            else
            {
                exit(call_user_func('convert_array_to_' . $data_type, array('error' => 103, 'reason' => lang('streams:no_api_selected'))));
            }
        }
        else if( !$actions )
        {            
            exit(call_user_func('convert_array_to_' . $data_type, array('error' => 101, 'reason' => lang('streams:no_requests'))));
        }
        else if( $request && $actions && $action == 'invalid' )
        {
            exit(call_user_func('convert_array_to_' . $data_type, array('error' => 102, 'reason' => lang('streams:invalid_action'))));
        }        
        else
        {            
            exit(call_user_func('convert_array_to_' . $data_type, array('error' => 100, 'reason' => lang('streams:no_requests'))));
        }
    }
    
    public function tests()
    {
        
        	$data = array(
                    'stream_slug' => 'estatistics', // stream slug name
                    'token' => 'KYZLNAXBSTNIU3RBH785WAZ0WNHKFRGT81HN1P1HN7L5',
                    'type' => 'xml', //xml or json
                    'query' => serialize(array(
                        array('select', 'metro_estatistics.*')
                    )),
                    'return' => 'result'                    
		);
                
                //request accepted methods: streams/get, streams/put, streams/upd, streams/del
		$url = 'http://www.fabriciorabelo.com/streams/get';
                
                $this->load->library('curl');
                
                $curl_opts = array(
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_URL => $url,           
                );
                
                $resp = $this->curl->simple_post($url, $data, $curl_opts);

                if(!$resp){
                    die('Error: "' . $this->curl->error_string . '" - Code: ' . $this->curl->error_code);
                }
                
                header('Content-type: text/xml; charset=utf-8');
                echo $resp;
         
    }
}