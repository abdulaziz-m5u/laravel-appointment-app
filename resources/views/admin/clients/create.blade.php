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
                    <h1 class="h3 mb-0 text-gray-800">{{ __('create client') }}</h1>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.clients.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('name') }}</label>
                        <input type="text" class="form-control" id="name" placeholder="{{ __('name') }}" name="name" value="{{ old('name') }}" />
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('email') }}</label>
                        <input type="email" class="form-control" id="email" placeholder="{{ __('email') }}" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('phone') }}</label>
                        <input type="text" class="form-control" id="phone" placeholder="{{ __('phone') }}" name="phone" value="{{ old('phone') }}" />
                    </div>
                    <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                        <label for="photo">Photo</label>
                        <div class="needsclick dropzone" id="photo-dropzone">

                        </div>
                        @if($errors->has('photo'))
                            <em class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </em>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    

    <!-- Content Row -->

</div>
@endsection


@push('style-alt')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
@endpush

@push('script-alt')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>
    Dropzone.options.photoDropzone = {
        url: "{{ route('admin.clients.storeMedia') }}",
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
        size: 2,
        width: 4096,
        height: 4096
        },
        success: function (file, response) {
        $('form').find('input[name="photo"]').remove()
        $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
        },
        removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="photo"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
        },
        init: function () {
            @if(isset($client) && $client->photo)
                var file = {!! json_encode($client->photo) !!}
                    this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, "{{ $client->photo->getUrl('thumb') }}")
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }
            return _results
        }
    }
</script>
@endpush