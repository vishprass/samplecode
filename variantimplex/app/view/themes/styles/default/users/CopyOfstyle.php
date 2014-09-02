<?php
header('Content-type: text/css');
$img = $_GET['img']; 
echo "
/* CSS Document */

* {
	margin: 0px;
	padding: 0px;
}

:focus {
	outline: none;
}
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
	margin:0 auto; 
	background-color:#ebecee;
}
p,h1,h2,h3,h4,h5,h6,form,ul,li{
	padding:0;
	margin:0;
	border:0;
	}
h1{
	font-size:14px;
	color:#58206d;
	margin-bottom:5px;
	border-bottom:dotted 1px #58206d;
	}
h2{
	font-size:14px;
	color:#000;
	}
p{margin-bottom:10px;}
a {
	font-size: 12px;
	color: #ffffff;
}
a:link {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color: #0066a9;
}
#wrapper{
	width:100%;
	height:auto;
	margin:0 auto;
	}
#container{
	background:url(".$img."body_bg.jpg) repeat-y top center;
	width:770px;
	height:auto;
	margin:0 auto;
	}
#top_curve{
	width:770px;
	height:20px;
	margin:0 auto;
	}
	
#header{
	width:760px;
	height:95px;
	margin:0 auto;
	}
#logo{
	width:185px;
	height:95px;
	float:left;
	}
#search{
	width:230px;
	height:24px;
	padding:45px 30px 25px 0px;
	float:right;
}
#menu1{
	width:760px;
	height:38px;
	color:#FFFFFF;
	background:url(".$img."menu_bg.jpg) repeat-x top left; 
	margin:0 auto;
	}

#banner{
	width:760px;
	height:300px;
	margin:0 auto;
	}
#content_container{
	width:740px;
	height:auto;
	overflow:hidden;
	padding:10px;
	}
#tab_content{
	width:560px;
	height:auto;
	overflow:hidden;
	float:left;
	}
/****************************LOGIN BOX****************************************************/
#login{
	width:168px;
	height:auto;
	overflow:hidden;
	float:right;
	border:1px solid #697076;
	}
.signup{
	width:148px;
	padding:5px 10px;
	text-align:center;
	border-bottom:20px #6d2c84 solid;
	}
.signup_box{
	width:148px;
	padding:5px 10px;
	float:left;
	}
.input_text_field input,select{
	width:145px;
	border:1px solid #a8aac0;
	font-size:10px;
	margin:2px;
	}
	
.input_text_field_small input{
	width:70px;
	height:14px;
	border:1px solid #a8aac0;
	font-size:10px;
	margin:2px 2px;
	float:left;
	}
.input_text_field_small_1 input{
	width:70px;
	height:14px;
	border:1px solid #a8aac0;
	font-size:10px;
	margin:2px 0;
	float:right;
	}
.input_text_field_small select{
	width:70px;
	border:1px solid #a8aac0;
	font-size:10px;
	margin:2px 0;
	float:left;
	}
.submit_button{
	width:120px;
	height:22px;
	margin:0 auto;
	float:left;
	padding:5px 0px 0px 25px;
	}
.required_field{
	width:138px;
	font-size:10px;
	color:#666666;
	text-align:right;
	padding-top:5px;
	margin:0 auto;
	float:left;
	}
/********************************NEWS & FOOTER**************************************************************/
#news{
	width:740px;
	height:90px;
	margin:0 auto;
	padding:10px;
	}
#footer{
	width:750px;
	height:30px;
	padding:10px;
	margin:0 auto;
	font-size:11px;
	color:#999999;
	}
.copyright{
	width:400px;
	float:left;
	}
.design{
	width:260px;
	text-align:right;
	float:right;
	}
.footerlinks{
	font-size:11px;
	color:#999999;
	text-decoration:none;
	}
.footerlinks:hover{
	font-size:11px;
	color: #333333;
	text-decoration:none;
	}

#bottom_curve{
	width:770px;
	height:20px;
	margin:0 auto;
	}
	
/*********************************************************/
#rotator {
	background:#FFF;
	color:#000;
	position:relative;
	margin:0; 
	font-size:12px;
}

/* Tabs */
ul.ui-tabs-nav, li.ui-tabs-nav-item, li.ui-tabs-nav-item a:link, li.ui-tabs-nav-item a:visited {
	margin:0;
	padding:0;
	border:0;
	outline:0;
	line-height:24px;
	text-decoration:none;
	font-size:100%;
	list-style:none;
	float:left;
	font-family:Arial, Helvetica, sans-serif;
}

ul.ui-tabs-nav {
	position:absolute;
	z-index:1;
	width:100%;
	/*background:#FFF url(".$img."uitabsbg.gif) repeat-x bottom right;*/
	border-bottom:20px solid #6d2c84;
}

/* Non-Selected Tabs */
li.ui-tabs-nav-item a:link,
li.ui-tabs-nav-item a:visited {	
	font-size:12px;
	font-weight:normal;
	color:#333;
	border-right:2px solid #fff;
}

/* Hovered Tab */
#rotator .ui-tabs-nav-item a:hover,
#rotator .ui-tabs-nav-item a:active {
	background-color:#6d2c84;
	color:#fff;
}

#rotator .ui-tabs-nav-item a span {
	font-size:12px;
	float:left; 
	padding:2px 11px; 
	cursor:pointer;
	border:1px solid #6d2c84;
	border-bottom:none;
}

/* Active Tab */
#rotator .ui-tabs-selected a:link,
#rotator .ui-tabs-selected a:visited,
#rotator .ui-tabs-selected a:hover,
#rotator .ui-tabs-selected a:active {
	background-color:#6d2c84;
	color:#fff;
}

/* Content Panels */
#rotator .ui-tabs-panel {
	font-family:Arial, Helvetica, sans-serif;
	clear:left;
	color:#000;
	/*height:180px;*/
	border:1px solid #6d2c84;
	padding:60px 10px 10px 10px;
}

#rotator .ui-tabs-hide {
	display:none;
}
";
?>