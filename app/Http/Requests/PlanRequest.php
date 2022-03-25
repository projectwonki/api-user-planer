<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class PlanRequest extends FormRequest
{
    public function __construct() 
    {
        $this->validate();
    }
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
            'title' => 'required|string',
                
            'origin' => 'required|string|checkSimiliarity',

            'destination' => 'required|string',

            'type' => 'required|string|checkType',

            'start_date' => 'date|date_format:Y-m-d|checkDate',

            'end_date' => 'date|date_format:Y-m-d',

            'description' => 'required|string',
        ];
    }

    public function validate()
    {
        Validator::extend('checkSimiliarity', function ($attribute, $value, $parameters, $validator) {
            
            if (strtolower(request()->input('origin')) == strtolower(request()->input('destination'))) {
                return false;
            } else {
                return true;
            }
            
        }, 'origin & destination can not be same');

        Validator::extend('checkDate', function ($attribute, $value, $parameters, $validator) {
            
            if (request()->input('start_date') > request()->input('end_date')) {
                return false;
            } else {
                return true;
            }
            
        }, 'value of start_date is invalid. the start_date can not be more than end_date');

        Validator::extend('checkType', function ($attribute, $value, $parameters, $validator) {
            
            if (!in_array(request()->input('type'), ['one-day','time-range'])) {
                return false;
            } else {
                return true;
            }
            
        }, 'value of type is invalid. the options is one-day or time-range');

        $valid = Validator::make(request()->all(), $this->rules(), $this->messages());

        if ($valid->fails()) {
            // dd('here');
            return response()->json($valid->getMessageBag()->toArray(), 422);
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'title is required',
            'title.string' => 'title is must a string',
            'origin.required' => 'origin is required',
            'origin.string' => 'origin is must a string',
            'destination.required' => 'destination is required',
            'destination.string' => 'destination is must a string',
            'type.required' => 'destination is required',
            'type.string' => 'destination is must a string',
            'start_date.date' => 'start_date is must a date',
            'start_date.date_format' => 'start_date format is Y-m-d',
            'end_date.date' => 'end_date is must a date',
            'end_date.date_format' => 'end_date format is Y-m-d',
            'description.required' => 'title is required',
            'description.string' => 'title is must a string',
        ];
    }
}
