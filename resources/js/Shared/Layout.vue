<template>
    <div class="flex flex-col h-full">
        <nav @keydown.window.escape="open = false" class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" :src="$page.app.logos.light" alt=""/>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline">
                                <inertia-link :href="route(item.route)" v-for="item in menu" :key="item.route"
                                              class="ml-4 px-3 py-2 rounded-md text-sm font-medium focus:outline-none"
                                              :class="route().current(item.is || item.route) ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700'"
                                              v-if="$page.auth.user.role.powerlevel >= (item.powerlevel || 0)">
                                    {{ item.title }}
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!--<button
                                class="p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </button>-->
                            <div v-click-away="() => open = false" class="ml-3 relative">
                                <div>
                                    <button @click.stop="open = !open"
                                            class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid">
                                        <img class="h-8 w-8 rounded-full"
                                             :src="$page.auth.user.avatar"
                                             :alt="`Gravatar ${$page.auth.user.name}`"
                                             alt=""/>
                                    </button>
                                </div>
                                <div v-if="open"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                    <div class="py-1 rounded-md bg-white shadow-xs">
                                        <!--<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Your Profile
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Settings
                                        </a>-->
                                        <inertia-link :href="route('logout')" method="post"
                                                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sign out
                                        </inertia-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mr-2 flex md:hidden">
                        <button @click.stop="open = !open"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="open" class="md:hidden">
                <div class="px-2 pt-2 pb-3 sm:px-3">
                    <inertia-link :href="route(item.route)" v-for="item in menu" :key="item.route"
                                  class="block mt-1 px-3 py-2 rounded-md text-sm font-medium focus:outline-none"
                                  :class="route().current(item.is || item.route) ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700'"
                                  v-if="$page.auth.user.role.powerlevel >= (item.powerlevel || 0)">
                        {{ item.title }}
                    </inertia-link>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                 :src="`https://www.gravatar.com/avatar/${$page.auth.user.hashed_email}?d=${$page.app.logos.light}`"
                                 :alt="`Gravatar ${$page.auth.user.name}`"/>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">
                                {{ $page.auth.user.name }}
                            </div>
                            <div class="mt-1 text-sm font-medium leading-none text-gray-400">
                                {{ $page.auth.user.email }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 px-2">
                        <!--<a href="#"
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">
                            Your Profile
                        </a>
                        <a href="#"
                           class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">
                            Settings
                        </a>-->
                        <a href="#"
                           class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">
                            Sign out
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <header class="bg-white shadow" v-if="$page.meta && $page.meta.title">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    {{ $page.meta.title }}
                </h2>
            </div>
        </header>
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 h-full">
                <div class="px-4 py-3 sm:px-0 h-full">
                    <slot/>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    export default {
        name: "Layout",
        data() {
            return {
                open: false,
                menu: [
                    /*{
                        title: "Dashboad",
                        route: "dashboard"
                    },*/
                    {
                        title: "Reports / Errors",
                        route: "reports.index",
                        is: "reports.*",
                        powerlevel: 0
                    },
                    {
                        title: "Users",
                        route: "users.index",
                        is: "users.*",
                        powerlevel: 100
                    }
                ]
            }
        },
        mounted() {
            this.updateMeta();
        },
        updated() {
            this.updateMeta();
        },
        methods: {
            updateMeta() {
                document.title = this.$page.meta && this.$page.meta.title ? this.$page.meta.title : "Unknown page";

                if (this.$page.flash.message) {
                    this.snackbar(this.$page.flash.message);
                    this.$page.flash.message = null;
                }
            }
        }
    }
</script>
