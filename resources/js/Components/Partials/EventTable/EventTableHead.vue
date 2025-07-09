<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    pending: {
        type: Boolean,
        required: true
    }
});

function sortEvents(method, property) {
    const pending = props.pending;

    if (!pending) {
        if (property === 'name') {
            if (method === 'asc') {
/*                router.get(route('admin.events'), {
                    event_sort_dir: 'asc'
                }, {
                    preserveScroll: true
                })*/
            } else if (method ==='desc') {

            } else {

            }
        } else if (property ==='date') {
            if (method === 'asc') {

            } else if (method ==='desc') {

            } else {

            }
        }
    } else {
        if (property === 'name') {
            if (method === 'asc') {

            } else if (method ==='desc') {

            } else {

            }
        } else if (property ==='date') {
            if (method === 'asc') {

            } else if (method ==='desc') {

            } else {

            }
        }
    }
}
</script>

<template>
    <tr>
        <th class="t-details-events__main-img">Obrazek Główny</th>
        <th class="t-details-events__name">
            <a @click="sortEvents('toggle', 'name')" href="#username-sort">Nazwa
                <span class="sorters">
          <span @click.stop="sortEvents('asc', 'name')" class="sort sort-asc fa"></span>
          <span @click.stop="sortEvents('desc', 'name')" class="sort sort-desc fa"></span>
        </span>
            </a>
        </th>
        <th class="t-details-events__date">
            <a @click="sortEvents('toggle', 'date')" href="#username-sort">Data
                <span class="sorters">
          <span @click.stop="sortEvents('asc', 'date')" class="sort sort-asc fa"></span>
          <span @click.stop="sortEvents('desc', 'date')" class="sort sort-desc fa"></span>
        </span>
            </a>
        </th>
        <th class="t-details-events__start">Początek</th>
        <th class="t-details-events__end">Koniec</th>
        <th class="t-details-events__loc">Lokalizacja</th>
        <th class="t-details-events__e-main">Email gł.</th>
        <th class="t-details-events__e-add">Email dodatkowy</th>
    </tr>
</template>

<style scoped lang="scss"></style>
