<?php $this->load->view('admin/partials/streams/filters'); ?>

<?php if ($entries) { ?>

    <table class="table-list responsive table table-hover table-striped table-bordered" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<?php if ($stream->sorting == 'custom'): ?><th></th><?php endif; ?>
				<?php foreach ($stream->view_options as $view_option): ?>
				<th><?php echo lang_label($stream_fields->$view_option->field_name); ?></th>
				<?php endforeach; ?>
                                <th width="180"><?php echo lang('global:actions'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($entries as $field => $data_item) { ?>

			<tr>

				<?php if ($stream->sorting == 'custom'): ?><td width="30" style="text-align: center"><i class="icon-move"></i></td><?php endif; ?>

				<?php if (is_array($stream->view_options)): foreach( $stream->view_options as $view_option ): ?>
				<td>
				
				<input type="hidden" name="action_to[]" value="<?php echo $data_item->id;?>" />
				
				<?php
				
					if ($view_option == 'created' or $view_option == 'updated')
					{
						if ($data_item->$view_option):echo format_date($data_item->$view_option); endif;	
					}				
					elseif ($view_option == 'created_by')
					{
					
						?><a href="<?php echo site_url('admin/users/edit/'. $data_item->created_by_user_id); ?>"><?php echo $data_item->created_by_username; ?></a><?php
					}
					else
					{
						echo $data_item->$view_option;
					}
					
				?></td>
				<?php endforeach; endif; ?>
				<td class="actions">
<div class="btn-group">
  <button class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
                <?php
				
						if (isset($buttons))
						{						
							$all_buttons = array();

							foreach($buttons as $button)
							{
								$class = (isset($button['confirm']) and $button['confirm']) ? 'confirm' : '';
								$class .= (isset($button['class']) and ! empty($button['class'])) ? ' '.$button['class'] : null;
								$all_buttons[] = '<li>' . anchor(str_replace('-entry_id-', $data_item->id, $button['url']), $button['label'], 'class="'.$class.'"') . '</li>';
							}
						
							echo implode('', $all_buttons);
							unset($all_buttons);
						}
						
					?>
  </ul>
</div>
				</td>
			</tr>
		<?php } ?>
		</tbody>
    </table>
    
<?php echo $pagination['links']; ?>

<?php } else { ?>

<div class="no_data">
	<?php
		
		if (isset($no_entries_message) and $no_entries_message)
		{
			echo lang_label($no_entries_message);
		}
		else
		{
			echo lang('streams:no_entries');
		}

	?>
</div><!--.no_data-->

<?php } ?>