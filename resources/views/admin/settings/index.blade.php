@extends('titan::layouts.admin')

@section('page')
    <h1 class="h3 mb-4 text-gray-800">Settings</h1>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($settings as $setting)

                    <tr>
                        <td class="align-middle">{{ $setting->key }}</td>
                        <td class="align-middle">{{ $setting->value }}</td>
                        <td class="align-middle"><a href="{{ route('admin.settings.edit', $setting) }}" class="btn btn-primary">Edit</a> </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
