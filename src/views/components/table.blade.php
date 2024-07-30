<div class="table-container-{{$name}} py-2">
    {!! $renderFilters() !!}
    <table id="{{ $id }}" class="{{ $class }}" citadel-src={!! $src !!}
        citadel-name="{{ $name }}" citadel-filter-class=".{{ $class }}" citadel-table>
    </table>
</div>