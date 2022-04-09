@extends('layouts.admin')

@section('content')
<div class="container-fluid">

<!-- Content Row -->
        <div class="card shadow">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{ __('Calendar') }}</h1>
                </div>
            </div>
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
    

    <!-- Content Row -->

</div>
@endsection


@push('style-alt')
<link rel='stylesheet'
                  href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>

@endpush

@push('script-alt')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
      $(document).ready(function () {
        // page is now ready, initialize the calendar...
        events = {!! json_encode($events) !!};

        $('#calendar').fullCalendar({
          // put your options and callbacks here
          events: events,
          defaultView: 'agendaWeek'
        })
      })
    </script>
@endpush