<?php
namespace producer;
use Connection;
use Pheanstalk_Pheanstalk;

abstract class Producer
{

	private $pheanstalk;

	public function __construct ()
	{
	}

	public function __destruct ()
	{
	}

	public function connectBeanstalk (Connection $connection)
	{
		$this->pheanstalk = new Pheanstalk_Pheanstalk($connection->host, $connection->port, $connection->connectTimeout);
	}

	public function setQueueName ($queueName)
	{
		$this->pheanstalk = $this->pheanstalk->useTube($queueName);
	}

	public abstract function makeJob ($data);

	public function pushJobToQuene ($job)
	{
		$this->pheanstalk->put($job);
	}
}

?>