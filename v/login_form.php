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
    
    <form action="/login/" class="col" method="post">
		<div class="form-group">
			<label for="name">User</label>
			<input class="form-control" type="text" name="login" required value="<?=$login ? $login : '';?>">
		</div>
		<div class="form-group">
			<label for="email">Password</label>
			<input class="form-control" type="password" name="pass" required>
		</div>
		<button class="btn btn-primary" type="submit">Log in</a>
	</form>
    
</section>
