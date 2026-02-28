<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

declare global {
    interface Window {
        google?: { maps: any };
        initMap?: () => void;
    }
}

const mapEl = ref<HTMLElement | null>(null);
const loadError = ref<string | null>(null);
const hasKey = computed(() => Boolean(import.meta.env.VITE_GOOGLE_MAPS_KEY));

let mapScript: HTMLScriptElement | null = null;

function initializeMap() {
    if (!window.google?.maps || !mapEl.value) {
        return;
    }

    const center = { lat: 37.7749, lng: -122.4194 };
    const map = new window.google.maps.Map(mapEl.value, {
        center,
        zoom: 11,
        mapTypeControl: false,
    });

    new window.google.maps.Marker({
        position: center,
        map,
        title: 'San Francisco',
    });
}

onMounted(() => {
    if (!hasKey.value) {
        loadError.value = 'Missing API key. Add VITE_GOOGLE_MAPS_KEY to your .env file.';
        return;
    }

    if (window.google?.maps) {
        initializeMap();
        return;
    }

    const key = encodeURIComponent(import.meta.env.VITE_GOOGLE_MAPS_KEY as string);

    window.initMap = () => {
        initializeMap();
    };

    mapScript = document.createElement('script');
    mapScript.src = `https://maps.googleapis.com/maps/api/js?key=${key}&callback=initMap`;
    mapScript.async = true;
    mapScript.defer = true;
    mapScript.onerror = () => {
        loadError.value = 'Failed to load Google Maps API script.';
    };

    document.head.appendChild(mapScript);
});

onBeforeUnmount(() => {
    if (mapScript?.parentNode) {
        mapScript.parentNode.removeChild(mapScript);
    }

    if (window.initMap) {
        delete window.initMap;
    }
});
</script>

<template>
    <Head title="Google Map" />

    <main class="min-h-screen bg-slate-100 px-6 py-8 text-slate-800">
        <section class="mx-auto w-full max-w-5xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
            <header class="border-b border-slate-200 px-5 py-4">
                <h1 class="text-lg font-semibold">Google Maps API Example</h1>
            </header>

            <div ref="mapEl" class="h-[560px] w-full bg-slate-100" />

            <p v-if="loadError" class="border-t border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                {{ loadError }}
            </p>
        </section>
    </main>
</template>
