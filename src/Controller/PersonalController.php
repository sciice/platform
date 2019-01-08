<?php

namespace Platform\Controller;

use Illuminate\Http\Request;
use Platform\Service\PlatformService;
use Platform\Requests\PersonalFormRequest;

class PersonalController extends Controller
{
    /**
     * @var PlatformService
     */
    private $service;

    /**
     * PersonalController constructor.
     *
     * @param PlatformService $service
     */
    public function __construct(PlatformService $service)
    {
        $this->middleware('login:admin');
        $this->service = $service;
    }

    /**
     * @param PersonalFormRequest $request
     *
     * @return mixed
     */
    public function account(PersonalFormRequest $request)
    {
        return $this->service->updateUserAccountInfo($request)->resource($request->user()->id, true);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function avatar(Request $request)
    {
        return $this->service->updateUserAvatar($request)->resource($request->user()->id, true);
    }
}
