<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Requests;

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
			'company.name'        => 'required|mb_between:2,200|whitelist_word_title',
			'company.description' => 'required|mb_between:5,1000|whitelist_word',
		];
	
		// Check 'logo' is required
		if ($this->hasFile('company.logo')) {
			$rules['company.logo'] = 'required|image|mimes:' . getUploadFileTypes('image') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
		}
        
        return $rules;
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        $messages = [];
        
        return $messages;
    }
}
