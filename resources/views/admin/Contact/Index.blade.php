@extends('components.layouts.admin.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800 fw-bold">Contact Request Management</h2>
    </div>

    {{-- Thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">

        {{-- Card Header --}}
        <div class="card-header text-white py-3"
             style="
                background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                margin-left: 10px;
                margin-right: 10px;
                border-radius: 6px;
             ">
            <h6 class="m-0 fw-bold text-white">
                Request / Question List
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0"
                       width="100%"
                       cellspacing="0">

                    <thead class="bg-primary bg-opacity-10 text-primary border-bottom border-primary border-opacity-25">
                        <tr>
                            <th class="ps-3" style="width: 70px;">ID</th>
                            <th>Sender</th>
                            <th>Email / Phone</th>
                            <th>Subject</th>
                            <th style="width: 130px;">Status</th>
                            <th style="width: 170px;">Submitted Date</th>
                            <th style="width: 140px;" class="text-center pe-3">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($queries as $query)

                            <tr class="border-bottom">

                                {{-- ID --}}
                                <td class="ps-3 fw-bold text-primary">
                                    #{{ $query->QueryId }}
                                </td>

                                {{-- Sender --}}
                                <td>
                                    <strong class="text-dark">
                                        {{ $query->SenderName }}
                                    </strong>
                                </td>

                                {{-- Email & Phone --}}
                                <td>
                                    <div class="text-primary-emphasis fw-medium">
                                        {{ $query->Email }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $query->PhoneNumber ?? 'N/A' }}
                                    </small>
                                </td>

                                {{-- Subject --}}
                                <td class="text-secondary fw-semibold">
                                    {{ $query->Subject }}
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if ($query->Status === 'Resolved')

                                        <span class="badge px-3 py-2 fw-semibold"
                                              style="
                                                background-color: #198754;
                                                color: white;
                                                border-radius: 20px;
                                              ">
                                            Responded
                                        </span>

                                    @else

                                        <span class="badge px-3 py-2 fw-semibold"
                                              style="
                                                background-color: #dc3545;
                                                color: white;
                                                border-radius: 20px;
                                              ">
                                            Pending
                                        </span>

                                    @endif
                                </td>

                                {{-- Submitted Date --}}
                                <td class="text-muted small">
                                    {{ $query->SubmittedAt
                                        ? $query->SubmittedAt->format('d/m/Y H:i')
                                        : 'N/A'
                                    }}
                                </td>

                                {{-- Action --}}
                                <td class="text-center pe-3">

                                    <a href="{{ route('admin.contact.show', $query->QueryId) }}"
                                       class="btn btn-sm px-3 py-2 fw-bold"
                                       style="
                                            background-color: #0d6efd;
                                            color: #FFFFFF;
                                            border-radius: 20px;
                                            border: none;
                                       ">
                                        View Details
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7"
                                    class="text-center py-5 text-muted bg-light">
                                    No contact requests found.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            @if(method_exists($queries, 'hasPages') && $queries->hasPages())

                <div class="p-3 d-flex justify-content-end bg-light border-top">
                    {{ $queries->links() }}
                </div>

            @else

                <div class="p-2 bg-light border-top"></div>

            @endif

        </div>
    </div>
</div>
@endsection