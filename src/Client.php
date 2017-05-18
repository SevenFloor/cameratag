<?php
namespace cameratag;

use cameratag\response\VideoObject;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

/**
 * Class Client
 * @package cameratag
 */
class Client
{
    /**
     *
     */
    const METHOD_GET = 'GET';

    /**
     *
     */
    const METHOD_POST = 'POST';

    /**
     * @var string
     */
    protected $baseUrl = 'https://cameratag.com/api';

    /**
     * @var
     */
    protected $token;

    /**
     * @var array
     */
    protected $httpOptions = [];

    /**
     * @var string
     */
    protected $version = 'v11';


    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->httpClient = new \GuzzleHttp\Client();
        foreach ($config as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * GET https://cameratag.com/api/v11/apps/[YOUR_APP_UUID]/assets.json
     * @param $app_uuid
     * @return array
     */
    public function listAssets($app_uuid)
    {
        $url = $this->baseUrl . '/' . $this->version . '/apps/' . $app_uuid . '/assets.json?api_key=' . $this->token;
        $response = $this->query($url);
        $result = [];
        foreach ($response as $item) {
            $result[] = $this->populate(new VideoObject(), $item);
        }
        return $result;
    }

    /**
     * GET https://cameratag.com/api/v11/assets/[YOUR_ASSET_UUID].json
     *
     */
    public function showAsset($asset_uuid)
    {
        $url = $this->baseUrl . '/' . $this->version . '/assets/' . $asset_uuid . '.json?api_key=' . $this->token;
        $response = $this->query($url);
        return $this->populate(new VideoObject(), $response);
    }

    /**
     * PUT https://cameratag.com/api/v11/assets/[YOUR_ASSET_UUID].json
     * @param $asset_uuid
     * @param array $params
     */
    public function updateAsset($asset_uuid, array $params)
    {
        // implement logic
    }

    /**
     * DELETE https://cameratag.com/api/v11/assets/[YOUR_ASSET_UUID].json
     * @param $asset_uuid
     */
    public function deleteAsset($asset_uuid)
    {
        // implement logic
    }

    /**
     * Requests API.
     *
     * @param string $uri
     * @param array $params
     *
     * @param string $method
     *
     * @return array
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    protected function query($uri, array $params = [], $method = self::METHOD_GET)
    {
        $request = new Request($method, $uri, [
            'Content-Type' => 'application/json',
            'api_key' => $this->token,
        ], 0 < count($params) ? json_encode($params) : null);
        $response = $this->httpClient->send($request, $this->httpOptions);
        $result = json_decode($response->getBody(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Error parsing response: ' . json_last_error_msg());
        }
        if (empty($result)) {
            throw new RuntimeException('Empty result');
        }
        return $result;
    }


    /**
     * Prepares URI for the request.
     *
     * @param string $endpoint
     * @return string
     */
    protected function prepareUri($endpoint)
    {
        return $this->baseUrl . '/' . $this->version . '/' . $endpoint;
    }


    /**
     * @param response\AbstractResponse $object
     * @param array $data
     * @return response\AbstractResponse
     */
    protected function populate(\cameratag\response\AbstractResponse $object, array $data)
    {
        $reflect = new ReflectionClass($object);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            if (array_key_exists($property->name, $data)) {
                $object->{$property->name} = $this->getValueByAnnotatedType($property, $data[$property->name]);
            }
        }
        return $object;
    }

    /**
     * Guesses and converts property type by phpdoc comment.
     *
     * @param ReflectionProperty $property
     * @param  mixed $value
     * @return mixed
     */
    protected function getValueByAnnotatedType(ReflectionProperty $property, $value)
    {
        $comment = $property->getDocComment();
        if (preg_match('/@var (.+?)(\|null)? /', $comment, $matches)) {
            switch ($matches[1]) {
                case 'integer':
                case 'int':
                    $value = (int)$value;
                    break;
                case 'float':
                    $value = (float)$value;
                    break;
            }
        }
        return $value;
    }


}