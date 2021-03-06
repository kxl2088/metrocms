<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('addons:admin_themes') ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                    <?php if ($themes): ?>

                            <?php echo form_open('admin/addons/admin_themes/set_default') ?>
                            <?php echo form_hidden('method', $this->method) ?>
                            <table class="table-list responsive table table-hover table-striped table-bordered" >
                                    <thead>
                                            <tr>
                                                    <th style="width: 120px" class="align-center"><?php echo lang('addons:themes:default_theme_label') ?></th>
                                                    <th style="width: 15%"><?php echo lang('addons:themes:theme_label') ?></th>
                                                    <th class="collapse"><?php echo lang('global:description') ?></th>
                                                    <th class="collapse" style="width: 10%"><?php echo lang('global:author') ?></th>
                                                    <th style="width: 50px" class="center"><?php echo lang('addons:themes:version_label') ?></th>
                                                    <th style="width: 180px"><?php echo lang('global:actions'); ?></th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($themes as $theme): ?>
                                            <tr>
                                                    <td class="align-center"><input type="radio" name="theme" value="<?php echo $theme->slug ?>"
                                                            <?php echo isset($theme->is_default) ? 'checked' : '' ?> />
                                                    </td>
                                                    <td>
                                                            <?php if ( ! empty($theme->website)): ?>
                                                                    <?php echo anchor($theme->website, $theme->name, array('target'=>'_blank')) ?>
                                                            <?php else: ?>
                                                                    <?php echo $theme->name ?>
                                                            <?php endif ?>
                                                    </td>
                                                    <td class="collapse"><?php echo $theme->description ?></td>
                                                    <td class="collapse">
                                                            <?php if ($theme->author_website): ?>
                                                                    <?php echo anchor($theme->author_website, $theme->author, array('target'=>'_blank')) ?>
                                                            <?php else: ?>
                                                                    <?php echo $theme->author ?>
                                                            <?php endif ?>
                                                    </td>

                                                    <td class="center"><?php echo $theme->version ?></td>
                                                    <td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <?php echo isset($theme->options) ? '<li>' . anchor('admin/addons/admin_themes/options/'.$theme->slug, lang('addons:themes:options'), 'title="'.$theme->name.'" class="options"') . '</li>' : '' ?>
      <?php if($theme->screenshot): ?><li><a href="<?php echo $theme->screenshot ?>" title="<?php echo $theme->name ?>" class="fancybox"><?php echo lang('buttons:preview') ?></a></li><?php endif; ?>
  </ul>
</div>

                                                    </td>
                                            </tr>
                                            <?php endforeach ?>
                                    </tbody>
                            </table>

                            <?php $this->load->view('admin/partials/pagination') ?>

                            <div class="action_buttons">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
                            </div>

                            <?php echo form_close() ?>

                    <?php else: ?>
                            <div class="blank-slate">
                                    <p><?php echo lang('addons:themes:no_themes_installed') ?></p>
                            </div>
                    <?php endif ?>
                    </div>
            </div>
        </div>
    </div>
</div>