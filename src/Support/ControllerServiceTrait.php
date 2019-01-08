<?php

namespace Platform\Support;

use Illuminate\Http\Request;

trait ControllerServiceTrait
{
    /**
     * @return mixed
     */
    public function index()
    {
        return $this->service()->resources(false);
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->service()->resource($id);
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        return $this->service()->deleteAs($id)->resources();
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    abstract public function store(Request $request);

    /**
     * @param Request $request
     * @param int $id
     *
     * @return mixed
     */
    abstract public function update(Request $request, int $id);

    /**
     * @return \Platform\Contracts\PlatformService
     */
    abstract protected function service();
}
