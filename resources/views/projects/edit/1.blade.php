<form class="stack" action="{{ localized_route('projects.update', $project) }}" method="POST"
    enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <div class="with-sidebar with-sidebar:last">

        @include('projects.partials.progress')

        <div class="stack">
            <h2>
                {{ __('Step :current of :total', ['current' => request()->get('step') ?? 1, 'total' => 2]) }}<br />
                {{ __('Project overview') }}
            </h2>
            <x-interpretation name="{{ __('Project overview', [], 'en') }}" />
            <hr class="divider--thick">
            <x-translatable-input name="name" :label="__('Project name') . ' ' . __('(required)')" :shortLabel="__('project name')" :hint="__('This is the name that will be displayed on your project page.')" :model="$project"
                interpretationName="Project name" interpretationNameSpace="project_name-required" required />

            <h3>{{ __('Project goals') }}</h3>
            <x-interpretation name="{{ __('Project goals', [], 'en') }}" />

            <x-translatable-textarea name="goals" :label="__('Please indicate the goals for this project.') . ' ' . __('(required)')" :short-label="__('project goals')" :model="$project" />

            <h3>{{ __('Project scope') }}</h3>
            <x-interpretation name="{{ __('Project scope', [], 'en') }}" />

            <x-translatable-textarea name="scope" :label="__(
                'Please describe how the Disability and Deaf communities will be impacted by the outcomes of your project.',
            ) .
                ' ' .
                __('(required)')" :short-label="__('how communities will be impacted')" :model="$project" />

            <fieldset class="field @error('regions') field--error @enderror" x-data="enhancedCheckboxes()">
                <legend>
                    {{ __('Please indicate the geographical areas this project will impact.') . ' ' . __('(required)') }}
                </legend>
                <x-interpretation
                    name="{{ __('Please indicate the geographical areas this project will impact.', [], 'en') }}" />
                <x-hearth-checkboxes name="regions" :options="array_filter($regions)" :checked="old('regions', $project->regions ?? [])" required />
                <div class="stack" x-cloak>
                    <button class="secondary" type="button" x-on:click="selectAll()">{{ __('Select all') }}</button>
                    <button class="secondary" type="button" x-on:click="selectNone()">{{ __('Select none') }}</button>
                </div>
                <x-hearth-error for="regions" />
            </fieldset>

            @if ($project->projectable instanceof App\Models\RegulatedOrganization)
                <fieldset class="field @error('impacts') field--error @enderror stack">
                    <legend>
                        {{ __('Please indicate which areas of your organization this project will impact.') . ' ' . __('(required)') }}
                    </legend>
                    <x-interpretation
                        name="{{ __('Please indicate which areas of your organization this project will impact.', [], 'en') }}" />
                    <x-hearth-checkboxes name="impacts" :options="$impacts" :checked="old('impacts', $project->impacts->pluck('id')->toArray())" />
                    <x-hearth-error for="impacts" />
                </fieldset>
            @endif

            <x-translatable-textarea name="out_of_scope" :label="__('Please indicate what is out of scope for this project.') . ' ' . __('(optional)')" :short-label="__('what is out of scope')" :model="$project"
                interpretationName="Please indicate what is out of scope for this project."
                interpretationNameSpace="indicate_out_of_scope-optional" />

            <h3>{{ __('Project timeframe') }}</h3>
            <x-interpretation name="{{ __('Project timeframe', [], 'en') }}" />

            <x-interpretation name="{{ __('Project start date', [], 'en') }}"
                namespace="project_start_date-required" />
            <x-date-picker name="start_date" :label="__('Project start date') . ' ' . __('(required)')" :value="old('start_date', $project->start_date?->format('Y-m-d') ?? '')" />

            <x-interpretation name="{{ __('Project end date', [], 'en') }}" namespace="project_end_date-required" />
            <x-date-picker name="end_date" :label="__('Project end date') . ' ' . __('(required)')" :value="old('end_date', $project->end_date?->format('Y-m-d') ?? '')" />

            <h3>{{ __('Project outcome') }}</h3>
            <x-interpretation name="{{ __('Project outcome', [], 'en') }}" />

            <fieldset class="field @error('outcome_analysis') field--error @enderror stack" x-data="{ otherOutcomeAnalysis: {{ old('has_other_outcome_analysis', !is_null($project->outcome_analysis_other) && $project->outcome_analysis_other !== '' ? 'true' : 'false') }} }">
                <legend>
                    {{ __('Who will be going through the results and producing an outcome?') . ' ' . __('(required)') }}
                </legend>
                <x-hearth-checkboxes name="outcome_analysis" :options="\Spatie\LaravelOptions\Options::forEnum(App\Enums\OutcomeAnalyzer::class)->toArray()" :checked="old('outcome_analysis', $project->outcome_analysis ?? [])" required />
                <div class="field">
                    <x-hearth-checkbox name="has_other_outcome_analysis" :checked="old(
                        'has_other_outcome_analysis',
                        !is_null($project->outcome_analysis_other) && $project->outcome_analysis_other !== '',
                    )"
                        x-model="otherOutcomeAnalysis" />
                    <x-hearth-label for='has_other_outcome_analysis'>{{ __('Other') }}</x-hearth-label>
                </div>
                <div class="field__subfield stack">
                    <x-translatable-input name="outcome_analysis_other" :label="__('Please indicate who will be going through the results')" :short-label="__('who is going through the results')"
                        :model="$project" x-show="otherOutcomeAnalysis"
                        interpretationName="Please indicate who will be going through the results"
                        interpretationNameSpace="indicate_who_reviews_results-required" />
                </div>
                <x-hearth-error for="outcome_analysis" />
            </fieldset>

            <x-translatable-textarea name="outcomes" :label="__('Please indicate the tangible outcomes of this project.') . ' ' . __('(required)')" :short-label="__('tangible outcomes of this project')" :hint="__('For example, an accessibility report')"
                :model="$project" interpretationName="Please indicate the tangible outcomes of this project."
                interpretationNameSpace="indicate_tangible_outcomes-required" />

            <fieldset class="field @error('public_outcomes') field--error @enderror stack">
                <legend>{{ __('Please indicate if the reports will be publicly available.') . ' ' . __('(required)') }}
                </legend>
                <x-interpretation
                    name="{{ __('Please indicate if the reports will be publicly available.', [], 'en') }}" />
                <x-hearth-hint for="public_outcomes">
                    {{ __('This can mean either on this website, or on your organization’s website.') }}
                </x-hearth-hint>
                <x-hearth-radio-buttons name="public_outcomes" :options="Spatie\LaravelOptions\Options::forArray([1 => __('Yes'), 0 => __('No')])->toArray()" :checked="old('public_outcomes', $project->public_outcomes ?? '')" />
                <x-hearth-error for="public_outcomes" />
            </fieldset>
            <hr class="divider--thick">
            <x-interpretation name="{{ __('Save', [], 'en') . '_' . __('Save and next', [], 'en') }}"
                namespace="save_save_and_next" />
            <p class="flex flex-wrap gap-8">
                <button class="secondary" name="save" value="1">{{ __('Save') }}</button>
                <button name="save_and_next" value="1">{{ __('Save and next') }}</button>
            </p>
        </div>
    </div>
</form>
