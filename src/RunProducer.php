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

$consumer = new producer\CrawlerProducer();
$consumer->connectBeanstalk($connection);
$consumer->setQueueName($queueName);

while (1)
{
	$crawlerInfo = new CrawlerInfo();
	$crawlerInfo->url = 'tw.yahoo.com';
	$job = $consumer->makeJob($crawlerInfo);
	$consumer->pushJobToQuene($job);
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