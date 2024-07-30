<div class="card">
    <div class="card-content">
        <ul class="nav nav-tabs">
            @foreach ($tab_title as $key => $title)
                @php
                    $title['active'] = $key == 0;
                @endphp
                <li class="nav-item">
                    <a class="nav-link 
                    {{ $title['active'] ? 'active' : '' }}
                    {{ $title['disabled'] ? 'disabled' : '' }}
                     "
                        aria-current="page" id="{{ $title['title_id'] }}" data-toggle="tab"
                        data-target="#{{ $tabs_id . $title['data_target'] }}" type="button"
                        href="#{{ $title['id'] }}">{{ $title['label'] }}</a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="myTabContent">
            @foreach ($tab_content as $key => $content)
                @php
                    $content['active'] = $key == 0;
                @endphp

                <div class="tab-pane fade {{ $content['active'] ? 'show active' : '' }}"
                    id="{{ $tabs_id . $content['content_id'] }}" role="tabpanel">
                    {!! $content['view']->render() !!}
                </div>
            @endforeach
        </div>
    </div>

</div>
