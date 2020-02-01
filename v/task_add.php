<section class="container">
    <div class="row">
    <? 
    if (isset($error)) {
        ?>
            <div class="alert alert-danger col-12">
                <?=$error;?>
            </div> 
        <?
    } 
    ?>
    
    <form action="/tasks/save/" class="col" method="post">
		<input type='hidden' name='id' value="<?=$id ? $id : '';?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input class="form-control" type="text" name="name" required value="<?=$name ?? $name;?>">
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input class="form-control" type="email" name="email" required value="<?=$email ?? $email;?>">
		</div>
		<div class="form-group">
			<label for="text">Text</label>
			<textarea class="form-control" name="text" required><?=$text ?? $text;?></textarea>
		</div>
		
		<?
		if ($admin) {
			?>
			<div class="form-check">
			  <input class="form-check-input" type="checkbox" value="1" id="done" name="done"<? if (!empty($done)) echo ' checked="checked"';?>>
			  <label class="form-check-label" for="done">
				Done
			  </label>
			</div>
			<?
		}
		?>
		
		<button class="btn btn-primary" type="submit">Save</a>

	</form>
    
</section>
