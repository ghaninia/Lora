<div class='content animated bounceInDown '>
    <div class='close cursor'></div>
    <div class='title'>
        <i class="icon icon-feather-plus"></i>
       {{ trans('dashboard.tickets.append') }}
    </div>
    <div class="context">
        <form id="ticketAppendStore" method="POST" action="{{ route('dashboard.ticket.appendStore') }}" >
            @csrf

            <div class="input-with-icon">
                <div id="autocomplete-container">
                    <input autocomplete="off" id="subject" type="text" name="subject" placeholder="{{ trans('dashboard.tickets.subject') }}">
                </div>
                <i class="icon-material-baseline-mail-outline"></i>
            </div>

            <div class="form-group margin-top-10">
                <label for="from_type">{{ trans('dashboard.tickets.priority.text') }}</label>
                @foreach(['low' , 'medium' , 'hight' ] as $key )
                    <div class="radio margin-right-5" >
                        <input id="priority_{{ $key }}" value="{{ $key }}" name="priority"  type="radio" checked>
                        <label for="priority_{{ $key }}"><span class="radio-label"></span>{{ trans("dashboard.tickets.priority.{$key}") }}</label>
                    </div>
                @endforeach
            </div>

            <div class="form-group margin-top-10">
                <label for="from_type">{{ trans('dashboard.tickets.from_type.text') }}</label>
                @foreach(['user' => 'me' , 'role' => 'my_role' ] as $key => $value)
                    <div class="radio margin-right-5" >
                        <input id="from_type_{{ $key }}" value="{{ $key }}" name="from_type" type="radio" checked>
                        <label for="from_type_{{ $key }}"><span class="radio-label"></span>{{ trans("dashboard.tickets.from_type.{$value}") }}</label>
                    </div>
                @endforeach
            </div>

            <div class="form-group margin-top-10">
                <label for="to_type">{{ trans('dashboard.tickets.to_type.text') }}</label>
                @foreach([ 'role' , 'user' ] as $key)
                    <div class="radio margin-right-5" >
                        <input id="to_type_{{ $key }}" value="{{ $key }}" name="to_type" type="radio" >
                        <label for="to_type_{{ $key }}"><span class="radio-label"></span>{{ trans("dashboard.tickets.to_type.{$key}") }}</label>
                    </div>
                @endforeach
            </div>

            <div id="to_id" class="form-group margin-top-10 hidden">
                <div class="insert">

                </div>
            </div>

            <div class="input-with-icon margin-top-15">
                <div id="autocomplete-container">
                    <textarea rows="2" name="message" id="message" placeholder="{{ trans('dashboard.tickets.message') }}"></textarea>
                </div>
                <i class="icon-material-outline-question-answer"></i>
            </div>

            <div class="tfoot">
                <button class="button dark ripple-effect" id="popupBtn">
                    <i class="icon icon-feather-plus"></i>
                    {{ trans('dashboard.tickets.append') }}
                </button>
            </div>
        </form>
    </div>
</div>

