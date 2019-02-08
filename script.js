function play(src_){
	document.getElementById("video").src="media/"+src_;
}
function findArg(key,str){
	if(haveCookie(key,str)){
		var result='';
		for(var i=(str.indexOf(key)+(key.length+1));str.charAt(i)!=';';i++){result+=str.charAt(i);}
		return result;
	}else{return false};
}
function addCookie(key,value){
	document.cookie=key+"="+value+";";
}
function haveCookie(key,str){
	var reg=new RegExp(key+"=.*;","g");
	if(str.match(reg)!= null){return true;}else{return false;}
}
function savedPos(){
	if(haveCookie(document.getElementById("video").src,document.cookie.toString()+";")){
		document.getElementById("video").currentTime=findArg(document.getElementById("video").src,
		document.cookie.toString()+";")
	}else{return false;}
}
function keyEventFun(e){
	if(e.keyCode == 70 /* 'f' */){
		var elem = document.getElementById("video");
		if (elem.requestFullscreen) {
		  elem.requestFullscreen();
		} else if (elem.mozRequestFullScreen) {
		  elem.mozRequestFullScreen();
		} else if (elem.webkitRequestFullscreen) {
		  elem.webkitRequestFullscreen();
		} else if (elem.msRequestFullscreen) { 
		elem.msRequestFullscreen();}
	}
	if(e.keyCode == 32 /* 'space' */){
		if(document.getElementById("video").paused){
			document.getElementById("video").play()
		}else{
			document.getElementById("video").pause()
		}
	}
}
window.onload = function() {
	var vid = document.getElementById("video");
	var cookIe=document.cookie.toString()+";";
	vid.load();
	//document.getElementById("myVideo").poster = "/images/w3schoolscomlogo.png";
	//console.log(findArg("volume",cookIe)+" "+findArg(vid.src,cookIe))
	if(haveCookie(vid.src,cookIe) && findArg(vid.src,cookIe) > 0/*  && !vid.ended *//* && findArg(vid.src,cookIe) < vid.duration */){
		
		document.getElementById("savedPos").innerHTML=" [ Contine watch ]";
	}
	if(haveCookie("volume",cookIe)){
		vid.volume=findArg("volume",cookIe);
	}
	window.onresize = function(event) {
		document.body.style.width=window.innerWidth;
		document.body.style.height=window.innerHeight;
		console.log("resize");
	};
	vid.onvolumechange = function() {
		addCookie("volume",vid.volume);
	};
	window.addEventListener('keydown', keyEventFun);
	window.onbeforeunload = function() {
		addCookie(vid.src,vid.currentTime);
	};
};