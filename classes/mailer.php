<?php
class Mail
{
	private $mailer;
	private $receiver;
	private $subject;
	private $message;
	private $verificationCode;
  private $sent = false;
	function __construct($mailer = '', $receiver = '', $subject = '', $message = '')
	{
		$this->mailer = $mailer;
		$this->receiver = $receiver;
		$this->subject = $subject;
		$this->message = $message;
	}
	public function setMailer($mailer)
	{
		$this->mailer = $mailer;
	}

	public function setReceiver($receiver)
	{
		$this->receiver = $receiver;
	}

	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function emailPerson()
	{
		$headers = "From: nate.gg <$this->mailer>\r\n";
		$headers.= "MIME-Version: 1.0\r\n";
		$headers.= "Content-type: text/html;charset=UTF-8\r\n";
		$headers.= "Reply-To: $this->mailer\r\n";

		$result = mail($this->receiver, $this->subject, $this->message, $headers);
		if($result)
		{
      $this->sent = true;
      return true;
		}
		else {
			return false;
		}
	}
}
?>
