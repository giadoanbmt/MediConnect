@extends('doctor.layouts.dashboard')

@section('title', 'MediConnect - Doctor Profile')

@section('content')

<style>
    .doctor-profile {
        --profile-card: #ffffff;
        --profile-input: #ffffff;
        --profile-text: #172b50;
        --profile-muted: #6c7a89;
        --profile-border: #d8e3ef;
        --profile-primary: #0088cc;
        --profile-primary-dark: #223b6b;

        width: 100%;
        color: var(--profile-text);
        box-sizing: border-box;
    }

    @media (prefers-color-scheme: dark) {
        .doctor-profile {
            --profile-card: #16263d;
            --profile-input: #101a29;
            --profile-text: #f2f6fb;
            --profile-muted: #aebdd0;
            --profile-border: #30445f;
            --profile-primary: #3da9e0;
            --profile-primary-dark: #223b6b;
        }
    }

    .doctor-profile-header {
        margin-bottom: 28px;
    }

    .doctor-profile-header h2 {
        margin: 0;
        color: var(--profile-primary);
        font-size: 32px;
        font-weight: 700;
    }

    .doctor-profile-header p {
        margin: 5px 0 0;
        color: var(--profile-muted);
    }

    .doctor-profile-card {
        width: 100%;
        padding: 32px;
        background: var(--profile-card);
        border: 1px solid var(--profile-border);
        border-radius: 10px;
        box-shadow: 0 4px 18px rgba(0,0,0,.08);
        box-sizing: border-box;
    }

    .profile-avatar-section {
        display: flex;
        align-items: center;
        gap: 30px;
        width: 100%;
        padding-bottom: 28px;
        margin-bottom: 30px;
        border-bottom: 1px solid var(--profile-border);
    }

    .avatar-wrapper {
        position: relative;
        width: 160px;
        height: 160px;
        flex: 0 0 160px;
    }

    .avatar-preview {
        display: block;
        width: 160px;
        height: 160px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--profile-primary);
        background: #eef4f8;
    }

    .avatar-camera {
        position: absolute;
        right: -2px;
        bottom: 2px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--profile-primary);
        color: #fff;
        border: 3px solid var(--profile-card);
        cursor: pointer;
        font-size: 16px;
        transition: .2s;
    }

    .avatar-camera:hover {
        transform: scale(1.08);
        background: var(--profile-primary-dark);
    }

    .avatar-info {
        min-width: 0;
    }

    .avatar-info h3 {
        margin-bottom: 8px;
        color: var(--profile-text);
        font-size: 22px;
        font-weight: 700;
    }

    .avatar-info p {
        margin-bottom: 8px;
        color: var(--profile-muted);
    }

    .avatar-help {
        color: var(--profile-muted);
        font-size: 13px;
    }

    .profile-row,
    .profile-select-row {
        width: 100%;
        margin-left: 0 !important;
        margin-right: 0 !important;
        margin-bottom: 24px;
    }

    .profile-row > [class*="col-"],
    .profile-select-row > [class*="col-"] {
        padding-left: 10px;
        padding-right: 10px;
    }

    .profile-field {
        width: 100%;
        min-width: 0;
    }

    .profile-field label {
        display: block;
        margin-bottom: 8px;
        color: var(--profile-text);
        font-weight: 600;
    }

    .profile-field .form-control {
        display: block;
        width: 100%;
        max-width: 100%;
        height: 54px;
        padding: 0 15px;
        background: var(--profile-input);
        color: var(--profile-text);
        border: 1px solid var(--profile-border);
        border-radius: 7px;
        box-sizing: border-box;
    }

    .profile-field textarea.form-control {
        height: auto;
        min-height: 120px;
        padding-top: 14px;
        resize: vertical;
    }

    .profile-field .form-control:focus {
        background: var(--profile-input);
        color: var(--profile-text);
        border-color: var(--profile-primary);
        box-shadow: 0 0 0 2px rgba(0,136,204,.12);
    }

    .profile-field .form-control:disabled {
        opacity: .75;
        cursor: not-allowed;
    }

    .profile-help {
        display: block;
        margin-top: 7px;
        color: var(--profile-muted);
        font-size: 13px;
    }

    .profile-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 8px;
    }

    .profile-actions .btn {
        min-width: 140px;
        height: 52px;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-save {
        background: var(--profile-primary);
        border: 1px solid var(--profile-primary);
        color: #fff;
    }

    .btn-save:hover {
        background: var(--profile-primary-dark);
        border-color: var(--profile-primary-dark);
        color: #fff;
    }

    .btn-reset {
        background: transparent;
        border: 1px solid var(--profile-border);
        color: var(--profile-text);
    }

    .btn-reset:hover {
        background: rgba(0,136,204,.08);
        color: var(--profile-text);
    }

    @media (max-width: 767px) {
        .doctor-profile-header h2 {
            font-size: 26px;
        }

        .doctor-profile-header p {
            font-size: 14px;
        }

        .doctor-profile-card {
            padding: 20px 15px;
        }

        .profile-avatar-section {
            align-items: flex-start;
            flex-direction: column;
            gap: 20px;
        }

        .avatar-wrapper {
            width: 140px;
            height: 140px;
            flex-basis: 140px;
        }

        .avatar-preview {
            width: 140px;
            height: 140px;
        }

        .doctor-profile-card .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .doctor-profile-card .row > [class*="col-"] {
            padding-left: 0;
            padding-right: 0;
        }

        .profile-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .profile-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="doctor-profile">

    <div class="doctor-profile-header">
        <h2>Doctor Profile</h2>
        <p>View and update personal information.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $gender = strtolower(
            trim((string) ($doctor->Gender ?? ''))
        );

        $avatarPath = trim(
            (string) ($doctor->AvatarUrl ?? '')
        );

        $avatarUrl = null;

        if ($avatarPath !== '') {

            $dbAvatarPath = ltrim(
                $avatarPath,
                '/'
            );

            if (file_exists(
                public_path($dbAvatarPath)
            )) {

                $avatarUrl = asset(
                    $dbAvatarPath
                );
            }
        }

        if (!$avatarUrl) {

            if ($gender === 'female') {

                $avatarUrl = asset(
                    'images/avatars/default_doctor_female.png'
                );

            } else {

                $avatarUrl = asset(
                    'images/avatars/default_doctor_male.png'
                );
            }
        }

        $currentCityName = trim(
            $doctor->city->CityName ?? ''
        );

        $currentDistrictId = $doctor->CityId;
    @endphp

    <div class="doctor-profile-card">

        <form
            action="{{ route('doctor.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            {{-- Avatar --}}
            <div class="profile-avatar-section">

                <div class="avatar-wrapper">

                    <img
                        id="avatarPreview"
                        src="{{ $avatarUrl }}"
                        alt="Doctor Avatar"
                        class="avatar-preview"
                        onerror="this.onerror=null;this.src='{{ asset('images/avatars/default_doctor_male.png') }}';"
                    >

                    <label
                        for="AvatarUrl"
                        class="avatar-camera"
                        title="Change photo"
                    >
                        <i class="fas fa-camera"></i>
                    </label>

                    <input
                        type="file"
                        name="AvatarUrl"
                        id="AvatarUrl"
                        accept="image/png,image/jpeg,image/webp,image/gif"
                        hidden
                    >

                </div>

                <div class="avatar-info">

                    <h3>Avatar</h3>

                    <p>
                        Upload a profile photo to personalize your account.
                    </p>

                    <div class="avatar-help">
                        JPG, PNG or GIF. Max size 2MB.
                    </div>

                </div>

            </div>

            {{-- Doctor Name / Account --}}
            <div class="row profile-row">

                <div class="col-md-6 mb-3 mb-md-0">

                    <div class="profile-field">

                        <label>Doctor Name</label>

                        <input
                            type="text"
                            name="FullName"
                            class="form-control"
                            value="{{ old('FullName', $doctor->FullName) }}"
                            required
                        >

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="profile-field">

                        <label>Doctor Account</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $doctor->Username }}"
                            disabled
                        >

                        <small class="profile-help">
                            The login account cannot be changed here.
                        </small>

                    </div>

                </div>

            </div>

            {{-- Gender / Phone --}}
            <div class="row profile-row">

                <div class="col-md-6 mb-3 mb-md-0">

                    <div class="profile-field">

                        <label>Sex</label>

                        <select
                            name="Gender"
                            id="Gender"
                            class="form-control"
                            required
                        >

                            <option
                                value="Male"
                                {{ strtolower(old('Gender', $doctor->Gender)) === 'male' ? 'selected' : '' }}
                            >
                                Male
                            </option>

                            <option
                                value="Female"
                                {{ strtolower(old('Gender', $doctor->Gender)) === 'female' ? 'selected' : '' }}
                            >
                                Female
                            </option>

                        </select>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="profile-field">

                        <label>Phone Number</label>

                        <input
                            type="text"
                            name="PhoneNumber"
                            class="form-control"
                            value="{{ old('PhoneNumber', $doctor->PhoneNumber) }}"
                            required
                        >

                    </div>

                </div>

            </div>

            {{-- Email / Qualifications --}}
            <div class="row profile-row">

                <div class="col-md-6 mb-3 mb-md-0">

                    <div class="profile-field">

                        <label>Email</label>

                        <input
                            type="email"
                            name="Email"
                            class="form-control"
                            value="{{ old('Email', $doctor->Email) }}"
                            required
                        >

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="profile-field">

                        <label>Qualifications</label>

                        <input
                            type="text"
                            name="Qualifications"
                            class="form-control"
                            value="{{ old('Qualifications', $doctor->Qualifications) }}"
                        >

                    </div>

                </div>

            </div>

            {{-- Specialization / City / District / Clinic Room --}}
            <div class="row profile-select-row">

                {{-- Specialization --}}
                <div class="col-md-3">

                    <div class="profile-field">

                        <label>Specialization</label>

                        <select
                            name="SpecializationId"
                            id="SpecializationSelect"
                            class="form-control"
                        >

                            <option value="">
                                -- Select Specialization --
                            </option>

                            @foreach($specializations as $specialization)

                                <option
                                    value="{{ $specialization->SpecializationId }}"
                                    {{ old('SpecializationId', $doctor->SpecializationId) == $specialization->SpecializationId ? 'selected' : '' }}
                                >
                                    {{ $specialization->SpecializationName }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- City --}}
                <div class="col-md-3">

                    <div class="profile-field">

                        <label>City</label>

                        <select
                            id="CitySelect"
                            class="form-control"
                        >

                            <option value="">
                                -- Select City --
                            </option>

                            @foreach($cities as $city)

                                @php
                                    $cityName = trim($city->CityName);
                                @endphp

                                <option
                                    value="{{ $cityName }}"
                                    {{ $currentCityName === $cityName ? 'selected' : '' }}
                                >
                                    {{ $cityName }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- District --}}
                <div class="col-md-3">

                    <div class="profile-field">

                        <label>District</label>

                        <select
                            name="CityId"
                            id="DistrictSelect"
                            class="form-control"
                            required
                        >

                            <option value="">
                                -- Select District --
                            </option>

                            @foreach($locations as $location)

                                <option
                                    value="{{ $location->CityId }}"
                                    data-city="{{ trim($location->CityName) }}"
                                    {{ old('CityId', $currentDistrictId) == $location->CityId ? 'selected' : '' }}
                                >
                                    {{ $location->DistrictName }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- Clinic Room --}}
                <div class="col-md-3">

                    <div class="profile-field">

                        <label>Clinic Room</label>

                        <select
                            name="RoomId"
                            id="RoomSelect"
                            class="form-control"
                        >

                            <option value="">
                                -- Select Clinic Room --
                            </option>

                            @foreach($rooms as $room)

                                <option
                                    value="{{ $room->RoomId }}"
                                    data-room-name="{{ strtolower(trim($room->RoomName)) }}"
                                    {{ old('RoomId', $doctor->RoomId) == $room->RoomId ? 'selected' : '' }}
                                >
                                    {{ $room->RoomName }}

                                    @if($room->RoomNumber)
                                        - Room {{ $room->RoomNumber }}
                                    @endif
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

            {{-- Address --}}
            <div class="profile-row">

                <div class="profile-field">

                    <label>Address</label>

                    <textarea
                        name="Address"
                        class="form-control"
                        rows="4"
                    >{{ old('Address', $doctor->Address) }}</textarea>

                </div>

            </div>

            {{-- Actions --}}
            <div class="profile-actions">

                <button
                    type="submit"
                    class="btn btn-save"
                >
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>

                <button
                    type="reset"
                    class="btn btn-reset"
                >
                    <i class="fas fa-redo mr-2"></i>
                    Reset
                </button>

            </div>

        </form>

    </div>

</div>

<script>

    /*
    |--------------------------------------------------------------------------
    | Avatar
    |--------------------------------------------------------------------------
    */

    const avatarInput =
        document.getElementById('AvatarUrl');

    const avatarPreview =
        document.getElementById('avatarPreview');

    const genderInput =
        document.getElementById('Gender');

    const defaultMale =
        "{{ asset('images/avatars/default_male.png') }}";

    const defaultFemale =
        "{{ asset('images/avatars/default_female.png') }}";

    const avatarPath = @json(
        strtolower(
            trim(
                (string) ($doctor->AvatarUrl ?? '')
            )
        )
    );

    const hasRealAvatar =
        avatarPath !== '' &&
        !avatarPath.includes('default_male.png') &&
        !avatarPath.includes('default_female.png');


    if (avatarInput) {

        avatarInput.addEventListener(
            'change',
            function () {

                const file = this.files[0];

                if (!file) {
                    return;
                }

                if (
                    file.size >
                    2 * 1024 * 1024
                ) {

                    alert(
                        'Avatar must be smaller than 2MB.'
                    );

                    this.value = '';

                    return;
                }

                const reader =
                    new FileReader();

                reader.onload =
                    function (event) {

                        avatarPreview.src =
                            event.target.result;

                    };

                reader.readAsDataURL(file);

            }
        );
    }


    if (genderInput) {

        genderInput.addEventListener(
            'change',
            function () {

                if (hasRealAvatar) {
                    return;
                }

                if (
                    avatarInput &&
                    avatarInput.files &&
                    avatarInput.files.length > 0
                ) {
                    return;
                }

                if (
                    this.value.toLowerCase() ===
                    'female'
                ) {

                    avatarPreview.src =
                        defaultFemale;

                } else {

                    avatarPreview.src =
                        defaultMale;
                }

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | City / District
    |--------------------------------------------------------------------------
    */

    const citySelect =
        document.getElementById(
            'CitySelect'
        );

    const districtSelect =
        document.getElementById(
            'DistrictSelect'
        );


    function filterDistricts() {

        if (
            !citySelect ||
            !districtSelect
        ) {
            return;
        }

        const selectedCity =
            citySelect.value.trim();

        const options =
            districtSelect.querySelectorAll(
                'option[data-city]'
            );

        options.forEach(
            function (option) {

                const optionCity =
                    option.dataset.city.trim();

                option.hidden =
                    selectedCity !== '' &&
                    optionCity !== selectedCity;

            }
        );


        const selectedOption =
            districtSelect.options[
                districtSelect.selectedIndex
            ];


        if (
            selectedOption &&
            selectedOption.dataset.city &&
            selectedOption.dataset.city.trim()
                !== selectedCity
        ) {

            districtSelect.value = '';

        }
    }


    if (citySelect) {

        citySelect.addEventListener(
            'change',
            filterDistricts
        );

    }

    filterDistricts();


    /*
    |--------------------------------------------------------------------------
    | Specialization / Clinic Room
    |--------------------------------------------------------------------------
    */

    const specializationSelect =
        document.getElementById(
            'SpecializationSelect'
        );

    const roomSelect =
        document.getElementById(
            'RoomSelect'
        );


    function filterRoomsBySpecialization() {

        if (
            !specializationSelect ||
            !roomSelect
        ) {
            return;
        }


        const selectedOption =
            specializationSelect.options[
                specializationSelect.selectedIndex
            ];


        const specialization =
            selectedOption
                ? selectedOption.text
                    .trim()
                    .toLowerCase()
                : '';


        const roomOptions =
            roomSelect.querySelectorAll(
                'option[data-room-name]'
            );


        roomOptions.forEach(
            function (option) {

                const roomName =
                    option.dataset.roomName
                        .trim()
                        .toLowerCase();

                let showRoom = false;


                /*
                 * Cardiology
                 */
                if (
                    specialization ===
                    'cardiology'
                ) {

                    showRoom =
                        roomName.includes(
                            'cardiology'
                        ) ||
                        roomName.includes(
                            'cardiac'
                        );
                }


                /*
                 * Neurology
                 */
                else if (
                    specialization ===
                    'neurology'
                ) {

                    showRoom =
                        roomName.includes(
                            'neurology'
                        ) ||
                        roomName.includes(
                            'neuro'
                        );
                }


                /*
                 * Gastroenterology
                 */
                else if (
                    specialization ===
                    'gastroenterology'
                ) {

                    showRoom =
                        roomName.includes(
                            'gastroenterology'
                        );
                }


                /*
                 * Nephrology
                 */
                else if (
                    specialization ===
                    'nephrology'
                ) {

                    showRoom =
                        roomName.includes(
                            'nephrology'
                        ) ||
                        roomName.includes(
                            'kidney'
                        );
                }


                /*
                 * Orthopedics
                 */
                else if (
                    specialization ===
                    'orthopedics'
                ) {

                    showRoom =
                        roomName.includes(
                            'orthopedic'
                        ) ||
                        roomName.includes(
                            'joint'
                        ) ||
                        roomName.includes(
                            'trauma'
                        );
                }


                /*
                 * Critical Care
                 */
                else if (
                    specialization ===
                    'critical care'
                ) {

                    showRoom =
                        roomName.includes(
                            'critical'
                        ) ||
                        roomName.includes(
                            'icu'
                        );
                }

                else if (
                    specialization !== ''
                ) {

                    showRoom =
                        roomName.includes(
                            specialization
                        );

                }

                else {

                    showRoom = false;

                }


                option.hidden =
                    !showRoom;

            }
        );

        const currentRoom =
            roomSelect.options[
                roomSelect.selectedIndex
            ];


        if (
            currentRoom &&
            currentRoom.dataset.roomName &&
            currentRoom.hidden
        ) {

            roomSelect.value = '';

        }

    }


    if (specializationSelect) {

        specializationSelect.addEventListener(
            'change',
            filterRoomsBySpecialization
        );

    }

    filterRoomsBySpecialization();

</script>

@endsection