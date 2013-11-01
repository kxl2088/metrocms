<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Default extends Theme
{
    public $name		= 'Modern Business Default Theme';
    public $author		= 'Start Bootstrap';
    public $author_website	= 'https://github.com/IronSummitMedia/startbootstrap';
    public $website		= 'http://startbootstrap.com/modern-business';
    public $description		= '\'Modern Business\' is the first full website template by Start Bootstrap!';
    public $version		= '1.0.0';
    public $options 		= array(
	    'show_breadcrumbs'   => array(
		    'title'	    => 'Show Breadcrumbs',
		    'description'   => 'Set it to display the theme breadcrumbs',
		    'default'       => 'yes',
		    'type'          => 'radio',
		    'options'       => 'yes=Yes|no=No',
		    'is_required'   => true
		),
	);
}

/* End of file theme.php */