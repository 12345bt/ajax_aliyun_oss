<?php
//禁用错误报告，也就是不显示错误
error_reporting(0);

	$error = "";
	$msg = "";
	$fileElementName = 'fileToUpload';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
			$filename = strtolower($_FILES['fileToUpload']['name']);
			if (strpos($filename, '.php') !== false) {
				echo '{"status":0,"msg":"http://xinyuemin.com/images/empty.png"}';
				sleep(1);
			exit;
			}			
			$imgurl= $_FILES['fileToUpload']['name'];
			$imgsize= @filesize($_FILES['fileToUpload']['tmp_name']);
			//for security reason, we force to remove all uploaded file
			    if (file_exists("../upload/" . $_FILES["fileToUpload"]["name"]))
			      {
			      //echo $_FILES["fileToUpload"]["name"] . " already exists. ";
			      }
			    else
			      {
			      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],
			      "./upload/" . $_FILES["fileToUpload"]["name"]);
			     // echo "Stored in: " . "upload/" . $_FILES["fileToUpload"]["name"];
			      }

			//@unlink($_FILES['fileToUpload']);				
	}		
	$imgName = date('YmdHis').'_'.$imgurl;
	$path = dirname(__FILE__);
	$path_file_img = $path."/upload/" . $imgurl;
	$content = file_get_contents($path_file_img);
	@unlink($path_file_img);		
	$aliyunossUrl =  upload_by_content( $obj = "", $imgName, $content, $save_type = 'content');

	$json=array(
		'status'=>1,
		// 'msg'=>"upload/{$imgurl}",
		'msg'=>$aliyunossUrl ,
		'size'=>$imgsize);
	echo json_encode($json);/*}}}*/


//通过内容上传文件
function upload_by_content( $obj = "", $imgName, $content, $save_type = 'url'){
	if(empty($obj)){
		/**
		 * 加载sdk包以及错误代码包
		 */
		require_once './sdk.class.php';

		$obj = new ALIOSS();

		//设置是否打开curl调试模式
		//$obj->set_debug_mode(FALSE);

		//设置开启三级域名，三级域名需要注意，域名不支持一些特殊符号，所以在创建bucket的时候若想使用三级域名，最好不要使用特殊字符
		$obj->set_enable_domain_style(TRUE);
	}
	$bucket = QRIMG_B;
	$folder = 'headimg/';

	$object = $folder.$imgName;

	if ($save_type == 'url'){
    	$content = file_get_contents($content);
	}else{
		$content = $content;
	}

	$upload_file_options = array(
		'content' => $content,
		'length' => strlen($content),
		ALIOSS::OSS_HEADERS => array(
			'Expires' => date('Y-m-d H:i:s', time()+3600*24*10),
		),
	);

	$response = $obj->upload_file_by_content($bucket,$object,$upload_file_options);
	//echo 'upload file {'.$object.'}'.($response->isOk()?'ok':'fail')."\n";
	//_format($response);
	$object = urlencode($object);
	return HTTP_IMG_HOST.$object;
}

?>