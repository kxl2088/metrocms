<a class="btn add green" id="add-item-multiple"><?php echo lang('streams:multiple.add_row'); ?></a>
<br /><br />
<table id="item-multiple-list responsive table table-hover table-striped table-bordered">
    <tr class="skip">
        <?php foreach($labels as $label): ?>
        <th><?php echo $label['label']; ?></th>
        <?php endforeach; ?>
        <th>Ação</th>
    </tr>
    <?php $index = 0; ?>   
        <?php foreach ($fields as $field): ?>                                    
            <tr id="item_<?php echo $index; ?>">  
                <?php foreach ($field as $input): ?>
                <td>
                    <?php echo $input['input']; ?>
                </td> 
                <?php endforeach; ?>
                <td>
                    <a class="btn red remove" data-row="item_<?php echo $index; ?>"><?php echo lang('global:delete'); ?></a>
                </td>
            </tr>
            <?php $index++; ?>
        <?php endforeach; ?>


    <tr id="item_<?php echo $index; ?>">
        <?php foreach($labels as $label): ?>
        <td><?php echo $label['input']; ?></td>
        <?php endforeach; ?>                                
        <td>
            <a class="btn red remove" data-row="item_<?php echo $index; ?>"><?php echo lang('global:delete'); ?></a>
        </td>
    </tr>
</table>

<script>
    // IMPORTANT VARS
    var SLUG_NAME = '<?php echo $slug; ?>';
    var STREAM_ID = '<?php echo $field_data['custom']['choose_stream']; ?>';
    
    //LANG
    var LANG_ADD_ROW = '<?php echo lang('streams:multiple.add_row'); ?>';
    var LANG_DELETE = '<?php echo lang('global:delete'); ?>';
    
    //INPUTS    
    var FIELDS = {
    <?php    
        $field_inputs = "";
            foreach($labels as $key => $value):
                $field_inputs .= "'" . $key . "': '" . $value['input'] . "', ";
            endforeach; 
            $field_inputs = substr($field_inputs, 0, (strlen($field_inputs)-2));
        echo $field_inputs;
    ?>};
    var FIELDS_NAMES = {
    <?php    
        $field_labels = "";
            foreach($labels as $key => $value):
                $field_labels .= "'" . $key . "': '" . $key . "', ";
            endforeach;
            $field_labels = substr($field_labels, 0, (strlen($field_labels)-2));
        echo $field_labels;
    ?>};
</script>
