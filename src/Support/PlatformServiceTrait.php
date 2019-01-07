<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Support;

use Illuminate\Http\Request;

trait PlatformServiceTrait
{
    /**
     * @return mixed
     */
    public function index()
    {
        return $this->service()->resources();
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
        return $this->service()->deleteAs($id)->response();
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
