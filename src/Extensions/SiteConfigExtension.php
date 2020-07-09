<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SiteConfigExtension extends DataExtension {

    private static $db = array(
        "ReadAPIKey" => "Varchar(500)",
        "WriteAPIKey" => "Varchar(500)",
        "ClassifierName" => "Varchar(500)",
        "AccountName" => "Varchar(500)",
        "PercentageThreshold" => "Text",
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldsToTab('Root.AutomaticTaggingSettings', [
            TextField::create("ReadAPIKey", "Read API Key"),
            TextField::create("WriteAPIKey", "Write API Key"),
            TextField::create("ClassifierName", "Classifier Name"),
            TextField::create("AccountName", "Account Name"),
            DropdownField::create('PercentageThreshold', 'Percentage Threshold', [
                "0.1" => "0.1",
                "0.2" => "0.2",
                "0.3" => "0.3",
                "0.4" => "0.4",
                "0.5" => "0.5",
                "0.6" => "0.6",
                "0.7" => "0.7",
                "0.8" => "0.8",
                "0.9" => "0.9"
            ]),
        ]);
    }

}