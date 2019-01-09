<?php

namespace Platform\Requests;

use Illuminate\Validation\Rule;
use Platform\Foundation\Form\Request;

class RoleFormRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required', 'string', Rule::unique('roles')],
            'title' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function update()
    {
        return [
            'name'  => ['required', 'string', Rule::unique('roles')->ignore($this->route('role'))],
            'title' => 'required|string',
        ];
    }
}
