<?php

namespace Platform\Requests;

use Illuminate\Validation\Rule;
use Platform\Foundation\Form\Request;
use Platform\Foundation\Form\ValidatorSometime;

class PlatformFormRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|string',
            'username' => 'required|min:4|string|unique:admin',
            'email'    => 'required|email|unique:admin',
            'role'     => 'required',
            'password' => 'required|min:5',
        ];
    }

    /**
     * @return array
     */
    public function update()
    {
        $id = $this->route('account');

        return [
            'name'     => 'required|string',
            'username' => ['required', 'min:4', 'string', Rule::unique('admin')->ignore($id)],
            'email'    => ['required', 'email', Rule::unique('admin')->ignore($id)],
            'role'     => 'required',
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
        return ValidatorSometime::make($validator)
            ->rule('mobile', ['required', 'mobile', Rule::unique('admin')])
            ->validate();
    }

    /**
     * @param $validator
     *
     * @return ValidatorSometime
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateWithValidator($validator)
    {
        return ValidatorSometime::make($validator)
            ->rule('password', 'required|min:5')
            ->rule('mobile', ['required', 'mobile', Rule::unique('admin')->ignore($this->route('account'))])
            ->validate();
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'role.required' => __('角色组不允许为空'),
        ];
    }
}
