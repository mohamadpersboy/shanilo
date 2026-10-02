<?php

return [

	/* Important Settings */

	// ======================================================================
	// never remove 'web', . just put your middleware like auth or admin (if you have) here. eg: ['web','auth']
	'middlewares' => ['web','auth.admin:admins'],
	// you can change default route from sms-admin to anything you want
	'route' => 'adminforarad/sms-admin',
	// SMS.ir Api Key
	'api-key' => env('SMSIR-API-KEY','7078f760f18628055e8ceb1f'),
	// SMS.ir Secret Key
	'secret-key' => env('SMSIR-SECRET-KEY','b2a9793bb1f4f3e94fb9d70bc7d01a50'),
	// Your sms.ir line number
	'line-number' => env('SMSIR-LINE-NUMBER','30004747475854'),
	// ======================================================================

	// set true if you want log to the database
	'db-log' => false,

	/* Admin Panel Title */
	'title' => 'مدیریت پیامک ها',
	// How many log you want to show in sms-admin panel ?
	'in-page' => '15'
];