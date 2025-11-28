<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-50 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
            <div class="p-4 sm:p-6 bg-slate-950 border border-slate-800 rounded-xl shadow">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-slate-950 border border-slate-800 rounded-xl shadow">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-slate-950 border border-slate-800 rounded-xl shadow">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
