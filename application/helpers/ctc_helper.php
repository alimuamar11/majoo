<?php
if (!function_exists('apache_request_headers')) {
	function apache_request_headers()
	{
		$arh = array();
		$rx_http = '/\AHTTP_/';
		foreach ($_SERVER as $key => $val) {
			if (preg_match($rx_http, $key)) {
				$arh_key = preg_replace($rx_http, '', $key);
				$rx_matches = array();
				$rx_matches = explode('_', $arh_key);
				if (count($rx_matches) > 0 and strlen($arh_key) > 2) {
					foreach ($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
					$arh_key = implode('-', $rx_matches);
				}
				$arh[$arh_key] = $val;
			}
		}
		return ($arh);
	}
}

function get_template($template_dir = '')
{
	$ci = &get_instance();
	$ci->load->library('session');
	$app_code = $ci->config->item('app_code');
	if ($ci->session->userdata($app_code . "CTC-TPL") && $template_dir == '') {
		return "templates/" . $ci->session->userdata($app_code . "CTC-TPL") . "/template";
	} else
		if ($template_dir != '') {
		return "templates/" . $template_dir . "/template";
	} else {
		return "templates/ctc-azia-topbar/template";
	}
}
function generateToken($data)
{
	if (gettype($data) != 'array' && gettype($data) != 'object') {
		sendError(lang('msg_invalid_token'));
	} else {
		$ci = &get_instance();
		$ci->load->library('session');
		$app_code = $ci->config->item('app_code');
		if (isset($data->template) && $data->template != "")
			$ci->session->set_userdata($app_code . "CTC-TPL", $data->template);
		if (isset($data->lang) && $data->lang != "" && file_exists(APPPATH . "language/" . $data->lang . "/ctcapp_lang.php"))
			$ci->session->set_userdata($app_code . 'site_lang', $data->lang);
		$encoded = base64_encode(json_encode($data));
		$ci->session->set_userdata($app_code . 'CTC-X-KEY', $encoded);
		if ($ci->input->get('redirect')) redirect($ci->input->get('redirect'));
		if (isset($data->last_page) && $data->last_page != "") {
			redirect($data->last_page);
		} else {
			redirect('master-data/produk');
		}
	}
}
function generateMenu($base_menu, $menus, $user_data)
{
	$ci = &get_instance();
	$ci->load->library('session');
	$app_code = $ci->config->item('app_code');
	if (gettype($base_menu) != 'object' && gettype($base_menu) != 'array') {
		die('Error in generating menu! It needs array type');
	}
	$new_menus = array();
	$actions_code = array();
	if (!empty($base_menu)) {
		foreach ($base_menu as $key => $arr) {
			array_push($actions_code, $arr->access_code);
			$excode = explode(",", $arr->actions_code);
			if (!empty($excode)) {
				foreach ($excode as $code) {
					if ($code != "") array_push($actions_code, $arr->access_code . "^" . $code);
				}
			}
			if ($arr->has_child == 1) {
				if (!empty($menus)) {
					$arr_menu = array(
						"label" => $arr->title,
						"url" => $arr->end_point,
						"icon" => $arr->icon,
						"sub_menu" => array()
					);
					foreach ($menus as $k => $menu) {
						if ($menu->base_id == $arr->base_id) {
							array_push($arr_menu['sub_menu'], array(
								"label" => $menu->title,
								"url" => $menu->end_point
							));
							array_push($actions_code, $menu->access_code);
							$excode = explode(",", $menu->actions_code);
							if (!empty($excode)) {
								foreach ($excode as $code) {
									if ($code != "") array_push($actions_code, $arr->access_code . "^" . $code);
								}
							}
						}
					}
				}
			} else {
				$arr_menu = array(
					"label" => $arr->title,
					"url" => $arr->end_point,
					"icon" => $arr->icon,
					"sub_menu" => array()
				);
			}
			array_push($new_menus, $arr_menu);
		}
	}
	$exp_user_actions_code = explode(",", $user_data->actions_code);

	$ci->session->set_userdata($app_code . "CTC-MENUS", $new_menus);

	if ($user_data->level == $ci->config->item('super_admin_code')) {
		$ci->session->set_userdata($app_code . "CTC-ACT-CODE", json_encode(array_unique($actions_code)));
	} else {
		$ci->session->set_userdata($app_code . "CTC-ACT-CODE", json_encode(array_intersect(array_unique($actions_code), array_merge(explode(",", $user_data->accessibility), explode(",", $user_data->actions_code)))));
		//$ci->session->set_userdata("CTC-ACT-CODE",json_encode(array_unique($actions_code)));
	}
}
function clearToken()
{
	$ci = &get_instance();
	$ci->load->library('session');
	$app_code = $ci->config->item('app_code');
	$session_list = array($app_code . 'CTC-TPL', $app_code . 'CTC-X-KEY', $app_code . 'CTC-MENUS', $app_code . 'CTC-ACT-CODE');
	$ci->session->unset_userdata($session_list);
	$ci->session->sess_destroy();
	redirect('admin/auth');
}
function lang($key)
{
	$ci = &get_instance();
	return $ci->lang->line($key);
}
function conf($key)
{
	$ci = &get_instance();
	return $ci->config->item($key);
}
function create_order_id($last_order, $type = '')
{
	$ci = &get_instance();
	$length = $ci->config->item('order_id_length');
	if ($type == "") {
		if ($last_order == null || $last_order == "") {
			$no = 1;
			$yr = date("y");
		} else {
			$split = explode("-", $last_order);
			$no = (int) $split[1];
			$no++;
			$yr = $split[0];
		}
		if (strlen($no) < $length) {
			$rep = str_repeat(0, $length - strlen($no));
			$no = $yr . "-" . $rep . $no;
		}
	} else {
		$no = $last_order;
		if (strlen($no) < $length) {
			$rep = str_repeat(0, $length - strlen($no));
			$no = $rep . $no;
		}
	}
	return $no;
}

function sendError($message, $data = array(), $code = '')
{
	$code = ($code == '') ? 400 : $code;
	http_response_code($code);
	die(json_encode(array('error' => "<strong>Error! </strong> $message", "data" => $data)));
}
function sendSuccess($message, $data = array(), $code = '')
{
	$code = ($code == '') ? 200 : $code;
	http_response_code($code);
	die(json_encode(array('message' => "<strong>Success! </strong> $message", "data" => $data)));
}
function sendJSON($array_data)
{
	die(json_encode($array_data));
}
function requiredMethod($method)
{
	$ci = &get_instance();
	$meth = $ci->input->method(true);
	if (strtoupper($method) != $meth) {
		sendError(lang('msg_method_invalid'), [], 405);
	}
}
function isEmailValid($email)
{
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if (preg_match($regex, $email)) return true;
	return false;
}
function isMatch($first, $second)
{
	if ($first == $second) return true;
	return false;
}
function hashPasswd($password)
{
	return md5(base64_encode($password));
}
function bilangRatusan($x)
{
	$kata = array('', 'Satu ', 'Dua ', 'Tiga ', 'Empat ', 'Lima ', 'Enam ', 'Tujuh ', 'Delapan ', 'Sembilan ');
	$string = '';
	$ratusan = floor($x / 100);
	$x = $x % 100;
	if ($ratusan > 1) $string .= $kata[$ratusan] . "Ratus ";
	else if ($ratusan == 1) $string .= "Seratus ";
	$puluhan = floor($x / 10);
	$x = $x % 10;
	if ($puluhan > 1) {
		$string .= $kata[$puluhan] . "Puluh ";
		$string .= $kata[$x];
	} else if (($puluhan == 1) && ($x > 0)) $string .= $kata[$x] . "Belas ";
	else if (($puluhan == 1) && ($x == 0)) $string .= $kata[$x] . "Sepuluh ";
	else if (($puluhan == 1) && ($x == 1)) $string .= $kata[$x] . "Sebelas ";
	else if ($puluhan == 0) $string .= $kata[$x];
	return $string;
}
function terbilang($x)
{
	$x = number_format($x, 0, "", ".");
	$pecah = explode(".", $x);
	$string = "";
	for ($i = 0; $i <= count($pecah) - 1; $i++) {
		if ((count($pecah) - $i == 5) && ($pecah[$i] != 0)) $string .= bilangRatusan($pecah[$i]) . "Triliyun ";
		else if ((count($pecah) - $i == 4) && ($pecah[$i] != 0)) $string .= bilangRatusan($pecah[$i]) . "Milyar ";
		else if ((count($pecah) - $i == 3) && ($pecah[$i] != 0)) $string .= bilangRatusan($pecah[$i]) . "Juta ";
		else if ((count($pecah) - $i == 2) && ($pecah[$i] == 1)) $string .= "Seribu ";
		else if ((count($pecah) - $i == 2) && ($pecah[$i] != 0)) $string .= bilangRatusan($pecah[$i]) . "Ribu ";
		else if ((count($pecah) - $i == 1) && ($pecah[$i] != 0)) $string .= bilangRatusan($pecah[$i]);
	}
	return $string;
}
function dateIndo($date_format)
{
	$day = date("d", strtotime($date_format));
	$month = date("n", strtotime($date_format));
	$year = date("Y", strtotime($date_format));
	$months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
	return "$day " . $months[$month - 1] . " $year";
}
function array_group_by($array, $key)
{
	$return = array();
	foreach ($array as $val) {
		$return[$val[$key]][] = $val;
	}
	return $return;
}
/**
 * Group items from an array together by some criteria or value.
 *
 * @param  $arr array The array to group items from
 * @param  $criteria string|callable The key to group by or a function the returns a key to group by.
 * @return array
 *
 */
function groupBy($arr, $criteria): array
{
	return array_reduce($arr, function ($accumulator, $item) use ($criteria) {
		$key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
		if (!array_key_exists($key, $accumulator)) {
			$accumulator[$key] = [];
		}

		array_push($accumulator[$key], $item);
		return $accumulator;
	}, []);
}
function format_number($nominal)
{
	return number_format($nominal, 0, ",", ".");
}

function build_filter_table($posted, $order_cols = [], $skipped_orders = [])
{
	$sWhere = "";
	$output = [];
	if (isset($posted['sSearch'])) {
		foreach ($posted['sSearch'] as $k => $v) {
			if ($v != "") {
				$sWhere .= ($sWhere == "") ? " WHERE " : " AND ";
				$sWhere .= htmlentities($k) . " LIKE '%" . trim(htmlentities($v)) . "%'";
			}
		}
	} else
		if (isset($posted['search'])) {
		if ($posted['search']['value'] != "") {
			$output['search'] = htmlentities(trim($posted['search']['value']));
		}
	}
	$order = "";
	$limit = 0;
	$offset = 25;
	if (isset($posted['start']) && isset($posted['length'])) {
		$limit = (int) $posted['start'];
		$offset = (int) $posted['length'];
	}
	if (isset($posted['order'])) {
		$ord = $posted['order'][0];
		$col = $ord['column'];
		$dir = $ord['dir'];
		if (isset($order_cols[(int) $col]) && !in_array($order_cols[(int) $col], $skipped_orders)) {
			$order = " ORDER BY " . $order_cols[(int) $col] . " " . $dir;
		}
	}
	$sLimit = " LIMIT $limit,$offset";
	$output['draw'] = (isset($posted['draw'])) ? (int) $posted['draw'] : 1;
	$output['recordsTotal'] = 0;
	$output['recordsFiltered'] = 0;
	$output['data'] = [];
	$output['where'] = $sWhere;
	$output['order'] = $order;
	$output['limit'] = $sLimit;
	return (object) $output;
}
function output_empty_datatable()
{

	$output = [];
	$output['sEcho'] = 0;
	$output['draw'] = 1;
	$output['iTotalRecords'] = 0;
	$output['iTotalDisplayRecords'] = 0;
	$output['data'] = [];
	return $output;
}
