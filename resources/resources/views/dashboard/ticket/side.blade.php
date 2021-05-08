@inject("ticket" , "\App\Models\Ticket" )
@if($tickets->isNotEmpty())
    @foreach($tickets as $ticket_id => $item)
        <li data-id="{{ $ticket_id }}">
            <a class="pointer">

                @php( $SideInformation = $ticket::information($item->from_type , $item->from_id) )
                {{--{{ dd($information) }}--}}
                <div class="message-avatar">

                    @if( isset($SideInformation['picture'] , $SideInformation['data']['name'] ) )
                        <img title="{{ $SideInformation['data']['name'] }}" src="{{ $SideInformation['picture'] }}" />
                    @endif

                    @if( array_key_exists( $ticket_id , $NotReads ) )
                        <span class="nav-tag">{{ $NotReads[$ticket_id] }}</span>
                    @endif

                </div>

                <div class="message-by">
                    <div class="message-by-headline">
                        @if( isset( $SideInformation['data']['name'] ) )
                            <h3>{{ $SideInformation['data']['name']  }}</h3>
                        @endif
                        <span>{{ $item->difference_at }}</span>
                    </div>
                    <p>{{ str_slice( strip_tags($item->subject) , 40 ) }}</p>
                </div>

            </a>
        </li>
    @endforeach
@endif