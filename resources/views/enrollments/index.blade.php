@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Enroll student in a subject</h1>
    <form method="POST" action="{{ route('enrollments.store') }}">
        @csrf
@include('partials.once')
        <div class="grid">
            <div>
                <label>Student</label>
                <select name="student_id">
                    <option value="">-- select --</option>
                    @foreach ($students as $s)
                        <option value="{{ $s->id }}" @selected(old('student_id') == $s->id)>
                            {{ $s->student_no }} - {{ $s->last_name }}, {{ $s->first_name }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Subject</label>
                <select name="subject_id">
                    <option value="">-- select --</option>
                    @foreach ($subjects as $sub)
                        <option value="{{ $sub->id }}" @selected(old('subject_id') == $sub->id)>
                            {{ $sub->code }} - {{ $sub->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_id') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>School year</label>
                <input type="text" name="school_year" placeholder="2026-2027" value="{{ old('school_year') }}">
                @error('school_year') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>
        <button type="submit">Enroll</button>
    </form>
</div>

<div class="card">
    <h1>Enrollments</h1>
    <table>
        <tr><th>Student</th><th>Subject</th><th>Units</th><th>School year</th></tr>
        @php $rows = 0; @endphp
        @foreach ($students as $s)
            @foreach ($s->subjects as $sub)
                @php $rows++; @endphp
                <tr>
                    <td>{{ $s->last_name }}, {{ $s->first_name }}</td>
                    <td>{{ $sub->code }} - {{ $sub->name }}</td>
                    <td>{{ $sub->units }}</td>
                    <td>{{ $sub->pivot->school_year }}</td>
                </tr>
            @endforeach
        @endforeach
        @if ($rows === 0)
            <tr><td colspan="4">No enrollments yet.</td></tr>
        @endif
    </table>
</div>
@endsection