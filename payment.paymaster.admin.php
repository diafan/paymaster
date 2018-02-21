<?php
/**
 * Настройки платежной системы Paymaster для административного интерфейса
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

class Payment_paymaster_admin
{
	public $config;

	public function __construct()
	{
		$this->config = array(
			"name" => 'Paymaster',
			"params" => array(
				'merchant_id' => 'Идентификатор',
				'secret' => 'Cекретный ключ',
                                'currency' => array('name'=>'Трехбуквенный код валюты','type'=>'text','help'=>'RUB, USD, EUR: https://ru.wikipedia.org/wiki/ISO_4217', 'default'=>'RUB'),
				'test' => array('name' => 'Тестовый режим', 'type' => 'checkbox'),
			)
		);
	}
}