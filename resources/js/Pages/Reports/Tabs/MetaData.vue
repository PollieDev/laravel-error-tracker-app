<template>
    <div class="px-4 py-5 sm:px-0">
        <info-item>
            <h2 class="text-lg font-bold">Meta Data</h2>
        </info-item>

        <info-item v-for="(value, key) in meta" :key="key">
            <template v-slot:title>
                {{ key }}
            </template>
            <pre v-if="typeof value === 'object'"
                 class="bg-gray-100 p-2">{{ JSON.stringify(value, undefined, 2) }}</pre>
            <span v-html="value" v-else></span>
        </info-item>
    </div>
</template>

<script>
    import InfoItem from "../../../Shared/InfoItem";

    export default {
        components: {InfoItem},
        computed: {
            meta() {
                return this.$page.report.vars.meta;
            }
        }
    }
</script>
