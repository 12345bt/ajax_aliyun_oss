
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>用ajax方式上传demo</title>

<script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
<script src="ajaxfileupload.js"></script>
<script>
 function uploadFile(e)
 {
     $("#loading")
     .ajaxStart(function(){
         $(this).show();
     })
     .ajaxComplete(function(){
         $(this).hide();
     });

     $('#loading').show();
     var inputId = $(e).attr('getSrc');

     $.ajaxFileUpload
     (
         {
             url:'doajaxfileupload.php',
             secureuri:false,
             fileElementId:'fileToUpload'+inputId,
             dataType: 'json',
             data:{name:'logan', id:'id'},
             success: function (data, status)
             {

                $('#loading').hide();
                // alert(data.msg);
                 $('img[getSrc="'+inputId+'"]').attr('src', data.msg);
                 $('input[getSrc="'+inputId+'"]').attr('value', data.msg);

                 if(typeof(data.error) != 'undefined')
                 {
                     if(data.error != '')
                     {
                         alert(data.error);
                     }else
                     {
                         alert(data.msg);
                     }
                 }
             },
             error: function (data, status, e)
             {
                 alert(e);
             }
         }
     )
     
     return false;

}
</script>
<style type="text/css">
	.spinner {
	  margin: 100px auto;
	  width: 32px;
	  height: 32px;
	  position: relative;
	  display: none;
	}
	 
	.cube1, .cube2 {
	  background-color: #67CF22;
	  width: 30px;
	  height: 30px;
	  position: absolute;
	  top: 0;
	  left: 0;
	   
	  -webkit-animation: cubemove 1.8s infinite ease-in-out;
	  animation: cubemove 1.8s infinite ease-in-out;
	}
	 
	.cube2 {
	  -webkit-animation-delay: -0.9s;
	  animation-delay: -0.9s;
	}
	 
	@-webkit-keyframes cubemove {
	  25% { -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5) }
	  50% { -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg) }
	  75% { -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5) }
	  100% { -webkit-transform: rotate(-360deg) }
	}
	 
	@keyframes cubemove {
	  25% {
	    transform: translateX(42px) rotate(-90deg) scale(0.5);
	    -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5);
	  } 50% {
	    transform: translateX(42px) translateY(42px) rotate(-179deg);
	    -webkit-transform: translateX(42px) translateY(42px) rotate(-179deg);
	  } 50.1% {
	    transform: translateX(42px) translateY(42px) rotate(-180deg);
	    -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg);
	  } 75% {
	    transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
	    -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
	  } 100% {
	    transform: rotate(-360deg);
	    -webkit-transform: rotate(-360deg);
	  }
	}
</style>

            <input type="text" getSrc="2" class="form-control" name="imgs[]" value="" placeholder="请选择文件上传或填写淘宝空间图片地址" >
            <img getSrc="2" src="" style="width:80px;height:80px;margin:5px 0 5px 0;" class="img-polaroid">
            <input id="fileToUpload2" type="file" size="45"  getSrc="2" name="fileToUpload" class="input" onchange="return uploadFile(this)">
<div class="spinner" id="loading">
  <div class="cube1"></div>
  <div class="cube2"></div>
</div>

<!--PageEndHtml Block End-->
</body>
</html>
