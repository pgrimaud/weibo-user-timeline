<?php
namespace Weibo;

use Weibo\Hydrator\Feed;
use Weibo\Hydrator\Item;

class Hydrator
{
    /**
     * @var \SimpleXMLElement
     */
    private $data;

    /**
     * @param $data
     */
    public function setData(\SimpleXMLElement $data)
    {
        $this->data = $data;
    }

    /**
     * @return Feed
     */
    public function getHydratedData()
    {
        $feed = $this->generateFeed();

        foreach ($this->data->channel->item as $xmlItem) {
            $item = new Item();

            $item->setItemId(md5((string)$xmlItem->pubDate));

            $date = new \DateTime((string)$xmlItem->pubDate);
            $item->setDate($date);

            $item->setTitle((string)$xmlItem->title);

            // clean link
            $xpl = explode('#', (string)$xmlItem->link);
            $item->setLink($xpl[0]);

            // get image in description
            $doc = new \DOMDocument();
            $doc->loadHTML((string)$xmlItem->description);
            $imageTags = $doc->getElementsByTagName('img');

            $images = [];

            /** @var \DOMElement $tag */
            foreach ($imageTags as $tag) {
                $images[] = str_replace('http:', 'https:', $tag->getAttribute('src'));
            }

            $item->setImages($images);

            $feed->addItem($item);
        }

        return $feed;
    }

    /**
     * @return Feed
     */
    private function generateFeed()
    {
        $feed = new Feed();
        $feed->setTitle((string)$this->data->channel->title);
        $feed->setDescription((string)$this->data->channel->description);

        return $feed;
    }
}
