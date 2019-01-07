<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Foundation\Form;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ValidatorSometime
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * ValidatorSometime constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Validator $validator
     *
     * @return ValidatorSometime
     */
    public static function make(Validator $validator)
    {
        return new static($validator);
    }

    /**
     * @param $field
     * @param $rule
     *
     * @return $this
     */
    public function rule($field, $rule)
    {
        $this->validator->sometimes($field, $rule, function ($value) use ($field) {
            return filled($value->{$field});
        });

        return $this;
    }

    /**
     * @return $this
     * @throws ValidationException
     */
    public function validate()
    {
        if ($this->validator->fails()) {
            throw new ValidationException($this->validator);
        }

        return $this;
    }
}
