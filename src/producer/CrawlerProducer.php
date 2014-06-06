<?php
namespace producer;
use producer\Producer;

class CrawlerProducer extends Producer
{

	public function makeJob ($data)
	{
		return json_encode($data);
	}
}

?>