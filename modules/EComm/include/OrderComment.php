<?php
include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');

class OrderComment extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('//integer', 'order_nb', 'Order'),
			DBColumn::make('select', 'status', 'Order Status', array("Pending"=>"Pending","Shipped"=>"Shipped","Complete"=>"Complete")),
			DBColumn::make('textarea', 'comment', 'Comment'),
		);
		return new DBTable("ecomm_order_comment", __CLASS__, $cols);
	}
	
	public function getAddEditFormHook($form){
		$form->setConstants( array ( 'order_id' => $this->getOrderNb() ) );
		$form->addElement( 'hidden', 'order_id' );
	}
	
	public static function getAll($orderId=0){
		$sql = 'select `id` from ecomm_order_comment';
		if ($orderId)
			$sql .= " where order_nb = '" . e($orderId) . "'";
		$sql .= " order by id";
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = OrderComment::make($result['id'],'OrderComment');
		}
		return $results;
	}
	static function getQuickFormPrefix() {return 'ordercomment_';}
}
DBRow::init('OrderComment');
