@inject("ticket" , "\App\Models\Ticket" )
<div class="messages-headline">
    @if(!! $information )
        <h4>{{ $information->subject }}</h4>
    @endif
    @if( $information->status == 'enable' )
        <a class="pointer changestatus message-action" data-id="{{ $trakingCode }}">
            <i class="icon-feather-trash-2"></i>
        </a>
    @endif
</div>

<!-- Message Content Inner -->
<div class="message-content-inner" id="content">
    @if($contents->isNotEmpty())
        @foreach($contents as $date => $content)
        <!-- Time Sign -->
            <div class="message-time-sign">
                <span>{{ $date }}</span>
            </div>
            @foreach($content as $message)

                @php( $ContentInformation = $ticket::information($message->from_type , $message->from_id) )

                <div class="message-bubble {{ $ticket::haveMe($message) ? "me" : null  }}">
                    <div class="message-bubble-inner">
                        <div class="message-avatar">
                            @if( isset( $ContentInformation['picture'] ) )
                                <img src="{{ $ContentInformation['picture'] }}" />
                            @endif
                        </div>
                        <div class="message-text">
                            <div class="name">
                                @if( isset( $ContentInformation['data']['name'] ) )
                                    {{ $ContentInformation['data']['name'] }}
                                @endif
                            </div>
                            @if(!! $message->subject && !! $message->priority )
                                <ul class="subjects">
                                    <li><strong>{{ trans("dashboard.tickets.priority.text") }} :</strong>{{ trans("dashboard.tickets.priority.{$message->priority}") }}</li>
                                    <li><strong>{{ trans("dashboard.items.status") }} :</strong>
                                        @if($message->status == 'enable')
                                            {{  trans("dashboard.status.true") }}
                                        @else
                                            {{  trans("dashboard.status.false") }}
                                        @endif
                                    </li>
                                    <li><strong>{{ trans('dashboard.tickets.subject') }} :</strong>{{ $message->subject  }}</li>
                                    <li><strong>{{ trans('dashboard.tickets.traking_code') }} :</strong>{{ $trakingCode }}</li>
                                </ul>
                            @endif
                            <p>
                                {{ $message->message }}
                            </p>
                            <ul class="message-info">
                                <li class="{{ $message->seen ? "seen" : "notseen" }}"></li>
                                <li>{{ $message->created_at->format("H:i:s") }}</li>
                            </ul>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        @endforeach
    @endif
</div>
<!-- Message Content Inner / End -->

<!-- Reply Area -->
@if( $information->status == 'enable' )
    <form method="POST" class="message-reply replayMessage" action="{{ route('dashboard.ticket.replay') }}">
        @csrf
        <input type="hidden" name="tracking_code" value="{{ $trakingCode }}">
        <textarea required cols="1" id="message" name="message" rows="1" placeholder="{{ trans('dashboard.tickets.replay') }}" data-autoresize></textarea>
        <button class="button ripple-effect">{{ trans('dashboard.tickets.send') }}</button>
    </form>
@endif