@if ($as_group)
    <a class="dropdown-item middle-align text-center rounded-sm  w-100 text-nowrap text-{{ $color }}"
        @if (!empty($onClick)) citadel-onclick="{{ $onClick }}" @endif href="{{ $getUrl() }}">
        @if (!empty($icon))
            <x-material-icon icon="{{ $icon }}" />
        @endif
        {{ $label }}
    </a>
@else
    <a class="btn btn-{{ $color }} middle-align text-center rounded-sm text-nowrap " href="{{ $getUrl() }}"
        @if (!empty($onClick)) citadel-onclick="{{ $onClick }}" @endif>
        @if (!empty($icon))
            <x-material-icon icon="{{ $icon }}" />
        @endif
        {{ $label }}
    </a>
@endif
