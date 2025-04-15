<script setup>
import { ref } from "vue";
import { onMounted, onUnmounted } from "vue";
import DropDown from "../partials/DropDown.vue";
import DatePicker from "@/Components/sections-new/DatePicker.vue";
defineProps({
    events: Array,
});

const scrollContainer = ref(null);
const scrollAmount = 50;

const scrollLeft = () => {
    if (scrollContainer.value) {
        scrollContainer.value.scrollBy(-scrollAmount, 0);
    }
};

const scrollRight = () => {
    if (scrollContainer.value) {
        scrollContainer.value.scrollBy(scrollAmount, 0);
    }
};
</script>
<template>
    <div class="select-filters">
        <DropDown title="test" subtitle="Wyszukaj lub wybierz miasto">
            <div class="dropdown-inner">
                <li class="dropdown-item dropdown-item-toggle">
                    <a href="">Drilldown<i class="fa fa-chevron-right"></i></a>
                    <ul class="dropdown-ndlevel">
                        <li class="ndlevel-back dropdown-item">
                            <a href=""
                                ><i class="fa fa-chevron-left"></i>Drilldown</a
                            >
                        </li>
                        <li class="dropdown-item">
                            <a href="#">item1</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#">item2</a>
                        </li>
                        <div class="divider"></div>
                        <li class="dropdown-item">
                            <a href="#">item1</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#">item2</a>
                        </li>
                        <div class="divider"></div>
                        <li class="dropdown-item">
                            <a href="#">item1</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#">item2</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown-item dropdown-item-toggle">
                    <a href="">Drilldown<i class="fa fa-chevron-right"></i></a>
                    <ul class="dropdown-ndlevel">
                        <li class="ndlevel-back dropdown-item">
                            <a href=""
                                ><i class="fa fa-chevron-left"></i>Drilldown</a
                            >
                        </li>
                        <li class="dropdown-item">
                            <a href="#">item4</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#">item3</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown-item">
                    <a href="#">Item 1 <i class="fa fa-chevron-right"></i></a>
                </li>
                <li class="dropdown-item">
                    <a href="#">Item 2 <i class="fa fa-chevron-right"></i></a>
                </li>
                <li class="dropdown-item">
                    <a href="#">Item 3 <i class="fa fa-chevron-right"></i></a>
                </li>
                <li class="dropdown-item">
                    <a href="#">Item 4 <i class="fa fa-chevron-right"></i></a>
                </li></div
        ></DropDown>
    </div>

    <div class="select-event-date mb-100px">
        <div class="date-jump">
            <button class="btn-reset date-jump__btn" @click="scrollLeft(50)">
                <i class="fa fa-chevron-left"></i>
            </button>
            <div ref="scrollContainer" class="date-jump__cont">
                <a href="" class="date-jump__link">Dziś</a>
                <a href="" class="date-jump__link">Jutro</a>
                <a href="" class="date-jump__link">Ten tydzień</a>
                <a href="" class="date-jump__link">Następny tydzień</a>
                <a href="" class="date-jump__link">Najbliższy weekend</a>
                <a href="" class="date-jump__link">Następny weekend</a>
                <a href="" class="date-jump__link">Ten miesiąc</a>
                <a href="" class="date-jump__link">Najbliższe 30 dni</a>
            </div>
            <button class="btn-reset date-jump__btn" @click="scrollRight(50)">
                <i class="fa fa-chevron-right"></i>
            </button>
        </div>
        <div class="d-flex flex-column">
            <div class="date-head">
                <div class="date-sec">
                    <div class="d-flex justify-content-end align-items-center">
                        <button class="date-dir">
                            <i class="fa fa-chevron-left"></i>
                            <i class="fa fa-chevron-left"></i>
                        </button>
                        <button class="date-dir">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                    </div>
                    <div
                        class="d-flex justify-content-center align-items-center flex-auto"
                    >
                        <button class="date-range">2025</button>
                        <button class="date-range">Kwie</button>
                    </div>

                    <div
                        class="d-flex justify-content-end align-items-center d-lg-none"
                    >
                        <button class="date-dir">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                        <button class="date-dir">
                            <i class="fa fa-chevron-right"></i>
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="date-sec d-none d-lg-flex">
                    <div
                        class="d-flex justify-content-center align-items-center flex-auto"
                    >
                        <button class="date-range">2025</button>
                        <button class="date-range">Kwie</button>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button class="date-dir">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                        <button class="date-dir">
                            <i class="fa fa-chevron-right"></i>
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="date-content">
                <div class="date-content__block">
                    <span class="date-item date-item--th">pon</span>
                    <span class="date-item date-item--th">wto</span>
                    <span class="date-item date-item--th">śro</span>
                    <span class="date-item date-item--th">czw</span>
                    <span class="date-item date-item--th">pią</span>
                    <span class="date-item date-item--th">sob</span>
                    <span class="date-item date-item--th">nie</span>
                    <a class="date-item disabled">31</a>
                    <a class="date-item disabled">1</a>
                    <a class="date-item disabled">2</a>
                    <a class="date-item disabled">3</a>
                    <a class="date-item disabled">4</a>
                    <a class="date-item disabled">5</a>
                    <a class="date-item disabled">6</a>
                    <a class="date-item disabled">7</a>
                    <a class="date-item disabled">8</a>
                    <a class="date-item disabled">9</a>
                    <a class="date-item disabled">10</a>
                    <a class="date-item disabled">11</a>
                    <a class="date-item">12</a>
                    <a class="date-item">13</a>
                    <a class="date-item">14</a>
                    <a class="date-item">15</a>
                    <a class="date-item">16</a>
                    <a class="date-item">17</a>
                    <a class="date-item">18</a>
                    <a class="date-item">19</a>
                    <a class="date-item">20</a>
                    <a class="date-item">21</a>
                    <a class="date-item">22</a>
                    <a class="date-item">23</a>
                    <a class="date-item">24</a>
                    <a class="date-item">25</a>
                    <a class="date-item">26</a>
                    <a class="date-item selected">27</a>
                    <a class="date-item">28</a>
                    <a class="date-item">29</a>
                    <a class="date-item">30</a>
                    <a class="date-item future">1</a>
                    <a class="date-item future">2</a>
                    <a class="date-item future">3</a>
                    <a class="date-item future">4</a>
                    <a class="date-item future">5</a>
                    <a class="date-item future">6</a>
                    <a class="date-item future">7</a>
                    <a class="date-item future">8</a>
                    <a class="date-item future">9</a>
                    <a class="date-item future">10</a>
                    <a class="date-item future">11</a>
                </div>
                <div class="date-content__block">
                    <span class="date-item date-item--th">pon</span>
                    <span class="date-item date-item--th">wto</span>
                    <span class="date-item date-item--th">śro</span>
                    <span class="date-item date-item--th">czw</span>
                    <span class="date-item date-item--th">pią</span>
                    <span class="date-item date-item--th">sob</span>
                    <span class="date-item date-item--th">nie</span>
                    <a class="date-item">31</a>
                    <a class="date-item">1</a>
                    <a class="date-item">2</a>
                    <a class="date-item">3</a>
                    <a class="date-item">4</a>
                    <a class="date-item">5</a>
                    <a class="date-item">6</a>
                    <a class="date-item">7</a>
                    <a class="date-item">8</a>
                    <a class="date-item">9</a>
                    <a class="date-item">10</a>
                    <a class="date-item">11</a>
                    <a class="date-item">12</a>
                    <a class="date-item">13</a>
                    <a class="date-item">14</a>
                    <a class="date-item">15</a>
                    <a class="date-item">16</a>
                    <a class="date-item">17</a>
                    <a class="date-item">18</a>
                    <a class="date-item">19</a>
                    <a class="date-item">20</a>
                    <a class="date-item">21</a>
                    <a class="date-item">22</a>
                    <a class="date-item">23</a>
                    <a class="date-item">24</a>
                    <a class="date-item">25</a>
                    <a class="date-item">26</a>
                    <a class="date-item">27</a>
                    <a class="date-item">28</a>
                    <a class="date-item">29</a>
                    <a class="date-item">30</a>
                    <a class="date-item future">1</a>
                    <a class="date-item future">2</a>
                    <a class="date-item future">3</a>
                    <a class="date-item future">4</a>
                    <a class="date-item future">5</a>
                    <a class="date-item future">6</a>
                    <a class="date-item future">7</a>
                    <a class="date-item future">8</a>
                    <a class="date-item future">9</a>
                    <a class="date-item future">10</a>
                    <a class="date-item future">11</a>
                </div>
            </div>
        </div>
    </div>
    <DatePicker></DatePicker>

    <div v-for="event in events" :key="event.id" class="event">
        <div class="event-img">
            <a class="link-stretched" :href="event.mainLink[0].href"> </a>
            <img :src="event.src" alt="" />
        </div>
        <div class="d-flex flex-column col-12">
            <div
                class="d-flex flex-lg-row justify-content-between align-items-center mt-lg-8px mb-16px"
            >
                <h6 class="event-title">
                    <a :href="event.mainLink[0].href">{{
                        event.mainLink[0].title
                    }}</a>
                </h6>
                <a
                    class="event-link d-none d-lg-flex"
                    :href="event.mainLink[0].ahref"
                    ><i class="fa fa-ticket"></i>
                    Zobacz więcej
                </a>
            </div>
            <p class="event-date ff-prompt">
                <i class="fa fa-calendar mr-5px"></i>{{ event.date }}
            </p>
            <p class="event-subtitle">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed,
                eum?
            </p>
            <a class="event-link d-lg-none" :href="event.mainLink[0].ahref"
                ><i class="fa fa-ticket"></i>
                Zobacz więcej
            </a>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "~css/mixin.scss";
.event {
    display: flex;
    flex-direction: column;
    padding: 16px;
    border: 1px solid #1910280a;
    position: relative;
    background-color: #fffc;
    word-break: break-word;
    border-radius: 8px;
    width: 100%;
    margin-bottom: 16px;
    &:last-of-type {
        margin-bottom: 0;
    }

    @include mixin.media-breakpoint-up(md) {
        flex-direction: row;
        justify-content: space-between;
        align-items: start;
    }

    &-img {
        max-width: 200px;
        flex-shrink: 0;
        margin-bottom: 20px;
        position: relative;
        display: flex;
        width: 100%;
        img {
            border-radius: 8px;
        }

        @include mixin.media-breakpoint-up(md) {
            margin-right: 16px;
            margin-bottom: 0;
        }
    }

    &-title {
        font-size: 24px;
        line-height: 1.5;
        font-weight: 500;
        @include mixin.media-breakpoint-down(lg) {
            font-size: 20px;
        }
        a {
            text-decoration: underline;
            text-decoration-color: transparent;
            text-decoration-thickness: 0.08em;
            text-underline-offset: 0.05em;
            transition: all 0.45s;
        }

        @include mixin.media-breakpoint-up(lg) {
            margin-bottom: 0;
        }

        &:hover {
            a {
                text-decoration-color: var(--dark);
            }
        }
    }
    &-link {
        height: 48px;
        min-width: 48px;
        font-size: 16px;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 0 16px;
        gap: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: var(--trans-def);
        background-color: var(--primary);
        &:hover {
            background-color: #a499d5;
        }
    }
    &-date {
        display: flex;
        align-items: center;
        color: #191028a3;
        line-height: 20px;
        i {
            font-size: 12px;
        }

        @include mixin.media-breakpoint-up(md) {
            margin-bottom: 0;
        }
        @include mixin.media-breakpoint-up(lg) {
            margin-bottom: 8px;
        }
    }
    &-subtitle {
        border-top: 1px solid #19102814;
        padding-top: 8px;
        margin-top: 30px;
        margin-bottom: 16px;
        font-size: 13px;
        line-height: 1.5;
        color: #191028a3;
        width: 100%;
        @include mixin.media-breakpoint-down(lg) {
            margin-bottom: 25px;
            margin-top: 25px;
        }
    }
    &-subtitle,
    &-date {
        transition: var(--trans-def);
    }
    &:hover {
        background-color: #19102805;
        .event-date,
        .event-subtitle {
            color: #191028;
        }
    }
}
.select-event-date {
    background: #fff;
    width: 100%;
    padding: 1rem;
    border: 1px solid #edecee;
    border-radius: 0.5rem;
    display: flex;
    flex-direction: column;
    // max-width: 352px;
    max-height: 60vh;
    column-gap: 8px;
    width: 100%;
    @include mixin.media-breakpoint-up(lg) {
        flex-direction: row;
        width: fit-content;
    }
    .date-jump {
        display: flex;
        @include mixin.media-breakpoint-up(lg) {
            flex-direction: column;
        }
        &__btn {
            @include mixin.media-breakpoint-up(lg) {
                display: none;
            }
        }
        &__cont {
            display: flex;
            flex-direction: row;
            scroll-snap-type: x mandatory;
            overflow-x: auto;
            max-width: 275px;
            gap: 8px;
            -ms-overflow-style: none;
            scrollbar-width: none;
            padding-bottom: 5px;
            @include mixin.media-breakpoint-up(lg) {
                flex-direction: column;
                padding-bottom: 5px;
            }
        }
        &__link {
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
            &:hover {
                background-color: var(--primary);
                border: 2px solid var(--text);
            }
        }
    }
    .date-sec {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
        @include mixin.media-breakpoint-up(lg) {
            justify-content: center;
        }
    }
    .date-head {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        column-gap: 16px;
        border-bottom: 1px solid var(--primary);
    }
    .date-dir,
    .date-range {
        background-color: transparent;
        border: 0;
        line-height: 40px;
        font-weight: 500;
        font-family: "Krona One";
        transition: var(--trans-def);
    }
    .date-range {
        &:hover {
            color: var(--primary);
        }
    }
    .date-dir {
        display: flex;
        align-items: center;
        color: var(--gray2);
        &:hover {
            color: var(--text);
        }
    }
    .date-content {
        display: flex;
        &__block {
            display: grid;
            grid-template-columns: repeat(7, auto);
            grid-auto-rows: 38px;
            padding: 8px 12px;
            width: 280px;
        }
    }

    .date-item {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        line-height: 32px;
        height: 32px;
        font-weight: 400;
        transition: var(--trans-def);
        border-radius: 2px;
        width: 100%;
        &.selected {
            border: 1px solid var(--primary);
        }
        &:hover:not(.date-item--th:hover) {
            background-color: #f5f5f5;
        }
        &.disabled {
            color: #00000040;
            pointer-events: none;
        }
        &--th {
            color: #000;
        }
    }
    .date-sec:nth-of-type(2) {
        display: none;
        @include mixin.media-breakpoint-up(lg) {
            display: flex;
        }
    }
    .date-content__block:nth-of-type(2) {
        display: none;
        @include mixin.media-breakpoint-up(lg) {
            display: grid;
        }
    }
}

.event-select-location {
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
    margin-bottom: 100px;
    &.open {
        border: 1px solid var(--primary);
        outline: 1px solid var(--primary);
    }
    i {
        &.fa-map-marker {
            font-size: 24px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 20px;
        }
        &.fa-chevron-down {
            font-size: 16px;
            transition: all 0.25s ease;
        }
    }
    .select-label {
        transition: all 0.25s ease;
    }
    .select-subtext {
        color: var(--n-gray);
        height: 0;
        line-height: 0;
        pointer-events: none;
        font-size: 0;
        transition: all 0.25s ease;
    }
    &.open {
        .select-label {
            position: absolute;
            top: 0;
            left: 60px;
            font-size: 12px;
        }
        .select-subtext {
            height: 1em;
            line-height: 1;
            font-size: 12px;
        }
        .fa-chevron-down {
            transform: rotateZ(180deg);
        }
    }

    &__dropdown {
        display: none;
        flex-direction: column;
        position: absolute;
        left: 0;
        right: 0;
        border: 1px solid var(--n-gray);
        top: 100%;
        border-radius: 8px;
        background-color: white;
        &.open {
            display: flex;
        }
        .dropdown-inner {
            height: 300px;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            overflow-y: auto;
            column-gap: 10px;
            font-family: "Prompt";
            padding: 16px;
            position: relative;
            border-radius: 8px;
        }
        .dropdown-item {
            height: 2rem;
            padding-inline: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            font-weight: 500;
            width: 100%;
            position: static;
            &:hover {
                background-color: #19102814;
            }
            a {
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: relative;
                width: 100%;
                i {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    right: 12px;
                }
            }
        }
        .dropdown-ndlevel {
            position: absolute;
            top: 0;
            transition: var(--trans-def);
            left: 100%;
            visibility: hidden;
            opacity: 0;
            padding: 16px;
            background: #fff;
            border-radius: 8px;
            z-index: 1;
            height: 100%;
            &.show {
                display: flex;
                flex-direction: column;
                gap: 8px;
                left: 0;
                right: 0;
                visibility: visible;
                opacity: 1;
            }
            .divider {
                height: 1px;
                width: 100%;
                background-color: var(--n-gray);
            }
            .ndlevel-back {
                position: sticky;
                top: -16px;
                background-color: white;
                z-index: 1;
                padding-left: 45px;
                &:hover {
                    background-color: #19102814;
                }
                a {
                    position: relative;
                }
                i {
                    right: auto;
                    left: -30px;
                }
            }
        }
    }
}
</style>
