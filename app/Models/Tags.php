<?php
/**
 

 *

 *

 * -------




 */

namespace App\Models;

use Larapen\Admin\app\Models\Crud;

class Tags extends BaseModel
{
	use Crud;
	
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';	
	
	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
		parent::boot();
    }
    
    public function tags()
    {
        return $this->hasMany(Tags::class, 'tag_name');
    }
}
