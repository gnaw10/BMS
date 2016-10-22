<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FuncController extends Controller
{
    public static function Success($response)
    {
        return json_encode(array(
		'code' => '0000',
		'response' => json_decode($response, true)
	));
    }

    public static function Error($code, $errorMsg) {
	return json_encode(array(
		'code' => $code,
		'errorMsg' => $errorMsg
	));
}

    public static function  handle($response) {
	header('Content-type: application/json');
	$code = substr($response, 0, 4);
	$msg = substr($response, 4);
	if($code === '0000') return FuncController::Success($msg);
	else {
		if($msg == '') {
			switch (substr($code, 0, 2)) {
				case ERROR_SYSTEM:
					$msg = 'System Error.';
					break;
				case ERROR_INPUT:
					$msg = 'Wrong Input.';
					break;
				case ERROR_PERMISSION:
					$msg = 'Permission Denied.';
					break;
				default:
					$msg = 'Error.';
					break;
			}
		}
		ERROR($code, $msg);
	}
}

}