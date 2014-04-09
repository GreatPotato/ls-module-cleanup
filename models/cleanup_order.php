<?php

class CleanUp_Order
{	

	public static function delete()
	{	
		$status = Shop_OrderStatus::create()->find_by_code('new');
		$settings = Core_ModuleSettings::create('cleanup', 'cleanup');
		
		if($settings->delete_method === 'delete_permanently')
		{
			$time = new DateTime("- $settings->order_age hours");
			
			$orders = Shop_Order::create()->where('status_id = ?', $status->id)->where('payment_processed is null')->where('order_datetime < ?', $time->format('Y-m-d H:i:s'))->find_all();
			
			if($orders->count) {
				foreach($orders as $order)
					$order->delete();
					
				traceLog("$orders->count orders were deleted permanently", 'CLEANUP');
			}
		}
		else
		{	
			$time = new DateTime("- $settings->order_age hours");

			$orders = Shop_Order::create()->where('status_id = ?', $status->id)->where('payment_processed is null')->where('deleted_at is null')->where('order_datetime < ?', $time->format('Y-m-d H:i:s'))->find_all();
			
			if($orders->count) {
				foreach($orders as $order)
					$order->delete_order();
					
				traceLog("$orders->count orders were marked as deleted", 'CLEANUP');
			}
			
		}
		
	}

}