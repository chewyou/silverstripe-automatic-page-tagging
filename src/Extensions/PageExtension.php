<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\TreeMultiselectField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class PageExtension extends DataExtension {
    private static $db = [
        'PageTags' => 'Varchar(510)'
    ];

    private static $many_many = [
        'PageTags' => PageTag::class
    ];

    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldsToTab('Root.PageTags', [
            // TODO: Use the TreeMultiselectField as it represents
            ListboxField::create('PageTags', 'Page Tags', PageTag::get()),
//            TreeMultiselectField::create('PageTags', 'Page Tags', PageTag::get())->setTreeBaseID(16)
        ]);

    }

}
