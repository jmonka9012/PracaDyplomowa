<script setup>
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    pending: {
        type: Boolean,
        required: true
    }
});

const routeParams = computed(() => new URLSearchParams(window.location.search));
const eventParam = computed(() => routeParams.value.get('event_sort_dir'));
const pendingParam = computed(() => routeParams.value.get('pending_sort_dir'));

function sortEvents(method) {
    const pending = props.pending;

    if (!pending) {
        if (method === 'toggle') {
            method = eventParam.value === 'asc' ? 'desc' : 'asc';
        }
        GetFilteredResults(method);
    } else {
        if (method === 'toggle') {
            method = pendingParam.value === 'asc' ? 'desc' : 'asc';
        }
        GetFilteredResults(method);
    }
}

function GetFilteredResults(method) {
    const request = props.pending
        ? {
            pending_sort_dir: method,
            tabName: 'Oczekujące wydarzenia'
        }
        : {
            event_sort_dir: method,
            tabName: 'Zatwierdzone wydarzenia'
        };

    router.get(
        route('admin.events'),
        request,
        {
            preserveScroll: true,
            only: props.pending ? ['pending'] : ['events'],
            onError: (err) => console.log(err)
        }
    );
}
</script>

<template>
    <tr>
        <th class="t-details-events__main-img">Obrazek Główny</th>
        <th class="t-details-events__name">Nazwa</th>
        <th class="t-details-events__date">
            <a @click="sortEvents('toggle')">Data
                <span class="sorters">
          <span :class="{ active: (eventParam === 'asc' && !props.pending) || (pendingParam === 'asc' && props.pending) }" class="sort sort-asc fa" @click.stop="sortEvents('asc')" />
          <span :class="{ active: (eventParam === 'desc' && !props.pending) || (pendingParam === 'desc' && props.pending) }" class="sort sort-desc fa" @click.stop="sortEvents('desc')" />
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

<style lang="scss" scoped></style>
