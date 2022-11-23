<select {!! $attributes->merge([
    'name' => $name,
    'id' => $id,
]) !!} {{ $required ? 'required' : '' }} {{ $autofocus ? 'autofocus' : '' }}
    @disabled($disabled) {!! $describedBy() ? 'aria-describedby="' . $describedBy() . '"' : '' !!} {!! $invalid ? 'aria-invalid="true"' : '' !!}>
    @foreach ($locales as $key => $locale)
        <option value="{{ $key }}" @if ($key === $selected) selected @endif>
            {{ is_signed_language($key) ? __(':signLanguage (with :locale)', ['signLanguage' => get_language_exonym($key, $key), 'locale' => get_language_exonym(get_written_language_for_signed_language($key), $key)], $key) : $locale }}
        </option>
    @endforeach
</select>
