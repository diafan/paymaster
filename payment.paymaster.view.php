<?php
/**
 * Шаблон платежа через систему Paymaster
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

echo $result["text"];



echo '<form id="pay" name="pay" method="POST" action="https://paymaster.ru/Payment/Init">
<b>'.$this->diafan->_('Платеж на %d %s.', false, $result["summ"], $result['currency']).'</b> &nbsp;';

foreach($result as $k => $v) {
    if(false === strpos($k, "LMI_")) { continue; }
    echo '<input type="hidden" name="'.$k.'" value="'.$v.'">';
}

echo '<p><input type="submit" value="'.$this->diafan->_('Оплатить', false).'"></p>
</form>';