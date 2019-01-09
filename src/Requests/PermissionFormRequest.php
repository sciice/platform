<?php

namespace Platform\Requests;

use Illuminate\Validation\Rule;
use Platform\Foundation\Form\Request;

class PermissionFormRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => ['required', 'string', Rule::unique('permissions')],
            'title'    => 'required|string',
            'grouping' => 'required|string',
            'parent'   => 'required',
        ];
    }

    /**
     * @return array
     */
    public function update()
    {
        return [
            'name'     => ['required', 'string', Rule::unique('permissions')->ignore($this->route('auth'))],
            'title'    => 'required|string',
            'grouping' => 'required|string',
            'parent'   => 'required',
        ];
    }
}
