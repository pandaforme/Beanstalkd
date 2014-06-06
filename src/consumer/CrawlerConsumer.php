<?php
namespace consumer;
use consumer\Consumer;

class CrawlerConsumer extends Consumer
{

	public function executeJob ($job)
	{
		$object = json_decode($job->getData());
		echo $this->getHtml($object->url);
	}

	private function getHtml ($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}

?>