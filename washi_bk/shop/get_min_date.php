<?

require_once('../library/config.php'); 
require_once('../library/functions.php');
 
if(isset($_GET['urgent_id'])){
	  $qr_d =dbQuery("SELECT * FROM tbl_urgent where urgent_id =".$_GET['urgent_id']);
				$rs_d=mysql_fetch_array($qr_d);	
				$urgent_idd = $rs_d['urgent_id'];
				$urgent_date =$rs_d['urgent_date'];

				echo date('Y-m-d', strtotime("+$urgent_date day"));
				}
				
				?>