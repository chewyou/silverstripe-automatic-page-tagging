<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\Forms\ListboxField;
use SilverStripe\ORM\DataExtension;

class PageExtension extends DataExtension {
    private static $db = [
        'PageTags' => 'Varchar(510)'
    ];

    private static $has_many = [
        'PageTags' => PageTag::class
    ];

    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldsToTab('Root.PageTags', [
            ListboxField::create('PageTags', 'PageTags', $this->PageTags()),
        ]);

    }

}
