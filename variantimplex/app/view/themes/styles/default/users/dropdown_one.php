<?php 
header('Content-type: text/css');
$img = $_GET['img']; 
echo "

#pad {height:140px;}
/* ================================================================ 
This copyright notice must be untouched at all times.

The original version of this stylesheet and the associated (x)html
is available at http://www.cssmenus.co.uk
Copyright (c) 2009- Stu Nicholls. All rights reserved.
This stylesheet and the associated (x)html may be modified in any 
way to fit your requirements.
=================================================================== */
#menu {padding:0; margin:0; list-style:none; height:40px; position:relative; z-index:500; font-family:arial, verdana, sans-serif;}
#menu li {float:left; margin-right:1px;}
#menu li a {display:block; float:left; height:40px; line-height:40px; background:#333; color:#ccc; text-decoration:none; font-size:11px; font-weight:bold; padding:0 30px 0 20px;}


#menu table {border-collapse:collapse; width:0; height:0; position:absolute; top:0; left:0;}

/* Default link styling */

/* Style the list OR link hover. Depends on which browser is used */

#menu li a:hover {z-index:200; position:relative;color:#fff; background-color:#c60;}
#menu li:hover {position:relative; z-index:200;}

#menu li:hover > a {color:#fff; background:#c60;}
#menu li:hover > a.sub {color:#fff; background-color:#c60;}

#menu li.current a {color:#fff; background:#840;}

#menu li a.sub {background: #333 url(".$img."drop-arrow.gif) no-repeat right center;}
#menu li.current a.sub {color:#fff; background:#840 url(".$img."drop-arrow.gif) no-repeat right center;;}

#menu :hover ul {left:0; top:40px; width:120px; background:#444;}

/* keep the 'next' level invisible by placing it off screen. */
#menu ul, 
#menu :hover ul ul {position:absolute; left:-9999px; top:-9999px; width:0; height:0; margin:0; padding:0; list-style:none;}

#menu :hover ul :hover ul
{left:120px; top:-1px; background:#222; white-space:nowrap; width:100px; z-index:200; height:auto;}

#menu :hover ul li {margin:0; border-top:1px solid #666;}
#menu :hover ul li a {width:120px; padding:0; text-indent:10px; background:#333; color:#ccc; height:30px; line-height:30px;}
#menu :hover ul li a.fly {background:#333 url(".$img."right-arrow.gif) no-repeat right center;}

#menu :hover ul :hover {background-color:#c60; color:#fff;}
#menu :hover ul :hover a.fly {background-color:#c60; color:#fff;}

#menu :hover ul li.currentsub a {background:#840; color:#fff;}
#menu :hover ul li.currentsub a.fly {background:#840 url(".$img."right-arrow.gif) no-repeat right center; color:#fff;}

#menu :hover ul :hover ul li a {width:100px; padding:0; text-indent:10px; background:#3e3e3e; color:#ccc;}
#menu :hover ul :hover ul :hover {background-color:#d70; color:#fff;}

#menu :hover ul :hover ul li.currentfly a,
#menu :hover ul :hover ul li.currentfly a:hover {background:#840; color:#fff;}";
?>