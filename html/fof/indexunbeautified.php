<?php 
session_start(); 
require_once 'Mobile_Detect.php';
require_once 'dbconfig.php';
$detect = new Mobile_Detect;

?>


<?php


if(!empty($_SESSION['FULLNAME'])){
  $_SESSION['logged_in'] = True;
  header('Location: main.php');
}

$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
 $_SESSION['mobile'] = True;
} else {
 $_SESSION['mobile'] = False;
}

?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<html>
<head>
<link rel="stylesheet" type="text/css" href="theme.css">
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
</head>

<body bgcolor="#EBEBEB">
<?php //echo DB_SERVER; ?>
<img src="logo.png" style="width:250px;padding-left:10%;padding-top:10px;padding-right:10px;" draggable="false">
<a <?php if(empty($_SESSION['FULLNAME'])){echo "href='fbconfig.php'";} else {echo "href = 'logout.php'";}?>>
    <div id="smalllogin" style="padding-right:6%;padding-top:14px;float:right">
    <div id="fblogin" style='width:<?php if(empty($_SESSION['FULLNAME'])){echo "150px;'";} else {echo "240px;'";}?>>
    <img style="padding-top: 7px;padding-bottom: 7px;padding-left:14px;" src="http://www.progenetix.org/Foswiki/pub/System/OriginalDocumentGraphics/facebook.gif" draggable="false">
    <tag style="float:right;padding-top: 7px;padding-bottom: 7px;padding-right:24px;"><?php if(empty($_SESSION['FULLNAME'])){echo "Sign in";} else {echo "Sign out " . $_SESSION['FULLNAME'];}?></tag></div>
    </div>
    </div>
</a>
<div id="loginform-container">
<div id="loginform" <?php if ( !$detect->isMobile() ) {echo "style='box-shadow:0px 10px 15px #808080;'";}?>>
<br><br>
<center><h1>See the truth</h1></center>
<center><h2>Very Long Cheesy Catchline Here</h2></center>
<br>
<a href="fbconfig.php">

<div id = "fblogin">
<img style="float: left;padding-left: 27px;padding-top: 7px;padding-bottom: 7px;" src="http://www.progenetix.org/Foswiki/pub/System/OriginalDocumentGraphics/facebook.gif" draggable="false">
<tag style="float: right;padding-right:18px;padding-top: 6px;padding-bottom: 6px;">Sign in via Facebook</tag></div>
</div>
</a>

<hr class="seperator" />



<div id="footer" style="position: fixed; Width: 100%; bottom: 2%;">
<hr class="seperator" />
<center>
<img src="icons/facebook.png" style="width:50px" draggable="false">
<img src="icons/google-plus.png" style="width:50px" draggable="false">
<img src="icons/twitter.png" style="width:50px" draggable="false">
<img src="icons/share.png" style="width:50px" draggable="false">
<hr class="seperator" />
<br>
<tag style="color:gray;">FriendOrFlirt 2016</tag>
<br>
<tag style="color:gray;font-size:10px;">Mobile Terms Privacy Help</tag>
</center>
</div>


</body>
</html>
