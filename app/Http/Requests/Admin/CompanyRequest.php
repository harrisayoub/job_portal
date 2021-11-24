<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Requests\Admin;

class CompanyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Validation Rules
		$rules = [
			'name'        => 'required|mb_between:2,200|whitelist_word_title',
			'description' => 'required|mb_between:5,1000|whitelist_word',
		];
	
		// Check 'logo' is required
		if ($this->hasFile('logo')) {
			$rules['logo'] = 'required|image|mimes:' . getUploadFileTypes('image') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
		}
        
        return $rules;
    }
}
