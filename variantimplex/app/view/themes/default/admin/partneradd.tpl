 <!-- BEGIN: main -->
<div id="content">
 <div id="leftcontent">
          	<div id="leftnav">
          	  <ul>
			  	<li><a href='{HOST}partners/'>Clients List</a></li>
			  </ul>
			</div>
          </div>
            <div id="rightcontent">
            	<div id="admin">
                	<table width="734" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                        <td width="734" class="viewadmintitle">ADD/EDIT CLIENT DETAILS</td>
              	    </tr>
   <tr>
    <td height="6"></td>
  </tr>
  <tr>
    <td align="right"><a href="#javascript:;"></a><a href="#javascript:;"></a></td>
  </tr>
   <tr>
    <td height="6"></td>
  </tr>
  <tr>
    <td>
	<div class='err' style='color:#FF0000' ><table><tr><td width='120px'></td><td>{ERR}</td></tr></table></div>
<form enctype="multipart/form-data" name='cms' id="cms" action='{HOST}partners/add/' method='post'>
  <table>
  	<tr height="29">
  	  <td align='left' width="55">&nbsp;</td>
  	  <td align='left' width="195">Company Name&nbsp;<span style="color:#FF0000">*</span>: <input type="hidden" name="id" id="id" value="{ID}" ></td>
  	  <td align='left' width="468"><input type="text" name="name" id="name" value="{NAME}" style="width:250px" /></td>
	  </tr>
	  <tr height="29">
	    <td align='left'>&nbsp;</td>
  	  <td align='left'>URL&nbsp;<span style="color:#FF0000">*</span>: </td>
  	  <td align='left'><input type="text" name="url" id="url" value="{URL}" style="width:250px" /><br />
                       <span style="color:#999; font-size:11px;">(For eg: http://www.google.co.in/)</span><br /><br />
	  </td>
	  </tr>
     
     {LOGO}
      
	  <tr height="29">
	    <td align='left'>&nbsp;</td>
  	    <td align='left'>Image&nbsp;<span style="color:#FF0000">*</span>: </td>
  	    <td align='left'><input type="file" name="logo" id="logo" style="width:250px"/><br />
                       <span style="color:#999; font-size:11px;">(Only JPG/PNG images are allowed)</span><br />
                       <span style="color:#999; font-size:11px;">(Maximum allowed image size is 2MB)</span>   
      </td>
	  </tr>  	
   <tr>
	<td colspan='3'>&nbsp;
	</td>
	</tr>
  <tr>
	<td colspan='3' align='center'>
		<input type='submit' name='submit' value='Submit' class="button" />&nbsp;&nbsp;&nbsp;<input type='button' name='butn' value='Cancel' onClick="Javascript:document.location.href='{HOST}partners/'" class="button"/>	</td>
 </tr>
  </table>
</form>
 </td>
  </tr>
   <tr>
    <td height="6"></td>
  </tr>
  <tr>
    <td align="right"><a href="#javascript:;"></a></td>
  </tr>
   <tr>
    <td height="6"></td>
  </tr>
</table>

              </div>
            </div>
</div>
 <!-- END: main -->