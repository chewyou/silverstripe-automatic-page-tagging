<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SiteConfigExtension extends DataExtension {

    private static $db = array(
        "ReadAPIKey" => "Varchar(500)",
        "WriteAPIKey" => "Varchar(500)",
        "ClassifierName" => "Varchar(500)",
        "AccountName" => "Varchar(500)",
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldsToTab('Root.AutomaticTaggingSettings', [
            TextField::create("ReadAPIKey", "Read API Key"),
            TextField::create("WriteAPIKey", "Write API Key"),
            TextField::create("ClassifierName", "Classifier Name"),
            TextField::create("AccountName", "Account Name"),
        ]);
    }

}