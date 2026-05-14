<x-app-layout>
    <div class="w-full">
        <div id="dashboard-root" data-username="{{ auth()->user()->name ?? 'Athlete' }}"></div>
    </div>
</x-app-layout>

