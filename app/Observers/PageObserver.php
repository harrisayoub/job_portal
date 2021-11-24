<?php
/**
 

 *

 *

 * -------




 */

namespace App\Observer;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageObserver extends TranslatedModelObserver
{
    /**
     * Listen to the Entry saved event.
     *
     * @param  Page $page
     * @return void
     */
    public function saved(Page $page)
    {
        // Removing Entries from the Cache
        $this->clearCache($page);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Page $page
     * @return void
     */
    public function deleted(Page $page)
    {
        // Removing Entries from the Cache
        $this->clearCache($page);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $page
     */
    private function clearCache($page)
    {
        Cache::flush();
    }
}
