<?php

namespace App\Http\Controllers\Concerns;

use App\Support\MaintainUserTemporaryPasswordStore;

trait UsesSetupLinkStore
{
    protected function setupLinkStore(): MaintainUserTemporaryPasswordStore
    {
        return app(MaintainUserTemporaryPasswordStore::class);
    }
}
