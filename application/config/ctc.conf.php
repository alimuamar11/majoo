<?php
/* INFORMASI PERUSAHAAN/USER */
$config['app_name']="Admin Panel - CTC";
$config['app_name_short']="CTC";
$config['company_name']="Codewell";
$config['company_name_short']="CTC";
$config['company_logo']='/assets/img/logo-ctc.png';
$config['company_address']='';
$config['company_telp']='';
$config['company_email']='';
$config['app_code']="CTC";
/* END INORMASI PERUSAHAAN/USER */

/* perubahan data dibawah ini sebaiknya dilakukan oleh developers */
$config['api-url']="";
$config['api-appkey']="5be929723e47e3bd0df2d41b090bff2a";
$config['meta_author']="Codewell Tekindo Cemerlang";
$config['meta_description']="";

// set tahun publikasi project
$config['publish_year']=2021;
// set multi bahasa [english,indonesia]
$config['multi_lang']=FALSE;
// set file apa saja yang bisa di upload
$config['upload_file_types']=array("jpg","jpeg","png","pdf","xls","xlsx","doc","docx");
// set ukuran maksimum file
$config['upload_max_size']=500; //MB
// izinkan mengganti file jika sudah tersedia
$config['upload_overwrite']=TRUE;
// izinkan user untuk memilih template
$config['enable_templating']=fALSE;
// daftar template yang tersedia
$config['ctc_templates']=array("ctc-azia-sidebar","ctc-azia-topbar");
$config['ctc_default_template']="ctc-azia-topbar";

?>
