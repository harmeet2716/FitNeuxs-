<x-app-layout>
    <div class="w-full">
        @if(isset($day))
        <form id="complete-workout-form" method="POST" action="{{ route('workout.complete', ['day' => $day]) }}" style="display: none;">
            @csrf
        </form>
        @endif
        
        <div id="workout-page-root" data-program-name="{{ $program->name ?? 'Custom Program' }}" data-day-name="{{ $workout->title ?? ('Day ' . ($day ?? 1)) }}"></div>
    </div>
</x-app-layout>

