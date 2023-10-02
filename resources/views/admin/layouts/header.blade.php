<h4>
    {{$params['titulo']}}
</h4>
@if(isset($params['arvore']))
<h6>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb text-secondary">
            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
            @foreach($params['arvore'] as $v)
                @if($v["url"] == '')
                    <li class="breadcrumb-item active"  aria-current="page">{{ $v['titulo'] }}</li>
                @else        
                    <li class="breadcrumb-item"  aria-current="page"><a href="{{ url($v["url"]) }}">{{ $v['titulo'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>
</h6>
@endif

