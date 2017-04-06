<?php 
if (Alert::hasAnyMessage()):
?>
<div class="alert alert-info" role="alert">
	<ul>
		<?
		foreach (Alert::getMessage() as $message):
			?><li><?echo $message;?></li><?
		endforeach;
		?>
	</ul>
</div>
<?
endif;
?>
