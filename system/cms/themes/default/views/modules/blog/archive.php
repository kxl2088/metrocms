{{ theme:partial name="header" }}
<div class="container">
<div class="row">

        <div class="col-lg-8">
{{ if posts }}
          {{ posts }}
          <h1><a href="{{ url }}">{{ title }}</a></h1>
          <p class="lead">by <a href="{{ author_url }}">{{ author }}</a></p>
          <hr>
          <p><i class="icon-time"></i> Posted on {{ helper:date format="F d, Y" timestamp=created_on }} at {{ helper:date format="H:i a" timestamp=created_on }}</p>
          <hr>
          {{ if image }}          
          <a href="{{ url }}"><img src="{{ thumb }}/900/300/fit" class="img-responsive"></a>
          <hr>
          {{ endif }}
          
          <p>{{ preview }}</p>
          <a class="btn btn-primary" href="{{ url }}">Read More <i class="icon-angle-right"></i></a>
          <hr>
          {{ /posts }}

          {{ pagination }}
{{ else }}
        <p>
            {{ helper:lang line="blog:currently_no_posts" }}
        </p>
{{ endif }}
        </div>

        <div class="col-lg-4">
          {{ search:form class="search-form" }}
          <div class="well">
            <h4>Blog Search</h4>
            <div class="input-group">
              <input type="text" name="q" class="form-control">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="icon-search"></i></button>
              </span>
            </div><!-- /input-group -->
          </div><!-- /well -->
          {{ /search:form }}
          {{ widgets:area slug="sidebar" }}
        </div>
      </div>   
</div>