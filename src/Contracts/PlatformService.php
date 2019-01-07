<?php

namespace Platform\Contracts;

use Illuminate\Http\Request;

interface PlatformService
{
    /**
     * @return mixed
     */
    public function response();

    /**
     * @return mixed
     */
    public function resources();

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function resource(int $id);

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request);

    /**
     * @param Request $request
     * @param int $id
     *
     * @return $this
     */
    public function updateAs(Request $request, int $id);

    /**
     * @param int $id
     *
     * @return $this
     * @throws \Exception
     */
    public function deleteAs(int $id);
}
