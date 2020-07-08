<?php

namespace Chewyou\AutoPageTagging;

use Seftan\App\Forms\GridField\GridFieldArchiveAction;
use Seftan\App\SeftanOrderableRows;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use Page;

class PageTag extends DataObject {

    private static $singular_name = 'Tag Name';
    private static $table_name = 'PageTagName';
    private static $plural_name = 'Tag Names';

    private static $db = [
        'Title' => 'Varchar(100)'
    ];

    private static $has_one = [
        'ParentTag' => PageTag::class,
    ];

    private static $has_many = [
        'ChildTags' => PageTag::class
    ];

    private static $belongs_many_many = [
        'Page' => Page::class
    ];

    private static $summary_fields = [
        'Title' => 'Name'
    ];

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->removeByName(['ParentTagID', 'ChildTags', 'Page']);

        $gridfieldConfig = (new GridFieldConfig_RelationEditor())
            ->removeComponentsByType(GridFieldAddExistingAutocompleter::class);

        if ($this->ID) {
            $fields->addFieldsToTab('Root.Main', [
                GridField::create('ChildTags', '', $this->ChildTags(), $gridfieldConfig)
            ]);
        }

        return $fields;
    }

    public function onBeforeWrite() {
        $classifyAPI = new ClassifyServiceAPI();
        $classifyAPI->addClass($this->Title);

        parent::onBeforeWrite();
    }

    public function onAfterDelete() {
        $classifyAPI = new ClassifyServiceAPI();
        $result = $classifyAPI->deleteClass($this->Title);

        parent::onBeforeWrite();
    }
}
