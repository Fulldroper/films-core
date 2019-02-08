<?php
function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function isFilm($x){
	$str = str_split($x);
	$count= sizeof($str)-1;
	if($str[$count-3] =='.' and $str[$count-2] =='m' and $str[$count-1] =='p' and $str[$count] =='4' )
	{return true;}else{return false;}
}
echo'<head><meta charset="utf-8" ></meta><link rel="stylesheet" href="style.css"></link></head>';
if($_GET['video']== null and $_GET['ch']== "1"){
	if($_POST['nick'] != null and $_POST['text'] != null){
		$file = file_get_contents('chat.txt', true);
		fwrite(fopen("chat.txt", "w"),"<a style=color:#494d56; title=".'"'.date("[j M] Y").'"'." >[ ".date("H:i:s")."] </a><a title=".'"'.date("[j M] Y").'"'." style=color:#ae6ef2; >".$_POST['nick'].":</a> ".$_POST['text']."</br>".$file);
		$_POST['nick'] = null;$_POST['text'] = null;
	}
	echo '<div class="chatf scroll">';
	echo file_get_contents('chat.txt', true);
	echo '</div><form class="chat" action="#" method="post" id="chat"><input required id="nick" placeholder="Nickname" name="nick"></input> <input name="text" form="chat" required placeholder="text"  AUTOCOMPLETE="off" form="chat"></input> <input type="submit" form="chat" onclick="setNick()" value="~>"></input></form>
	<script>
	function setNick(){
		document.cookie="nick="+document.getElementById("nick").value;
	}
	function findArg(key,str){
		if(haveCookie(key,str)){
			var result="";
			for(var i=(str.indexOf(key)+(key.length+1));str.charAt(i)!=";";i++){result+=str.charAt(i);}
			return result;
		}else{return false};
	}
	function haveCookie(key,str){
		var reg=new RegExp(key+"=.*;","g");
		if(str.match(reg)!= null){return true;}else{return false;}
	}
	window.onload=function(){
		if(haveCookie("nick",document.cookie.toString()+";")){
		document.getElementById("nick").value=findArg("nick",document.cookie.toString()+";")
		}
	}
	</script>';
}
if($_GET['video']==null){

$dir = "/home/192.168.0.104/www/films/media";
$array = scandir($dir);
$count = sizeof($array);
$counter;
	if($_GET['ch']==null){echo '<a id="chbtn" href="?ch=1">Open chat ~> </a>';}
	echo '<ul id="inf">';
	for($i = 2;$i <= $count-1;$i++){
		echo'<li><a class="el" href="?video='.$array[$i].'">';
		$str= str_split($array[$i]); 
		for($j=0;$j<=sizeof($str)-5;$j++){
			echo $str[$j];
		}
		echo '</a></li>';
		$counter=$i;
	}
	echo '</br><li>##########</li>';
	echo '<li style="color:#f37070;"># '.$counter.':Films #</li>';
	echo '<li>##########</li>';
	echo '</ul>';
}else{
	if(isFilm($_GET['video'])){
		echo'
			<video id="video" poster="poster.png" controls src="media/'.$_GET['video'].'"></video></br>
			<div class="block" >
			<a>[ Video ]</a><a id="videoName"> [ '.$_GET['video'].' ]</a><a id="savedPos" onclick="savedPos()"></a><a href="../films" id="goMain"> [ Go back ]</a></br><hr/>
			<a>[ Your ip ] [ '.getRealIpAddr().' ]</a></br>
			<a>[ Your browser ] [ '.$_SERVER['HTTP_USER_AGENT'].' ]</a></br>
			<a>[ Your referrer ] [ '.$_SERVER['HTTP_REFERER'].' ]</a></br>
			</div>
			<script type="text/javascript" src="script.js" defer="defer"></script>';
	}else{
		$dir = "/home/192.168.0.104/www/films/media"."/".$_GET['video'];
		$array = scandir($dir);
		$count = sizeof($array);
	 	echo'
			<body style="overflow: hidden;" >
			<video id="video"  poster="poster.png"  controls src="media/'.$_GET['video'].'/1.1.mp4"></video></br>
			<div class="block" ><a style="color:red;"> [ Beta version ]</a>
			<a>[ Video ]</a><a id="videoName"> [ '.$_GET['video'].' ]</a><a id="savedPos" onclick="savedPos()"></a><a href="../films" id="goMain"> [ Go back ]</a></br>
			<hr/><div style="overflow:auto;	scrollbar-color: #2a2c31 #36393f;scrollbar-width: thin;max-width:1250px;max-height:40px;">';
			
			for($i=2;$i<=$count-1;$i++){
				$str= str_split($array[$i]); 
				echo '<a id="seasonButton" onclick=play("'.$_GET['video']."/".$array[$i].'"); >';
				
				for($j=0;$j<=sizeof($str)-5;$j++){
					echo $str[$j];
				}
				
				echo "</a> ";
			}
			
			echo '</div></br>
			<a>[ Your ip ] [ '.getRealIpAddr().' ]</a></br>
			</div>
			<script type="text/javascript" src="script.js" defer="defer"></script>'; 
	}
}?>