<div class="az-sidebar">
      <div class="az-sidebar-header text-center">
        <a href="<?=base_url();?>" class="d-md-none d-lg-block" style="padding-top: 10px">
          <img class='img-logo hidden-xs' width="40" src="<?=base_url(conf('company_logo'));?>" />
          <br>
          <div class="company-name hidden-xs" style="font-size: 12px"><b><?=conf('company_name');?></b></div>
          <i class="az-logo-small-text hidden-xs"><?=conf('app_name');?></i>
        </a>

      </div><!-- az-sidebar-header -->
      <div class="az-sidebar-loggedin">
       
      </div><!-- az-sidebar-loggedin -->
      <div class="az-sidebar-body">
        <ul class="nav">
          <li class="nav-label">Main Menu</li>
          <li class="nav-item">
          <a href="<?=base_url();?>" class="nav-link"><i class="fa fa-home"></i> Home</a>
        </li>
        <?php
        $build_menu='';
        $main_menu=$this->session->userdata($app_code.'CTC-MENUS');
        if(isset($main_menu) && gettype($main_menu)!='undefined' && $main_menu!=null){
          foreach ($main_menu as $key => $menu) {
            $menu=(object) $menu;
            $build_menu.='<li class="nav-item">';
            if(isset($menu->sub_menu) && !empty($menu->sub_menu)){
              $build_menu.='
              <a href="'.base_url($menu->url).'" class="nav-link with-sub"><i class="fa '.$menu->icon.'"></i> '.$menu->label.'</a>
              <nav class="nav-sub">';
              foreach($menu->sub_menu as $k=>$sub){
                $sub=(object) $sub;
                $build_menu.='<a href="'.base_url($sub->url).'" class="nav-sub-link">'.$sub->label.'</a>';
              }
              $build_menu.='</nav>';
            }else{
              $build_menu.='<a href="'.base_url($menu->url).'" class="nav-link"><i class="fa '.$menu->icon.'"></i> '.$menu->label.'</a>';
            }
            $build_menu.='</li>';
          }
        }
        echo $build_menu;
        ?>
        </ul><!-- nav -->
      </div><!-- az-sidebar-body -->
    </div><!-- az-sidebar -->
    