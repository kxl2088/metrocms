<?php if ($assignments): ?>
                <table class="table-list responsive table table-hover table-striped table-bordered" border="0" cellspacing="0">
                            <thead>
                                    <tr>	
                                        <th width="30"></th>
                                        <th><?php echo lang('streams:label.field_name');?></th>
                                        <th><?php echo lang('streams:label.field_slug');?></th>
                                        <th><?php echo lang('streams:label.field_type');?></th>
                                        <th width="180"><?php echo lang('global:actions'); ?></th>
                                    </tr>
                            </thead>
                            <tbody>		
                            <?php foreach ($assignments as $assignment):?>
                                    <tr>
                                            <td width="30" style="text-align: center"><i class="icon-move"></i></td>
                                            <td>
                                                    <input type="hidden" name="action_to[]" value="<?php echo $assignment->assign_id;?>" />
                                                    <?php echo $this->fields->translate_label($assignment->field_name); ?></td>
                                            <td><?php echo $assignment->field_slug; ?></td>
                                            <td><?php echo $this->type->types->{$assignment->field_type}->field_type_name; ?></td>
                                            <td class="actions">
<div class="btn-group">
  <button class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
                                                    <?php

                                                            $all_buttons = array();
                                                            if (isset($buttons))
                                                            {
                                                                    foreach($buttons as $button)
                                                                    {
                                                                            // don't render button if field is locked and $button['locked'] is set to TRUE
                                                                            $class = (isset($button['confirm']) and $button['confirm']) ? 'confirm' : '';
                                                                            if($assignment->is_locked == 'no')
                                                                            {
                                                                               $all_buttons[] = '<li>' . anchor(str_replace('-assign_id-', $assignment->assign_id, $button['url']), $button['label'], 'class="'.$class.'"') . '</li>';
                                                                            }
                                                                            else if($assignment->is_locked == 'yes' && stristr($button['url'], 'edit') == true)
                                                                            {
                                                                                $all_buttons[] = '<li>' . anchor(str_replace('-assign_id-', $assignment->assign_id, $button['url']), $button['label'], 'class="'.$class.'"') . '</li>';
                                                                            }
                                                                    }
                                                            }

                                                            echo implode('', $all_buttons);
                                                            unset($all_buttons);

                                                    ?>	
  </ul>
</div>
                                            </td>
                                    </tr>
                            <?php endforeach;?>
                            </tbody>
                </table>

            <?php echo $pagination['links']; ?>

            <?php else: ?>

                <div class="no_data">
                        <?php

                                if (isset($no_assignments_message) and $no_assignments_message)
                                {
                                        echo lang_label($no_assignments_message);
                                }
                                else
                                {
                                        echo lang('streams:no_field_assign');
                                }

                        ?>
                </div><!--.no_data-->

<?php endif;?>