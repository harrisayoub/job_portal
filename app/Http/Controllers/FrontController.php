<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CommonTrait;
use App\Http\Controllers\Traits\LocalizationTrait;
use App\Http\Controllers\Traits\RobotsTxtTrait;
use App\Http\Controllers\Traits\SettingsTrait;

class FrontController extends Controller
{
	use LocalizationTrait, SettingsTrait, RobotsTxtTrait, CommonTrait;
	
	public $request;
	public $data = [];
	
	/**
	 * FrontController constructor.
	 */
	public function __construct()
	{
		// Check & Change the App Key (If needed)
		$this->checkAndGenerateAppKep();
		
		// Load the Plugins
		$this->loadPlugins();
		
		// From Laravel 5.3.4+
		$this->middleware(function ($request, $next)
		{
			$this->loadLocalizationData();
			$this->checkDotEnvEntries();
			$this->applyFrontSettings();
			$this->checkRobotsTxtFile();
			
			return $next($request);
		});
		
		// Check the 'Domain Mapping' plugin
		if (config('plugins.domainmapping.installed')) {
			$this->middleware(['domainVerification']);
		}
	}
}
