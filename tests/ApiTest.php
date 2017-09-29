<?php
namespace Weibo\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Weibo\Api;
use Weibo\Exception\WeiboException;
use Weibo\Hydrator\Feed;
use Weibo\Hydrator\Item;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $validClient;

    /**
     * @var Client
     */
    private $invalidClient;

    public function setUp()
    {
        $validFixtures = file_get_contents(__DIR__ . '/fixtures/valid_rss.xml');

        $response          = new Response(200, [], $validFixtures);
        $mock              = new MockHandler([$response]);
        $handler           = HandlerStack::create($mock);
        $this->validClient = new Client(['handler' => $handler]);

        $invalidFixtures = file_get_contents(__DIR__ . '/fixtures/invalid_rss.xml');

        $response            = new Response(200, [], $invalidFixtures);
        $mock                = new MockHandler([$response]);
        $handler             = HandlerStack::create($mock);
        $this->invalidClient = new Client(['handler' => $handler]);
    }

    public function testValidRSSReturn()
    {
        $api = new Api($this->validClient);
        $api->setUserId(12345678);
        $feed = $api->getFeed();

        $this->assertInstanceOf(Feed::class, $feed);
    }

    public function testFeedContent()
    {
        $api = new Api($this->validClient);
        $api->setUserId(12345678);
        $feed = $api->getFeed();

        $this->assertInstanceOf(Feed::class, $feed);

        // test feed
        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertSame('pgrimaud 的微博rss', $feed->getTitle());
        $this->assertSame('YOLO', $feed->getDescription());
        $this->assertCount(3, $feed->getItems());
    }

    public function testItemContent()
    {
        $api = new Api($this->validClient);
        $api->setUserId(12345678);
        $feed = $api->getFeed();

        $this->assertInstanceOf(Feed::class, $feed);

        // test first item in feed
        /** @var Item $item */
        $item = $feed->getItems()[0];

        $this->assertInstanceOf(Item::class, $item);

        $this->assertSame('Cute cat in snow and Iron Man : http://t.cn/RtsEHkr :) ​', $item->getTitle());
        $this->assertSame('c56dad8c9faef724e7447b0d40f829a0', $item->getId());
        $this->assertSame('http://weibo.wbdacdn.com/user/6356999361/status4157436061195251.html', $item->getLink());

        $this->assertInstanceOf(\Datetime::class, $item->getDate());
        $this->assertCount(2, $item->getImages());
    }

    public function testInvalidRSSReturn()
    {
        $this->expectException(WeiboException::class);

        $api = new Api($this->invalidClient);
        $api->setUserId(12345678);
        $api->getFeed();
    }

    public function testClientWithoutUserId()
    {
        $this->expectException(WeiboException::class);

        $api = new Api($this->validClient);
        $api->getFeed();
    }

    public function testClientWithInvalidResponseCode()
    {
        $this->expectException(WeiboException::class);

        $response         = new Response(200, [], '');
        $mock             = new MockHandler([$response]);
        $handler          = HandlerStack::create($mock);
        $enmptyBodyClient = new Client(['handler' => $handler]);

        $api = new Api($enmptyBodyClient);
        $api->setUserId(12345678);
        $api->getFeed();
    }
}
