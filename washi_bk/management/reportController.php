<html>
<head>
<script src="../library/jquery-1.9.1.js"></script>

</script>
<script>
$(document).ready(function(){
  $("#view").change(function(){
    $("#from").val("เลือกวัน");
  });
});
</script>

</head>
<body>
<select id="view">
<option value="1" selected="selected">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select>

<input type="text" id="from" />
<input type="text" id="to" />
</html>