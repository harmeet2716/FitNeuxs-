<x-app-layout>
    <div class="w-full">
        <div 
            id="profile-settings-root" 
            data-user="{{ json_encode($user) }}"
            data-fitness-profile="{{ json_encode($user->fitnessProfile) }}"
        ></div>
    </div>
</x-app-layout>
