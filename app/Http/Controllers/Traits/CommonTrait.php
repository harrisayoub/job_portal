<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Controllers\Traits;

use App\Helpers\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

trait CommonTrait
{
	/**
	 * Check & Change the App Key (If needed, for security reasons)
	 */
	private function checkAndGenerateAppKep()
	{
		try {
			if (DotenvEditor::keyExists('APP_KEY')) {
				if (DotenvEditor::getValue('APP_KEY') == 'SomeRandomStringWith32Characters') {
					// Generating a new App Key, remove (or clear) all the sessions and cookies
					$exitCode = Artisan::call('key:generate', ['--force' => true]);
				}
			}
		} catch (\Exception $e) {}
	}
	
	/**
	 * Load all the installed plugins
	 */
	private function loadPlugins()
	{
		$plugins = plugin_installed_list();
		$plugins = collect($plugins)->map(function ($item, $key) {
			if (is_object($item)) {
				$item = Arr::fromObject($item);
			}
			if (isset($item['item_id']) && !empty($item['item_id'])) {
				$item['installed'] = plugin_check_purchase_code($item);
			}
			
			return $item;
		})->toArray();
		
		Config::set('plugins', $plugins);
		Config::set('plugins.installed', collect($plugins)->whereStrict('installed', true)->toArray());
	}
}
