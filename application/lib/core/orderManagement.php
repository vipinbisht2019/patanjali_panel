<?php

class orderManagement extends dbclass
{
	public function detail($id)
	{
	    $query = "SELECT orders.*,u.name as userName,u.mobile as userMobile,u.user_role_id as userRoleId,u.dealerCode FROM  orders  JOIN users u ON u.id= orders.user_id WHERE order_id=$id";

	    
		return $this->fetchRow($query);
	}
	
	public function disPatchQty($id,$itemid)
	{
	   $dispatchQuery = "SELECT sum(dispatch_qty) as dispatchQTY FROM order_items_dispatch WHERE order_item_id=$itemid and order_id=$id";
	   return $this->fetchRow($dispatchQuery);
	}
	
	
	public function disPatchOrderDetail($id)
	{
	   $dispatchOrderQuery = "SELECT oid.*,oi.item_product_id FROM order_items_dispatch oid JOIN order_items oi ON oi.item_id=oid.order_item_id WHERE oid.order_id=$id";
	   return $this->fetchResult($dispatchOrderQuery);
	}
	
	
	public function orderItems($id)
	{
	    $query = "SELECT oi.item_product_id,oi.item_qty,oi.item_id FROM orders o JOIN order_items oi ON oi.order_id=o.order_id WHERE o.order_id=$id";
		return $this->fetchResult($query);
	}

	public function add($data)
	{
		return $this->_insert('orders', $data);
	}

	public function update($id, $data)
	{
		return $this->_update('orders', $data, array('order_id' => $id));
	}
	
	public function dispatchUpdate($id, $data)
	{
		return $this->_insert('order_items_dispatch', $data );
	}

	public function delete($id)
	{
		$query = "DELETE FROM orders WHERE order_id=$id";
		$this->_query($query);
		
		$query = "DELETE FROM order_items WHERE order_id=$id";
		$this->_query($query);
		
		$dispatchQuery = "DELETE FROM order_items_dispatch WHERE order_id=$id";
		return $this->_query($dispatchQuery);
	}

	public function getList($filter)
	{


		$query = "SELECT orders.*,u.name as userName,u.mobile as userMobile,u.user_role_id as userRoleId,u.dealerCode FROM  orders  JOIN users u ON u.id= orders.user_id WHERE 1";

		if (!empty($filter['transactionIdFilter']))
			$query .= " AND orders.order_id=" . $filter['transactionIdFilter'];

		if (!empty($filter['mobileFilter']))
			$query .= " AND u.mobile='" . $filter['mobileFilter'] . "' ";

		if (!empty($filter['paymentStatus']))
			$query .= " AND orders.payment_status='" . $filter['paymentStatus'] . "' ";

		if (!empty($filter['orderStatusFilter']))
			$query.=" AND orders.order_status='".$filter['orderStatusFilter']."' ";

		
		if (!empty($filter['orderDateFilterFrom']) && !empty($filter['orderDateFilterTo'])) :
			 $requestDateFrom = $filter['orderDateFilterFrom'];
			 $requestDateTo = $filter['orderDateFilterTo'];
			$query.=" AND orders.order_date >= '$requestDateFrom 00:00:00' AND  orders.order_date <= '$requestDateTo 23:59:59'";
        else:
		    if (!empty($filter['orderDateFilterFrom'])){
			    $requestDateFrom = $filter['orderDateFilterFrom'];
			    $query.=" AND orders.order_date  >= '$requestDateFrom 00:00:00' ";
	    	}
		endif;


		$query .= " ORDER BY orders.order_id DESC"; 


		return $this->fetchResult($query);
	}
	
	public function getDistributorList(){
	    
	    $query = "SELECT id,name,dealerCode FROM users WHERE user_role_id=2";
		return $this->fetchResult($query);
	    
	}
	
	public function getUserData($userId){
	    
	    $query = "SELECT id,name,dealerCode,mobile FROM users WHERE id=".$userId;
		return $this->fetchResult($query);
	    
	}
}
