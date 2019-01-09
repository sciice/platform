<?php

namespace Platform\Requests;

use Illuminate\Validation\Rule;
use Platform\Foundation\Form\Request;
use Platform\Foundation\Form\ValidatorSometime;

class PersonalFormRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        $id = auth('admin')->id();

        return [
            'name'     => 'required|min:2',
            'username' => 'required',
            'email'    => ['required', 'email', Rule::unique('admin')->ignore($id)],
            'mobile'   => ['required', 'mobile', Rule::unique('admin')->ignore($id)],
        ];
    }

    /**
     * @param $validator
     *
     * @return ValidatorSometime
     * @throws \Illuminate\Validation\ValidationException
     */
    public function withValidator($validator)
    {
        return ValidatorSometime::make($validator)->rule('password', 'required|min:5')->validate();
    }
}
