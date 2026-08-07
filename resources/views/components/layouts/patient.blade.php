<x-layouts.public :title="$title ?? 'MediConnect - Patient'">
    <x-slot:head>{{ $head ?? '' }}</x-slot:head>
    {{ $slot }}
    <x-slot:scripts>{{ $scripts ?? '' }}</x-slot:scripts>
</x-layouts.public>
