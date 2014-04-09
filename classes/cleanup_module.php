<?php

class CleanUp_Module extends Core_ModuleBase
{
	/**
	 * Generate the module information
	 * 
	 * @access protected
	 * @return Core_ModuleInfo
	 */
	protected function createModuleInfo()
	{
		return new Core_ModuleInfo(
			'Clean-up',
			'Automatically deletes unpaid orders',
			'Aaron Hodges'
		);
	}
	
	
	public function register_access_points()
	{
		return array(
			'cleanup' => 'cleanup'
		);
	}
	
	
	public function listSettingsForms()
	{
		return array(
			'cleanup' => array(
				'icon' => '/modules/cleanup/resources/images/cleanup.png',
				'title' => 'Clean-Up',
				'description' => 'Cleans up redundant data from LemonStand installation',
				'sort_id' => 1000,
				'section' => 'System'
			)
		);
	}
	
	 
	public function buildSettingsForm($model, $form_code)
	{
		switch ($form_code)
		{
			case 'cleanup':
				$model->add_field('delete_method', 'Delete method', 'left', db_varchar)->comment('Please select how the orders should be deleted')->renderAs(frm_dropdown)->tab('Orders');
				$model->add_field('order_age', 'Order age', 'right', db_number)->comment('Enter the number of hours old an order should be before it is deleted')->tab('Orders');
			break;
		}
	}
	
	
	public function initSettingsData($model, $form_code)
	{
		if ($form_code == 'cleanup') {
			$model->order_age = 168;
			$model->delete_method = 'mark_as_deleted';
		}
	}
	
	
	public function getSettingsFieldOptions($model, $form_code, $field_code)
	{
		if ($form_code == 'cleanup') {
			if ($field_code == 'delete_method')
				return array(
					'mark_as_deleted' => 'Mark As Deleted',
					'delete_permanently' => 'Delete Permanently'
				);
		}
	}
	
	
	public function cleanup()
	{
		if (Core_CronManager::access_allowed())
		{
			try
			{
				CleanUp_Order::delete();
			}
			catch (Exception $ex)
			{
				echo $ex->getMessage();
			}
		}
	}
	
}