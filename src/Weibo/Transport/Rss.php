<?php
namespace Weibo\Transport;

use GuzzleHttp\Client;
use Weibo\Exception\WeiboException;

class Rss
{
    const WEIBO_ENDPOINT = 'http://rss.weibodangan.com/weibo/rss/';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * FetchRss constructor.
     * @param Client $client
     * @param $userId
     */
    public function __construct(Client $client, $userId)
    {
        $this->client   = $client;
        $this->endpoint = self::WEIBO_ENDPOINT . $userId;
    }

    /**
     * @return \SimpleXMLElement
     * @throws WeiboException
     */
    public function fetch()
    {
        $client = new Client();
        $res    = $client->request('GET', $this->endpoint, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]
        ]);

        if ($res->getStatusCode() === 200) {

            libxml_use_internal_errors(true);
            $sxe = simplexml_load_string((string)$res->getBody());

            if (!$sxe) {
                foreach (libxml_get_errors() as $error) {
                    $message = str_replace("\n", '', $error->message);
                    throw new WeiboException($message . ' (Probably invalid userId)');
                }
            }

            $xml = new \SimpleXMLElement($res->getBody());
            return $xml;
        } else {
            throw new WeiboException('Impossible to retrieve formatted endpoint');
        }
    }
}