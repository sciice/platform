<?php

namespace Platform\Controller;

use Illuminate\Http\Request;
use Platform\Service\RoleService;
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
