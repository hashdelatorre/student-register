@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Add department</h1>
    <form method="POST" action="{{ route('departments.store') }}">
        @csrf
        @include('partials.once')   
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name') <p class="error">{{ $message }}</p> @enderror
        <button type="submit">Add</button>
    </form>
</div>

<div class="card">
    <h1>Departments</h1>
    <table>
        <tr><th>#</th><th>Name</th><th>No. of students</th></tr>
        @forelse ($departments as $d)
            <tr><td>{{ $d->id }}</td><td>{{ $d->name }}</td><td>{{ $d->students_count }}</td></tr>
        @empty
            <tr><td colspan="3">No departments yet.</td></tr>
        @endforelse
    </table>
</div>
@endsection