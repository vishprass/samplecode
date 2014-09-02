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
	font: 11px Tahoma;
	margin: 0px;
	background: #FFF;
	color: #000;
}

input {
	color: #234f7a;
	border: 1px solid #aaa9a7;
	padding: 3px 0 0 7px;
	font-size:11px;
}

input.srch {
	color: #5a5a5a;
	border: 1px solid #aaa9a7;
	padding: 3px 0 0 7px;
	width: 262px;
	font-size:11px;
	height:16px;
}


ul {
	list-style: none;
	color: #fff;
	font-size:11px;
}

li {
	list-style: none;
}

a, img {
	border: none;
	text-decoration: none;
	color: #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}

a.blue {
	color: #09F;
	font: 11px Tahoma;
}

a:hover {
	text-decoration: none;
}

p {
    font-size: 11px;
    line-height:  1.5em;
	color: #000;    
}

p.sub {
    font-size: 11px;
    line-height:  1.5em;
	color: #000;
	border-top: 1px solid #000;
}


h1 {
	font: 16px Tahoma;
	color:#0171c0;
	text-decoration:none;
}
h2 {
	font: normal 11px Tahoma;
	color: #e0e0e0;
	text-decoration:none;
}

h3 {
	font: normal 14px Tahoma;
	color: #2b6992;
	text-decoration:none;
}

#wrapper {
	margin: 0 auto;
	color: #fff;
	width: 980px;
}

#header {
	width:980px;
	height: 69px;
	margin:0 auto;
	float: left;
}

#header #logo {
	float: left;
	padding-top:15px;
}

#header #search {
	padding-top:20px;
	float:right;
	text-align:right;
	width: 300px;
}

#header #search .submitbtn {
	border:1px #44281D solid;
	font-size:11px;
	color:#fff;
	float:right;
	width: 27px;
	height: 19px;
}

#header #search .box {
	font-size:11px;
	height:21px;
	width: 200px;
	background-color:#FFFFFF;
	float: left;
}

#bannercontainer {
	float: left;
	width: 980px;
}

#bannercontainer #navigation {
	float: left;
	height: 21px;
	width: 980px;
}

#bannercontainer #navigation .navleft {
	float: left;
	height: 21px;
	background: url(".$img."navleft.gif) no-repeat;
	width: 8px;
}

#bannercontainer #navigation .nav {
	float: left;
	height: 21px;
	width: 964px;
	background: #aaa9a7;
	font: 11px Tahoma;
}

#bannercontainer #navigation .navmenu {
	float: left;
	width: 650px;
}

#bannercontainer #navigation .navmenuicon {
	background: url(".$img."toparrow.jpg) no-repeat bottom;
	width: 20px;
	height: 8px;
	padding-right: 126px;
	float: right;
	margin-top: 13px;
}

#bannercontainer #navigation .navright {
	float: left;
	height: 21px;
	background: url(".$img."navright.gif) no-repeat right;
	width: 8px;
}

#bannercontainer #banner {
	float: left;
	height: 326px;
	background: #075c88;
	width: 980px;
}

#bannercontainer #banner span {
	float: left;
	padding: 10px 0 0 10px;
}

#bannercontainer #banner .bannertext {
	float: left;
	padding: 5px 0 0 16px;
	width: 250px;
}

#bannercontainer #banner .bannertext ul li.btxt {
	float: left;
	list-style:none;
	width: 200px;
	padding-top: 6px;
}

#bannercontainer #banner .bannertext ul li.btxt span.blue {
	color: #42bfff;
}

#bannercontainer #banner .bannertext ul li {
	float: left;
	list-style:none;
}

#bannercontainer #banner .clientcontainer {
	float: left;
	width: 271px;
	height: 143px;
	padding: 5px 0 0 8px;

}

#bannercontainer #banner .clientcontainer .client {
	float: left;
	width: 267px;
	height: 125px;
	background: url(".$img."clients.gif) no-repeat;
}

#bannercontainer #banner .clientcontainer .client span {
	float: left;
	width: 150px;
	height: 70px;
	margin: 36px 0 0 26px;
}

#content {
	float: left;
	width: 980px;
	height: 230px;
	background: url(".$img."contentbg.jpg) repeat-x;
	border-bottom: 4px solid #075c88;
}

#content .intro {
	float: left;
	width: 519px;
	padding: 15px 0 0 15px;
	color: #3b3b3b;
}

#content .tabs {
	float: left;
	width: 420px;
	margin-top: 10px;
}

#footer {
	float: left;
	width: 980px;
	height: 29px;
	background: #aaa9a7;
}

#footer .ftext {
	float: left;
	width: 500px;
	padding-top: 7px;
}

#footer .ftext ul li {
	float: left;
	padding-left: 15px;
}

#footer .dwnarrow {
	float:right;
	background: url(".$img."bottomarrow.jpg) no-repeat;
	width: 20px;
	height: 13px;
	padding-right: 80px;
}

#copyright {
	float: left;
	width: 980px;
}

#copyright .cpytext {
	float: left;
	width: 450px;
	color: #888;
	padding: 10px 0 0 15px;
}

#copyright .cpylinks {
	float: left;
	width: 190px;
	padding: 8px 0 0 160px;
}

#copyright .cpylinks ul li {
	float: left;
	padding-right:10px;
	color: #888;
}

#copyright .cpylinks ul li a{
	color: #888;
	font: 11px Tahoma;
}

#copyright .cpyfollow {
	float: right;
	width: 130px;
	padding: 8px 0 0 10px;

}

#copyright .cpyfollow ul li {
	float: left;
	padding-right: 5px;
	color: #075c88;
}


#contentInner {
	float: left;
	width: 980px;
	background-color:#F0F0F0;
	border-bottom: 4px solid #075c88;
}

#contentInner .intro {
	float: left;
	width: 650px;
	padding: 15px 0 0 15px;
	color: #3b3b3b;
}



";
?>