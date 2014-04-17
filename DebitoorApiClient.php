<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 16/04/2014
 * Time: 16:06
 */

namespace Kairos\DebitoorApi;

use Guzzle\Common\Collection;
use Guzzle\Http\Message\Request;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class DebitoorApiClient extends Client
{
    public static function factory($config = array())
    {
        $default = array(
            'ssl' => true
        );

        $required = array('service_definition', 'access_token', 'ssl');

        $config = Collection::fromConfig($config, $default, $required);

        $baseUrl = 'https://invoice.zoho.com';
        $client = new self($baseUrl, $config);


        $filePath = __DIR__ . '/Services/' . $config->get('service_definition') .".json";

        //check if service definition exists
        if(!file_exists($filePath))
            throw new \Exception("Service not found exception, couldn't find service " . $config->get('service_definition'));

        $description = ServiceDescription::factory($filePath);
        $client->setDescription($description);

        if (true === isset($config['access_token'])) {
            $client->getEventDispatcher()->addListener('command.before_prepare', function (\Guzzle\Common\Event $e) use($config) {
                    if (false === $e['command']->hasKey('access_token')) {
                        $e['command']->set('access_token', $config['access_token']);
                    }
                })
            ;
        }

        return $client;
    }

    /**
     * Get right service
     *
     * @param $service
     * @param array $config
     * @return ZohoInvoiceApiClient
     */
    public static function getService($service, $config = array()) {
        return self::factory(array_merge($config, array('service_definition' => $service)));
    }
}