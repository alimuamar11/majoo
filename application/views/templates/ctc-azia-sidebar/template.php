<!DOCTYPE html>
<html lang="en">
<?php 
$src_assets_template="assets/azia-assets";
$src_view_template="templates/ctc-azia-sidebar";
$time=(int) rand();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?=lang('meta_description');?>">
    <meta name="author" content="<?=lang('meta_author');?>">
		<link rel="icon" href="<?=base_url('assets/img/favicon.ico');?>" type="image/gif">	
    <title>
      <?php if(isset($web_title)){ echo $web_title; }else if(isset($page_title)){ echo $page_title; }else{ echo conf('app_name_short'); };?></title>
    <!-- vendor css -->
    <link href="<?=base_url($src_assets_template.'/lib/font-awesome-4.7.0/css/font-awesome.min.css');?>" rel="stylesheet">
    <link href="<?=base_url($src_assets_template.'/lib/lightslider/css/lightslider.min.css');?>" rel="stylesheet">
    <link href="<?=base_url($src_assets_template.'/lib/select2/css/select2.min.css');?>" rel="stylesheet">
    <!-- azia CSS -->
    <?php if(isset($datatable)){ ?>
    <link rel="stylesheet" href="<?=base_url($src_assets_template.'/lib/datatables.net-dt/css/jquery.dataTables.min.css');?>">  
    <?php } ?>
    <link rel="stylesheet" href="<?=base_url($src_assets_template.'/css/azia.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/ctc.css?pid='.$time);?>">
  </head>

  <body class="az-body az-body-sidebar az-light">
    <?php  $this->load->view("$src_view_template/sidebar"); ?>
    <div class="az-content az-content-dashboard-five">
      <div class="az-header" style="min-height: 35px">
        <div class="container-fluid">
          <div class="az-header-left">
            <a href="#" id="azSidebarToggle" class="az-header-menu-icon"><span></span></a>
          </div><!-- az-header-left -->
          
          <div class="az-header-center" style="margin-left: 50px">
            <i class="fa fa-home"></i> <b class="page-title"><?=isset($page_title) ? $page_title : "&nbsp;";?> </b>
          <small class="page-title-small"><?=isset($page_title_small) ? $page_title_small : "&nbsp;";?></small>
          </div> 
          <div class="az-header-right">
      
          <div class="az-header-message">
            <a href="app-chat.html"><i class="fa fa-envelop"></i></a>
          </div><!-- az-header-message -->
          <div class="dropdown az-header-notification">
            <span class="current-datetime"></span> 
          </div><!-- az-header-notification -->
          <div class="dropdown az-profile-menu">
            <!-- <a href="#" class="az-img-user"><img src="<?=$C_USER_PROFILE;?>" alt="<?=$C_NAME;?>" height="80px"></a> -->
            <div class="dropdown-menu">
              <div class="az-dropdown-header d-sm-none">
                <a href="#" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
              </div>
              <div class="az-header-profile">
                <div class="az-img-user">
                  <img src="<?=$C_USER_PROFILE;?>" alt="No Image">
                </div><!-- az-img-user -->
                <h6><?=$C_NAME;?></h6>
                <span><?=$C_EMAIL;?></span>
              </div><!-- az-header-profile -->

              <a href="<?=base_url();?>" class="dropdown-item"><i class="fa fa-home"></i> Home</a>
              <a href="<?=base_url('profile');?>" class="dropdown-item"><i class="fa fa-cog"></i> <?=lang('label_account_setting');?></a>
              <a href="<?=base_url('admin/auth/signout');?>" class="dropdown-item"><i class="fa fa-sign-out"></i> <?=lang('label_sign_out');?></a>
              <?php
              if(conf('enable_templating')){ ?>
              <div class="az-footer-profile">
                <i class="fa fa-picture-o"></i> Template

                <?php
                if(conf('ctc_templates')!=null){
                  if($this->session->userdata("CTC-TPL")){  $tpls=$this->session->userdata("CTC-TPL"); }else{ $tpls=conf('ctc_default_template'); };
                  foreach (conf('ctc_templates') as $tpl) {
                    $checked=($tpl==$tpls) ? "checked='true'" : "";
                    echo "
                    <li><label class='rdiobox'>
                        <input type='radio' name='switch-template' value='".$tpl."' $checked>
                    <span>$tpl</span></label></li>";
                  }
                }
                ?>
              </div>
            <?php } ?>
            </div><!-- dropdown-menu -->
          </div>
        </div><!-- az-header-right -->
        </div><!-- container -->
      </div><!-- az-header -->
      <div class="az-content-body">
        <div class="row row-sm">
          <?=(isset($contents)) ? $contents : "";?>    
        </div>
      </div><!-- az-content-body -->
      <div class="az-footer">
        <div class="container-fluid">
          <span>&copy; <?=conf('publish_year');?><?=(date("Y")>conf('publish_year')) ? "-".date("Y") : ""; ?> | <?=conf('company_name');?> </span>
        <span class="<?=(conf('multi_lang')) ? '' : 'hide';?>">
        <span class="option-language form-inline"> 
          <label class=""><?=lang('label_switch_lang');?> </label> 
          <?php
          $site_lang=$this->session->userdata($app_code.'site_lang');
          $current_lang=(isset($site_lang)) ? $site_lang : conf('language');
          $this->session->set_userdata('referred_from', current_url());
          echo "<select id='switch-lang' class='form-control input-sm minimize-padding'>";
          $langs=array('English','Indonesia');
          foreach($langs as $language){
            $selected=(strtolower($language)==strtolower($current_lang)) ? "selected='selected'": "";
            echo "<option value='".strtolower($language)."' $selected>$language</option>";
          }
          echo "</select>";
          ?>
        </span>
      </span>
        <span>All right reserved | <a href="http://codewell.co.id" target="_blank">CTC</a></span>
        <input type="hidden" id="base_url" value="<?=base_url();?>">
        </div><!-- container -->
      </div><!-- az-footer -->
    </div><!-- az-content -->
<script src="<?=base_url($src_assets_template.'/lib/jquery/jquery.min.js');?>"></script>
<script src="<?=base_url($src_assets_template.'/lib/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
<script src="<?=base_url($src_assets_template.'/lib/jquery-ui/ui/widgets/datepicker.js');?>"></script>
<script src="<?=base_url($src_assets_template.'/lib/lightslider/js/lightslider.min.js');?>"></script>
<script src="<?=base_url($src_assets_template.'/lib/select2/js/select2.min.js');?>"></script>
<?php if(isset($datatable)){ ?>
<script src="<?=base_url($src_assets_template.'/lib/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script src="<?=base_url($src_assets_template.'/lib/datatables.net-dt/js/dataTables.dataTables.min.js');?>"></script>
<?php 
} 
if(isset($chartjs)){ ?>
  <script src="<?=base_url($src_assets_template.'/lib/chart.js/Chart.bundle.min.js');?>"></script>
<?php
}
?>
<script src="<?=base_url($src_assets_template.'/js/azia.js');?>"></script>
<script src="<?=base_url($src_assets_template.'/lib/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/js/jQuery.print.min.js?pid='.$time);?>"></script>
<script src="<?=base_url('assets/pages/bootbox-custom.min.js?pid='.$time);?>"></script>
<script src="<?=base_url('assets/pages/lodash.min.js');?>"></script>
<script src="<?=base_url('assets/pages/ctc.js?pid='.$time); ?>"></script>
<?php
if(isset($add_js)){
	echo '<script src="'.base_url($add_js).'?pid='.$time.'"></script>';
}
if(isset($js_control)){
  if(gettype($js_control)=="string"){
    echo '<script src="'.base_url('assets/pages/'.$js_control).'?pid='.$time.'"></script>';
  }else{
    foreach ($js_control as $jsk) {
      echo '<script src="'.$jsk.'?pid='.$time.'"></script>';
    }
  }
}
?>
    <script>
      $(function(){
        'use strict'

        $('.az-sidebar .with-sub').on('click', function(e){
          e.preventDefault();
          $(this).parent().toggleClass('show');
          $(this).parent().siblings().removeClass('show');
        })

        $(document).on('click touchstart', function(e){
          e.stopPropagation();

          // closing of sidebar menu when clicking outside of it
          if(!$(e.target).closest('.az-header-menu-icon').length) {
            var sidebarTarg = $(e.target).closest('.az-sidebar').length;
            if(!sidebarTarg) {
              $('body').removeClass('az-sidebar-show');
            }
          }
        });


        $('#azSidebarToggle').on('click', function(e){
          e.preventDefault();

          if(window.matchMedia('(min-width: 992px)').matches) {
            $('.az-sidebar').toggle();
          } else {
            $('body').toggleClass('az-sidebar-show');
          }
        })

      });
    </script>
  </body>

<!-- dashboard-five.html  14:08:05 GMT -->
</html>
