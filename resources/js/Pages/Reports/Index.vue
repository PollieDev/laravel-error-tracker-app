<template>
    <div>
        <div class="bg-white shadow overflow-hidden sm:rounded-md mb-3">
            <div class="p-3 border-b border-gray-200 sm:px-6 flex justify-between">
                <div class="flex items-center">
                    <input-val type="select" v-model="filters.all" class="text-gray-500">
                        <option :value="false">Unhandeled reports</option>
                        <option :value="true">All reports</option>
                    </input-val>
                    <span class="mx-2 text-sm text-gray-500">
                        <b>from</b>
                    </span>
                    <input-val v-model="filters.website" placeholder="Website..." class="text-gray-500"/>
                    <span class="ml-2 text-sm text-gray-400">
                        <b>{{ $page.reports.length || "No" }}</b> report{{ $page.reports.length !== 1 ? 's' : '' }} found
                    </span>
                </div>
                <input-val type="select" v-model="filters.sort" class="text-gray-500">
                    <option value="date">Ordered by date</option>
                    <option value="occurrences">Ordered by occurrences count</option>
                </input-val>
            </div>
        </div>
        <reports-list :reports="$page.reports"/>
    </div>
</template>

<script>
    import Layout from '@/Shared/Layout';
    import ReportsList from "../../Shared/ReportsList";
    import InputVal from "../../Shared/InputVal";

    export default {
        components: {InputVal, ReportsList},
        layout: Layout,
        data() {
            return {
                filters: {
                    website: this.$page.filters.website,
                    all: this.$page.filters.all,
                    sort: this.$page.filters.sort
                },

                timeout: null
            }
        },
        watch: {
            "filters.website"() {
                if (this.timeout)
                    clearTimeout(this.timeout);

                this.timeout = setTimeout(this.applyFilters, 1000);
            },
            "filters.all"() {
                this.applyFilters();
            },
            "filters.sort"() {
                this.applyFilters();
            }
        },
        methods: {
            applyFilters() {
                let url = this.route('reports.index');
                let params = {};

                if (this.filters.website)
                    params['website'] = this.filters.website;
                if (this.filters.all === 'true' || this.filters.all === true)
                    params['all'] = 'true';
                if (this.filters.sort)
                    params['sort'] = this.filters.sort;

                params = Object.keys(params).map(key => `${key}=${params[key]}`).join("&");
                this.$inertia.visit(`${url}${params.length > 0 ? '?' : ''}${params}`, {
                    preserveState: true,
                    preserveScroll: true
                });
            }
        }
    }
</script>
