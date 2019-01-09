<?php

namespace Platform\Controller;

use Platform\Service\RoleService;
use Platform\Requests\RoleFormRequest;
use Platform\Support\ControllerServiceTrait;

class RoleController extends Controller
{
    use ControllerServiceTrait;

    /**
     * @var RoleService
     */
    private $service;

    /**
     * RoleController constructor.
     *
     * @param RoleService $service
     */
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    /**
     * @param RoleFormRequest $request
     *
     * @return mixed
     */
    public function store(RoleFormRequest $request)
    {
        return $this->service()->storeAs($request)->resources();
    }

    /**
     * @param RoleFormRequest $request
     * @param int $id
     *
     * @return mixed
     */
    public function update(RoleFormRequest $request, int $id)
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
