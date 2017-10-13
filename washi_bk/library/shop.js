function Shop()
{
	window.location.href = 'index.php';
}
function newOrder()
{
	window.location.href = 'index.php?content=new';
}
function orderList()
{
	window.location.href = 'index.php?content=list';
}

function editOrder()
{
	window.location.href = 'index.php?content=edit';
}

function deleteOrder()
{	
		window.location.href = 'index.php?content=delete';
}
function applyBarcode()
{	
		window.location.href = 'index.php?content=barcode';
}
function applyProductCode(order_id)
{	
		window.location.href = 'index.php?content=apply&order_id='+order_id;
}
function Edit(order_id)
{	
		window.location.href = 'index.php?content=Edit&order_id='+order_id;
}
function backHome()
{
		window.location.href ='index.php';
}
function delete_product_code(detail_id,order_id)
{
		window.location.href='submit_barcode.php?action=delete_code&detail_id='+detail_id+'&order_id='+order_id;
}
function showDetail(order_id)
{
	window.location.href='index.php?content=detail&order_id='+order_id;
}
function newDelivery()
{
	window.location.href='../delivery/index.php?=new';
}