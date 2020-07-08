<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\SiteConfig\SiteConfig;

class ClassifyServiceAPI {

    private $readApiKey;
    private $writeApiKey;
    private $classifierName;
    private $baseUrl;

    public function __construct() {
        $siteConfig = SiteConfig::current_site_config();

        $this->writeApiKey = $siteConfig->WriteAPIKey;
        $this->readApiKey = $siteConfig->ReadAPIKey;
        $this->classifierName = $siteConfig->ClassifierName;
        $this->baseUrl = 'https://api.uclassify.com/v1';
    }

    public function classify($text) {
        $apiKey = $this->readApiKey;
        $classifierName = $this->classifierName;
        $url = $this->baseUrl. '/uclassify/' . $classifierName . '/classify';
        $result = $this->apiPost($apiKey, 'texts', $text, $url);
        var_dump($result);
    }

    public function addClass($className) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $url =  $this->baseUrl. '/me/' . $classifierName . '/addClass';
        $result = $this->apiPost($apiKey, 'className', $className, $url);
        var_dump($result);
    }

    public function deleteClass($className) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $url =  $this->baseUrl. '/me/'.$classifierName.'/'.$className.'';
        $result = $this->apiDelete($apiKey, $url);
        var_dump($result);
    }

    public function trainClass($className, $text) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $url =  $this->baseUrl. '/me/' . $classifierName . '/'.$className.'/train';
        $result = $this->apiPost($apiKey, 'texts', $text, $url);
        var_dump($result);
    }

    public function untrainClass($className, $text) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $url =  $this->baseUrl. '/v1/me/' . $classifierName . '/'.$className.'/untrain';
        $result = $this->apiPost($apiKey, 'texts', $text, $url);
        var_dump($result);
    }

    private function apiPost($apiKey, $contentTitle, $text, $url) {
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Authorization: Token " . $apiKey . "\r\nContent-Type: application/json\r\n",
                'content' => '{"'.$contentTitle.'": [' . $text . ']}',
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    private function apiDelete($apiKey, $url) {
        $options = [
            'http' => [
                'method' => 'DELETE',
                'header' => "Authorization: Token " . $apiKey . "\r\nContent-Type: application/json\r\n",
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

}
