@extends('doctor.layouts.dashboard')

@section('title', 'Create News')

@section('content')

<style>
    .news-create-page {
        max-width: 1080px;
        margin: 0 auto;
    }

    .news-create-title {
        margin-bottom: 4px;
        color: #35a8e0;
        font-size: 28px;
        font-weight: 700;
    }

    .news-create-breadcrumb {
        margin-bottom: 18px;
        color: #8ca9c8;
        font-size: 13px;
    }

    .news-create-card {
        padding: 20px 18px;
        background: #123252;
        border: 1px solid #294866;
        border-radius: 6px;
    }

    .news-form-group {
        margin-bottom: 18px;
    }

    .news-form-group label {
        display: block;
        margin-bottom: 8px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
    }

    .news-form-group label span {
        color: #ff4d5a;
    }

    .news-input,
    .news-select {
        width: 100%;
        height: 36px;
        padding: 0 10px;
        background: #0b2138 !important;
        border: 1px solid #345472 !important;
        border-radius: 4px;
        color: #ffffff !important;
        outline: none;
    }

    .news-input::placeholder {
        color: #6f94b8;
    }

    .news-input:focus,
    .news-select:focus {
        border-color: #28a9e8 !important;
        box-shadow: 0 0 0 1px rgba(40,169,232,.2);
    }

    .thumbnail-upload {
        width: 245px;
        height: 125px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #0b2138;
        border: 1px dashed #159ee0;
        border-radius: 4px;
        cursor: pointer;
        overflow: hidden;
    }

    .thumbnail-upload:hover {
        background: #0d2944;
    }

    .thumbnail-upload-content {
        color: #ffffff;
        font-size: 12px;
    }

    .thumbnail-upload-content i {
        display: block;
        margin-bottom: 8px;
        color: #149fe5;
        font-size: 20px;
    }

    .thumbnail-upload-content strong {
        display: block;
        margin-bottom: 5px;
        font-size: 12px;
    }

    .thumbnail-upload-content small {
        display: block;
        color: #7fa3c5;
        font-size: 10px;
    }

    #thumbnail {
        display: none;
    }

    #thumbnail-preview {
        width: 100%;
        height: 100%;
        display: none;
        object-fit: cover;
    }

    .editor-wrapper {
        border: 1px solid #345472;
        border-radius: 4px;
        overflow: hidden;
    }

    #editor-toolbar {
        background: #0b2138;
        border: 0;
        border-bottom: 1px solid #345472;
    }

    #editor-toolbar .ql-picker,
    #editor-toolbar button {
        color: #ffffff;
    }

    #editor-toolbar .ql-stroke {
        stroke: #ffffff;
    }

    #editor-toolbar .ql-fill {
        fill: #ffffff;
    }

    #editor-toolbar .ql-picker-label {
        color: #ffffff;
    }

    #editor-toolbar .ql-picker-options {
        background: #123252;
        border-color: #345472;
    }

    #editor-toolbar .ql-picker-item {
        color: #ffffff;
    }

    #editor {
        min-height: 255px;
        background: #0b2138;
        color: #ffffff;
        font-size: 14px;
    }

    #editor.ql-container {
        border: 0;
    }

    #editor .ql-editor {
        min-height: 255px;
        color: #ffffff;
    }

    #editor .ql-editor.ql-blank::before {
        color: #6689aa;
        font-style: normal;
    }

    .news-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-save-news {
        height: 36px;
        padding: 0 15px;
        background: #159fe4;
        border: 1px solid #159fe4;
        border-radius: 4px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-save-news:hover {
        background: #078bcf;
        border-color: #078bcf;
    }

    .btn-cancel-news {
        height: 36px;
        padding: 0 15px;
        background: transparent;
        border: 1px solid #345472;
        border-radius: 4px;
        color: #ffffff;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-cancel-news:hover {
        background: #173d60;
        color: #ffffff;
        text-decoration: none;
    }

    .invalid-feedback {
        display: block;
        margin-top: 5px;
        color: #ff6874;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .news-create-page {
            width: 100%;
        }

        .thumbnail-upload {
            width: 245px;
        }
    }
</style>

<div class="news-create-page">

    <h1 class="news-create-title">Create News</h1>

    <div class="news-create-breadcrumb">
        News › Create News
    </div>

    <div class="news-create-card">

        <form
            action="{{ route('doctor.news.store') }}"
            method="POST"
            enctype="multipart/form-data"
            id="newsForm"
        >

            @csrf

            {{-- Title --}}
            <div class="news-form-group">
                <label>
                    1. Title <span>*</span>
                </label>

                <input
                    type="text"
                    name="Title"
                    class="news-input"
                    value="{{ old('Title') }}"
                    placeholder="Enter news headline..."
                    required
                >

                @error('Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="news-form-group">
                <label>
                    2. Category <span>*</span>
                </label>

                <select
                    name="Category"
                    class="news-select"
                    required
                >
                    <option value="">Select Category</option>

                    <option
                        value="MediConnect News"
                        {{ old('Category') == 'MediConnect News' ? 'selected' : '' }}
                    >
                        MediConnect News
                    </option>

                    <option
                        value="Health & Lifestyle"
                        {{ old('Category') == 'Health & Lifestyle' ? 'selected' : '' }}
                    >
                        Health & Lifestyle
                    </option>

                    <option
                        value="General Medicine"
                        {{ old('Category') == 'General Medicine' ? 'selected' : '' }}
                    >
                        General Medicine
                    </option>

                    <option
                        value="Doctor Advice"
                        {{ old('Category') == 'Doctor Advice' ? 'selected' : '' }}
                    >
                        Doctor Advice
                    </option>
                </select>

                @error('Category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Thumbnail --}}
            <div class="news-form-group">
                <label>
                    3. Thumbnail
                </label>

                <label
                    for="thumbnail"
                    class="thumbnail-upload"
                >
                    <div
                        class="thumbnail-upload-content"
                        id="thumbnail-placeholder"
                    >
                        <i class="fas fa-image"></i>

                        <strong>
                            Click to upload image
                        </strong>

                        <small>
                            JPG, PNG or WEBP. Max size 5MB.
                        </small>
                    </div>

                    <img
                        id="thumbnail-preview"
                        alt="Thumbnail preview"
                    >
                </label>

                <input
                    type="file"
                    name="ThumbnailUrl"
                    id="thumbnail"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                @error('ThumbnailUrl')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content --}}
            <div class="news-form-group">
                <label>
                    4. Content <span>*</span>
                </label>

                <div class="editor-wrapper">

                    <div id="editor-toolbar">

                        <select class="ql-header">
                            <option selected></option>
                            <option value="1">Heading 1</option>
                            <option value="2">Heading 2</option>
                            <option value="3">Heading 3</option>
                        </select>

                        <button type="button" class="ql-bold"></button>
                        <button type="button" class="ql-italic"></button>
                        <button type="button" class="ql-underline"></button>
                        <button type="button" class="ql-strike"></button>

                        <button
                            type="button"
                            class="ql-list"
                            value="ordered"
                        ></button>

                        <button
                            type="button"
                            class="ql-list"
                            value="bullet"
                        ></button>

                        <button
                            type="button"
                            class="ql-align"
                            value=""
                        ></button>

                        <button
                            type="button"
                            class="ql-align"
                            value="center"
                        ></button>

                        <button
                            type="button"
                            class="ql-align"
                            value="right"
                        ></button>

                        <button
                            type="button"
                            class="ql-link"
                        ></button>

                        <button
                            type="button"
                            class="ql-image"
                        ></button>

                    </div>

                    <div id="editor"></div>

                </div>

                <input
                    type="hidden"
                    name="Content"
                    id="Content"
                    value="{{ old('Content') }}"
                >

                @error('Content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="news-buttons">

                <button
                    type="submit"
                    class="btn-save-news"
                >
                    <i class="fas fa-save mr-1"></i>
                    Save News
                </button>

                <a
                    href="{{ route('doctor.news.index') }}"
                    class="btn-cancel-news"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

<link
    href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css"
    rel="stylesheet"
>

<script
    src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"
></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Editor
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write your content here...',
            modules: {
                toolbar: '#editor-toolbar'
            }
        });

        const contentInput =
            document.getElementById('Content');

        const form =
            document.getElementById('newsForm');

        const oldContent =
            contentInput.value;

        if (oldContent) {
            quill.root.innerHTML = oldContent;
        }

        // Save editor content
        form.addEventListener('submit', function () {
            contentInput.value =
                quill.root.innerHTML;
        });

        // Thumbnail preview
        const thumbnail =
            document.getElementById('thumbnail');

        const preview =
            document.getElementById('thumbnail-preview');

        const placeholder =
            document.getElementById('thumbnail-placeholder');

        thumbnail.addEventListener('change', function () {

            const file =
                this.files[0];

            if (!file) {
                preview.style.display = 'none';
                placeholder.style.display = 'block';
                return;
            }

            const reader =
                new FileReader();

            reader.onload = function (event) {

                preview.src =
                    event.target.result;

                preview.style.display =
                    'block';

                placeholder.style.display =
                    'none';
            };

            reader.readAsDataURL(file);
        });
    });
</script>

@endsection