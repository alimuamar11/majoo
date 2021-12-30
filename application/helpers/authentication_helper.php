<?php
function isAuthorized($public=""){
	$ci = &get_instance(); 
	$ci->load->library('session');
	$app_code=$ci->config->item('app_code');
	if($ci->session->userdata($app_code."CTC-X-KEY")){
		$data=json_decode(base64_decode($ci->session->userdata($app_code.'CTC-X-KEY')));
		$user_profile=($data->profile!="") ? base_url('files/imgs/'.$data->profile) : base_url('assets/user-img/img-user-default.png');
		$data=array(
				'app_code'=>$app_code,
				'C_UID'=>$data->uid,
				'C_NAME'=>$data->name,
				'C_EMAIL'=> $data->email,
				'C_USER_PROFILE'=> $user_profile,
				'add_js'=>'assets/pages/admin/common.admin.js'
				);
		return $data;
	}else
	if($public!=""){
		//$this->load->library('PHPRequests');
		$options=array("x-user-agent"=>"ptte-api");
		$data=array(
			'C_NAME'=>"Guest",
			'C_EMAIL'=> "---"
			);
		return $data;
	}
	return false;
}
if(!isAuthorized()){
	$ci = &get_instance();
	$current_url=current_url();
	$params   = $_SERVER['QUERY_STRING'];
	$redirect_url = "$current_url?$params";
	if($ci->uri->segment(1)!=="auth"){
		redirect("auth?redirect=$redirect_url","refresh");
	}
}
function isAllowed($access_code,$cond=false){
	$ci = &get_instance(); 
	$ci->load->library('session');
	$app_code=$ci->config->item('app_code');
	//$accessibility=explode(",",$ci->session->userdata("CTC-ACT-CODE"));
	$accessibility=json_decode($ci->session->userdata($app_code."CTC-ACT-CODE"));
	$data=json_decode(base64_decode($ci->session->userdata($app_code.'CTC-X-KEY')));
	if($data->level==$ci->config->item('super_admin_code')){
		return true;
	}else{
		//echo $access_code;
		//echo gettype($accessibility);
		//print_r($accessibility);
		if(gettype($accessibility)=="object") $accessibility=(array) $accessibility;
		if(!in_array($access_code,$accessibility)){
			if($cond==true){
				return false;
			}else{
				$headers = apache_request_headers();
				$is_ajax = (isset($headers['x-user-agent']) && $headers['x-user-agent']=="ctc-webapi") ? true : false;
				if($is_ajax){  
					if(!$ci->input->post('draw'))
				  		http_response_code(403);
				  $output = [];
			        $output['sEcho'] = 0;
			        $output['draw'] = 1;
			        $output['iTotalRecords'] = 0;
			        $output['iTotalDisplayRecords'] = 0;
			        $output['data']=[];
				  die(json_encode(array("error"=>lang('msg_error_403'),"data"=>$output)));
				}else{

					$ci->session->set_userdata('url_403', base_url(uri_string()));
					
					redirect("error/403","refresh");
				}
			}
		}else{
			return true;
		}
	}
}
function isAllowedSection($access_code,$cond=false){
	$ci = &get_instance(); 
	$ci->load->library('session');
	$app_code=$ci->config->item('app_code');
	//$accessibility=explode(",",$ci->session->userdata("CTC-ACT-CODE"));
	$accessibility=json_decode($ci->session->userdata($app_code."CTC-ACT-CODE"));
	$data=json_decode(base64_decode($ci->session->userdata($app_code.'CTC-X-KEY')));
	if($data->level==$ci->config->item('super_admin_code')){
		return true;
	}else{
		//echo $access_code;
		//print_r(json_decode($accessibility));
		//die();
		if(gettype($accessibility)=="object") $accessibility=(array) $accessibility;
		if(!in_array($access_code,$accessibility)){
			if($cond==true){
				return false;
			}else{
				$headers = apache_request_headers();
				$is_ajax = (isset($headers['x-user-agent']) && $headers['x-user-agent']=="ctc-webapi") ? true : false;
				if($is_ajax){  
					if(!$ci->input->post('draw'))
				  		http_response_code(403);
				  $output = [];
			        $output['sEcho'] = 0;
			        $output['draw'] = 1;
			        $output['iTotalRecords'] = 0;
			        $output['iTotalDisplayRecords'] = 0;
			        $output['data']=[];
				  die(json_encode(array("error"=>lang('msg_error_403'),"data"=>$output)));
				}else{
					return false;
				}
			}
		}else{
			return true;
		}
	}
}

?>
