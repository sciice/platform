<?php

namespace Platform\Service;

use Illuminate\Http\Request;
use Platform\Model\Platform;
use Platform\Resources\PlatformResource;
use Platform\Support\PlatformServiceTrait;
use Platform\Contracts\PlatformService as Service;

class PlatformService implements Service
{
    use PlatformServiceTrait;

    /**
     * @var int
     */
    const NOT_CAN_DATA = 1;

    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * PlatformService constructor.
     *
     * @param Platform|\Illuminate\Database\Eloquent\Builder $model
     */
    public function __construct(Platform $model)
    {
        $this->model = $model->getModel();
    }

    /**
     * @param bool $message
     *
     * @return mixed
     */
    public function resources($message = true)
    {
        return PlatformResource::collection($this->model->paginate())
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
        return (new PlatformResource($this->model->findOrFail($id)))
            ->additional($this->message($message));
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request)
    {
        $this->model->create($request->except('role'))->assignRole($request->input('role'));

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
        abort_if($id === self::NOT_CAN_DATA, 403, __('该账号不允许编辑'));

        $data = $this->model->findOrFail($id);
        $data->update($request->except(['username', 'role']));
        $data->syncRoles($request->input('role'));

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
        abort_if($id === self::NOT_CAN_DATA, 403, __('该账号不允许删除'));

        $this->model->findOrFail($id)->delete();

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function updateUserAvatar(Request $request)
    {
        $this->model->findOrFail($request->user('admin')->id)
            ->uploadImage($request->file('avatar'), 'avatar');

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function updateUserAccountInfo(Request $request)
    {
        $this->model->findOrFail($request->user('admin')->id)
            ->update($request->except('username'));

        return $this;
    }
}
