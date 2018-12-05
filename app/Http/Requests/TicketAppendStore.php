<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketAppendStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    public function rules()
    {
        return [
            'subject' => 'required|max:255|min:5',
            'priority' => 'required|in:low,medium,hight',
            'from_type' => 'required|in:user,role' ,
            'to_type' => 'required|in:user,role,operator' ,
            'to_id' => 'required|numeric',
            'message' => 'required'
        ];
    }

}
