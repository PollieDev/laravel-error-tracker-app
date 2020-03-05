<template>
    <div class="px-4 py-5 sm:px-0">
        <info-item>
            <h2 class="text-lg font-bold">Environment</h2>
        </info-item>

        <info-item>
            <template v-slot:title>
                Laravel Config Cached?
            </template>
            <span>{{ env.laravel_config_cached ? 'Yes' : 'No' }}</span>
        </info-item>
        <info-item>
            <template v-slot:title>
                Laravel Locale
            </template>
            <span>{{ env.laravel_locale }}</span>
        </info-item>
        <info-item>
            <template v-slot:title>
                Laravel Version
            </template>
            <span>{{ env.laravel_version }}</span>
        </info-item>
        <info-item>
            <template v-slot:title>
                PHP Version
            </template>
            <span>{{ env.php_version }}</span>
        </info-item>

        <info-item>
            <h2 class="text-lg font-bold">Route</h2>
        </info-item>

        <info-item>
            <template v-slot:title>
                Action
            </template>
            <pre class="bg-gray-100 p-2">{{ JSON.stringify(route.action, undefined, 2) }}</pre>
        </info-item>
        <info-item>
            <template v-slot:title>
                Methods
            </template>
            <pre class="bg-gray-100 p-2">{{ JSON.stringify(route.methods, undefined, 2) }}</pre>
        </info-item>
        <info-item>
            <template v-slot:title>
                Parameters
            </template>
            <pre class="bg-gray-100 p-2">{{ JSON.stringify(route.parameters, undefined, 2) }}</pre>
        </info-item>
        <info-item>
            <template v-slot:title>
                uri
            </template>
            <span>{{ route.uri }}</span>
        </info-item>
    </div>
</template>

<script>
    import InfoItem from "../../../Shared/InfoItem";

    export default {
        components: {InfoItem},
        computed: {
            env() {
                return this.$page.report.vars.env;
            },
            route() {
                return this.$page.report.vars.route;
            }
        }
    }
</script>
