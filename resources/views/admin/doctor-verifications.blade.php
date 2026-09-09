@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h3 class="mb-3">Doctor verifications</h3>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header fw-bold">
            Pending applications
            <span class="badge bg-warning text-dark ms-1">{{ $pending->count() }}</span>
        </div>
        <div class="card-body p-0">
            @if ($pending->isEmpty())
                <p class="text-muted m-3">No applications waiting for review.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>Certificate</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $applicant)
                                <tr>
                                    <td>{{ $applicant->name }}</td>
                                    <td>{{ $applicant->email }}</td>
                                    <td>{{ $applicant->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if ($applicant->doctor_certificate)
                                            <a href="{{ $applicant->doctor_certificate }}" target="_blank" rel="noopener">
                                                View file
                                            </a>
                                        @else
                                            <span class="text-muted">none provided</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <form method="POST"
                                              action="{{ route('admin.doctors.approve', $applicant) }}"
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form method="POST"
                                              action="{{ route('admin.doctors.reject', $applicant) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Reject this application? The user becomes a normal member.');">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-danger">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-bold">Approved doctors ({{ $approved->count() }})</div>
        <div class="card-body p-0">
            @if ($approved->isEmpty())
                <p class="text-muted m-3">None yet.</p>
            @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approved as $doctor)
                            <tr>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->doctor_verified_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
