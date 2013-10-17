<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Number of Links
|--------------------------------------------------------------------------
|
| How many links should be output for pagination.
|
*/
$pagination['num_links'] = 8;

/*
|--------------------------------------------------------------------------
| Tags
|--------------------------------------------------------------------------
|
| Control the HTML that gets wrapped around pagination.
|
*/
$pagination['full_tag_open'] = '<div class="pagination_links"><div><ul class="pagination pagination-large">';
$pagination['full_tag_close'] = '</ul></div></div>';

$pagination['first_link'] = '&lt;&lt;';
$pagination['first_tag_open'] = '<li class="first">';
$pagination['first_tag_close'] = '</li>';

$pagination['prev_link'] = '&laquo;';
$pagination['prev_tag_open'] = '<li class="prev">';
$pagination['prev_tag_close'] = '</li>';

$pagination['cur_tag_open'] = '<li class="active"><span>';
$pagination['cur_tag_close'] = '</span></li>';

$pagination['num_tag_open'] = '<li>';
$pagination['num_tag_close'] = '</li>';

$pagination['next_link'] = '&raquo;';
$pagination['next_tag_open'] = '<li class="next">';
$pagination['next_tag_close'] = '</li>';

$pagination['last_link'] = '&gt;&gt;';
$pagination['last_tag_open'] = '<li class="last">';
$pagination['last_tag_close'] = '</li>';

/* End of file pagination.php */