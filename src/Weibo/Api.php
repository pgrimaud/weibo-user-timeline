<?php

namespace Weibo;

use GuzzleHttp\Client;
use Weibo\Exception\WeiboException;
use Weibo\Transport\Rss;

class Api
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $userId = '';

    /**
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return Hydrator\Feed
     *
     * @throws WeiboException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFeed()
    {
        if (!$this->userId) {
            throw new WeiboException();
        }

        $rss  = new Rss($this->client, $this->userId);
        $data = $rss->fetch();

        $hydrator = new Hydrator();
        $hydrator->setData($data);

        return $hydrator->getHydratedData();
    }
}
