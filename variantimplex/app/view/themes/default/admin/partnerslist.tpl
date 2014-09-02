 <!-- BEGIN: main -->
<div id="content">
       	  <div id="leftcontent">
          	<div id="leftnav">
          	  <ul>
			  	<li><a href="{HOST}partners/add/"><span class="links">Add New Client</span></a> </li>
				<li>{CLRRESULT} </li>
			   </ul>
			</div>
          </div>
            <div id="rightcontent">
            	<div id="admin">
                	<table width="734" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                        <td width="734" class="viewadmintitle">CLIENTS LIST </td>
              	    </tr>
   <tr>
    <td height="6"></td>
  </tr>
  <tr>
    <td height="39" align="center" valign="middle" >
	<form name='searchform' id='searchform' method='post' action='{HOST}partners/'>
	<table border="0" cellspacing="5" cellpadding="0" class='searchfield'>
      <tr>
        <td class="tabletl">Client Name</td>
        <td>
          <input type="text" name="name" id="name" value='{NAME}' />
        </td>
		<td class="tabletl">URL</td>
		<td>
          <input type="text" name="url" id="url" value='{URL}'/>
        </td>		
        <td><input type='image' src="{IMAGE}search.gif" alt="search" width="57" height="18" /></td>
      </tr>
    </table>
	</form>
	</td>
  </tr>
   <tr>
    <td height="6"></td>
  </tr>
  <tr>
    <td><blockquote>
      
        <!-- BEGIN: row -->
		<table width="668" border="0" cellspacing="1" cellpadding="0" bgcolor="#c8e4ff" class="tabletl">
          <tr>
            <td width="133" height="25" align="center"><b>Company Logo</b></td>
            <td width="163" align="center"><b>URL</b></td>
            <td align="center"><b>Client Name</b></td>
			<td align="center"><b>Status</b></td>
            <td align="center"><b>Action</b></td>
          </tr>
          <!-- BEGIN: columns -->
		   <tr class="tablewhitebg">
            <td align="left" style="padding-left:10px;" width="133"><img src="{THUMB}{DATA.LOGO}" alt="{DATA.NAME}" title="{DATA.NAME}"  /></td>
            <td align="left" style="padding-left:10px;" width="163" >{DATA.URL}</td>
            <td width="141" align="left" style="padding-left:10px;">{DATA.NAME}</td>
			<td width="119" align="center">{DATA.STATUS}</td>
            <td width="106" align="center">{DATA.EDIT} <span style="vertical-align:top;">|</span> {DATA.DEL}</td>
          </tr>
		  <!-- END: columns -->
		  <tr class="tablewhitebg">
            <td colspan='6'>{NORECORD}</td>
          </tr>
          </table>
		 <!-- END: row -->	 
  
    </blockquote></td>
  </tr>
   <tr>
    <td height="6"></td>
  </tr>
   <tr>
    <td height="6">
		<table class="pages" style='width:669px'><tr><td>{PAGINATION}</td></tr></table>
	</td>
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