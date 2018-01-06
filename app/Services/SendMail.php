<?php

namespace TaskProcess\Services;

class SendMail {

	public function fire($job, $data)
	{
        //I send an email to my email address with subject "gearman test" and message whatever comes from gearman
		// mail('vophitruonganh@gmail.com', 'gearman test', $data['message']);
		return phpinfo();
	}

}