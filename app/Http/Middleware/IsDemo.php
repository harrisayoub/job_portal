<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Middleware;

use Closure;
use Prologue\Alerts\Facades\Alert;

class IsDemo
{
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (isDemo()) {
			$message = t("This feature has been turned off in demo mode.");
			
			if (isFromAdminPanel()) {
				Alert::info($message)->flash();
			} else {
				flash($message)->info();
			}
			
			return redirect()->back();
		}
		
		return $next($request);
	}
}
