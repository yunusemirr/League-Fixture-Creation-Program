<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        return match($this->method()){
            'POST' => $this->store(),
            default => $this->store()
        };
    }

    public function store(){
        return [
            'parent_tc' => 'required|numeric|digits:11',
            'parent_name' => 'required|string|max:50',
            'parent_surname' => 'required|string|max:50',
            'parent_phone' => 'required|string',
            'parent_email' => 'required|email:rfc,dns',
            'parent_address' => 'required|string|max:255',
            'school' => 'nullable',

            'group_id' => 'required|exists:groups,id',

            'register_date' => 'required|date',
            'tc' => 'required|numeric|digits:11|unique:users,tc',
            'birthdate' => 'required|date',
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'gender' => 'required|in:male,female',

            'payment_date' => 'nullable|date',
            'payment_amount' => [Rule::requiredIf(request()->filled('payment_date')), 'nullable','numeric'],
            'payment_payment_plan' => [Rule::requiredIf(request()->filled('payment_date')), 'nullable','numeric'],
            'payment_advance_payment' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'parent_tc' => __('models.user.tc'),
            'parent_name' => __('models.user.name'),
            'parent_surname' => __('models.user.surname'),
            'parent_phone' => __('models.user.phone'),
            'parent_email' => __('models.user.email'),
            'parent_address' => __('models.user.address'),
            'school' => 'nullable',

            'register_date' => __('models.user.register_date'),
            'tc' => __('models.user.tc'),
            'birthdate' => __('models.user.birthdate'),
            'name' => __('models.user.name'),
            'surname' => __('models.user.surname'),
            'phone' => __('models.user.phone'),
            'email' => __('models.user.email'),
            'gender' => __('models.user.gender'),

            'payment_date' => __('models.payment.date'),
            'payment_amount' => __('models.payment.amount'),
            'payment_payment_plan' => __('models.payment.payment_plan'),
            'payment_advance_payment' => __('models.payment.advance_payment'),
        ];
    }


    public function failedValidation($validator){
        return parent::failedValidation($validator);
    }
}
