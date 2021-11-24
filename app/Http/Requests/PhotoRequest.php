<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Requests;

class PhotoRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [];
		
		// Require 'pictures' if exists
		if ($this->file('pictures')) {
			$files = $this->file('pictures');
			foreach ($files as $key => $file) {
				if (!empty($file)) {
					$rules['pictures.' . $key] = 'required|image|mimes:' . getUploadFileTypes('image') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
				}
			}
		}
		
		return $rules;
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		$messages = [];
		
		if ($this->hasFile('pictures')) {
			$files = $this->file('pictures');
			foreach ($files as $key => $file) {
				$messages['pictures.' . $key . '.required'] = t('The picture #:key is required.', ['key' => $key]);
				$messages['pictures.' . $key . '.image'] = t('The picture #:key must be image.', ['key' => $key]);
				$messages['pictures.' . $key . '.mimes'] = t('The picture #:key must be a file of type :type.', [
					'key'  => $key,
					'type' => getUploadFileTypes('image'),
				]);
				$messages['pictures.' . $key . '.max'] = t('The picture #:key may not be greater than :max.', [
					'key' => $key,
					'max' => fileSizeFormat((int)config('settings.upload.max_file_size', 1000)),
				]);
			}
		}
		
		return $messages;
	}
}
