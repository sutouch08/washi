<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
</HEAD>

<BODY>

<SCRIPT Language="JavaScript">

function startCalc(){ 
interval = setInterval("calc()",1); 
} 
function calc(){ 
one = document.autoSumForm.target.value; 
two = document.autoSumForm.sumassess.value; 

document.autoSumForm.gap.value = (one) - (two); 
} 
function stopCalc(){ 
clearInterval(interval); 
} 
</SCRIPT>

<div style="width: 200px; text-align: center;"> 
<form name="autoSumForm"> 

<table width="685" border="0">
<tr>
<td><div align="left">target</div></td>
<td><div align="left">&nbsp;&nbsp; sumassess</div></td>
<td><div align="left">&nbsp;&nbsp; GAP</div></td>
</tr>
<tr>
<td width="144">
<div align="left">
<input class="right" type=text name="target" value="" onFocus="startCalc();" onBlur="stopCalc();">
</div></td>
<td width="159"><div align="left">-
<input class="right" type=text name="sumassess" value="" onFocus="startCalc();" onBlur="stopCalc();">
</div></td>
<td width="368"><div align="left">=
<input class="right" type=text name="gap">
</div></td>
</tr>
</table>
<p>&nbsp;</p>
</form> 
</div> 
</BODY>
</HTML>

