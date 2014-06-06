<?php
namespace consumer;
use Connection;
use Pheanstalk_Pheanstalk;

abstract class Consumer
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

	public function addToWatchOnlyList ($queueName)
	{
		$this->pheanstalk = $this->pheanstalk->watchOnly($queueName);
	}

	public function getJob ()
	{
		return $this->pheanstalk->reserve();
	}

	public abstract function executeJob ($job);

	public function deleteJob ($job)
	{
		$this->pheanstalk->delete($job);
	}
}
?>