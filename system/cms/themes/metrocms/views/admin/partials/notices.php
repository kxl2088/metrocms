<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error animated fadeIn">
        <i class="icon-minus-sign"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>

<?php if (validation_errors()): ?>
<div class="alert alert-error animated fadeIn">
        <i class="icon-minus-sign"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['error'])): ?>
<div class="alert alert-error animated fadeIn">
        <i class="icon-minus-sign"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $messages['error']; ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('notice')): ?>
<div class="alert animated fadeIn">
        <i class="icon-exclamation-sign"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $this->session->flashdata('notice');?>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['notice'])): ?>
<div class="alert animated fadeIn">
        <i class="icon-exclamation-sign"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $messages['notice']; ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success animated fadeIn">
        <i class="icon-ok-sign"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['success'])): ?>
<div class="alert alert-success animated fadeIn">
        <i class="icon-ok-sign"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $messages['success']; ?>
</div>
<?php endif; ?>

<?php 

	/**
	 * Admin Notification Event
	 */
	Events::trigger('admin_notification');
	
?>