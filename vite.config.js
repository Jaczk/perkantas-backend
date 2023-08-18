import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import tailwindcss from "tailwindcss";
import { resolve } from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: [...refreshPaths, "app/Http/Livewire/**"],
        }),
        tailwindcss(resolve(__dirname, "tailwind.config.js")), // Add Tailwind CSS plugin
    ],
    build: {
        outDir: "public/dist",
        assetsDir: "public/assets",
        manifest: true,
        minify: true,
    },
});
