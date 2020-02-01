<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$header;?></title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <header class="container mb-5">
		<div class="row">
			<div class="col">
				<a href="/">Tasks</a>
			</div>
            <div class="col">
            <?
			if ($admin) {
				?>
				Admin authorized. 
				<a href="/login/logout/">Logout</a>
				<?				
			}
			else {
				?>
				<a href="/login/">Login</a>
				<?
			}
			?>
            </div>
			
			<div class="col-12">
				<h1><?=$header;?></h1>
			</div>
		</div>
    </header>