<?php

namespace App\Admin\Navigation;

use SleepingOwl\Admin\Navigation\Page;
use SleepingOwl\Admin\Contracts\Navigation\PageInterface;

class PageTitle extends Page implements PageInterface
{
    /**
     * @return string
     */
    public function getUrl()
    {
        return true;
    }

    /**
     * @param null $view
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Throwable
     */
    public function render($view = null)
    {
        $data = $this->toArray();

        if (! is_null($view)) {
            return view($view, $data)->render();
        }

        return view('admin._partials.navigation.page_title', $data)->render();
    }
}
