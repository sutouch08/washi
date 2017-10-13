function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write(
		'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
		'<td class="td" valign="top">' +

		'<h3>เริ่มต้นระบบ</h3>' +
		'<ul>' +/*
			'<li><a href="'+base+'index.php?content=login">การเข้าใช้ระบบ</a></li>' +
			'<li><a href="'+base+'index.php?content=pre_data">การเตรียมข้อมูล สำหรับเริ่มต้นระบบ</a></li>' +
			'<li><a href="'+base+'index.php?content=profile">สร้างโปรไฟล์</a></li>' +
			'<li><a href="'+base+'index.php?content=permission">กำหนดสิทธิ์</a></li>' +
			'<li><a href="'+base+'index.php?content=employee">เพิ่ม/แก้ไข พนักงาน</a></li>' +
			'<li><a href="'+base+'index.php?content=sale">เพิ่ม/แก้ไข พนักงานขาย</a></li>' +
			'<li><a href="'+base+'index.php?content=warehouse">เพิ่ม/แก้ไข คลังสินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=zone">เพิ่ม/แก้ไข โซนสินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=color">เพิ่ม/แก้ไข สี</a></li>' +
			'<li><a href="'+base+'index.php?content=size">เพิ่ม/แก้ไข ไซด์</a></li>' +
			'<li><a href="'+base+'index.php?content=attribute">เพิ่ม/แก้ไข คุณลักษณะ</a></li>' +
			'<li><a href="'+base+'index.php?content=category">เพิ่ม/แก้ไข หมวดหมู่สินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=product">เพิ่ม/แก้ไข สินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=customer_group">เพิ่ม/แก้ไข กลุ่มลูกค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=customer">เพิ่ม/แก้ไข ลูกค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=setting">กำหนดค่าต่างๆ</a></li>' +*/
		'</ul>' +
		
		'</td><td class="td_sep" valign="top">' +

		'<h3>หน้าร้าน</h3>' +
		'<ul>' +
			'<li><a href="'+base+'index.php?content=order">เพิ่ม ออเดอร์</a></li>' +
			'<li><a href="'+base+'index.php?content=delete_order">ลบ ออเดอร์</a></li>' +
			'<li><a href="'+base+'index.php?content=change_status">เปลี่ยนสถานะ ออเดอร์</a></li>' +
			'<li><a href="'+base+'index.php?content=add_customer">เพิ่ม/แก้ไข ลูกค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=package">การขายแพ็คเกจ</a></li>' +
			'<li><a href="'+base+'index.php?content=send_order">การส่งสินค้าไปโรงงาน</a></li>' +
			'<li><a href="'+base+'index.php?content=return_order">การรับสินค้าคืนจากโรงงาน</a></li>' +
			'<li><a href="'+base+'index.php?content=finished_order">การส่งสินค้าคืนลูกค้า</a></li>' +
		'</ul>' +
		/*
		
		'<h3>คลังสินค้า</h3>' +
		'<ul>' +
			'<li><a href="'+base+'index.php?content=receive_product">รับสินค้าเข้า</a></li>' +
			'<li><a href="'+base+'index.php?content=return_product">รับคืนสินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=requisition">เบิกสินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=lend">ยืมสินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=transfer">โอนสินค้าระหว่างคลัง</a></li>' +
			'<li><a href="'+base+'move_zone">ย้ายพื้นที่จัดเก็บ</a></li>' +
			'<li><a href="'+base+'index.php?content=stock_check">ตรวจนับสินค้า(เปรียบเทียบยอด)</a></li>' +
			'<li><a href="'+base+'index.php?content=adjust">ปรับปรุงยอดสินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=warehouse">เพิ่ม/แก้ไข คลังสินค้า</a></li>' +
			'<li><a href="'+base+'index.php?content=zone">เพิ่ม/แก้ไข โซนสินค้า</a></li>' +
		'</ul>' + 
		*/

		'</td><td class="td_sep" valign="top">' +
		
		'<h3>โรงงาน</h3>' +
		/*
		'<ul>' +
		'<li><a href="'+base+'index.php?content=order">ออเดอร์</a></li>' +
		'<li><a href="'+base+'index.php?content=prepare">การจัดสินค้า</a></li>' +
		'<li><a href="'+base+'index.php?content=qc">การตรวจสินค้า</a></li>' +
		'<li><a href="'+base+'index.php?content=bill">การเปิดบิล</a></li>' +
		'<li><a href="'+base+'index.php?content=sponsor">สปอนเซอร์</a></li>' +
		'<li><a href="'+base+'index.php?content=consign">ฝากขาย</a></li>' +
		'</ul>' +
		*/
		/*
		'<h3>Class Reference</h3>' +
		'<ul>' +
		'<li><a href="'+base+'libraries/benchmark.html">Benchmarking Class</a></li>' +
		'<li><a href="'+base+'libraries/calendar.html">Calendar Class</a></li>' +
		'<li><a href="'+base+'libraries/cart.html">Cart Class</a></li>' +
		'<li><a href="'+base+'libraries/config.html">Config Class</a></li>' +
		'<li><a href="'+base+'libraries/email.html">Email Class</a></li>' +
		'<li><a href="'+base+'libraries/encryption.html">Encryption Class</a></li>' +
		'<li><a href="'+base+'libraries/file_uploading.html">File Uploading Class</a></li>' +
		'<li><a href="'+base+'libraries/form_validation.html">Form Validation Class</a></li>' +
		'<li><a href="'+base+'libraries/ftp.html">FTP Class</a></li>' +
		'<li><a href="'+base+'libraries/table.html">HTML Table Class</a></li>' +
		'<li><a href="'+base+'libraries/image_lib.html">Image Manipulation Class</a></li>' +
		'<li><a href="'+base+'libraries/input.html">Input Class</a></li>' +
		'<li><a href="'+base+'libraries/javascript.html">Javascript Class</a></li>' +
		'<li><a href="'+base+'libraries/loader.html">Loader Class</a></li>' +

		'</ul>' +
		*/

		'</td><td class="td_sep" valign="top">' +

		'<h3>บริหาร</h3>' +
		/*
		'<ul>' +
		'<li><a href="'+base+'libraries/caching.html">Caching Class</a></li>' +
		'<li><a href="'+base+'database/index.html">Database Class</a></li>' +
		'<li><a href="'+base+'libraries/javascript.html">Javascript Class</a></li>' +
		'</ul>' +

		'<h3>Helper Reference</h3>' +
		'<ul>' +
		'<li><a href="'+base+'helpers/array_helper.html">Array Helper</a></li>' +
		'<li><a href="'+base+'helpers/captcha_helper.html">CAPTCHA Helper</a></li>' +
		'<li><a href="'+base+'helpers/cookie_helper.html">Cookie Helper</a></li>' +
		'<li><a href="'+base+'helpers/date_helper.html">Date Helper</a></li>' +
		'<li><a href="'+base+'helpers/directory_helper.html">Directory Helper</a></li>' +
		'<li><a href="'+base+'helpers/download_helper.html">Download Helper</a></li>' +
		'<li><a href="'+base+'helpers/email_helper.html">Email Helper</a></li>' +
		'<li><a href="'+base+'helpers/file_helper.html">File Helper</a></li>' +
		'<li><a href="'+base+'helpers/form_helper.html">Form Helper</a></li>' +
		'<li><a href="'+base+'helpers/html_helper.html">HTML Helper</a></li>' +
		
		'</ul>' +
		*/

		'</td></tr></table>');
}