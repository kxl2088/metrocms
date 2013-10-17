{{ theme:partial name="header" }}
<div class="container">
<div class="row">

        <div class="col-lg-8">
          <hr>
          <p><i class="icon-time"></i> Posted on {{ helper:date format="F d, Y" timestamp=post:created_on }} at {{ helper:date format="H:i a" timestamp=post:created_on }} by <a href="{{ post:author_url }}">{{ post:author }}</a</p>
          <hr>
          {{ if post:image }}          
          <a href="{{ post:url }}"><img src="{{ post:thumb }}/900" class="img-responsive"></a>
          <hr>
          {{ endif }}
          
          <p>{{ post:body }}</p>
          <hr>
          
<?php if (Settings::get('enable_comments')): ?>

	<?php if ($form_display): ?>
		<?php echo $this->comments->form() ?>
	<?php else: ?>
	<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post['comments_enabled'])))) ?>
	<?php endif ?>
		<h4><?php echo lang('comments:title') ?></h4>
		<?php echo $this->comments->display() ?>
<?php endif ?>
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