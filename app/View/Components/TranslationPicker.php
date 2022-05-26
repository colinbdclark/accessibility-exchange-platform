<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TranslationPicker extends Component
{
    /**
     * The languages selected for translation.
     *
     * @var array
     */
    public array $languages;

    /**
     * The languages available for translation.
     *
     * @var array
     */
    public array $availableLanguages = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->languages = ['en', 'fr', 'ase', 'fcs'];
        $this->availableLanguages = ['' => __('Choose a language…')] + get_available_languages(true);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.translation-picker');
    }
}