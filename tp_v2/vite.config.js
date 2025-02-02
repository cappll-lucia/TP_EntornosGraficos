import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // build: {
    //     outDir: "public/build",
    //     assetsDir: 'assets',
    // },
    server: {
        https: true, // Esto asegura que Vite sirva los activos a través de HTTPS en desarrollo
      },
      build: {
        manifest: true, // Esto es importante para que Vite genere un manifiesto de los archivos para Laravel
      },
});
