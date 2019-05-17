<?php

namespace Goalandfrance\AlpiaImport\Helper\Api;

use Goalandfrance\AlpiaImport\Helper\Api\Result\AbstractResult;
use Goalandfrance\AlpiaImport\Helper\Api\Result\BooleanResult;
use Goalandfrance\AlpiaImport\Helper\Api\Result\StatusResult;
use Goalandfrance\AlpiaImport\Helper\Api\Result\HistoryDetailsResult;
use Goalandfrance\AlpiaImport\Helper\Api\Result\HistoryListResult;
use Goalandfrance\AlpiaImport\Helper\Api\Result\MappingResult;
use Goalandfrance\AlpiaImport\Helper\Api\Result\VersionResult;
use Goalandfrance\AlpiaImport\Helper\Config;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Helper\AbstractHelper;

class Api extends AbstractHelper
{
    const S_METHOD_POST = "POST";
    const S_METHOD_GET = "GET";
    const S_METHOD_PUT = "PUT";
    const S_METHOD_DELETE = "DELETE";

    /**
     * API base Url
     *
     * @var string
     */
    private $apiUrl = "";

    /**
     * API app key
     *
     * @var string
     */
    private $applicationKey = "";

    /**
     * API user key
     *
     * @var string
     */
    private $userKey = "";
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Context
     */
    private $context;

    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    private $_objectManager;

    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);

        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $config = $this->_objectManager->create('Goalandfrance\AlpiaImport\Helper\Config');

        $this->apiUrl = $config->getApiUrl();
        $this->applicationKey = $config->getApplicationKey();
        $this->userKey = $config->getUserKey();
        $this->config = $config;
        $this->context = $context;
    }

    /**
     * @return VersionResult
     */
    public function getVersion()
    {
        $result = $this->_objectManager->create('\Goalandfrance\AlpiaImport\Helper\Api\Result\VersionResult');

        return $this->read($result, ["version"]);
    }

    /**
     * @return MappingResult
     */
    public function getMappingList()
    {
        $result = $this->_objectManager->create('\Goalandfrance\AlpiaImport\Helper\Api\Result\MappingResult');

        return $this->read($result, ["magento", "mapping"], ["magento_url" => $this->config->getBaseUrl()]);
    }

    /**
     * @return HistoryListResult
     */
    public function getHistoryList()
    {
        $result = $this->_objectManager->create('\Goalandfrance\AlpiaImport\Helper\Api\Result\HistoryListResult');

        $mappingId = $this->config->getMappingId();
        if ($mappingId > 0) {
            $this->read($result, ["magento", "history"], ["magento_url" => $this->config->getBaseUrl(), "mapping_id" => $mappingId]);
        } else {
            $result->setSuccess(false);
            $result->setMessage(__('Configuration is not complete: no mapping defined.'));
        }

        return $result;
    }

    /**
     * @return BooleanResult
     */
    public function export()
    {
        $result = $this->_objectManager->create('\Goalandfrance\AlpiaImport\Helper\Api\Result\BooleanResult');

        $mappingId = $this->config->getMappingId();
        if ($mappingId > 0) {
            $this->read($result, ["magento", "export"], ["mapping_id" => $mappingId]);
        } else {
            $result->setSuccess(false);
            $result->setMessage(__('Configuration is not complete: no mapping defined.'));
        }

        return $result;
    }

    /**
     * @param int $id
     * @return HistoryDetailsResult
     */
    public function getHistoryDetails($id)
    {
        $result = $this->_objectManager->create('\Goalandfrance\AlpiaImport\Helper\Api\Result\HistoryDetailsResult');

        $mappingId = $this->config->getMappingId();
        if ($mappingId > 0) {
            $this->read($result, ["magento", "history", $id], ["mapping_id" => $mappingId]);
        } else {
            $result->setSuccess(false);
            $result->setMessage(__('Configuration is not complete: no mapping defined.'));
        }

        return $result;
    }

    /**
     * @return StatusResult
     */
    public function getStatus()
    {
        $result = $this->_objectManager->create('\Goalandfrance\AlpiaImport\Helper\Api\Result\StatusResult');

        $mappingId = $this->config->getMappingId();
        if ($mappingId > 0) {
            $this->read($result, ["magento", "status"], ["mapping_id" => $mappingId]);
        } else {
            $result->setSuccess(false);
            $result->setMessage(__('Configuration is not complete: no mapping defined.'));
        }

        return $result;
    }
    /**
     * Calls the "read" method.
     * Verbs are an array of strings (ordered) representing verbs of the URL to call.
     * For example, verbs for the following url "http://127.0.0.1/pimdatamanager/api/records/film" are ["records", film"]
     *
     * @param AbstractResult $result
     * @param string[] $verbs Verbs used to build request URL
     * @param string[] $parameters Associative array (key / value pairs) of parameters sent with the request (as GET parameters)
     * @return mixed Decoded JSON returned by the server (contents depends on the object requested)
     */
    private function read(AbstractResult $result, $verbs, $parameters = null)
    {
        try {
            $value = $this->call(self::S_METHOD_GET, $verbs, $parameters);
            $result->setValue($value);
            $result->setSuccess(true);
        } catch (\Exception $ex) {
            $result->setSuccess(false);
            $result->setMessage($ex->getMessage());
        }

        return $result;
    }

    /**
     * Do the call to the API
     *
     * @param string $method A method const
     * @param string[] $verbs List of verbs
     * @param mixed[] $parameters Array of parameters
     * @throws \Exception When HTTP response is an error
     * @return mixed
     */
    private function call($method, $verbs, $parameters = null)
    {
        if (is_null($parameters)) {
            $parameters = array();
        }
        $parameters["app"] = $this->applicationKey;
        $parameters["user"] = $this->userKey;

        // CURL options: depends on the method to call
        $curlHandle = curl_init();
        $url = $this->apiUrl . implode("/", $verbs);
        switch ($method) {
            case self::S_METHOD_GET:
                $url .= "?" . http_build_query($parameters);
                curl_setopt($curlHandle, CURLOPT_POST, false);
                break;
            case self::S_METHOD_POST:
                curl_setopt($curlHandle, CURLOPT_POST, true);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameters);
                break;
            case self::S_METHOD_PUT:
                curl_setopt($curlHandle, CURLOPT_POST, true);
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array("X-HTTP-Method: PUT"));
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameters);
                break;
            case self::S_METHOD_DELETE:
                $url .= "?" . http_build_query($parameters);
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array("X-HTTP-Method: DELETE"));
                break;
            default:
                // implement an error mechanism here
        }
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        $response = curl_exec($curlHandle);
        $errno = curl_errno($curlHandle);
        $error = curl_error($curlHandle);
        $getInfo = curl_getinfo($curlHandle);
        curl_close($curlHandle);

        if ($getInfo["http_code"] != 200) {
            throw new \Exception($response, $getInfo["http_code"]);
        } elseif ($response === false) {
            throw new \Exception($error, $errno);
        }
        return json_decode($response, true);
    }
}