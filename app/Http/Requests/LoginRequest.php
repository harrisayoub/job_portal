<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Requests;

class LoginRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		// If previous page is not the Login page...
		if (!str_contains(url()->previous(), trans('routes.login'))) {
			// Save the previous URL to retrieve it after success or failed login.
			session()->put('url.intended', url()->previous());
		}
		
        $rules = [
            'login'    => 'required',
            'password' => 'required|min:5|max:50',
        ];
    
        // Recaptcha
        if (config('settings.security.recaptcha_activation')) {
            $rules['g-recaptcha-response'] = 'required';
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
