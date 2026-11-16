@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Add subject</h1>
    <form method="POST" action="{{ route('subjects.store') }}">
        @csrf
@include('partials.once')
        <div class="grid">
            <div>
                <label>Code</label>
                <input type="text" name="code" value="{{ old('code') }}">
                @error('code') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Units</label>
                <input type="number" name="units" value="{{ old('units') }}">
                @error('units') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>
        <button type="submit">Add</button>
    </form>
</div>

<div class="card">
    <h1>Subjects</h1>
    <table>
        <tr><th>Code</th><th>Name</th><th>Units</th></tr>
        @forelse ($subjects as $s)
            <tr><td>{{ $s->code }}</td><td>{{ $s->name }}</td><td>{{ $s->units }}</td></tr>
        @empty
            <tr><td colspan="3">No subjects yet.</td></tr>
        @endforelse
    </table>
</div>
@endsection