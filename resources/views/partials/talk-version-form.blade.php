<x-input.text
    name="title"
    label="*Talk Title"
    :value="$current->title"
></x-input.text>

<x-input.radios
    name="type"
    label="*Type of Talk"
    :value="$current->type"
    :options="[
        'Seminar' => 'seminar',
        'Workshop' => 'workshop',
        'Lightning' => 'lightning',
        'Keynote' => 'keynote',
    ]"
    class="mt-8"
></x-input.radios>

<x-input.radios
    name="level"
    label="*Difficulty Level"
    :value="$current->level"
    :options="[
        'Beginner' => 'beginner',
        'Intermediate' => 'intermediate',
        'Advanced' => 'advanced',
    ]"
    class="mt-8"
></x-input.radios>

<x-input.text
    name="length"
    label="*Length (mins)"
    :value="$current->length"
    class="mt-8"
></x-input.text>

<x-input.radios
    name="public"
    label="*Show on public speaker profile?"
    :value="$talk->public"
    :options="[
        'Yes' => '1',
        'No' => '0',
    ]"
    class="mt-8"
></x-input.radios>

<x-input.textarea
    name="description"
    label="Description"
    class="mt-8"
    :value="$current->description"
    help="markdown supported"
></x-input.textarea>

<x-input.text
    name="slides"
    label="Slides URL"
    :value="$current->slides"
    class="mt-8"
></x-input.text>

<x-input.textarea
    name="organizer_notes"
    label="*Organizer Notes"
    class="mt-8"
    :value="$current->organizer_notes"
></x-input.textarea>
