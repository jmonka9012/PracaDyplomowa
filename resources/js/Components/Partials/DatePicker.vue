<script setup>
import { ref } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import {
    endOfMonth,
    endOfWeek,
    endOfYear,
    startOfMonth,
    startOfWeek,
    startOfYear,
    subDays,
    addDays,
    addWeeks,
} from "date-fns";
const date = ref(new Date());

const today = new Date();

const getNextWeek = () => {
    const start = addDays(endOfWeek(today, { weekStartsOn: 1 }), 1);
    const end = addWeeks(startOfWeek(today, { weekStartsOn: 1 }), 1);
    return [start, endOfWeek(end, { weekStartsOn: 1 })];
};

const getClosestWeekend = () => {
    let friday = new Date();
    while (friday.getDay() !== 5) {
        friday = addDays(friday, 1);
    }
    const saturday = addDays(friday, 1);
    const sunday = addDays(friday, 2);
    return [saturday, sunday];
};

const getNextWeekend = () => {
    let friday = new Date();
    while (friday.getDay() !== 5) {
        friday = addDays(friday, 1);
    }
    const nextFriday = addWeeks(friday, 1);
    const nextSaturday = addDays(nextFriday, 1);
    const nextSunday = addDays(nextFriday, 2);
    return [nextSaturday, nextSunday];
};

const getNext30Days = () => {
    return [today, addDays(today, 29)];
};

const presetDates = ref([
    { label: "Dzisiaj", value: [today, today] },
    { label: "Jutro", value: [addDays(today, 1), addDays(today, 1)] },
    {
        label: "Ten tydzień",
        value: [
            startOfWeek(today, { weekStartsOn: 1 }),
            endOfWeek(today, { weekStartsOn: 1 }),
        ],
    },
    { label: "Następny tydzień", value: getNextWeek() },
    { label: "Najbliższy weekend", value: getClosestWeekend() },
    { label: "Następny weekend", value: getNextWeekend() },
    { label: "Ten miesiąc", value: [startOfMonth(today), endOfMonth(today)] },
    { label: "Najbliższe 30 dni", value: getNext30Days() },
]);
</script>

<template>
    <VueDatePicker
        v-model="date"
        range
        multi-calendars
        :preset-dates="presetDates"
        placeholder="Data"
        :enable-time-picker="false"
        locale="pl"
        :day-names="['pon', 'wto', 'śro', 'czw', 'pią', 'sob', 'nie']"
        :preview-format="null"
        model-type="dd-MM-yyyy"
    >
        <template #dp-input="{ value, onInput, onEnter, onTab, isMenuOpen }">
            <div class="dp__input_wrap" :class="{ open: isMenuOpen }">
                <i class="fa fa-calendar"></i>
                <input
                    class="dp__pointer dp__input_readonly dp__input dp__input_icon_pad dp__input_reg"
                    :value="value"
                    placeholder="Data"
                    readonly
                    autocomplete="off"
                    aria-label="Datepicker input"
                    @input="onInput"
                    @keydown.enter.prevent="onEnter"
                    @keydown.tab="onTab"
                />
                <i class="fa fa-chevron-down"></i>
            </div>
        </template>

        <template #preset-date-range-button="{ label, value, presetDate }">
            <span
                role="button"
                :tabindex="0"
                @click="presetDate(value)"
                @keyup.enter.prevent="presetDate(value)"
                @keyup.space.prevent="presetDate(value)"
            >
                {{ label }}
            </span>
        </template>
        <template #action-row="{ internalModelValue, selectDate, closePicker }">
            <div class="dp__action_buttons">
                <button
                    type="button"
                    class="dp__action_button dp__action_cancel"
                    @click="closePicker"
                >
                    Anuluj
                </button>
                <button
                    type="button"
                    class="dp__action_button dp__action_select"
                    @click="
                        () => {
                            selectDate();
                            closePicker();
                            console.log('Selected:', internalModelValue);
                        }
                    "
                >
                    Wybierz
                </button>
            </div>
        </template>
    </VueDatePicker>
</template>

<style lang="scss">
@use "~css/mixin.scss";
.dp__main {
    max-height: 60px;
    max-width: 100%;
}
.dp__input {
    box-shadow: none;
    min-height: 60px;
    display: block;
    padding: 0.375rem 0.75rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 8px;
    appearance: none;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    min-width: 330px;
    padding-left: 60px;
    font-family: "Krona One";
    display: flex;
    align-items: center;
    justify-content: flex-start;
    position: relative;
    color: var(--text);
    @include mixin.media-breakpoint-down(xl) {
        width: 100%;
    }
    &::placeholder {
        opacity: 1;
        color: var(--text);
    }
}
.dp__input_wrap {
    .fa-calendar {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 20px;
        z-index: 1;
    }
    .fa-chevron-down {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 12px;
        z-index: 1;
    }
    &.open {
        .fa-chevron-down {
            transform: translateY(-50%) rotateZ(180deg);
        }
        .dp__input {
            border: 1px solid var(--primary);
            outline: 1px solid var(--primary);
        }
    }
}

.dp__input_icons {
    padding: 0;
    width: 18px;
    height: 24px;
    left: 20px;
}
.dp__outer_menu_wrap {
    @include mixin.media-breakpoint-down(xl) {
        width: 100%;
    }
}
.dp__calendar_header_separator {
    background-color: transparent;
}
.dp__menu_inner {
    padding: 16px 16px 0 16px;
}
.dp--preset-dates {
    padding: 16px;
    gap: 8px;
    display: flex;
    flex-direction: column;
    border-inline-end: 0;
    max-width: 275px;
}
.dp--preset-dates[data-dp-mobile] {
    max-width: 100%;
    overflow: hidden;
}
.dp--preset-range {
    font-size: 14px;
    height: 32px;
    color: #000;
    padding: 0 14px;
    font-weight: 500;
    align-items: center;
    transition: all 0.5s ease;
    border-radius: 0.5rem;
    border: 2px solid transparent;
    width: 100%;
    white-space: nowrap;
    font-family: "Krona one";
    &:hover {
        background-color: var(--primary);
        border: 2px solid var(--text);
    }
}
.dp--preset-range[data-dp-mobile] {
    border: 2px solid transparent;
    &:hover,
    &:focus {
        border: 2px solid var(--text);
    }
}
.dp__instance_calendar > .dp--header-wrap {
    border-bottom: 1px solid var(--primary);
}

.dp__calendar_next {
    margin-inline-start: 22.5;
}

.dp__calendar_row {
    margin: 10px 0;
}
.dp__calendar_item {
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.dp__cell_inner {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    line-height: 32px;
    height: 32px;
    width: 32px;
    font-weight: 400;
    transition: var(--trans-def);
    border-radius: 2px;
    padding: 0;
}
.dp__calendar_header_item {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    line-height: 32px;
    height: 32px;
    width: 32px;
    font-weight: 400;
    transition: var(--trans-def);
    border-radius: 2px;
    padding: 0;
}
.dp__today {
    border: 1px solid var(--primary);
}
.dp__range_end,
.dp__range_start {
    background: var(--primary);
    border-radius: 2px;
}
.dp__range_between {
    border: 1px dotted var(--primary);
    background-color: transparent;
}
.dp__action_row {
    padding: 16px;
}
.dp__action_button {
    margin-inline-start: 0;
    font-family: "Prompt";
    border: 1px solid var(--primary);
    height: 30px;
    line-height: 30px;
    padding: 8px;
}
.dp__action_cancel {
    margin-right: 10px;
    &:hover {
        background: var(--primary);
        border: 1px solid var(--primary);
        color: white;
    }
}
.dp__action_buttons .dp__action_select {
    border-color: transparent;
    background-color: var(--primary);
    &:hover {
        background-color: black;
        color: white;
    }
}

.dp--clear-btn {
    display: none;
}

.datepicker-hero {
    .dp__input {
        min-width: 100%;
        font-size: 12px;
        border-radius: 0;
        border: 0;
        padding-left: 35px;
        color: #495057;
    }
    .fa {
        color: #495057;
    }
    .fa-calendar {
        left: 12px;
        color: var(--primary);
    }
    .dp__input_wrap.open .dp__input {
        border: 0;
        outline: 0;
    }
}
</style>
