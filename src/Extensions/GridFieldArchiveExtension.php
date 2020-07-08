<?php

namespace Chewyou\AutoPageTagging;

use Chewyou\AutoPageTagging\Forms\GridField\GridFieldArchiveAction;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Versioned\VersionedGridFieldArchiveExtension;

class GridFieldArchiveExtension extends VersionedGridFieldArchiveExtension {
    public function updateConfig() {
        $owner = $this->getOwner();

        $owner->addComponent(new GridFieldArchiveAction(), GridFieldDeleteAction::class);
    }
}