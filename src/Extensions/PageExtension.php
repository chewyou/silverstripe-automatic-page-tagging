<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\TreeMultiselectField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

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
            // TreeMultiselectField::create('PageTags', 'Page Tags', PageTag::get())->setTreeBaseID(16)
        ]);

    }

    public function onBeforeWrite() {

        if ($this->owner->AutomaticTaggingEnabled === 1) {
            $textToClassify = '';
            $textToClassify .= ' ' . $this->owner->Title;

            $classifyAPI = new ClassifyServiceAPI();
            $result = $classifyAPI->classify($textToClassify);

            // IF there is a difference between the PageTags before and after saving, find out what was added and deleted
            // then, train/untrain based on what was added/deleted



        }

        parent::onBeforeWrite();
    }

}
