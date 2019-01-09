<?php

namespace Platform\Service;

use Illuminate\Http\Request;
use Platform\Model\Permission;
use Platform\Contracts\PlatformService;
use Platform\Resources\PermissionResource;
use Platform\Support\PlatformServiceTrait;

class PermissionService implements PlatformService
{
    use PlatformServiceTrait;

    /**
     * @var Permission
     */
    private $model;

    /**
     * PermissionService constructor.
     *
     * @param Permission|\Illuminate\Database\Eloquent\Builder $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    /**
     * @param bool $message
     *
     * @return mixed
     */
    public function resources($message = true)
    {
        return PermissionResource::collection($this->model->where('guard_name', 'admin')->get())
            ->additional($this->message($message));
    }

    /**
     * @param int $id
     *
     * @param bool $message
     *
     * @return mixed
     */
    public function resource(int $id, $message = false)
    {
        return (new PermissionResource($this->model->findOrFail($id)))
            ->additional($this->message($message));
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request)
    {
        $this->model->create(array_merge($request->all(), ['guard_name' => 'admin']));

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
        $this->model->findOrFail($id)->update($request->all());

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
        $data = $this->model->findOrFail($id);

        abort_if($this->model->where('parent', $data->id)->get()->isNotEmpty(), 403, __('请先删除子权限'));

        $data->delete();

        return $this;
    }
}
