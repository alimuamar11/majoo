<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adms extends CI_Controller {
    var $data;
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/Administrative_model","admin");
	}
  public function backup_db(){
		$this->load->dbutil();
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		$file_loc='files/bupsysdb/klinikymdb_'.date("Ymdhis").'.sql.gz';

		write_file("./".$file_loc, $backup);
		$save_list=$this->admin->save_backup_db(array("filename"=>$file_loc));
		$del_old=$this->admin->delete_old_backup_db();
		//echo "Done";
		$files = glob("./files/bupsysdb/klinik*");
		$now   = time();
		foreach ($files as $file) {
			if (is_file($file)) {
				if ($now - filemtime($file) >= 60 * 60 * 24 * 3) { // 2 days
				//if ($now - filemtime($file) >= 60 * 2) { 
					unlink($file);
				}
			}
		}
		
		
		// $configMail = [
    //         'mailtype'  => 'html',
    //         'charset'   => 'utf-8',
    //         'protocol'  => 'smtp',
    //         'smtp_host' => 'smtp.gmail.com',
    //         'smtp_user' => 'bupsysctc@gmail.com',  // Email gmail
    //         'smtp_pass'   => 'CTC#2021..Backup',  // Password gmail
    //         'smtp_crypto' => 'ssl',
    //         'smtp_port'   => 465,
    //         'crlf'    => "\r\n",
    //         'newline' => "\r\n"
    //     ];
		// $this->load->library('email',$configMail);
		// $this->email->from('admin.bup@codewell.co.id', 'CTC Admin');
		// $this->email->to('yans.start@gmail.com');
		// $this->email->attach(base_url($file_loc));
		// $this->email->subject(conf('company_name')." | Backup Database");
		// $this->email->message('Backup database');
		// if ($this->email->send()) {
		// 		echo 'Sukses! email berhasil dikirim.';
		// } else {
		// 		echo 'Error! email tidak dapat dikirim.';
		// }
		redirect(base_url());
	}
}
