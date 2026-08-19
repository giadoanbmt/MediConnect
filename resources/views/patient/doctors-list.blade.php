@forelse($doctors as $doctor)
<div class="col-lg-3 col-sm-6 col-md-6 mb-4 shuffle-item"
    data-groups='["spec-{{ $doctor->SpecializationId }}", "city-{{ $doctor->CityId }}"]'>

    <div class="position-relative doctor-inner-box">
        <div class="doctor-profile">
            <div class="doctor-img">
                <a href="{{ route('public.doctorProfile', ['id' => $doctor->DoctorId]) }}">
                    @php
                    $avatar = ($doctor->AvatarUrl && file_exists(public_path($doctor->AvatarUrl)))
                    ? asset($doctor->AvatarUrl)
                    : asset('Novena/images/team/1.jpg');
                    @endphp
                    <img src="{{ $avatar }}" alt="{{ $doctor->FullName }}" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                </a>
            </div>
        </div>

        <div class="content mt-3 text-center">
            <h4 class="mb-0">
                <a href="{{ route('public.doctorProfile', $doctor->DoctorId) }}">{{ $doctor->FullName }}</a>
            </h4>
            <p class="mb-0 text-primary font-weight-bold">
                {{ $doctor->specialization->SpecializationName ?? 'Update soon' }}
            </p>
            <p class="mb-0 text-muted small">
                <i class="icofont-location-pin"></i> {{ $doctor->city->CityName ?? 'Update soon' }}
            </p>
        </div>
    </div>

</div>
@empty
<div class="col-12 text-center py-5">
    <p class="text-muted">No doctors found matching your criteria.</p>
</div>
@endforelse