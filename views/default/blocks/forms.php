<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>

<h2><?php echo $formtype;?> Form</h2>
<form class="form form-preview" enctype="multipart/form-data" autocomplete="off" method="post" role="form">
<div class="row form-info">
	<div class="col-md-4">
		<p>Name : <?php echo $formName;?></p>
	</div>
</div>
<?php foreach ($form['sections'] as $section){ //pr($section);?>
<?php if (isset($section['cummulation']) AND $section['cummulation'] != 'none'){?>
	<h2><?php echo ucwords($section['cummulation']);?></h2>
<?php } ?>
<?php 
			foreach($section['fields'] as $field){
?>
<div class="container-fluid form-section">
	<div class="section-header clearfix">
		<span class="pull-left"><strong><?php echo $field['name'];?></strong></span>
		<?php if (isset($field['type']) AND $field['type'] == 'rating'){?>
		<div class="pull-right rating-stars">
			<?php
				$output = '';
				for ($i = 5; $i >= 1; $i--) {
					/*<input class="fa fa-star-o" type="radio" name="<?php echo $field['id'] ?>" value="<?php echo $i; ?>" />*/
					/*
					$output .= '<label class="" for="'.$field["id"].$i.'">';
					$output .= '<input id="'.$field["id"].$i.'" type="radio" name="'.$field["id"].'" value="'.$i.'" />';
					$output .= '<span class="fa-lg"></span>';
					$output .= '</label>';
					*/
					$output .= '<input id="'.$field["id"].$i.'" type="radio" name="'.$field["id"].'" value="'.$i.'" />';
					$output .= '<label class="" for="'.$field["id"].$i.'">'.$i.'</label>';
				}				
				echo $output;
				?>
		</div>
		<?php }?>
	</div>
	<div class="section-description">
		<?php echo $field['description'];?>
	</div>
	<?php if (isset($field['type']) AND $field['type'] == 'text'){?>
	<div>
		<textarea class="form-control"></textarea>
	</div>
	<?php }?>
</div>
<?php }} ?>
<button class="btn btn-primary" type="submit" name="preview">Close</button>
</form>
<?php /*
<div class="container-fluid form-section">
	<div class="section-header clearfix">
		<?php if (isset($section['name'])) {
		echo '<h3 class="pull-left">'.$section['name'].'</h3>';
		}?>
			<?php if (isset($section['type']) AND $section['type'] == 'rating'){?>
			<div class="pull-right rating-stars">
				<?php
					for ($i = 1; $i <= 5; $i++) {?>
					<span class="fa fa-star"><input type="hidden" value="<?php echo $i;?>" /></span>
				<?php }?>
			</div>
			<?php }?>
	</div>
	<div class="section-description">
			<?php if (isset($section['name'])) {?>
		<?php echo $section['description'];?>
			<?php } ?>
	</div>
	<?php if (isset($section['type']) AND $section['type'] == 'text'){?>
	<div>
		<textarea class="form-control"></textarea>
	</div>
	<?php }?>
</div>
<?php } */?>