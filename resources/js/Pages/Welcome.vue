<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue';

const props = defineProps({
    'results': Array,
    'positions': Array,
})

function getResults(id) {
    let result = [];
    Array.from(props.results).forEach((item) => {
        if (item.position_id === id) {
            result.push(item);
        }
    })
    return result;
}

</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-rose-100
         dark:bg-rose-100 sm:items-center sm:pt-0"
    >
        <Card title="Poll Results!" class="w-1/2">
            <div v-if="results.length > 0">
                <div v-for="position in positions">
                    <div class="rounded-md border-2 border-rose-800 p-1 my-7">
                        <div class="text-gray-700 text-3xl font-bold bg-rose-100 -mt-7 px-1 w-fit">
                            {{position.position}} Candidates
                        </div>
                        <div v-for="record in getResults(position.position_id)">
                            <div  class="grid grid-cols-2">
                                <div class="text-gray-600 text-xl">{{record.nominee}}</div>
                                <div class="text-gray-600 text-xl">Vote Count: {{record.vote_count}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-gray-600 text-2xl text-bold">Oops! No available results yet.</div>
        </Card>
    </div>
</template>
