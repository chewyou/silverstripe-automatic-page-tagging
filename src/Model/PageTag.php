<?php

namespace Chewyou\AutoPageTagging;

use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use Page;

class PageTag extends DataObject {

    private static $singular_name = 'Tag Name';

    private static $plural_name = 'Tag Names';

    private static $db = [
        'Title' => 'Varchar(100)'
    ];

    private static $has_one = [
        'Parent' => PageTag::class,
    ];

    private static $many_many = [
        'Children' => PageTag::class
    ];

    private static $table_name = 'PageTagName';

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        return $fields;
    }
}
