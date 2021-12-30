<div class="row">
	<?php if(isset($manage_user) && $manage_user!=false){ ?>
	<section class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
		<div class="card bd-0 with-border">
			<div class="card-header bd-0 tx-white bg-indigo">
				<i class="fa fa-users"></i> <?=lang('label_list_user');?> <span class="pull-right pointer add-user"><i class="fa fa-plus"></i></span>
			</div><!-- card-header -->
			<div class="card-body">
				<table id="tableUsers" class="display responsive cell-border table-border minimize-padding-all" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Username</th>
							<th>Email</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			<div class="card-footer tx-indigo">
				
			</div>
		</div>
		<p></p>
	</section>
	<?php
	}
	?>
	
</div>


<div id="modal-manage-user" class="modal">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
  	<form method="POST" name="form-manage-user">
	    <div class="modal-content modal-content-demo">
	      <div class="modal-header">
	        <h6 class="modal-title">Tambah/Update User</h6>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="row">
	      		<section class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	      			<div class="row">
								
				        <div class="col-sm-8">
				        	<div class="form-group">
				        		<label class="form-label"><?=lang('label_enter_name');?></label>
				        		<input type="text" class="hide" name="user_id" value="">
				        		<input type="text" name="name" class="form-control input-sm" required="" placeholder="<?=lang('label_enter_name');?>" autocomplete="off">
				        	</div>
				        </div>
				        <div class="col-sm-12"></div>
				        <div class="col-sm-6">
				        	<div class="form-group">
				        		<label class="form-label"><?=lang('label_enter_username');?></label>
				        		<input type="text" name="username" class="form-control no-space input-sm" required="" placeholder="<?=lang('label_enter_username');?>" autocomplete="off">
				        	</div>
				        </div>
				        
				        <div class="col-sm-6">
				        	<div class="form-group">
				        		<label class="form-label"><?=lang('label_enter_email');?></label>
				        		<input type="text" name="email" class="form-control input-sm" required="" placeholder="<?=lang('label_enter_email');?>" autocomplete="off">
				        	</div>
				        </div>
				        
			        	<div class="col-sm-12">
			        		<div class="row">
						        <div class="col-sm-6">
						        	<div class="form-group">
						        		<label class="form-label"><?=lang('label_enter_password');?></label>
						        		<input type="password" name="password" class="form-control input-sm" required="" placeholder="<?=lang('label_enter_password');?>" autocomplete="off">
						        	</div>
						        </div>
						        <div class="col-sm-6">
						        	<div class="form-group">
						        		<label class="form-label"><?=lang('label_enter_repassword');?></label>
						        		<input type="password" name="repassword" class="form-control input-sm" required="" placeholder="<?=lang('label_enter_repassword');?>" autocomplete="off">
						        	</div>
						        </div>
						        <div class="col-sm-12">
						        	<sup class="show-on-update hide text-danger"><?=lang('label_is_change_password');?></sup>
						        </div>
						    </div>
					    </div>
				        <div class="col-sm-12">
					        <div class="form-group">
					        	
					        </div>
					    </div>
					</div>
				</section>
				<section class="col-lg-6 col-md-6 col-sm-12 col-xs-12 border-left-dashed">
					<h5><?=lang('label_user_privilege');?></h5>
					<?php
					if(isset($base_menu)){
						$row="<ul class='setting_menu'>";
						foreach($base_menu as $k=>$bm){
							$row.="<li><label class='ckbox'>
								<input type='checkbox' name='accessibility[]' value='".$bm->access_code."' class='accessibility' > <span> ".strtoupper($bm->title)."</span></label>";
								$split_actions_code=explode(",",$bm->actions_code);
								if($bm->actions_code=="") $split_actions_code=array();
								if(sizeof($split_actions_code)>0) $row.="<ul>";
								foreach($split_actions_code as $ac){
									$row.="<li class='inline'><label class='ckbox'><input type='checkbox' class='accessibility' name='actions_code[]' value='".$bm->access_code."^".$ac."'><span>".strtoupper($ac)."<span></label> </li>";
								}
								if(sizeof($split_actions_code)>0) $row.="</ul>";
							$row.="</li>";
						}
						$row.="</ul>";
						echo $row;
					}
					?>
					<p>
						<hr>
						<label class="ckbox text-primary">
							<input type="checkbox" class="accessibility" name="level" value="<?=$this->config->item('super_admin_code');?>"> <span>Super Admin (<?=lang('label_allow_access_all');?>)</span>
						</label>
					</p>
				</section>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" id="save-user" class="btn btn-indigo">Save changes</button>
	        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	</form>
  </div><!-- modal-dialog -->
</div><!-- modal -->
