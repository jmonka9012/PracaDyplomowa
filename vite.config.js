import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app-old.scss", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
    // server: {
    //     hmr: {
    //         host: 'localhost',
    //     }
    // },
    resolve: {
        alias: {
            "-nd": path.resolve(__dirname, "./node_modules"),
            "@": path.resolve(__dirname, "./resources/js"),
            "~css": path.resolve(__dirname, "./resources/css"),
            "~images": path.resolve(__dirname, "./public/images"),
            "~icons": path.resolve(__dirname, "./public/icons"),
        },
    },
    // css: {
    //     preprocessorOptions: {
    //         scss: {
    //             additionalData: `@use "~css/mixin-test.scss";`,
    //         },
    //     },
    // },
});
