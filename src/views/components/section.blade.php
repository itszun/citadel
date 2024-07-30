<div class="card">
    <div class="card-header border-bottom p-0 px-2 d-flex justify-content-between flex-wrap  align-items-center">
        <div class="card-title col-12 col-md-6 pt-2">
            <div>
                {{ $label }}
                @isset($badge_info)
                {!! $badge_info !!}
                    
                @endisset
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="d-flex justify-content-md-end" style="gap: 10px; padding: 12px 0">
                @foreach ($headers as $h)
                    {!! $h->render() !!}
                @endforeach
                @if ($has_floaters)
                    <div class="border-right"></div>
                    <a href="javascript:void(0)" onclick="toggleFloaters(event)"
                        class="btn-show-floaters middle-align btn w-auto btn-info rounded-sm m-0 d-none d-md-block"
                        data-blueprint="#citadel-blueprint" data-container="#citadel-floaters">
                        <x-material-icon icon="keyboard_double_arrow_left" />
                    </a>
                @endif
            </div>
        </div>
    </div>


    <div class="card-body citadel-section {{ $see_more ? "see-more" : "without-see-more"}}" id="section-{{ $id }}">
        {!! $renderView() !!}
        @if($see_more)
        <div class="citadel-see-more">
            <a href="#" onclick="section_see_more(event)" class="citadel-section-expand middle-align text-nowrap"
                data-target="#section-{{ $id }}">lihat
                Selengkapnya <x-material-icon icon="expand_content" /></a>
            <a href="#" onclick="section_see_more(event)"
                class="citadel-section-collapse middle-align text-nowrap"
                data-target="#section-{{ $id }}">lihat
                Lebih Sedikit <x-material-icon icon="collapse_content" /></a>
        </div>
        @endif
        {{-- {{ $renderChildComponent() }} --}}
    </div>
</div>
