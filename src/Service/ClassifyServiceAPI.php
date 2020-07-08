<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\SiteConfig\SiteConfig;

class ClassifyServiceAPI {

    private $readApiKey;
    private $writeApiKey;
    private $classifierName;
    private $accountName;
    private $baseUrl;

    public function __construct() {
        $siteConfig = SiteConfig::current_site_config();

        $this->writeApiKey = $siteConfig->WriteAPIKey;
        $this->readApiKey = $siteConfig->ReadAPIKey;
        $this->classifierName = $siteConfig->ClassifierName;
        $this->accountName = $siteConfig->AccountName;
        $this->baseUrl = 'https://api.uclassify.com/v1';
    }

    public function classify($text) {
        $apiKey = $this->readApiKey;
        $classifierName = $this->classifierName;
        $accountName = $this->accountName;
        $url = $this->baseUrl . '/' . $accountName . '/' . $classifierName . '/classify';
        $result = $this->apiPost($apiKey, 'texts', [$text], $url);
        return $result;
    }

    public function addClass($className) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $accountName = $this->accountName;
        $url = $this->baseUrl . '/' . $accountName . '/' . $classifierName . '/addClass';
        $result = $this->apiPost($apiKey, 'className', $className, $url);
        return $result;
    }

    public function deleteClass($className) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $accountName = $this->accountName;
        $url = $this->baseUrl . '/' . $accountName . '/' . $classifierName . '/' . $className . '';
        $result = $this->apiDelete($apiKey, $url);
        return $result;
    }

    public function trainClass($className, $text) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $accountName = $this->accountName;
        $url = $this->baseUrl . '/' . $accountName . '/' . $classifierName . '/' . $className . '/train';
        $result = $this->apiPost($apiKey, 'texts', $text, $url);
        return $result;
    }

    public function untrainClass($className, $text) {
        $apiKey = $this->writeApiKey;
        $classifierName = $this->classifierName;
        $accountName = $this->accountName;
        $url = $this->baseUrl . '/' . $accountName . '/' . $classifierName . '/' . $className . '/untrain';
        $result = $this->apiPost($apiKey, 'texts', $text, $url);
        return $result;
    }

    private function apiPost($apiKey, $contentTitle, $text, $url) {
        $data = [$contentTitle => $text];
        $data_string = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Token ' . $apiKey,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            ]
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return $this->handleResponse($result);
    }

    private function apiDelete($apiKey, $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Token ' . $apiKey,
                'Content-Type: application/json',
            ]
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return $this->handleResponse($result);
    }

    private function handleResponse($result) {
        // Handle errors and other responses here

        return $result;
    }

}
