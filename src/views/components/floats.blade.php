@php
    $tabs_id = 'floats-';
@endphp
<div class="card floaters">
    <div class="card-content">
        <div class="d-flex will-hidden">
            <ul class="nav nav-tabs">
                @foreach ($tab_title as $key => $title)
                    @php
                        $title['active'] = $key == 0;
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link 
                            {{ $title['active'] ? 'active' : '' }}
                            {{ $title['disabled'] ? 'disabled' : '' }}
                             middle-align w-100 text-center text-nowrap
                             "
                            aria-current="page" id="{{ $title['title_id'] }}" data-toggle="tab"
                            data-target="#{{ $tabs_id . $title['data_target'] }}" type="button"
                            href="#{{ $title['id'] }}">
                            @if ($title['icon'])
                                <x-material-icon icon="{{ $title['icon'] }}" />
                            @endif
                            {{ $title['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="tab-content will-hidden" id="myTabContent">
            @foreach ($tab_content as $key => $content)
                @php
                    $content['active'] = $key == 0;
                @endphp

                <div class="tab-pane floaters-content fade {{ $content['active'] ? 'show active' : '' }}"
                    id="{{ $tabs_id . $content['content_id'] }}" role="tabpanel">
                    {!! $content['view']->render() !!}
                </div>
            @endforeach
        </div>
    </div>

</div>
