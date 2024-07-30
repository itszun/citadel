<?php

namespace Itszun\Citadel\Menu;

use Itszun\Citadel\Component;
use Itszun\Citadel\Traits\UseLibraryView;
use Itszun\Citadel\Traits\UseURL;
use Closure;

class MenuItem extends Component
{
    use UseURL, UseLibraryView;

    protected $authorize = true;
    protected $children = [];
    protected $icon = "chevron_right";
    protected $show = true;

    protected $is_open = false;
    protected $is_active = false;
    protected $active = false;

    public function authorize(\Closure|bool $authorize)
    {
        $this->authorize = $authorize;
        return $this;
    }

    public function route($name, $parameters = [], $absolute = true)
    {
        $this->url = route($name, $parameters, false);
        return $this;
    }

    public function children(array $children)
    {
        $this->children = $children;
        return $this;
    }

    public function renderChildren()
    {
        $str = "";
        foreach ($this->children as $c) {
            $str .= $c->render();
        }
        return $str;
    }

    public function getData()
    {
        $this->isActive();
        $child = $this->renderChild();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'tooltip' => 'Tooltip',
            'icon' => $this->icon,
            'children' => $this->children,
            'children_html' => $child['html'],
            'is_show' => $this->show,
            'li_class' => $this->classProcessor(!empty($child['html']), $this->is_active, $this->is_open),
            'url' => $this->url,
            'is_open' => $this->is_open
        ];
    }

    public function active()
    {
        return $this;
    }

    public function isActive()
    {
        $check_is_active = function ($this_url) {
            if (empty($this_url) || $this_url == "#") {
                return false;
            }
            $menu_url = str_replace("/", "\/", $this_url);
            // because route('', absolute: false) resulting with "/{path}" we need to add "/" in front of request()->path()
            $url = "/" . request()->path();
            $result = 0;
            $pattern = "/^" . $menu_url . "\/*$/";
            preg_match($pattern, $url, $result);
            return !empty($result);
        };
        // if ($this->name == "create_pola_belanja") dd($this, $check_is_active($this->url));

        $this->is_active = is_callable($this->active)
            ? Closure::fromCallable($this->active)->call($this)
            : $check_is_active($this->url);
        return $this->is_active;
    }

    protected function classProcessor($has_sub, $is_active, $is_open)
    {
        $result = fn ($condition, $value) => $condition ? $value : null;
        return implode(" ", [
            'citadel-menu-item',
            $result($has_sub, 'has-sub'),
            $result($is_active, 'active'),
            $result($is_open, 'open'),
        ]);
    }

    protected function renderChild()
    {
        $html = "";
        foreach ($this->children as $menu_item) {
            if ($menu_item->isActive()) {
                $this->is_open = true;
                $this->is_active = true;
            }
            $html .= $menu_item->render();
        }
        return compact('html');
    }

    protected function isAuthorize()
    {
        $user = optional(auth()->user());
        $this->authorize = is_callable($this->authorize) ? Closure::fromCallable($this->authorize)->call($this, $user) : $this->authorize;
        return $this->authorize;
    }

    public function render()
    {
        if (!$this->isAuthorize()) {
            return "";
        }
        $this->view(config('citadel.sidebar_menu_item'));
        return $this->getView($this->getData())->render();
    }
}
