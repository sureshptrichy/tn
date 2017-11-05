					<?php foreach ($files as $file){ ?>
					<div class="row filerow">
						<div class="col-md-7 file-name" style="padding-left:0;">
							<a href="/toolbox/download/<?php echo $file['id'];?>" data-sort-name="<?=$file['name']?>"><?=$file['name']?></a>
							<ul class="list-inline table-action" style="display:inline-block;float:right;">
								<?php if ($currentUser->acl->has('editTemplate') && $editable) { ?><li><a href="/toolbox/edit/<?php echo $file['id']; ?>" class="label label-default">Edit</a></li><?php } ?>
								<?php if ($currentUser->acl->has('deleteTemplate') && $editable) { ?><li><a href="/toolbox/delete/<?php echo $file['id']; ?>" class="label label-danger">Delete</a></li><?php } ?>
							</ul>
						</div>
						<div class="col-md-2 file-mime" data-sort-mime="<?=$file['mime']?>"><?=$file['filetype']?></div>
						<div class="col-md-3 file-date" data-sort-date="<?=$file['created']?>"><?=date('Y-m-d', $file['created'])?></div>
					</div>
					<?php } ?>
					<span class="divider"></span>
					<?php if ($currentUser->acl->has('editTemplate') && $editable) { ?>
					<div class="row add-file-btn" style="padding:20px 0 0 0;">
						<div class="col-sm-2" data-sort="<?=$file['created']?>">
						<a href="/toolbox/new/<?=$folderid?>" id="<?=$folderid?>" class="btn btn-success add-files">Add File</span></a>
						</div>
					</div>
					<?php } ?>
