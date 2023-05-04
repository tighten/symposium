<div v-cloak {{ $attributes->merge(['class' => 'relative']) }}>
    <menu-toggle>
        <div slot-scope="{show, toggle}">
            <button
                v-on:click="toggle"
                {{ $trigger->attributes }}
            >
                {{ $trigger }}
            </button>
            <div
                class="bg-white border border-indigo-600 flex flex-col py-1 mt-6 right-0 rounded text-indigo-600 z-50"
                :class="{
                    'absolute': show,
                    'hidden': !show,
                }"
            >
                {{ $items }}
            </div>
        </div>
    </menu-toggle>
</div>
