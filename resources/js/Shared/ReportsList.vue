<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul>
            <li v-for="(report, i) in $page.reports" :key="report.uuid"
                :class="i !== 0 ? 'border-t border-gray-200' : ''">
                <inertia-link :href="route('reports.show', report.uuid)"
                              class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="min-w-0 flex-1 flex items-center">
                            <div class="min-w-0 flex-1 px-4 md:flex">
                                <div class="flex-grow max-w-full min-w-0" :class="!$page.report ? 'pr-6' : ''">
                                    <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                                        {{ report.message }}
                                    </div>
                                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                        <template v-if="!$page.report">
                                            <i class="fas fa-globe flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 flex items-center"></i>
                                            <span class="truncate">{{ report.website }}</span>
                                        </template>
                                        <template v-else>
                                            <div class="flex text-sm leading-5 text-gray-900">
                                                <i class="fas fa-clock flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 flex items-center"></i>
                                                <time :datetime="moment($page.created_at).format('YYYY-M-D')" class="text-gray-500">
                                                    {{ moment($page.created_at).format('DD/MM/YYYY') }}
                                                </time>
                                            </div>
                                        <status :report="report" class="ml-6" v-if="$page.report"/>
                                        </template>
                                    </div>
                                </div>
                                <div class="hidden md:block pr-10 flex-shrink-0" v-if="!$page.report">
                                    <div>
                                        <div class="text-sm leading-5 text-gray-900">
                                            Occurred on
                                            <time :datetime="moment($page.created_at).format('YYYY-M-D')">
                                                {{ moment($page.created_at).format('MMMM Do, YYYY') }}
                                            </time>
                                        </div>
                                        <status :report="report" class="mt-2"/>
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
        components: {Status},
        methods: {
            moment(date) {
                return window.moment(date);
            }
        }
    }
</script>
