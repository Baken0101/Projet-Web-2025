<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Dashboard') }}
            </span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">Promotions</h3>
                    </div>
                    <div class="card-body flex flex-col gap-5">
                        <p class="text-2xl font-semibold">{{ $promotionsCount ?? 'N/A' }}</p>
                        <a href="{{ route('cohort.index') }}" class="text-blue-500 hover:underline">Voir les promotions</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="card card-grid h-full min-w-full">
                <div class="card-header">
                    <h3 class="card-title">Étudiants</h3>
                </div>
                <div class="card-body flex flex-col gap-5">
                    <p class="text-2xl font-semibold">{{ $studentsCount ?? 'N/A' }}</p>
                    <a href="{{ route('student.index') }}" class="text-blue-500 hover:underline">Voir les étudiants</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">Groupes</h3>
                    </div>
                    <div class="card-body flex flex-col gap-5">
                        <p class="text-2xl font-semibold">{{ $groupsCount ?? 'N/A' }}</p>
                        <a href="{{ route('group.index') }}" class="text-blue-500 hover:underline">Voir les groupes</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="card card-grid h-full min-w-full">
                <div class="card-header">
                    <h3 class="card-title">Enseignants</h3>
                </div>
                <div class="card-body flex flex-col gap-5">
                    <p class="text-2xl font-semibold">{{ $teachersCount ?? 'N/A' }}</p>
                    <a href="{{ route('teacher.index') }}" class="text-blue-500 hover:underline">Voir les enseignants</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end: grid -->
</x-app-layout>
