<div id="details-container">
    <br>
	<h4><?php echo $link->title ?></h4>
	
	<input id="link-id" type="hidden" value="<?php echo $link->id ?>" />
	<input id="link-uri" type="hidden" value="<?php echo ! empty($link->uri) ? $link->uri : '' ?>" />

	<fieldset>
		<legend><?php echo lang('nav:details_label') ?></legend>
		<p>
			<strong>ID:</strong> #<?php echo $link->id ?>
		</p>

		<p>
			<strong><?php echo lang('global:title');?>:</strong> <?php echo $link->title ?>
		</p>
                
                <p>
			<strong><?php echo lang('global:lang');?>:</strong> <?php echo $link->lang ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:target_label');?>:</strong> <?php echo (!empty($link->target)) ? lang('nav:link_target_blank') : lang('nav:link_target_self') ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:class_label');?>:</strong> <?php echo $link->class ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:type_label');?>:</strong> <?php echo $link->link_type ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:location_label');?>:</strong>
			<a target="_blank" href="<?php echo $link->url ?>"><?php echo $link->url ?></a>
		</p>
		
		<p>
			<strong><?php echo lang('nav:restricted_to');?>:</strong> <?php echo $link->restricted_to ?>
		</p>
	</fieldset>	
	
	<div class="buttons">
		<?php echo anchor('admin/navigation/edit/' . $link->id, lang('global:edit'), 'rel="'.$link->navigation_group_id.'" class="btn btn-primary ajax"') ?>
		<?php echo anchor('admin/navigation/delete/' . $link->id, lang('global:delete'), 'class="confirm btn btn-danger"') ?>
	</div>
</div>
<script>
                // load edit via ajax
		$('a.ajax').click( function(){
			// make sure we load it into the right one
			var id = $(this).attr('rel');
			if ($(this).hasClass('add')) {
				// if we're creating a new one remove the selected icon from link in the tree
				$('.group-'+ id +' #link-list a').removeClass('selected');
			}
			// Load the form
			$('div#link-details.group-'+ id +'').load($(this).attr('href'), '', function(){
				$('div#link-details.group-'+ id +'').fadeIn();
				// display the create/edit title in the header
				var title = $('#title-value-'+id).html();
				$('div.box .titles h3.group-title-'+id).html(title);
				
				// Update Chosen
				
			});
			return false;
		});
</script>