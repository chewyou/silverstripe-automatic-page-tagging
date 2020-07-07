<?php

namespace Chewyou\AutoPageTagging;

use Seftan\App\Forms\GridField\GridFieldArchiveAction;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldImportButton;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Security\PermissionProvider;
use Symbiote\GridFieldExtensions\GridFieldConfigurablePaginator;

class PageTagsModelAdmin extends ModelAdmin implements PermissionProvider {
    private static $url_segment = 'page-tags-admin';
    private static $menu_title = 'Page Tags';
    private static $menu_icon_class = 'font-icon-tags';
    private static $managed_models = [PageTag::class];

    public function getList() {
        $list = parent::getList();
        $list = $list->filter('ParentTagID', '');
        return $list;
    }

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);
        $gridField = $form->Fields()->fieldByName($this->sanitiseClassName($this->modelClass));
        $gridField->getConfig()->removeComponentsByType(GridFieldExportButton::class);
        $gridField->getConfig()->removeComponentsByType(GridFieldImportButton::class);
        $gridField->getConfig()->removeComponentsByType(GridFieldPaginator::class);
        $gridField->getConfig()->removeComponentsByType(GridFieldPageCount::class);
        $gridField->getConfig()->addComponent(new GridFieldConfigurablePaginator(25, [25, 50, 100]));
        return $form;
    }
}
