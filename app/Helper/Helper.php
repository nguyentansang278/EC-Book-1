<?php

if (!function_exists('format_currency')) {
    /**
     * Định dạng số thành dạng tiền tệ
     *
     * @param float $amount
     * @param string $currency
     * @return string
     */
    function format_currency($amount)
    {
        return number_format($amount, 0, '.', ',');
    }
}

if (!function_exists('remove_null_params')) {
    function remove_null_params(array $params)
    {
        return array_filter($params, function($value) {
            return !is_null($value);
        });
    }
}

if (!function_exists('printr')) {
	function printr($data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		die(); // Dừng chương trình, tương tự dd()
	}
}
