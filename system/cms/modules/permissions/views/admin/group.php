<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo $group->description ?></h3>
            </div>
            <div class="widget-container">
                    <div class="content">
                            <?php echo form_open(uri_string(), array('class'=> 'crud', 'id'=>'edit-permissions')) ?>
                            <table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                    <thead>
                                            <tr>
                                                    <th><?php echo form_checkbox(array('id'=>'check-all', 'name' => 'action_to_all', 'class' => 'check-all', 'title' => lang('permissions:checkbox_tooltip_action_to_all'))) ?></th>
                                                    <th><?php echo lang('permissions:module') ?></th>
                                                    <th><?php echo lang('permissions:roles') ?></th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($permission_modules as $module): ?>
                                            <tr>
                                                    <td style="width: 30px">
                                                            <?php echo form_checkbox(array(
                                                                    'id'=> $module['slug'],
                                                                    'class' => 'select-row',
                                                                    'value' => true,
                                                                    'name'=>'modules['.$module['slug'].']',
                                                                    'checked'=> array_key_exists($module['slug'], $edit_permissions),
                                                                    'title' => sprintf(lang('permissions:checkbox_tooltip_give_access_to_module'), $module['name']),
                                                            )) ?>
                                                    </td>
                                                    <td>
                                                            <label class="inline" for="<?php echo $module['slug'] ?>">
                                                                    <?php echo $module['name'] ?>
                                                            </label>
                                                    </td>
                                                    <td>
                                                    <?php if ( ! empty($module['roles'])): ?>
                                                            <?php foreach ($module['roles'] as $role): ?>
                                                            <label class="inline">
                                                                    <?php echo form_checkbox(array(
                                                                            'class' => 'select-rule',
                                                                            'name' => 'module_roles['.$module['slug'].']['.$role.']',
                                                                            'value' => true,
                                                                            'checked' => isset($edit_permissions[$module['slug']]) AND array_key_exists($role, (array) $edit_permissions[$module['slug']])
                                                                    )) ?>
                                                                    <?php echo lang($module['slug'].':role_'.$role) ?>
                                                            </label>
                                                            <?php endforeach ?>
                                                    <?php endif ?>
                                                    </td>
                                            </tr>
                                            <?php endforeach ?>
                                    </tbody>
                            </table>
                            <div class="buttons float-right padding-top">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
                            </div>
                            <?php echo form_close() ?>
                    </div>
            </div>
        </div>
    </div>
</div>