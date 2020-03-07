<template>
    <div :class="!compact ? 'bg-white shadow overflow-hidden sm:rounded-md' : ''">
        <ul>
            <li v-for="(report, i) in reports" :key="report.uuid"
                :class="i !== 0 ? 'border-t border-gray-200' : ''">
                <inertia-link :href="route('reports.show', report.uuid)"
                              :preserve-state="compact" :preserve-scroll="compact"
                              class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="min-w-0 flex-1 flex items-center">
                            <div class="min-w-0 flex-1 px-4 md:flex">
                                <div class="flex-grow max-w-full min-w-0 pr-6">
                                    <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                                        <template v-if="compact && $page.report.uuid === report.uuid">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mr-2">
                                                This report
                                            </span>
                                        </template>
                                        {{ report.message }}
                                    </div>
                                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                        <i class="fas fa-globe flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 flex items-center"></i>
                                        <span class="truncate">{{ report.website }}</span>
                                    </div>
                                </div>
                                <div class="hidden md:flex pr-10 flex-shrink-0 items-center"
                                     :style="{ 'min-width': maxWidth }" ref="right_content">
                                    <div v-if="!compact">
                                        <div class="text-sm leading-5 text-gray-900">
                                            Last occurence on
                                            <time :datetime="moment(report.created_at).format('YYYY-M-D')">
                                                {{ moment(report.created_at).format('MMMM Do, YYYY') }}
                                            </time>
                                        </div>
                                        <status :report="report" :count="report.occurrences" class="mt-2"/>
                                    </div>
                                    <div v-else>
                                        <div class="text-sm leading-5 text-gray-900">
                                            Occurred on
                                            <time :datetime="moment(report.created_at).format('YYYY-M-D HH:mm')">
                                                {{ moment(report.created_at).format('MMMM Do, YYYY HH:mm') }}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </inertia-link>
            </li>
        </ul>
    </div>
</template>

<script>
    import Status from "./Status";

    export default {
        props: {
            reports: Array,
            compact: {
                type: Boolean,
                default: false
            }
        },
        components: {Status},
        data() {
            return {
                maxWidth: null
            }
        },
        mounted() {
            this.calcMaxWidth()
        },
        updated() {
            this.calcMaxWidth()
        },
        methods: {
            moment(date) {
                return window.moment(date);
            },
            calcMaxWidth() {
                if (!this.$refs.right_content)
                    return null;

                const sorted = this.$refs.right_content.sort((a, b) => b.clientWidth - a.clientWidth);
                this.maxWidth = sorted[0].clientWidth + "px";
            }
        }
    }
</script>
