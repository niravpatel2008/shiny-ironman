<?php if (isset($start_data_fields[$tosVariable]) && $start_data_fields[$tosVariable] == true) : $hasExtraField = true;?>
<div class="form-group">
    <label><input type="checkbox" <?php echo $input_data->accept_tos == true ? 'checked="checked"' : '';?> name="AcceptTOS" value="on">&nbsp;<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/startchat','I accept my personal data will be handled according to');?>&nbsp;<a target="_blank" href="<?php echo erLhcoreClassModelChatConfig::fetch('accept_tos_link')->current_value?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/startchat','our terms and to the Law');?></a></label>
</div>
<?php endif; ?>