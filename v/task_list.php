<section class="container">

	<div class="row">
		<?
		foreach ($sort_tpl['by'] as $v) {
			?>
			<div class="col px-2">
				sort by <?=$v;?>
				<?
				foreach ($sort_tpl['order'] as $vv) {
					if ($v == $sort && $vv == $order) {
						echo '<strong>'.$vv.'</strong>';
					}
					else {
						?>
						<a href="?sort=<?=$v;?>&order=<?=$vv;?>"><?=$vv;?></a>
						<?
					}
				}
				?>
			</div>
			<?
		}
		?>
	</div>


    <div class="row">
    <? 
    if (isset($error)) {
        ?>
            <div class="alert alert-danger col-12">
                <?=$error;?>
            </div> 
        <?
    } 
	if (isset($message)) {
        ?>
            <div class="alert alert-success col-12">
                <?=$message;?>
            </div> 
        <?
    } 
    ?>
	</div>
    
	<div class="row">
    <?
    if (count($task_list)) {
        foreach ($task_list as $v) {
            ?>
			<div class="card m-3">
			  <div class="card-body">
				<h5 class="card-title"><?=$v['name'];?></h5>
				<p class="card-text"><a href="mailto:<?=$v['email'];?>"><?=$v['email'];?></a></p>
				<p class="card-text"><?=$v['text'];?></p>
				
				<?
				if (isset($v['done']) ) {
					?>
					<div class="alert alert-info">done</div>
					<?
				}
				if (isset($v['admin_edit']) ) {
					?>
					<div class="alert alert-warning">edited by admin</div>
					<?
				}
				
				?>
				
				<? if ($admin) {
					?>
					<a href="/tasks/edit/?id=<?=$v['id'];?>" class="btn btn-primary">edit</a>
					<?
				}
				?>
			  </div>
			</div>
            <?      
        }
    }
    ?>
	</div>
	
	<div class="row">
	<? 
	if (!empty($page_count) && $page_count > 1) {
		?>
		<nav class="col-12">
		  <ul class="pagination">
			<li class="page-item<? if (empty($page) || $page < 2) echo ' disabled'; ?>">
			  <a class="page-link" href="/?page=<?=($page-1);?>">Previous</a>
			</li>
			<?
			if ($page > 1) {
				?>
				<li class="page-item"><a class="page-link" href="/?page=<?=($page-1);?>"><?=($page-1);?></a></li>
				<?
			}
			?>
			
			<li class="page-item active">
			  <a class="page-link" href="/?page=<?=$page;?>"><?=$page;?> <span class="sr-only">(current)</span></a>
			</li>
			
			<?
			if ($page < $page_count) {
				?>
				<li class="page-item"><a class="page-link" href="/?page=<?=($page+1);?>"><?=($page+1);?></a></li>
				<?
			}
			?>
			
			<li class="page-item<? if (empty($page) || $page >= $page_count) echo ' disabled'; ?>">
			  <a class="page-link" href="/?page=<?=($page+1);?>">Next</a>
			</li>
		  </ul>
		</nav>
		<?
	}
	?>
	</div>
	
    <div class="row">
	<div class="col-12">
        <a class="btn btn-primary" href="/tasks/add" role="button">Add task</a>
    </div>
	</div>
</section>
