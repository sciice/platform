<?php

namespace Platform\Controller;

use Platform\Service\PlatformService;
use Platform\Requests\PlatformFormRequest;
use Platform\Support\ControllerServiceTrait;

class PlatformController extends Controller
{
    use ControllerServiceTrait;

    /**
     * @var PlatformService
     */
    private $service;

    /**
     * PlatformController constructor.
     *
     * @param PlatformService $service
     */
    public function __construct(PlatformService $service)
    {
        $this->service = $service;
    }

    /**
     * @param PlatformFormRequest $request
     *
     * @return mixed
     */
    public function store(PlatformFormRequest $request)
    {
        return $this->service()->storeAs($request)->resources();
    }

    /**
     * @param PlatformFormRequest $request
     * @param int $id
     *
     * @return mixed
     */
    public function update(PlatformFormRequest $request, int $id)
    {
        return $this->service()->updateAs($request, $id)->resources();
    }

    /**
     * @return \Platform\Contracts\PlatformService
     */
    protected function service()
    {
        return $this->service;
    }
}
