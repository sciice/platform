<?php

namespace Platform\Foundation\Form;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class Request extends FormRequest
{
    /**
     * {@inheritdoc}
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $make = $this->isMethod('POST') ? 'rules' : 'update';

        return $factory->make(
            $this->validationData(),
            $this->container->call([$this, $make]),
            $this->messages(),
            $this->attributes()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        $factory = $this->container->make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            $validator = $this->container->call([$this, 'validator'], compact('factory'));
        } else {
            $validator = $this->createDefaultValidator($factory);
        }

        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        if (! $this->isMethod('POST') && method_exists($this, 'updateWithValidator')) {
            $this->updateWithValidator($validator);
        }

        return $validator;
    }
}
