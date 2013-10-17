<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Streams Helper
 *
 * @author      Adam Fairholm
 */

/**
 * Check that the user has access to a  stream. Redirects
 * if this is not the case. This is like the streams
 * version of role_or_die.
 *
 * @return 	mixed
 */
function check_stream_permission($stream, $redirect = true)
{
	if ( ! isset(ci()->current_user->group) or ci()->current_user->group == 'admin') return true;

	if ( ! isset($stream->permissions)) return true;

	$perms = @unserialize($stream->permissions);
	if ( ! is_array($perms)) return true;

	if (in_array(ci()->current_user->group_id, $perms)) return true;

	if ($redirect)
	{
		ci()->session->set_flashdata('error', lang('cp:access_denied'));
		redirect('admin/streams');
	}
	else
	{
		return false;
	}
}
        
function token($lenght = 8)
{        
        $uppercase = true; 
        $numbers = true; 
        $simbols = false;
        //Strings
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';

        //Result to return
        $result = '';
        //Chars to mount return
        $chars = '';
        $chars .= $lmin;

        if ($uppercase){ $chars .= $lmai; }
        if ($numbers){ $chars .= $num; }
        if ($simbols){ $chars .= $simb; }

        $len = strlen($chars);

        for ($n = 1; $n <= $lenght; $n++) {
            $rand = mt_rand(1, $len);
            $result .= $chars[$rand-1];
        }

        return strtoupper($result);
}

function convert_array_xml($arr) {
        $xml = '';
        foreach ($arr as $key => $value)
            $xml .= sprintf("<%s>%s</%s>", $key, is_array($value) ? convert_array_xml($value) : (phpversion() >= '5.4.0'  ? htmlspecialchars($value, ENT_XML1) : htmlspecialchars($value)), $key);

        return $xml;
}

function convert_array_to_xml($array = array())
{    
        $xml_tags = "<?xml version=\"1.0\"?>\n";
        $xml_tags .= "<root>\n";
        $xml_tags .= convert_array_xml($array);
        $xml_tags .= "</root>\n";
        
        return $xml_tags;
}

function convert_array_to_json($array = array())
{
        $json_tags = phpversion() >= '5.4.0' ? json_encode($array, JSON_PRETTY_PRINT) : json_encode($array, 128);
        
        return $json_tags;
}

function check_api_key($key)
{
    ci()->load->model(array('streams/api_m', 'streams/stream_m'));
    
    $data = ci()->api_m->get_by(array('token' => $key));
    
    if( $data )
    {
        if($data->enabled == 'yes')
        {
            return TRUE;
        }
        return FALSE;
    }
    return FALSE;
}

function check_expiration_api($key)
{
    ci()->load->model(array('streams/api_m', 'streams/stream_m'));
    
    $data = ci()->api_m->get_by(array('token' => $key));
    
    if( $data )
    {
        if($data->expires_on >= date('Y-m-d H:i:s'))
        {
            return TRUE;
        }
        return FALSE;
    }
    return FALSE;
}

function check_api_permission($key, $slug, $action)
{
    ci()->load->model(array('streams/api_m', 'streams/stream_m'));
    
    $data = ci()->api_m->get_by(array('token' => $key));
    
    if( $data )
    {
        if($data->enabled == 'yes' && $data->expires_on >= date('Y-m-d H:i:s'))
        {
            $data = (array)$data;
            $data['permissions'] = unserialize($data['permissions']);
                        
            if( !isset($data['permissions'][$slug]) )
            {                
                return FALSE;
            }            
            if( !isset($data['permissions'][$slug][$action]) )
            {                
                return FALSE;
            }            
            return TRUE;
        }
        return FALSE;
    }
    return FALSE;
}

function check_array_data($array = array(), $action)
{
        if( ($array && is_array($array)) && isset($array['data']) && isset($array['stream_slug']) )
        {
            $array['data'] = unserialize($array['data']);
            
            if(ci()->db->table_exists($array['stream_slug']))
            {
                // Check table
                $fields_list = ci()->db->field_data($array['stream_slug']);
                $fields = array();

                foreach ($fields_list as $field_data)
                {
                    $fields[$field_data->name] = array(
                        'type' => $field_data->type,
                        'max_length' => $field_data->max_length,
                        'primary_key' => $field_data->primary_key
                    );
                }
                // Check data
                foreach ($array['data'] as $field => $value)
                {
                    if( !isset($fields[$field]) )
                    {
                        switch ($fields[$field]['type'])
                        {
                            case 'datetime':
                                if(!preg_match('^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$', $value) || strlen($value > $fields[$field]['max_length']))
                                {
                                    unset($array['data'][$field]);
                                }
                            break;
                            
                            case 'timestamp':
                                if(!preg_match('^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$', $value) || strlen($value > $fields[$field]['max_length']))
                                {
                                    unset($array['data'][$field]);
                                }
                            break;
                            
                            
                            case 'date':
                                if(!preg_match('^[0-9]{4}-[0-9]{2}-[0-9]{2}$', $value) || strlen($value > $fields[$field]['max_length']))
                                {
                                    unset($array['data'][$field]);
                                }
                            break;
                            
                            case 'time':
                                if(!preg_match('^[0-9]{2}:[0-9]{2}:[0-9]{2}$', $value) || strlen($value > $fields[$field]['max_length']))
                                {
                                    unset($array['data'][$field]);
                                }
                            break;
                            
                            case 'int':
                                if(!preg_match('[0-9]', $value) || strlen($value > $fields[$field]['max_length']))
                                {
                                    unset($array['data'][$field]);
                                }
                            break;
                        }
                    }
                    
                    //destry no exists fields
                    if( !ci()->db->field_exists($field, $array['stream_slug']) )
                    {
                        unset($array['data'][$field]);
                    }  
                    //unset id because it is auto increment
                    unset($array['data']['id']);
                }
                    //set some default values
                    ((!isset($array['data']['created']) && $action == 'insert') ? $array['data']['created'] = date('Y-m-d H:i:s') : false);
                    ((!isset($array['data']['updated']) && $action == 'update') ? $array['data']['updated'] = date('Y-m-d H:i:s') : false);
                    ((!isset($array['data']['created_by']) && $action == 'insert') ? $array['data']['created_by'] = 1 : false);
                    ((!isset($array['data']['ordering_count']) && $action == 'insert') ? $array['data']['ordering_count'] = (ci()->db->count_all($array['stream_slug'])+1) : false);
                    
                return $array['data'];
            }            
        }

        return false;
}

function build_requests($request, $action)
{
    ci()->load->model(array('streams/api_m', 'streams/stream_m'));
    
    if( !$request || !$action)
    { 
        return FALSE;
    }
    $data = ci()->api_m->get_by(array('token' => $request['token']));
    
    if( $data )
    {
        if($data->enabled == 'yes' && $data->expires_on >= date('Y-m-d H:i:s'))
        {
            $stream_data = ci()->db->where('stream_slug', $request['stream_slug'])
                                   ->get('data_streams')
                                   ->row();
            
            if($stream_data->stream_prefix != NULL)
            {
                $request['stream_slug'] = $stream_data->stream_prefix.$request['stream_slug'];
            }
            //build queries
            switch ($action)
            {
                case 'select': 
                    //select
                    if( $request['query'] )
                    {   
                        $request['type'] = (($request['type'] == 'xml' || $request['json']) ? $request['type'] : 'xml');
                        $request['query'] = unserialize($request['query']);
                        
                        foreach ($request['query'] as $key) 
                        {
                            if(count($key) == 4 && isset($key[0]) && isset($key[1]) && isset($key[2]))
                            {
                                if($key[0] == 'select' || $key[0] == 'select_max' || $key[0] == 'select_min' || $key[0] == 'select_avg' || $key[0] == 'select_sum' || $key[0] == 'where' || $key[0] == 'or_where' || $key[0] == 'where_in' || $key[0] == 'or_where_in' || $key[0] == 'where_not_in' || $key[0] == 'or_where_not_in' || $key[0] == 'like' || $key[0] == 'or_like' || $key[0] == 'not_like' || $key[0] == 'or_not_like' || $key[0] == 'order_by' || $key[0] == 'group_by' || $key[0] == 'limit' || $key[0] == 'join' || $key[0] == 'select' || $key[0] == 'select' || $key[0] == 'select'){                                
                                    ci()->db->{$key[0]}($key[1], $key[2], $key[3]);   
                                }
                            }
                            else if(count($key) == 3 && isset($key[0]) && isset($key[1]) && isset($key[2]))
                            {
                                if($key[0] == 'select' || $key[0] == 'select_max' || $key[0] == 'select_min' || $key[0] == 'select_avg' || $key[0] == 'select_sum' || $key[0] == 'where' || $key[0] == 'or_where' || $key[0] == 'where_in' || $key[0] == 'or_where_in' || $key[0] == 'where_not_in' || $key[0] == 'or_where_not_in' || $key[0] == 'like' || $key[0] == 'or_like' || $key[0] == 'not_like' || $key[0] == 'or_not_like' || $key[0] == 'order_by' || $key[0] == 'group_by' || $key[0] == 'limit' || $key[0] == 'join' || $key[0] == 'select' || $key[0] == 'select' || $key[0] == 'select'){                                
                                    ci()->db->{$key[0]}($key[1], $key[2]);   
                                }
                            }
                            else if(count($key) == 2 && isset($key[0]) && isset($key[1]))
                            {
                                if($key[0] == 'select' || $key[0] == 'select_max' || $key[0] == 'select_min' || $key[0] == 'select_avg' || $key[0] == 'select_sum' || $key[0] == 'where' || $key[0] == 'or_where' || $key[0] == 'where_in' || $key[0] == 'or_where_in' || $key[0] == 'where_not_in' || $key[0] == 'or_where_not_in' || $key[0] == 'like' || $key[0] == 'or_like' || $key[0] == 'not_like' || $key[0] == 'or_not_like' || $key[0] == 'order_by' || $key[0] == 'group_by' || $key[0] == 'limit' || $key[0] == 'select' || $key[0] == 'select' || $key[0] == 'select' || $key[0] == 'select'){
                                    ci()->db->{$key[0]}("{$key[1]}");
                                }
                            }
                        }
                    }
                    else
                    {
                        return FALSE;
                    }
                    
                    $get = ci()->db->get($request['stream_slug']);
                    
                    if ($request['return'] == 'result')
                    {
                        $result = $get->{$request['return']}();
                    }
                    else if ($request['return'] == 'result_array')
                    {
                        $result = $get->{$request['return']}();
                    }
                    else
                    {
                        $result = $get->row();
                    }
                    
                    ($request['type'] == 'xml' && is_object($result)) ? $result = (array)$result : $result = $result; 
                    if(is_array($result))
                    {   
                        $results = array();
                        foreach ($result as $key => $value)
                        {
                            if (is_array($value) || is_object($value))
                            {
                                $results['data-'.$key] = (array)$value;
                            }
                            else
                            {
                                $results[$key] = $value;
                            }
                        }                        
                        $result = $results;
                    }
                                        
                    if($result)
                    {
                        ci()->db->insert('data_stream_api_sessions', array(
                            'token' => $request['token'],
                            'ip_address' => ci()->input->ip_address(),
                            'user_agent' => ci()->agent->browser() . ' ' . ci()->agent->version(),
                            'system_op' => ci()->agent->platform(),
                            'last_activity' => date('Y-m-d H:i:s'),
                            'user_data' => serialize($request)
                        ));
                    }
                    
                    return $result;
                    
                break;
                case 'insert': 
                    
                    //insert
                    if( !$request || !$request['data'] )
                    {
                        return FALSE; 
                    }     
                    
                    $extra = check_array_data($request, $action);
                    $insert = ci()->db->insert($request['stream_slug'], $extra);
                                        
                    if( !$insert ){
                        return FALSE;
                    }
                    
                    if($result)
                    {
                        ci()->db->insert('data_stream_api_sessions', array(
                            'token' => $request['token'],
                            'ip_address' => ci()->input->ip_address(),
                            'user_agent' => ci()->agent->browser() . ' ' . ci()->agent->version(),
                            'system_op' => ci()->agent->platform(),
                            'last_activity' => date('Y-m-d H:i:s'),
                            'user_data' => serialize($request)
                        ));
                    }
                    return ci()->db->insert_id();
                    
                break;
                case 'update': 
                    //update
                    if( !$request['data'] || !$request['where'])
                    {
                        return FALSE; 
                    }    
                    $request['where'] = unserialize($request['where']);
                            
                    $extra = check_array_data($request, $action);
                    $update = ci()->db->update($request['stream_slug'], $extra, array($request['where'][0] => $request['where'][1]));
                    
                    if(!$update){
                        return FALSE;
                    }
                    
                    if($result)
                    {
                        ci()->db->insert('data_stream_api_sessions', array(
                            'token' => $request['token'],
                            'ip_address' => ci()->input->ip_address(),
                            'user_agent' => ci()->agent->browser() . ' ' . ci()->agent->version(),
                            'system_op' => ci()->agent->platform(),
                            'last_activity' => date('Y-m-d H:i:s'),
                            'user_data' => serialize($request)
                        ));
                    }
                    return TRUE;
                    
                break;
                case 'delete': 
                    //delete
                    if( !$request['where'] )
                    {
                        return FALSE; 
                    }    
                    $request['where'] = unserialize($request['where']);
                    
                    $delete = ci()->db->delete($request['stream_slug'], array($request['where'][0] => $request['where'][1]));
                    
                    if(!$delete){
                        return FALSE;
                    }
                    
                    if($result)
                    {
                        ci()->db->insert('data_stream_api_sessions', array(
                            'token' => $request['token'],
                            'ip_address' => ci()->input->ip_address(),
                            'user_agent' => ci()->agent->browser() . ' ' . ci()->agent->version(),
                            'system_op' => ci()->agent->platform(),
                            'last_activity' => date('Y-m-d H:i:s'),
                            'user_data' => serialize($request)
                        ));
                    }
                    return TRUE;
                    
                break;
                default: 
                    return FALSE;
            }                
        }
        return FALSE;
    }
    return FALSE;
}