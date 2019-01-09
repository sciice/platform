<?php

namespace Platform\Controller;

use Illuminate\Http\Request;
use Platform\Service\PermissionService;
use Platform\Support\ControllerServiceTrait;

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
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->service()->storeAs($request)->resources();
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return mixed
     */
    public function update(Request $request, int $id)
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
