<?php

namespace Itszun\Citadel\Menu;

use Itszun\Citadel\Component;
use Itszun\Citadel\Traits\UseLibraryView;
use Illuminate\Support\Facades\Log;

class MenuContainer extends Component
{
    use UseLibraryView;

    /**
     * Get instance
     *me
     * @return static
     */
    final public static function getInstance()
    {
        $class = config('citadel.class.menu_container');
        return new $class;
    }

    public function renderSidebarMenu()
    {
        $menu = "";
        
        foreach ($this->sidebar() as $menu_item) {
            try {
                $menu .= $menu_item->render();
            } catch (\Throwable $th) {
                Log::error("Problem rendering menu item", compact('menu_item'));
            }
        }

        !empty($this->view) ?: $this->view(config('citadel.sidebar_menu_container'));
        // dd($menu);
        $view = $this->getView([
            'menu_content_html' => $menu
        ])->render();

        return $view;
    }

    public static function sidebar(): array
    {
        return [];
    }

    public static function navbar(): array
    {
        return [];
    }
}
