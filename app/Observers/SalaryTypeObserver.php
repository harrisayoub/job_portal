<?php
/**
 

 *

 *

 * -------




 */

namespace App\Observer;

use App\Models\SalaryType;
use Illuminate\Support\Facades\Cache;

class SalaryTypeObserver extends TranslatedModelObserver
{
    /**
     * Listen to the Entry saved event.
     *
     * @param  SalaryType $salaryType
     * @return void
     */
    public function saved(SalaryType $salaryType)
    {
        // Removing Entries from the Cache
        $this->clearCache($salaryType);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  SalaryType $salaryType
     * @return void
     */
    public function deleted(SalaryType $salaryType)
    {
        // Removing Entries from the Cache
        $this->clearCache($salaryType);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $salaryType
     */
    private function clearCache($salaryType)
    {
        Cache::flush();
    }
}
