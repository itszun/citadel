<div class="btn-group" role="group">
    <button type="button"
        class="btn btn-{{ $color }} dropdown-toggle middle-align text-center rounded-sm text-nowrap"
        data-toggle="dropdown" aria-expanded="false" title="{{ $label }}">
        @if (!empty($icon))
            <x-material-icon icon="{{ $icon }}" />
        @endif
        {{ $label }}
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        @foreach ($items as $comp)
            {!! $comp->render() !!}
        @endforeach
    </div>
</div>
