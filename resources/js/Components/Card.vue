<template>
    <div class="w-full border-2 border-dotted border-black rounded-md pb-4 px-6">
        <div class="flex justify-center bg-rose-800 rounded-md border-2 border-dotted border-gray-600
                    p-1 text-xl text-white font-bold -mt-4">
            {{ title }}
        </div>
        <slot />
    </div>
</template>

<script setup>
    defineProps({
        title: String
    })
</script>
