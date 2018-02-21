<?php
/**
 * Формирует данные для формы платежной системы Paymaster
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

class Payment_paymaster_model extends Diafan
{
	/**
     * Формирует данные для формы платежной системы "Paymaster"
     * 
     * @param array $params настройки платежной системы
     * @param array $pay данные о платеже
     * @return array
     */
	public function get($params, $pay)
	{
		$result["text"]      = $pay["text"];
		$result["LMI_PAYMENT_DESC"]      = $pay["desc"];
		$result["LMI_PAYMENT_DESC_BASE64"] = base64_encode($pay["desc"]);
		$result["LMI_MERCHANT_ID"] = $result["LMI_SHOP_ID"] =  $params["merchant_id"];
                $result["LMI_CURRENCY"] = $result['currency'] = $params['currency'];
		
		$result["summ"]  = $result["LMI_PAYMENT_AMOUNT"] = $pay["summ"];
                
                
		$result["LMI_PAYMENT_NO"]  = $pay["id"];

		// режим тестирования:
		//  0 или не отсутствует: Для всех тестовых платежей сервис будет имитировать успешное выполнение;
		//  1: Для всех тестовых платежей сервис будет имитировать выполнение с ошибкой (платеж не выполнен);
		//  2: Около 80% запросов на платеж будут выполнены успешно, а 20% - не выполнены.
		if(!  empty($params["test"]))
		{
			$result["LMI_SIM_MODE"] = 2;
		}
		return $result;
	}
}