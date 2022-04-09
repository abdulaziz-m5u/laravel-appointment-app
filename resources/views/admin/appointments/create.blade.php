@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<!-- Content Row -->
        <div class="card shadow">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{ __('create appointment') }}</h1>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.appointments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="employee">{{ __('employee') }}</label>
                        <select class="form-control" name="employee_id">
                            @foreach($employees as $id => $employee)
                                <option value="{{ $id }}"> {{ $employee }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="client">{{ __('client') }}</label>
                        <select class="form-control" name="client_id" >
                            @foreach($clients as $id => $client)
                                <option value="{{ $id }}"> {{ $client }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_time">{{ __('Start Time') }}</label>
                        <input type="text" class="form-control datetimepicker" id="start_time" name="start_time" value="{{ old('start_time') }}" />
                    </div>
                    <div class="form-group">
                        <label for="finish_time">{{ __('Finish Time') }}</label>
                        <input type="text" class="form-control datetimepicker" id="finish_time" name="finish_time" value="{{ old('finish_time') }}" />
                    </div>
                    <div class="form-group">
                        <label for="service">{{ __('service') }}</label>
                        <select class="form-control" name="services[]" multiple id="">
                            @foreach($services as $id => $service)
                                <option value="{{ $id }}"> {{ $service }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comments">{{ __('comments') }}</label>
                        <textarea class="form-control" id="comments" placeholder="{{ __('comments') }}" name="comments" >
                            {{ old('comments') }}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">{{ __('price') }}</label>
                        <input type="text" class="form-control" id="price" placeholder="{{ __('price') }}" name="price" value="{{ old('price') }}" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    

    <!-- Content Row -->

</div>
@endsection


@push('style-alt')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@endpush

@push('script-alt')
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            locale: 'en',
            sideBySide: true,
            icons: {
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right'
            },
            stepping: 10
        });
    </script>
@endpush