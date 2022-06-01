<x-app-layout>
    <x-slot name="title">
        {{ __('regulated-organization.types.' . $type) }}
    </x-slot>
    <x-slot name="header">
        <h1>{{ __('Create new :type', ['type' => __('regulated-organization.types.' . $type)]) }}</h1>
    </x-slot>

    @foreach(['en', 'fr'] as $locale)
        @error('name.' . $locale)
            <div class="stack">
                @php
                $regulatedOrganization = App\Models\RegulatedOrganization::where('name->' . $locale, old('name.' . $locale))->first()
                @endphp
                <x-hearth-alert type="error">
                    {{ __('There is already a :type with the name “:name” on this website. If this is the organization you work for, please contact your colleagues to get an invitation to the organization. If this isn’t the organization you work for, please use a different name.', ['type' => __('regulated-organization.types.' . $type), 'name' => old('name.' . $locale)]) }}
                </x-hearth-alert>
                <x-regulated-organization-card level="3" :regulatedOrganization="$regulatedOrganization" />
            </div>
            @break
        @enderror
    @endforeach

    <form class="stack" action="{{ localized_route('regulated-organizations.store') }}" method="post" novalidate>
        <fieldset class="stack">
            <legend>{{ __('Your organization’s name') }}</legend>
            <div class="field @error('name.en') field--error @enderror">
                <x-hearth-label for="name-en">{{ __('Name of organization — English') }}</x-hearth-label>
                <x-hearth-input name="name[en]" id="name-en" :value="old('name.en', '')" />
                <x-hearth-error for="name.en" />
            </div>
            <div class="field @error('name.fr') field--error @enderror">
                <x-hearth-label for="name-fr">{{ __('Name of organization — French') }}</x-hearth-label>
                <x-hearth-input name="name[fr]" id="name-fr" :value="old('name.fr', '')" />
                <x-hearth-error for="name.fr" />
            </div>

            <x-hearth-input type="hidden" name="type" :value="$type" />
        </fieldset>

        <button>{{ __('Create') }}</button>

        @csrf
    </form>
</x-app-layout>
