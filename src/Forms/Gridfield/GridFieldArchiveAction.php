<?php

namespace Chewyou\AutoPageTagging\Forms\GridField;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\ORM\ManyManyThroughList;
use SilverStripe\Versioned\GridFieldArchiveAction as SS_GridFieldArchiveAction;

/**
 * Class GridFieldArchiveAction
 * @package HMSM\App\Forms\GridField
 *
 * https://github.com/silverstripe/silverstripe-versioned/issues/200#issuecomment-465152708
 */
class GridFieldArchiveAction extends SS_GridFieldArchiveAction {
    /**
     * Add a column 'Actions'
     * @param GridField $gridField
     * @param array $columns
     */
    public function augmentColumns($gridField, &$columns) {
        if($gridField->getList() instanceof ManyManyList || $gridField->getList() instanceof ManyManyThroughList) {
            return;
        }

        return parent::augmentColumns($gridField, $columns);
    }

    /**
     * Returns the GridField_FormAction if archive can be performed
     *
     * @param GridField $gridField
     * @param DataObject $record
     * @return GridField_FormAction|null
     */
    public function getArchiveAction($gridField, $record) {
        if($gridField->getList() instanceof ManyManyList || $gridField->getList() instanceof ManyManyThroughList) {
            return null;
        }

        return parent::getArchiveAction($gridField, $record);
    }
}