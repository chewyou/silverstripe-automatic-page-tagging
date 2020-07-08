<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TreeMultiselectField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Controller;

class PageExtension extends DataExtension {

    private static $db = [
        'PageTags' => 'Varchar(510)',
        'AutomaticTaggingEnabled' => 'Boolean(0)'
    ];

    private static $many_many = [
        'PageTags' => PageTag::class
    ];

    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldsToTab('Root.PageTags', [
            CheckboxField::create("AutomaticTaggingEnabled", 'Enable Automatic Tagging?'),
            // TODO: Use the TreeMultiselectField as it represents
            ListboxField::create('PageTags', 'Page Tags', PageTag::get()),
            LiteralField::create('TrainButton',
                '<button class="train-tags-button">Train Tags</button>
                 <button class="untrain-tags-button">Untrain Tags</button>')
        ]);

    }

    public function onBeforeWrite() {

        if ($this->owner->AutomaticTaggingEnabled === 1) {
            $text = '';
            $text .= ' ' . $this->owner->Title;

            $classifyAPI = new ClassifyServiceAPI();
            $result = $classifyAPI->classify($text);
            $arrayResult = json_decode($result, true);
            $classifications = $arrayResult[0]['classification'];

            foreach ($classifications as $classification) {
                // TODO: Percentage could be set in CMS Settings?
                if ($classification['p'] >= 0.5) {
                    $pageTag = PageTag::get()->filter(['Title' => $classification['className']])->first();
                    $this->owner->PageTags()->add($pageTag);
                }
            }
        }

        parent::onBeforeWrite();
    }

    private function getObjectIDs($objects) {
        $returnArray = [];
        foreach ($objects as $object) {
            array_push($returnArray, $object->ID);
        }
        return $returnArray;
    }

}
