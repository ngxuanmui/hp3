<?php

/**
 * Class to get content and send email
 * @author Nguyen Xuan Mui
 *
 */
class EmailTemplate
{
	protected $content;

	/**
	 * Get content for email body
	 *
	 * @param string $filename File name
	 * @param array $vars Array variable to replace
	 * @param array $values Array value to replace
	 * @return content replaced
	 */
	function getContent($filename, $values = array())
	{
		$content = file_get_contents($filename);
		
		$values = array_unique($values);
		
		foreach ($values as $key => $val)
		{
			$search[] = '%%' . $key . '%%';
			$replace[] = $val;
		}

		$this->content = str_replace($search, $replace, $content);

		return $this->content;
	}

	/**
	 * Send email to recipient
	 *
	 * @param mix $recipient Recipients (array or string)
	 * @return boolean true or false
	 */
	function send($recipient)
	{
		$mailer = JFactory::getMailer();

		
		$mailer->addRecipient($recipient);

		$subject = 'hello';
		$body = $this->content;

		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);

		$send = $mailer->sendMail('abc@test.com', 'Test mail', $recipient, $subject, $body);
		
		if ( $send !== true ) {
			return false;
		} else {
			return true;
		}
	}
}