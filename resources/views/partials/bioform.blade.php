<x-input.text
    name="nickname"
    label="*Nickname"
    :value="$bio->nickname"
></x-input.text>

<x-input.textarea
    name="body"
    label="*Body"
    class="mt-8"
    :value="$bio->body"
></x-input.textarea>

<x-input.radios
    name="public"
    label="*Show on public speaker profile?"
    :value="$bio->public"
    :options="[
        'Yes' => '1',
        'No' => '0',
    ]"
></x-input.radios>
