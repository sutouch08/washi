
<form name="form1" method="post" action="index.php?content=add_customer">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr valign="top">
    <td width="97" height="46">Name</td>
    <td colspan="2">
      <input name="customer_name" type="text" id="customer_name" class="form-control" size="40" required></td>
  </tr>
  <tr valign="top">
    <td height="126">Address</td>
    <td colspan="2">
     
      <textarea name="customer_address" id="customer_address" class="form-control" cols="45" rows="5"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="43">Phone</td>
    <td colspan="2">
      <input name="customer_phone" class="form-control" type="text" id="customer_phone" size="30" required></td>
  </tr>
  <tr valign="top">
    <td height="46">Email</td>
    <td colspan="2">
      <input name="customer_email" type="text" id="customer_email" class="form-control" size="40"></td>
  </tr>
    <tr valign="top">
    <td height="46">Code</td>
    <td colspan="2">
      <input name="customer_code" type="text" id="customer_code" class="form-control" size="40"></td>
  </tr>
</table>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="button" id="button" value="Submit" class="btn btn-primary">Save changes</button>
      </div>
</form>

