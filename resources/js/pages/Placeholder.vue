<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Placeholder" />

    <main class="min-h-screen bg-slate-100 px-6 py-8 text-slate-800">
        <section class="mx-auto w-full max-w-3xl rounded-xl border border-slate-200 bg-white p-8 shadow-lg">
            <h1 class="text-2xl font-semibold">Placeholder Page</h1>
            <p class="mt-3 text-sm text-slate-600">
                This is a placeholder page for future content.
            </p>

            <Link
                href="/"
                class="mt-6 inline-block rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700"
            >
                Back To Map
            </Link>
        </section>
    </main>
</template>
