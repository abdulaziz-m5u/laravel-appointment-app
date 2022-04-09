<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id'   => [
                'required',
                'integer',
            ],
            'employee_id'   => [
                'required',
                'integer',
            ],
            'start_time'  => [
                'required',
                'date_format:Y-m-d H:i',
            ],
            'finish_time' => [
                'required',
                'date_format:Y-m-d H:i',
            ],
            'services.*'  => [
                'integer',
            ],
            'services'    => [
                'array',
            ],
        ];
    }
}
