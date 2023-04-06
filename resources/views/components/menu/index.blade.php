<div class="relative">
    <menu-toggle>
        <div slot-scope="slotProps">
            <button
                v-on:click="slotProps.toggle"
                {{ $trigger->attributes }}
            >
                {{ $trigger }}
            </button>
            <div
                class="bg-white border border-indigo-600 flex flex-col py-1 mt-6 right-0 rounded text-indigo-600 z-50"
                :class="slotProps.show ? 'absolute' : 'hidden'"
            >
                {{ $items }}
            </div>
        </div>
    </menu-toggle>
</div>
