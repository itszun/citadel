@php

    // $has_sub = !$menu->children->isEmpty() ? 'has-sub' : '';
    // $url = empty($menu->url) ? '#' : url($menu->url);
    // $url = $has_sub ? '#' : $url;
    // $is_child = isset($is_child) ? $is_child : null;

    // $is_show = in_array($menu->module, $permissions);
    // $render_child = $menu->renderChild($permissions); // ""
    // if (!empty($render_child)) {
    //     $is_show = true;
    // }
    // if ($menu->module == 'home' && Auth::user()->user_type == 'internal') {
    //     $is_show = true;
    // }

    // if ($menu->module == 'home_vendor' && Auth::user()->user_type == 'vendor') {
    //     $is_show = true;
    // }

    // if(Auth::user()->nip == "SUPERADMIN")
    // {
    //     $is_show = true;
    // }

    // $li_class = $is_child ? '' : $has_sub . ' nav-item ' . ($menu->is_active ? 'active' : '');
@endphp

@if ($is_show)
    <li class="{{ $li_class }}" id="menu-{{ $id }}">
        <a title="{{ $tooltip }}" href="{{ $url }}" class="nav_link">
            <div class="d-flex align-items-center">
                <x-material-icon icon="{{ $icon }}" />
                <span class="menu-title ml-1">
                    {{ $label }}
                </span>
            </div>
        </a>
        @if (!empty($children_html))
            <ul class="menu-content" id="data-menu-{{ $id }}">
                {!! $children_html !!}
            </ul>
        @endif
    </li>

@endif
