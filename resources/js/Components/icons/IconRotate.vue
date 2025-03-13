<script setup>
defineProps({
    background: {
        type: String,
        default: "transparent",
    },
    rotateText: {
        type: String,
    },
});
</script>

<template>
    <div
        class="icon-rotate-holder"
        v-bind="$attrs"
        :style="{ backgroundImage: background }"
    >
        <svg
            class="icon-rotate-svg"
            xmlns="http://www.w3.org/2000/svg"
            width="250.5"
            height="250.5"
            viewBox="0 0 250.5 250.5"
        >
            <path
                d="M.25,125.25a125,125,0,1,1,125,125,125,125,0,0,1-125-125"
                id="e-path-78c8962"
            ></path>
            <text>
                <textPath
                    id="e-text-path-78c8962"
                    href="#e-path-78c8962"
                    startOffset="0%"
                >
                    {{ rotateText }}
                </textPath>
            </text>
        </svg>
    </div>
</template>

<style lang="scss">
.icon-rotate-holder {
    background-position: center center;
    background-repeat: no-repeat;
    font-family: "Krona One", Sans-serif;
    font-size: 24px;
    line-height: 0em;
    width: auto;
}
.icon-rotate-svg {
    width: 190px;
    max-width: 100%;
    height: auto;
    overflow: visible;
    transform: rotate(0) scaleX(1) scaleY(1);
    animation: rotate-right linear 60s infinite;

    path {
        vector-effect: non-scaling-stroke;
        fill: transparent;
        stroke: transparent;
        stroke-width: 1px;
        transition: stroke, fill;
    }

    text {
        fill: rgb(0, 0, 0);
        direction: var(--direction, ltr);
        transition: 0.3s stroke, 0.3s stroke-width, 0.3s fill;
    }
}
</style>
