<template>
    <div class="grid grid-cols-4">
        <div class="col-span-4" :class="$page.reports.length > 0 ? 'lg:col-span-3 lg:pr-4' : ''">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-no-wrap">
                        <div class="ml-4 mt-4 min-w-0">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Error occured on {{ e.website }}
                                <a :href="e.vars.request.url" class="ml-1" target="_blank">
                                    <i class="fas fa-link text-sm text-indigo-600"></i>
                                </a>
                            </h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500 truncate">
                                {{ error }}
                            </p>
                        </div>
                        <div class="ml-4 mt-4 flex-shrink-0">
                            <span class="inline-flex rounded-md shadow-sm">
                                <button type="button" v-if="e.resolved_at" @click="updateReport({resolved: false})"
                                        class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-500 hover:bg-red-700 transition-all duration-150 focus:outline-none">
                                    Mark as unresolved
                                </button>
                                <button type="button" v-else @click="updateReport({resolved: true})"
                                        class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-500 hover:bg-green-800 transition-all duration-150 focus:outline-none">
                                    Mark as resolved
                                </button>
                            </span>
                            <i class="fas fa-trash-alt text-red-600 mx-2 cursor-pointer hover:text-red-800"
                               @click="deleteItemModal = true"></i>
                            <p class="text-xs text-gray-500" v-if="e.resolved_at">
                                By {{ e.user.name }} on {{ moment(e.resolved_at).format('MMMM Do, YYYY') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <div class="sm:hidden">
                        <select class="form-select block w-full" v-model="activeTabId">
                            <option v-for="(tab, id) in tabs" :key="id" :value="id">{{ tab.title }}</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <nav class="flex justify-center">
                            <a href="#" v-for="(tab, id) in tabs" :key="id" @click="activeTabId = id"
                               class="mx-2 px-3 py-2 font-medium text-sm leading-5 rounded-md  focus:outline-none select-none"
                               :class="id === activeTabId ? 'text-indigo-700 bg-indigo-100' : 'text-gray-500 hover:text-gray-700'">
                                {{ tab.title }}
                            </a>
                        </nav>
                    </div>
                </div>

                <component :is="activeTab.component"/>
            </div>
        </div>
        <div class="col-span-1 hidden lg:block" v-if="$page.reports.length > 0">
            <div class="text-gray-400 text-center">
                Other reports from {{ e.website }}
            </div>
            <reports-list/>
        </div>
        <modal v-model="deleteItemModal">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Remove error
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm leading-5 text-gray-500">
                                Are you sure you want to remove this error? All of your data will be permanantly
                                removed. This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse">
              <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button @click="deleteError" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                  Delete
                </button>
              </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button @click="deleteItemModal = false" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                  Cancel
                </button>
              </span>
            </div>
        </modal>
    </div>
</template>

<script>
    import Layout from '@/Shared/Layout';
    import ReportsList from "../../Shared/ReportsList";
    import StackTrace from "./Tabs/StackTrace";
    import Request from "./Tabs/Request";
    import Modal from "../../Shared/Modal";
    import App from "./Tabs/App";
    import Git from "./Tabs/Git";
    import moment from 'moment';

    export default {
        components: {Modal, ReportsList},
        metaInfo: {
            title: 'Error reports'
        },
        layout: Layout,
        data() {
            return {
                activeTabId: 0,
                tabs: [
                    {
                        title: "Stack trace",
                        component: StackTrace
                    },
                    {
                        title: "Request",
                        component: Request
                    },
                    {
                        title: "App",
                        component: App
                    }
                    ,
                    {
                        title: "Git",
                        component: Git
                    }
                ],

                deleteItemModal: false
            }
        },
        computed: {
            e() {
                return this.$page.report
            },
            error() {
                return this.e.vars.message;
            },
            activeTab() {
                return this.tabs[this.activeTabId];
            }
        },
        methods: {
            updateReport(data) {
                this.$inertia.patch(this.route('reports.update', this.e.uuid), data);
            },
            deleteError() {
                this.$inertia.delete(this.route('reports.update', this.e.uuid));
            },

            moment(date) {
                return moment(date);
            }
        }
    }
</script>
