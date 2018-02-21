<?php

/**
 * Обработка данных, полученных от системы Paymaster
 * 
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */
if (!defined('DIAFAN')) {
    $path = __FILE__;
    $i = 0;
    while (!file_exists($path . '/includes/404.php')) {
        if ($i == 10)
            exit;
        $i++;
        $path = dirname($path);
    }
    include $path . '/includes/404.php';
}

if (!isset($_POST['LMI_MERCHANT_ID']) || !isset($_POST['LMI_PAYMENT_NO']) || preg_match('/^\d+$/', $_POST['LMI_PAYMENT_NO']) != 1) {
    Custom::inc('includes/404.php');
}

$pay = $this->diafan->_payment->check_pay($_POST['LMI_PAYMENT_NO'], 'paymaster');

// проверка валидности запроса
if ($_GET["rewrite"] == "paymaster/notification") {


    File::save_file(serialize($_POST), 'tmp/pm' . time() . '_' . rand(0, 999));


    $keys = explode(", ", "LMI_MERCHANT_ID, LMI_PAYMENT_NO, LMI_SYS_PAYMENT_ID, LMI_SYS_PAYMENT_DATE, LMI_PAYMENT_AMOUNT, LMI_CURRENCY, LMI_PAID_AMOUNT, LMI_PAID_CURRENCY, LMI_PAYMENT_SYSTEM, LMI_SIM_MODE");

    $values = array();
    foreach ($keys as $key) {
        $values[] = (!empty($_POST[$key]) ? $_POST[$key] : "");
    }

    $values[] = $pay["params"]['secret'];
    $hash = base64_encode(hash('sha256', implode(';', $values), true));



    if ($pay["summ"] != $_POST['LMI_PAYMENT_AMOUNT'] || $_POST['LMI_MERCHANT_ID'] != $pay["params"]['merchant_id'] || $_POST['LMI_HASH'] != $hash) {
        Custom::inc('includes/404.php');
    }
    $this->diafan->_payment->success($pay, 'pay');

    exit;
}

// оплата прошла успешно
if ($_GET["rewrite"] == "paymaster/success") {
    $this->diafan->_payment->success($pay, 'redirect');
}

$this->diafan->_payment->fail($pay);
