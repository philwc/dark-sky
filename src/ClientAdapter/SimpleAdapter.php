<?php
declare(strict_types=1);

namespace philwc\DarkSky\ClientAdapter;

use GuzzleHttp\Psr7\Response;
use philwc\DarkSky\Exception\DarkSkyException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class SimpleAdapter
 * @package philwc\DarkSky\ClientAdapter
 */
class SimpleAdapter implements ClientAdapterInterface
{

    /**
     * @param $uri
     * @return ResponseInterface
     * @throws DarkSkyException
     */
    public function get($uri): ResponseInterface
    {
        $body = file_get_contents($uri);

        $parsedHeaders = [];
        $statusCode = 0;

        if ($http_response_header === null) {
            throw  new DarkSkyException('Missing http response headers.');
        }

        foreach ($http_response_header as $header) {
            $headerParts = explode(':', $header, 2);
            if (isset($headerParts[1])) {
                $parsedHeaders[trim($headerParts[0])] = trim($headerParts[1]);
                continue;
            }

            $parsedHeaders['Response-Code'] = $header;
            $matches = [];
            if (preg_match("#HTTP/[\d\.]+\s+([\d]+)#", $header, $matches)) {
                $statusCode = $matches[1];
            }
        }

        return new Response($statusCode, $parsedHeaders, $body);
    }
}
