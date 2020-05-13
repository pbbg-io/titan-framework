@extends('layouts.admin')

@section('page')

    <h1 class="h3 mb-4 text-gray-800">Search Results for "{{ $search_term }}"</h1>
    <h2><i class="fas fa-users"></i> {{ $results['members']->count() }} Users Found</h2>
    <table class="table table-hover table-striped table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Last Move</th>
            <th></th>
        </tr>
        </thead>
        <tbody class="align-middle">
        @forelse($results['members'] as $member)


            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->last_move ?? 'Never' }}</td>
                <td><a href="{{ route('admin.users.edit', $member->id) }}" class="btn btn-primary">
                        Edit
                    </a> </td>
            </tr>

            @empty

            <tr>
                <td colspan="999">No users were found with that criteria</td>
            </tr>

        @endforelse
        </tbody>
    </table>

    <h2><i class="fas fa-cogs"></i> {{ $results['settings']->count() }} Settings Found</h2>

    <table class="table table-hover table-striped table-bordered">
        <thead>
        <tr>
            <th>Key</th>
            <th>Value</th>
            <th></th>
        </tr>
        </thead>
        <tbody class="align-middle">
        @forelse($results['settings'] as $setting)


            <tr>
                <td>{{ $setting->key }}</td>
                <td>{{ $setting->value }}</td>
                <td><a href="{{ route('admin.settings.edit', $setting->id) }}" class="btn btn-primary">
                        Edit
                    </a> </td>
            </tr>

        @empty

            <tr>
                <td colspan="999">No settings were found with that criteria</td>
            </tr>

        @endforelse
        </tbody>
    </table>
@endsection
