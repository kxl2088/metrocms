<?php defined('BASEPATH') OR exit('No direct script access allowed');

// define all custom fields that a new installation should have
$config['pages:default_fields']	= array(
	array(         
		'name'          => 'lang:pages:body_label',
		'slug'          => 'body',
		'namespace'     => 'pages',
		'type'          => 'wysiwyg',
		'extra'		=> array('editor_type' => 'advanced', 'allow_tags' => 'y'),
		'assign'        => 'def_page_fields',
                'locked'        => true
	)
);

// and now the content for the pages
$config['pages:default_page_content'] = array(
		/* The home page data. */
		'home' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4">
            <h3><i class="icon-ok-circle"></i> Bootstrap 3 Built</h3>
            <p>The \'Modern Business\' website template by <a href="http://startbootstrap.com">Start Bootstrap</a> is built with <a href="http://getbootstrap.com">Bootstrap 3</a>. Make sure you\'re up to date with latest Bootstrap documentation!</p>
          </div>
          <div class="col-lg-4 col-md-4">
            <h3><i class="icon-pencil"></i> Ready to Style &amp; Edit</h3>
            <p>Your ready to go with this pre-built page structure, now all you need to do is add your own custom stylings! You can see some free themes over at <a href="http://bootswatch.com">Bootswatch</a>, or come up with your own using <a href="http://getbootstrap.com/customize/">the Bootstrap customizer</a>!</p>
          </div>
          <div class="col-lg-4 col-md-4">
            <h3><i class="icon-folder-open-alt"></i> Many Page Options</h3>
            <p>This template features many common pages that you might see on a business website. Pages include: about, contact, portfolio variations, blog, pricing, FAQ, 404, services, and general multi-purpose pages.</p>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.section -->
    <div class="section-colored text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2>Modern Business: A Clean &amp; Simple Full Website Template by Start Bootstrap</h2>
            <p>A complete website design featuring various single page templates from Start Bootstraps library of free HTML starter templates.</p>
            <hr>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.section-colored -->
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2>Display Some Work on the Home Page Portfolio</h2>
            <hr>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
            <a href="#"><img alt="" class="img-responsive img-home-portfolio" src="http://placehold.it/700x450"></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
            <a href="#"><img alt="" class="img-responsive img-home-portfolio" src="http://placehold.it/700x450"></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
            <a href="#"><img alt="" class="img-responsive img-home-portfolio" src="http://placehold.it/700x450"></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
            <a href="#"><img alt="" class="img-responsive img-home-portfolio" src="http://placehold.it/700x450"></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
            <a href="#"><img alt="" class="img-responsive img-home-portfolio" src="http://placehold.it/700x450"></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
            <a href="#"><img alt="" class="img-responsive img-home-portfolio" src="http://placehold.it/700x450"></a>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.section -->
    <div class="section-colored">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <h2>Modern Business Features Include:</h2>
            <ul>
              <li>Bootstrap 3 Framework</li>
              <li>Mobile Responsive Design</li>
              <li>Predefined File Paths</li>
              <li>Working PHP Contact Page</li>
              <li>Minimal Custom CSS Styles</li>
              <li>Unstyled: Add Your Own Style and Content!</li>
              <li>Font-Awesome fonts come pre-installed!</li>
              <li>100% <strong>Free</strong> to Use</li>
              <li>Open Source: Use for any project, private or commercial!</li>
            </ul>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <img  alt="" class="img-responsive" src="http://placehold.it/700x450/ffffff/cccccc">
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.section-colored -->
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <img  alt="" class="img-responsive" src="http://placehold.it/700x450">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <h2>Modern Business Features Include:</h2>
            <ul>
              <li>Bootstrap 3 Framework</li>
              <li>Mobile Responsive Design</li>
              <li>Predefined File Paths</li>
              <li>Working PHP Contact Page</li>
              <li>Minimal Custom CSS Styles</li>
              <li>Unstyled: Add Your Own Style and Content!</li>
              <li>Font-Awesome fonts come pre-installed!</li>
              <li>100% <strong>Free</strong> to Use</li>
              <li>Open Source: Use for any project, private or commercial!</li>
            </ul>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.section -->
    <div class="container">
      <div class="row well">
        <div class="col-lg-8 col-md-8">
          <h4>\'Modern Business\' is a ready-to-use, Bootstrap 3 updated, multi-purpose HTML theme!</h4>
          <p>For more templates and more page options that you can integrate into this website template, visit Start Bootstrap!</p>
        </div>
        <div class="col-lg-4 col-md-4">
          <a class="btn btn-lg btn-primary pull-right" href="http://startbootstrap.com">See More Templates!</a>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container -->',
			'created_by' => 1
		),
		/* The contact page data. */
		'contact' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<div class="container">
                            <div class="row">
        <div class="col-sm-8">
          <h3>Let\'s Get In Touch!</h3>
          <p>Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
			{{ contact:form name="text|required|class::form-control" email="text|required|valid_email|class::form-control" phone="text|required|class::form-control" message="textarea|required|class::form-control" button="submit|Submit|class::btn btn-primary" lang="br" }}
			{{ session:messages success="alert alert-success" notice="alert alert-warning" error="alert alert-danger" }}
	            <div class="row">
	              <div class="form-group col-lg-4">
	                <label for="name">Name</label>
	                {{ name }}
	              </div>
	              <div class="form-group col-lg-4">
	                <label for="email">Email Address</label>
	                {{ email }}
	              </div>
	              <div class="form-group col-lg-4">
	                <label for="phone">Phone Number</label>
	                {{ phone }}
	              </div>
	              <div class="clearfix"></div>
	              <div class="form-group col-lg-12">
	                <label for="message">Message</label>
	               {{ message }}
	              </div>
	              <div class="form-group col-lg-12">
                        {{ button }}
	              </div>
              </div>
            {{ /contact:form }}
        </div>

        <div class="col-sm-4">
          <h3>Modern Business</h3>
          <h4>A Start Bootstrap Template</h4>
          <p>
            5555 44th Street N.<br>
            Bootstrapville, CA 32323<br>
          </p>
          <p><i class="icon-phone"></i> <abbr title="Phone">P</abbr>: (555) 984-3600</p>
          <p><i class="icon-envelope-alt"></i> <abbr title="Email">E</abbr>: <a href="mailto:feedback@startbootstrap.com">feedback@startbootstrap.com</a></p>
          <p><i class="icon-time"></i> <abbr title="Hours">H</abbr>: Monday - Friday: 9:00 AM to 5:00 PM</p>
          <ul class="list-unstyled list-inline list-social-icons">
            <li class="tooltip-social facebook-link"><a href="#facebook-page" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="icon-facebook-sign icon-2x"></i></a></li>
            <li class="tooltip-social linkedin-link"><a href="#linkedin-company-page" data-toggle="tooltip" data-placement="top" title="LinkedIn"><i class="icon-linkedin-sign icon-2x"></i></a></li>
            <li class="tooltip-social twitter-link"><a href="#twitter-profile" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="icon-twitter-sign icon-2x"></i></a></li>
            <li class="tooltip-social google-plus-link"><a href="#google-plus-page" data-toggle="tooltip" data-placement="top" title="Google+"><i class="icon-google-plus-sign icon-2x"></i></a></li>
          </ul>
        </div>
      </div>
      </div>',
			'created_by' => 1
		),
		/* The search page data. */
		'search' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<div class="container">
                            <div class="row">
        <div class="col-lg-12">
        {{ search:form class="search-form" }}<input type="text" class="form-control" name="q" placeholder="Termos de busca..." />{{ /search:form }}
        </div>
</div>
</div>',
			'created_by' => 1
		),
		/* The search results page data. */
		'search-results' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<div class="container">
                            <div class="row">
        <div class="col-lg-12">
        {{ search:form class="search-form" }} 		<input type="text" class="form-control" name="q" placeholder="Termos de busca..." />	{{ /search:form }}
        </div>
        </div>
        <div class="row">
        <div class="col-lg-12">{{ search:results }}	<hr />{{ total }}&nbsp;resultados para "{{ query }}".	<hr />	{{ entries }}		<article>			<h4>{{ singular }}: <a href="{{ url }}">{{ title }}</a></h4>			<p>{{ description }}</p>		</article>	{{ /entries }}        {{ pagination }}{{ /search:results }}
        </div>
</div>
</div>',
			'created_by' => 1
		),
		'fourohfour' => array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<div class="container">
                            <div class="row">
        <div class="col-lg-12">
          <p class="error-404">404</p>
          <p class="lead">The page you\'re looking for could not be found.</p>
          <p>Here are some helpful links to help you find what you\'re looking for:</p>
          <ul>
            {{ navigation:links group="header" }}
          </ul>
        </div>
      </div>
      </div>',
			'created_by' => 1
		)
);