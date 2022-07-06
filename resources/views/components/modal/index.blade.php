@props([
    'heading',
])

<modal-toggle>
    <template #default="{ isVisible, toggleModal }">
        <div>
            {{ $trigger }}
            <div v-if="isVisible" class="fixed inset-0 flex items-center">
                <div class="fixed inset-0 z-10 bg-black opacity-75"></div>

                <div class="relative z-20 w-full m-8 mx-6 md:mx-auto md:w-1/2 lg:w-1/3">
                    <div class="p-8 bg-white rounded-lg shadow-lg">
                        <div class="flex justify-end mb-6">
                            <button @click="toggleModal" class="flex items-center text-red-500">
                                <span class="mr-2">Close</span>
                                <svg viewBox="0 0 20 20" class="h-4 fill-current">
                                    <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                                </svg>
                            </button>
                        </div>

                        <h1 class="text-2xl text-center text-indigo-800">{{ $heading }}</h1>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </template>
</modal-toggle>
