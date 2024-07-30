<?php

namespace Itszun\Citadel;

use Itszun\Citadel\Menu\MenuContainer;
use App\Models\Menu;
use App\Models\UserPosition;
use App\Models\VMS\User;
use Itszun\Citadel\Layouts\Floater;
use App\Services\Dashboard;
use App\Settings\GeneralSettings;
use Error;
use Illuminate\Support\Facades\View;
use stdClass;

class Page extends Component
{
    protected $schema;
    protected $floaters = [];
    protected $is_view = true;
    protected $data = [];

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function schema(array $schema)
    {
        $this->schema = $schema;
        return $this;
    }

    public function floats(array $floaters)
    {
        $this->floaters = $floaters;
        return $this;
    }

    public function pageInfoShare()
    {
        $user = auth()->check() ? auth()->user() : new User();
        $current_user_position = $user->current_position ?? new UserPosition();
        $menu = Menu::getAdminSidebarMenuRender();
        $page_info = $this->getPageInfo();
        View::share([
            'menu' => $menu,
            'page_info' => $page_info,
            'user' => $user,
            'current_user_position' => $current_user_position,
            'is_view_only' => $this->is_view
        ]);
    }


    public function getPageInfo()
    {
        $settings = app(GeneralSettings::class);
        return [
            'name' => $this->name,
            'title' => $this->label,
            'prefix' => $settings->site_name,
            'site_name' => $settings->site_name
        ];
    }


    public function render()
    {
        // $floats = parent::renderChildComponents($this->floaters, $this->data);
        $blueprints = parent::renderChildComponents($this->schema, (array_merge($this->data, ['has_floaters' => !empty($this->floaters)])));
        // dd($floats);
        // dd(MenuContainer::getInstance()->renderSidebarMenu());
        $this->pageInfoShare();
        return view(config('citadel.template'), array_merge($this->data, [
            'blueprints' => $blueprints,
            'renderBlueprints' => fn () => $this->renderSchema($blueprints, !empty($this->floaters)),
            'renderFloats' => fn () => $this->renderFloats($this->floaters, $this->data),
            'sidebarMenuRender' => fn () => MenuContainer::getInstance()->renderSidebarMenu()
        ]));
    }

    public function renderFloats(&$floats, &$data)
    {
        $tab_title = [];
        $tab_content = [];
        foreach ($floats as $tab) {
            if (!($tab instanceof Floater)) throw new Error("Tabs schema should having Tab Component Only. Getting " . gettype($tab) . " instead");
            $tab_title[] = $tab->getTitle();
            $tab_content[] = $tab->getContent();
        }

        $data = compact('tab_title', 'tab_content');

        return view(config('citadel.floats'), $data)->render();
    }

    public function renderSchema($blueprints, $hasFloats = false)
    {

        $acc = "";
        foreach ($blueprints as $component) {
            try {
                $acc .= $component->render();
            } catch (\Throwable $th) {
                dd($component, $th);
            }
        }
        return $acc;
    }
}
