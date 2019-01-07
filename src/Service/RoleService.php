<?php

namespace Platform\Service;

use Platform\Model\Role;
use Illuminate\Http\Request;
use Platform\Resources\RoleResource;
use Platform\Contracts\PlatformService;

class RoleService implements PlatformService
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var int
     */
    const NOT_CAN_DELETE = 1;

    /**
     * RoleService constructor.
     *
     * @param Role|\Illuminate\Database\Eloquent\Builder $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model->getModel();
    }

    /**
     * @return mixed
     */
    public function response()
    {
        //
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|mixed
     */
    public function resources()
    {
        return RoleResource::collection($this->model->grouping()->get());
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function resource(int $id)
    {
        $data = $this->model->findOrFail($id);
        $authorize = $data->permissions()->pluck('id');

        return (new RoleResource($data))->additional(['authorize' => $authorize]);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request)
    {
        $this->model->create(array_merge($request->except('authorize'), ['guard_name' => 'admin']))
            ->syncPermissions($request->input('authorize'));

        return $this;
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return $this
     */
    public function updateAs(Request $request, int $id)
    {
        $data = $this->model->findOrFail($id);
        $data->update($request->except('authorize'));

        if ($id !== self::NOT_CAN_DELETE) {
            $data->syncPermissions($request->input('authorize'));
        }

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     * @throws \Exception
     */
    public function deleteAs(int $id)
    {
        abort_if($id === self::NOT_CAN_DELETE, 403, __('该角色组不允许删除'));

        $this->model->findOrFail($id)->delete();

        return $this;
    }
}
