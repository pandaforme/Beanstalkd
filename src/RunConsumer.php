<?php
define('ROOT_DIR', dirname(dirname(__FILE__)));
define('CLASS_DIR', 'src/');

require_once ROOT_DIR . '/vendor/autoload.php';

spl_autoload_register(function  ($class_name)
{
	require_once ROOT_DIR . "/src/{$class_name}.php";
});

$connection = getConnection();
$queueName = 'quene1';

$consumer = new consumer\CrawlerConsumer();
$consumer->connectBeanstalk($connection);
$consumer->addToWatchOnlyList($queueName);

while (1)
{
	$job = $consumer->getJob();
	$consumer->executeJob($job);
	$consumer->deleteJob($job);
}

function getConnection ()
{
	$connection = new Connection();
	$connection->host = '127.0.0.1';
	$connection->port = '11300';
	$connection->connectTimeout = null;

	return $connection;
}

?>