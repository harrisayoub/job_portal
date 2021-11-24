<?php
/**
 

 *

 *

 * -------




 */

namespace Larapen\Impersonate\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Lab404\Impersonate\Services\ImpersonateManager;
use Prologue\Alerts\Facades\Alert;

class ProtectFromImpersonation
{
    /**
     * Handle an incoming request.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \Closure  $next
     * @return  mixed
     */
    public function handle($request, Closure $next)
    {
        $impersonate_manager = app()->make(ImpersonateManager::class);

        if ($impersonate_manager->isImpersonating()) {
        	$message = t('Can\'t be accessed by an impersonator');
        	
			if ($request->segment(1) == admin_uri()) {
				Alert::error($message)->flash();
			} else {
				flash($message)->error();
			}
			
            return Redirect::back();
        }

        return $next($request);
    }
}
