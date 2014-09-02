function showDD() {
		//alert(document.cms.cate.selectedIndex);

if (document.cms.cate.selectedIndex!="") //Hide others drop-down list if myself is selected
{
document.getElementById("pc").style.display='block';
}
else //show drop-down list of others
{
	
document.getElementById("pc").style.display='none';
}
}