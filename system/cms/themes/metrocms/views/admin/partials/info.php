<table border="0" celspadding="0" celspacing="0" class="responsive table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th colspan="2"><?php echo lang('cp:about_system'); ?></th>
        </tr>
        <tr>
            <th><?php echo lang('cp:item'); ?></th>
            <th><?php echo lang('cp:information'); ?></th>
        </tr>
    </thead> 
    <tfoot>
        <tr>
            <th colspan="2">&nbsp;</th>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td><?php echo lang('cp:name'); ?></td>
            <td><?php echo CMS_NAME; ?></td>
        </tr>
        <tr>
            <td><?php echo lang('cp:version'); ?></td>
            <td><?php echo CMS_VERSION; ?></td>
        </tr>
        <tr>
            <td><?php echo lang('cp:revision'); ?></td>
            <td><?php echo CMS_REVISION; ?></td>
        </tr>
        <tr>
            <td><?php echo lang('cp:website'); ?></td>
            <td><?php echo anchor('http://www.fabriciorabelo.com/metrocms', 'http://www.fabriciorabelo.com/metrocms', 'target="_blank"'); ?></td>
        </tr>
        <tr>
            <td><?php echo lang('cp:docs'); ?></td>
            <td><?php echo anchor('http://www.fabriciorabelo.com/docs/metrocms', 'http://www.fabriciorabelo.com/docs/metrocms', 'target="_blank"'); ?></td>
        </tr>
        <tr>
            <td><?php echo lang('cp:community'); ?></td>
            <td><?php echo anchor('http://www.fabriciorabelo.com/forums/', 'http://www.fabriciorabelo.com/forums', 'target="_blank"'); ?></td>
        </tr>
        
    </tbody>
</table>