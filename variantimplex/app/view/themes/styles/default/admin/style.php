<?php

header('Content-type: text/css');
$img = $_GET['img']; 
echo "
body,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote{margin:0;padding:0;}
text .input{color: #000000; padding: 2px 0 0 5px;	font-size:12px;}



* {
	margin: 0px;
	padding: 0px;
}

:focus {
	outline: none;
}

body {
	font-size: 11px;
	margin: 0px;
	font-family: Tahoma;
	background: #FFF;
	color: #000;
}

.textbox {
	color: #828181;	
	font-size:11px;
	height:15px;
}

ul {
	list-style: none;
	padding: 7px 0 0 5px;
	font-size:11px;
}

li {
	list-style: none;
}

a, img {
	border: none;
	text-decoration: none;
	font-size:11px;
	color:#004993;
}

a:hover {
	text-decoration:none;
}

p {
    font-size: 11px;
    line-height:  1.5em;
	color: #000;    
}

b, strong {
	color:#737879;
	font-weight:bold;
}

h1 {
	font: bold 11px Tahoma;
	color:#000;
	text-decoration:none;
}
h2 {
	font: normal 11px Tahoma;
	color: #e0e0e0;
	text-decoration:none;
}

#wrapper {
	margin: 0 auto;
	color: #004993;
	width: 960px;
}

#header {
	background:#fff url(".$img."header_bg.jpg) no-repeat;
	width:960px;
	height: 118px;
	float:left;
}

#header #status {
	width: 960px;
	height: 25px;
	float: left;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	color: #FFF;
	font-size: 12px;
}

#header #status span {
	float:right;
	margin:3px 77px 0 0;
	font:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#fff;
}

#header #status a.span {
	color:#fff;
}

#header #logocontainer {
	float: left;
	width: 940px;
	height: 90px;
}

#header #logocontainer #logo {
	float: left;
	width: 550px;
	height: 60px;
	padding:18px 0 0 25px;
}

#header #logocontainer #tlilogo {
	float: left;
	height: 68px;
	vertical-align:top;
	padding:10px 0 0 265px;
}

.seperator {
	height:25px;
	width:960px;
	float:left;
}

#navigation {
	width: 960px;
	float:left;
	height:28px;
	margin:0 auto;
	background:url(".$img."navbg.jpg) no-repeat;
}

#navigation .nav {
	width: 940px;
	height:28px;
	padding-left:30px;
}

#navigation .nav .home {
	float:left;
	display:block;
	color:#cdaf7e;
	background:url(".$img."home_bg.jpg) no-repeat;
	width: 96px;
	height: 26px;
}

#navigation .nav ul li {
	list-style:none;
	padding:5px 5px 0 11px;
	display:inline;
	color:#004993;
	font-family:Tahoma;
	font-size:12px;
}

#navigation .nav ul li:hover {
	text-decoration: none;
}

#navigation .nav ul li span.links {
	color:#0C4079;
}

#navigation .nav ul li a.span.links {
	color:#004993;
}

#navigation .nav ul li span.linkcolor {
	color:#2790f9;
}

#navigation .nav ul li a.span.linkcolor {
	color:#2790f9;
}


#navigation .nav ul li span.homelink {
	color:#4f4f4f;
	padding-right:18px;
}

#navigation .nav ul li a.span.homelink {
	color:#4f4f4f;
}
	
#contenttop {
	float: left;
	clear: both;
	width: 960px;
	height: 8px;
	background:url(".$img."contenttopbg.jpg) no-repeat;
}

#content {
	float: left;
	clear: both;
	width: 960px;
	background:url(".$img."contentbg.jpg) repeat-y;
}

#contentbottom {
	float: left;
	clear: both;
	height: 8px;
	width: 960px;
	background:url(".$img."contentbottombg.jpg) no-repeat;
}

#content #leftcontent { 
	float: left;
	display: block;
	width: 216px;
	height: 484px;
}

#content #leftcontent { 
	float: left;
	display: block;
	width: 216px;
	background:url(".$img."leftseperator.jpg) no-repeat right;
}

#content #leftcontent #leftnav {
	list-style:none;
	font-size:12px;
	width:209px;
	float:left;
	margin:0;
	clear:both;
}

#content #leftcontent #leftnav ul {
	padding-left:6px;
	list-style:none;
	font-size:12px;
}

#content #leftcontent #leftnav li a {
	padding-left:11px;
	display:block;
	background:url(".$img."navblue.jpg) no-repeat right;
	line-height: 35px;
	color:#004993;
}

#content #leftcontent #leftnav li a:hover {
	background: url(".$img."navblue_hover.jpg) no-repeat right;
	color:#004993;
	text-decoration:none;
}

#content #leftcontent #leftnav li.color a {
	padding-left:11px;
	display:block;
	background: url(".$img."leftnavorange.gif) no-repeat right;
	line-height: 35px;
	color:#004993;
}

#content #leftcontent #leftnav li.color a:hover {
	background: url(".$img."leftnavorange_hover.gif) no-repeat right;
	color:#004993;
	text-decoration:none;
}

#content #rightcontent {
	float: left;
	display: block;
	width: 744px;
}

#content #maincontent {
	float: left;
	display: block;
	width: 744px;
}
#content #maincontent #logincontainer {
	background:url(".$img."login_bg.jpg) no-repeat left;
	float: right;
	width: 480px;
	height: 484px;
}

#content #maincontent #logincontainer span.logintitle {
	float: left;
	margin-top: 150px;
	color: #0048cc;
	font-size: 14px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}

#content #maincontent #logincontainer .loginsection {
	float: right;
	width: 200px;
	height: 150px;
	padding: 220px 115px 0 0px;
	font-family:Tahoma;
	color:#404040;
	font-size:11px;
}

.loginbutton {
	padding-right: 4px;
	float: right;
}

#content #rightcontent #icons {
	float: right;
	width: 550px;
	height: 350px;
	padding: 60px 10px 0 60px;
}

#content #rightcontent #icons img{
	padding-right: 20px;
}

#content #rightcontent #icons .secrow {
	/*padding-left: 35px; */
}

#content #rightcontent #icons img.secrow{
	padding-right: 40px;
	margin-top:50px;
}

#footer {
	display: block;
	height: 28px;
	width: 960px;
	background:url(".$img."footer_bg.jpg) no-repeat center;
	color: #80baf4;
	float: left;
	padding-top:2px;
}

#footer .footerleft {
	float: left;
	display: block;
	padding: 6px 0 0 20px;
}

#footer .footerright {
	float: right;
	display: block;
	padding: 6px 20px 0 0;
}

<!--footer-->
.input span.admin{
	height: 5px;
}

#content #rightcontent {
	float: left;
	display: block;
	width: 744px;
}

#content #rightcontent #admin {
	width: 679px;
	float: left;
	padding: 50px 0 0 30px;
}
	
.searchfield {
	width: 90%;
	float:left;
	background: #f5f5f5;
	border: 1px solid #b8b8b8;
	height: 5px;
}

.buttonbg {
	height: 16px;
	width: auto;
	background: #0a6cff;
	border: 1px solid #004aff;
}

.tablewhitebg {
	background: #fff;
}

.tablepermissionimg {
	background:#fff url(".$img."permission.gif) no-repeat center;
	height: 17px;
}

.tablestatusimg {
	background:#fff url(".$img."status.gif) no-repeat center;
	height: 17px;
}

.tableviewimg {
	background:#fff url(".$img."view.gif) no-repeat center;
	height: 17px;
}

.tableeditimg {
	background:#fff url(".$img."edit.gif) no-repeat center;
	height: 17px;
}

.tabledeleteimg {
	background:#fff url(".$img."delete.gif) no-repeat center;
	height: 17px;
}

.tabletl {
	text-align: center;
	color:#737879;
	font-size:11px;
	font-family:Tahoma;
}

#content #rightcontent #admin .pages {
	width: 664px;
	background: #f5f5f5;
	border: 1px solid #b8b8b8;
	height: 24px;
	color: #8f8efe;
	text-align:center;
}

.viewadmintitle {
	color:#737879;
	font-size:12px;
	font-family:Tahoma;
	font-weight:bold;
}


.subpagename {
	text-align: center;
}

.vpstatus {
	background:url(".$img."status_vp.gif) no-repeat center;
	height: 17px;
}

.vpedit {
	background:url(".$img."edit_vp.gif) no-repeat center;
	height: 17px;
}

.vpdel {
	background:url(".$img."del_vp.gif) no-repeat center;
	height: 17px;
}

.editvp {
	background:url(".$img."vpedit.gif) no-repeat center;
	height: 17px;
}

.online {
	background:url(".$img."online.gif) no-repeat center;
	height: 17px;
}

.busy {
	background:url(".$img."busy.gif) no-repeat center;
	height: 17px;
}

.err{
	font-weight:bolder;
	color:#FF0000;
	padding-bottom:20px;
}

.button, button{ 
	width:auto; 
	height:20px; 
	line-height:20px; 
	background:#0171E1; 
	font-family:Tahoma; 
	color:#CAE4FF; 
	font-size:11px; 
	font-weight:bold; 
	margin:0 10px 0 0;
	/*min-width: 100px;*/
	padding:3px 5px 18px 5px;
	border:0;
	
}
"
?>