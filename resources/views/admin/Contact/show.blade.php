@extends('components.layouts.admin.master')

@section('content')

{{-- ========================================================= --}}
{{-- SUMMERNOTE CSS --}}
{{-- ========================================================= --}}
<link
    href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css"
    rel="stylesheet"
>

<div class="container-fluid py-4">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}
    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            {{-- Back Button --}}
            <a href="{{ route('admin.contact.index') }}"
               class="btn btn-outline-primary btn-sm px-3 mb-2"
               style="border-radius: 6px;">

                &larr; Back to Contact List

            </a>

            <h2 class="h3 mb-0 text-gray-800 fw-bold">
                Inquiry Details #{{ $query->QueryId }}
            </h2>
            <br>

        </div>


        {{-- STATUS --}}
        <div>

            @if ($query->Status === 'Responded')

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

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}
    <div class="row g-4">


        {{-- ===================================================== --}}
        {{-- LEFT COLUMN --}}
        {{-- ===================================================== --}}
        <div class="col-lg-5">

            <div class="card shadow-sm border-0 h-100"
                 style="border-radius: 8px; overflow: hidden;">


                {{-- ================================================= --}}
                {{-- SENDER INFORMATION HEADER --}}
                {{-- ================================================= --}}
                <div class="card-header text-white py-3"
                     style="
                        background: linear-gradient(
                            135deg,
                            #0d6efd 0%,
                            #0a58ca 100%
                        );
                     ">

                    <h6 class="m-0 fw-bold text-white">
                        Sender Information
                    </h6>

                </div>


                {{-- ================================================= --}}
                {{-- SENDER INFORMATION BODY --}}
                {{-- ================================================= --}}
                <div class="card-body">


                    {{-- Full Name --}}
                    <div class="pb-3 mb-3 border-bottom">

                        <label class="text-muted small text-uppercase fw-semibold d-block mb-1">
                            Full Name
                        </label>

                        <div class="fw-bold text-dark">
                            {{ $query->SenderName }}
                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="pb-3 mb-3 border-bottom">

                        <label class="text-muted small text-uppercase fw-semibold d-block mb-1">
                            Email Address
                        </label>

                        <a href="mailto:{{ $query->Email }}"
                           class="text-primary fw-medium text-decoration-none">

                            {{ $query->Email }}

                        </a>

                    </div>


                    {{-- Phone --}}
                    <div class="pb-3 mb-3 border-bottom">

                        <label class="text-muted small text-uppercase fw-semibold d-block mb-1">
                            Phone Number
                        </label>

                        <div class="text-dark">
                            {{ $query->PhoneNumber ?? 'Not provided' }}
                        </div>

                    </div>


                    {{-- Submitted Date --}}
                    <div class="pb-3 mb-4 border-bottom">

                        <label class="text-muted small text-uppercase fw-semibold d-block mb-1">
                            Submitted Date
                        </label>

                        <div class="text-dark">
                            {{ $query->SubmittedAt
                                ? $query->SubmittedAt->format('d/m/Y H:i:s')
                                : 'N/A'
                            }}
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SUBJECT --}}
                    {{-- ================================================= --}}
                    <div class="mb-4">

                        <label class="text-muted small text-uppercase fw-semibold d-block mb-1">
                            Subject
                        </label>

                        <div class="fw-bold text-dark fs-6">
                            {{ $query->Subject }}
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- MESSAGE --}}
                    {{-- ================================================= --}}
                    <div>

                        <label class="text-muted small text-uppercase fw-semibold d-block mb-2">
                            Message Content
                        </label>


                        <div class="p-3 text-dark"
                             style="
                                background-color: #f8f9fa;
                                border: 1px solid #dee2e6;
                                border-radius: 6px;
                                white-space: pre-line;
                                min-height: 150px;
                             ">

                            {{ $query->MessageText }}

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- RIGHT COLUMN --}}
        {{-- ===================================================== --}}
        <div class="col-lg-7">

            <div class="card shadow-sm border-0 h-100"
                 style="border-radius: 8px; overflow: hidden;">


                {{-- ================================================= --}}
                {{-- REPLY HEADER --}}
                {{-- ================================================= --}}
                <div class="card-header text-white py-3"
                     style="
                        background: linear-gradient(
                            135deg,
                            #0d6efd 0%,
                            #0a58ca 100%
                        );
                     ">

                    <h6 class="m-0 fw-bold text-white">
                        Response &amp; Auto-Email
                    </h6>

                </div>


                {{-- ================================================= --}}
                {{-- REPLY BODY --}}
                {{-- ================================================= --}}
                <div class="card-body">


                    {{-- Information Box --}}
                    <div class="p-3 mb-4"
                         style="
                            background-color: #e7f1ff;
                            border: 1px solid #b6d4fe;
                            border-left: 4px solid #0d6efd;
                            border-radius: 6px;
                         ">

                        <div class="d-flex">

                            <div class="me-2 text-primary">
                                <strong>To:</strong>
                            </div>

                            <div class="text-dark">
                                {{ $query->Email }}
                            </div>

                        </div>

                        <small class="text-muted d-block mt-1">
                            Your response will be automatically sent to this email address.
                        </small>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FORM --}}
                    {{-- ================================================= --}}
                    <form action="{{ route('admin.contact.respond', $query->QueryId) }}"
                          method="POST">

                        @csrf

                        @method('PUT')


                        {{-- ================================================= --}}
                        {{-- REPLY MESSAGE --}}
                        {{-- ================================================= --}}
                        <div class="mb-4">

                            <label for="admin_notes"
                                   class="form-label fw-bold text-dark">

                                Reply Message

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <textarea
                                name="admin_notes"
                                id="admin_notes"
                                class="form-control @error('admin_notes') is-invalid @enderror"
                            >{{ old('admin_notes', $query->AdminNotes) }}</textarea>


                            @error('admin_notes')

                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>



                        {{-- ================================================= --}}
                        {{-- RESPONSE INFORMATION --}}
                        {{-- ================================================= --}}
                        @if ($query->Status === 'Responded')

                            <div class="mb-4 p-3"
                                 style="
                                    background-color: #eaf7ef;
                                    border: 1px solid #badbcc;
                                    border-left: 4px solid #198754;
                                    border-radius: 6px;
                                 ">

                                <div class="text-success fw-bold mb-1">
                                    Response Information
                                </div>

                                <div class="small text-dark">

                                    <div>
                                        <strong>Responded by:</strong>
                                        {{ $query->respondedByAdmin->FullName ?? 'Admin' }}
                                    </div>

                                    <div class="mt-1">
                                        <strong>Date:</strong>
                                        {{ $query->RespondedAt
                                            ? $query->RespondedAt->format('d/m/Y H:i:s')
                                            : 'N/A'
                                        }}
                                    </div>

                                </div>

                            </div>

                        @endif



                        {{-- ================================================= --}}
                        {{-- ACTION BUTTON --}}
                        {{-- ================================================= --}}
                        <div class="pt-3 border-top">

                            <div class="d-flex justify-content-end">

                                <button type="submit"
                                        class="btn px-4 py-2 fw-bold shadow-sm"
                                        style="
                                            background-color: #0d6efd;
                                            color: white;
                                            border: none;
                                            border-radius: 6px;
                                        ">

                                    {{ $query->Status === 'Responded'
                                        ? 'Update & Resend Email'
                                        : 'Send Response & Email Patient'
                                    }}

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- SUMMERNOTE JS --}}
{{-- ========================================================= --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


<script>

    $(document).ready(function () {

        $('#admin_notes').summernote({

            placeholder: 'Type your official response here...',

            tabsize: 2,

            height: 260,

            toolbar: [

                ['style', ['style']],

                ['font', [
                    'bold',
                    'underline',
                    'clear',
                    'italic'
                ]],

                ['color', ['color']],

                ['para', [
                    'ul',
                    'ol',
                    'paragraph'
                ]],

                ['table', ['table']],

                ['insert', ['link']],

                ['view', [
                    'fullscreen',
                    'codeview'
                ]]

            ]

        });

    });

</script>



{{-- ========================================================= --}}
{{-- CUSTOM SUMMERNOTE STYLE --}}
{{-- ========================================================= --}}

<style>

    /* Summernote container */
    .note-editor.note-frame {

        border: 1px solid #dee2e6 !important;

        border-radius: 6px !important;

        overflow: hidden;

        box-shadow: none;

    }


    /* Summernote toolbar */
    .note-toolbar {

        background-color: #f8f9fa !important;

        border-bottom: 1px solid #dee2e6 !important;

    }


    /* Toolbar buttons */
    .note-btn {

        border-radius: 4px !important;

    }


    /* Editor area */
    .note-editable {

        min-height: 260px;

        font-size: 15px;

        line-height: 1.6;

        color: #212529;

    }


    /* Summernote status bar */
    .note-statusbar {

        background-color: #f8f9fa !important;

        border-top: 1px solid #dee2e6 !important;

    }


    /* Card divider */
    .border-bottom {

        border-color: #e9ecef !important;

    }


    /* Button hover */
    button[type="submit"] {

        transition: all 0.2s ease;

    }


    button[type="submit"]:hover {

        background-color: #0b5ed7 !important;

        transform: translateY(-1px);

    }

</style>

@endsection