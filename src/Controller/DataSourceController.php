<?php

namespace Platform\Controller;

class DataSourceController extends Controller
{
    /**
     * DataSourceController constructor.
     */
    public function __construct()
    {
        $this->middleware('login:admin');
    }

    public function __invoke()
    {
        //
    }
}
