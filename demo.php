<?php
/**
 * 将图片上传到aliyun oss
 * @create_time 2015-10-14
 * @author [sixian] [1741159138@qq.com]
 */
class uploadImg{

	/**
	 * @param  上传图片到aliyun oss
	 * @param  [obj] 阿里云sdk  可不填
	 * @param  [imgName] 图片名称
	 * @param  [content] 图片地址
	 * @param  [save_type] 保存图片时的模式  url=>表示传入url 上传 否则为图片的源数据
	 * @return [ossImgUrl]
	 */
	public function upload_by_content( $obj = "", $imgName, $content, $save_type = 'url'){
		if(empty($obj)){
			/**
			 * 加载sdk包以及错误代码包
			 */
			$sdkPath = dirname(__FILE__);
			require_once $sdkPath.'/sdk.class.php';
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

		return HTTP_IMG_HOST.$object;
	}
}

/**
 * demo
 * @var uploadImg
 */
$upload_app = new uploadImg();
$filePath = dirname(__FILE__).'/';
$imgName = "test.jpg";
$fileImgPath = $filePath . $imgName;
$ossImgUrl = $upload_app->upload_by_content('', $imgName, file_get_contents($fileImgPath), 'openFileImg');
echo $ossImgUrl;



?>	