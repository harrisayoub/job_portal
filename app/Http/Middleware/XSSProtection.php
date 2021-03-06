<?php
/**
 * JobClass - Geo Classified Ads Software

 *

 *

 * -------




 */

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Schema;

class XSSProtection
{
	/**
	 * The following method loops through all request input and strips out all tags from
	 * the request. This to ensure that users are unable to set ANY HTML within the form
	 * submissions, but also cleans up input.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (request()->segment(1) == admin_uri()) {
			if (!Schema::hasTable('permissions')) {
				return $next($request);
			}
			
			if (auth()->check() and auth()->user()->can(Permission::getStaffPermissions())) {
				return $next($request);
			}
		}
		
		// Get all fields values
		$input = $request->all();
		
		// Remove all HTML tags in the fields values
		// Except fields: description
		array_walk_recursive($input, function (&$input, $key) use ($request) {
			if (!in_array($key, ['description'])) {
				if (!empty($input)) {
					$input = strip_tags($input);
				}
			}
		});
		
		// Replace the fields values
		$request->merge($input);
		
		return $next($request);
	}
}
