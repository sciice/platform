<?php

namespace Platform\Contracts;

use Illuminate\Http\Request;

interface PlatformService
{
    /**
     * @param bool $message
     *
     * @return array
     */
    public function message($message);

    /**
     * @param bool $message
     *
     * @return mixed
     */
    public function resources($message = true);

    /**
     * @param int $id
     *
     * @param bool $message
     *
     * @return mixed
     */
    public function resource(int $id, $message = false);

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
