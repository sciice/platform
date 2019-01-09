<?php

namespace Platform\Controller;

use Platform\Service\PermissionService;
use Platform\Support\ControllerServiceTrait;
use Platform\Requests\PermissionFormRequest;

class PermissionController extends Controller
{
    use ControllerServiceTrait;

    /**
     * @var PermissionService
     */
    private $service;

    /**
     * PermissionController constructor.
     *
     * @param PermissionService $service
     */
    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * @param PermissionFormRequest $request
     *
     * @return mixed
     */
    public function store(PermissionFormRequest $request)
    {
        return $this->service()->storeAs($request)->resources();
    }

    /**
     * @param PermissionFormRequest $request
     * @param int $id
     *
     * @return mixed
     */
    public function update(PermissionFormRequest $request, int $id)
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
