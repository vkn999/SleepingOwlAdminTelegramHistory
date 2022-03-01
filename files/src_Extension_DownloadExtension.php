<?php


namespace Dunco\Extension;


use KodiComponents\Support\HtmlAttributes;
use SleepingOwl\Admin\Contracts\Display\DisplayExtensionInterface;
use SleepingOwl\Admin\Contracts\Display\Placable;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\Extension\Extension;

class DownloadExtension extends Extension implements Placable, Initializable
{
    use HtmlAttributes;

    /**
     * @var string|\Illuminate\View\View
     */
    protected $view = 'dunco::export';

    /**
     * @var string
     */
    protected $placement = 'inside.panel';

    protected $route;
    protected $with;

    public function __construct($route, $with)
    {
        $this->route = $route;
        $this->with = $with;
    }

    public function set($route)
    {
        $this->route = $route;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getPlacement()
    {
        return $this->placement;
    }

    public function initialize()
    {
        $this->getDisplay()->addScript('download', asset('js/download.js'));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'route' => $this->route,
            'with' => $this->with,
            'attributes' => $this->htmlAttributesToString(),
        ];
    }
}
