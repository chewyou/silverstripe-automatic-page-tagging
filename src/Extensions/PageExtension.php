<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TreeMultiselectField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Core\Config\Config;
use SilverStripe\SiteConfig\SiteConfig;

class PageExtension extends DataExtension {

    private static $db = [
        'PageTags' => 'Varchar(510)',
        'AutomaticTaggingEnabled' => 'Boolean(0)',
        'AutomaticTrainingEnabled' => 'Boolean(0)'
    ];

    private static $many_many = [
        'PageTags' => PageTag::class
    ];

    static $has_written = false;

    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldsToTab('Root.PageTags', [
            ListboxField::create('PageTags', 'Page Tags', PageTag::get())->setDisabled(($this->owner->AutomaticTaggingEnabled === 1)),
        ]);

        $fields->addFieldsToTab('Root.PageTags', [
            FieldGroup::create(
                CheckboxField::create("AutomaticTaggingEnabled", 'Enable')->setDisabled(($this->owner->AutomaticTrainingEnabled === 1))
            )->setTitle('Enable Automatic Tagging?'),
        ]);

        $fields->addFieldsToTab('Root.PageTags', [
            FieldGroup::create(
                CheckboxField::create("AutomaticTrainingEnabled", 'Enable')->setDisabled(($this->owner->AutomaticTaggingEnabled === 1))
            )->setTitle('Enable Automatic Training?'),
        ]);

    }

    public function onBeforeWrite() {

        if (!self::$has_written) {
            $classifyAPI = new ClassifyServiceAPI();
            $siteConfig = SiteConfig::current_site_config();

            $text = $this->getPageContent();

            if ($this->owner->AutomaticTaggingEnabled === 1) {
                $result = $classifyAPI->classify($text);
                $arrayResult = json_decode($result, true);
                $classifications = $arrayResult[0]['classification'];

                foreach ($classifications as $classification) {
                    if ($classification['p'] >= $siteConfig->PercentageThreshold) {
                        $pageTag = PageTag::get()->filter(['Title' => $classification['className']])->first();
                        $this->owner->PageTags()->add($pageTag);
                    }
                }
            }

            if ($this->owner->AutomaticTrainingEnabled === 1) {
                $classNames = $this->owner->PageTags();
                if ($classNames) {
                    foreach ($classNames as $className) {
                        $trainResult = $classifyAPI->trainClass($className->Title, $text);
                    }
                }
            }
            self::$has_written = true;
        }

        parent::onBeforeWrite();
    }

    public function getPageContent() {
        $string = "";
        $configContentToTrain = Config::inst()->get($this->owner->ClassName, 'content_to_train');

        if ($configContentToTrain) {
            $configContentToTrain = explode(',', $configContentToTrain);
            foreach ($configContentToTrain as $contentItem) {
                if ($this->owner->$contentItem) {
                    $string .= " " . $this->owner->$contentItem;
                }
            }
        }

        return $string;
    }

}
