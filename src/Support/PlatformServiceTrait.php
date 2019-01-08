<?php

namespace Platform\Support;

trait PlatformServiceTrait
{
    /**
     * @param bool $message
     *
     * @return array
     */
    public function message($message)
    {
        return $message ? ['message' => __('操作成功')] : [];
    }
}
