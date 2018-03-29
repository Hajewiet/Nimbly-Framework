<?php

/**
 * @doc `[email recipient@ema.il subject="test email" tpl="welcome_email"]` sends an email using email template `welcome_email`
 */
function email_sc($params) {
	email(array(
		'recipient' => get_param_value($params, 'recipient', current($params)),
		'subject' => get_param_value($params, 'subject'),
		'tpl' => get_param_value($params, 'tpl')));
}

function email($email_data) {

	if (empty($email_data['recipient'])) {
		throw new Exception('Email field "recipient" not set');
		return false;
	}

	if (empty($email_data['subject']) || empty($email_data['tpl']) || ($tpl = find_template($email_data['tpl'])) === false) {
		throw new Exception('Email subject not set or template not found');
		return false;
	}

	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	$recipient = is_array($email_data['recipient'])? implode(',', $email_data['recipient']) : $email_data['recipient'];

	if (!empty($email_data['from'])) {
		$headers[] = sprintf('From: %s', $email_data['from']);
	}

	if (!empty($email_data['cc'])) {
		$cc = is_array($email_data['cc'])? implode(',', $email_data['cc']) : $email_data['cc'];
		$headers[] = sprintf('Cc: %s', $cc);
	}

	if (!empty($email_data['bcc'])) {
		$bcc = is_array($email_data['bcc'])? implode(',', $email_data['cc']) : $email_data['bcc'];
		$headers[] = sprintf('Bcc: %s', $bcc);
	}

	load_library("set");
	if(@mail($recipient, $email_data['subject'], run_buffered($tpl), implode("\r\n", $headers))) {
		set_variable("email.result", "email sent");
		return true;
	} else {
		load_library("log");
		load_library("set");
		set_variable("email.result", "error: email not sent");
		log_system("Error: email not sent");
		return false;
	}
}
