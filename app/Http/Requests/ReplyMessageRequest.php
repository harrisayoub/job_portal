<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Requests;


class ReplyMessageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
			'message' => 'required|mb_between:20,500',
        ];
        
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
