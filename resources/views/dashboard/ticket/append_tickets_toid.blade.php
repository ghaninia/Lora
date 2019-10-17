@if($items->isNotEmpty())
    <select name="to_id"  class="selectpicker" data-live-search="true">
        @foreach($items as $item)
            @if( $type == "user" )
                <option value="{{ $item->id }}" data-subtext="{{ $item->fullname }}">{{ $item->username }}</option>
            @elseif( $type == "role" )
                <option value="{{ $item->id }}" data-subtext="{{ str_slice( $item->description , 30 ) }}">{{ $item->name }}</option>
            @endif
        @endforeach
    </select>
    @else
    <div class="notification warning closeable">
        {{ trans('dashboard.tickets.notfound') }}
    </div>
@endif