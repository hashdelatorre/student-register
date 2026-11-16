@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Register student</h1>
    <form method="POST" action="{{ route('students.store') }}">
@csrf
@include('partials.once')
        <div class="grid">
            <div>
                <label>Department</label>
                <select name="department_id">
                    <option value="">-- select --</option>
                    @foreach ($departments as $d)
                        <option value="{{ $d->id }}" @selected(old('department_id') == $d->id)>{{ $d->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Student no.</label>
                <input type="text" name="student_no" value="{{ old('student_no') }}">
                @error('student_no') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>First name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}">
                @error('first_name') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Last name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}">
                @error('last_name') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}">
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Address</label>
                <input type="text" name="address" value="{{ old('address') }}">
                @error('address') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
                @error('phone') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Birthdate</label>
                <input type="date" name="birthdate" value="{{ old('birthdate') }}">
                @error('birthdate') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>
        <button type="submit">Register</button>
    </form>
</div>

<div class="card">
    <h1>Students</h1>
    <table>
        <tr>
            <th>Student no.</th><th>Name</th><th>Email</th><th>Department</th>
            <th>Phone</th><th>Address</th><th>Birthdate</th>
        </tr>
        @forelse ($students as $s)
            <tr>
                <td>{{ $s->student_no }}</td>
                <td>{{ $s->first_name }} {{ $s->last_name }}</td>
                <td>{{ $s->email }}</td>
                <td>{{ $s->department->name }}</td>
                <td>{{ $s->profile->phone ?? '-' }}</td>
                <td>{{ $s->profile->address ?? '-' }}</td>
                <td>{{ $s->profile->birthdate ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="7">No students yet.</td></tr>
        @endforelse
    </table>
</div>
@endsection