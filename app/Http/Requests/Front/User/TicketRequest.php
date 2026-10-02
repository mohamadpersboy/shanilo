<?php

namespace App\Http\Requests\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= [
            'title' => 'required|between:3,1000',
            'priority' => 'required|in:1,2,3',
            'message' => 'required|between:3,1000',
        ];
        if($this->get('ticket_id')){
            unset($rules['title']);
            unset($rules['priority']);
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'موضوع',
            'priority' => 'اولویت',
            'message' => 'پیام',
        ];
    }
}
