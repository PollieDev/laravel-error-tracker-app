<template>
    <div>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <form @submit.prevent="$page.user ? updateUser() : createUser()">
                    <div>
                        <div>
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Profile
                                </h3>
                            </div>
                            <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <input-val v-model="user.name" name="name" label="Username"/>
                                </div>

                                <div class="sm:col-span-3">
                                    <input-val type="email" v-model="user.email" name="email" label="Email address"/>
                                </div>

                                <div class="sm:col-span-3">
                                    <input-val type="select" v-model="user.role_id" name="role_id" label="Role" :disabled="!$page.admin_edit">
                                        <option v-for="role in $page.roles" :key="role.id" :value="role.id">
                                            {{ role.name }}
                                        </option>
                                    </input-val>
                                </div>

                                <div class="sm:col-span-3" v-if="$page.user">
                                    <label class="block text-sm leading-5 font-medium text-gray-700">
                                        Photo
                                    </label>
                                    <div class="flex items-center">
                                        <span class="h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                            <img :src="user.avatarDark" :alt="`Gravatar ${user.name}`"
                                                 class="h-full w-full">
                                        </span>
                                        <span class="ml-5 rounded-md shadow-sm">
                                            <a href="https://nl.gravatar.com/emails/" target="_blank">
                                                <button type="button"
                                                        class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                                    Change
                                                </button>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Password
                                    <small class="text-gray-400 font-normal" v-if="$page.user">
                                        Leave empty if you don't want to update it
                                    </small>
                                </h3>
                            </div>
                            <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <input-val type="password" v-model="user.current_password" name="current_password"
                                               label="Current password" v-if="!$page.admin_edit"/>
                                </div>
                                <div class="sm:col-span-3">
                                    <input-val type="password" v-model="user.password" name="password"
                                               label="Password"/>
                                </div>
                                <div class="sm:col-span-3">
                                    <input-val type="password" v-model="user.password_confirmation"
                                               name="password_confirmation" label="Confirm password"/>
                                </div>
                            </div>
                        </div>
                        <!--<div class="mt-8 border-t border-gray-200 pt-8">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Notifications
                                </h3>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    We'll always let you know about important changes, but you pick what else you want
                                    to hear about.
                                </p>
                            </div>
                            <div class="mt-6">
                                <fieldset>
                                    <legend class="text-base font-medium text-gray-900">
                                        By Email
                                    </legend>
                                    <div class="mt-4">
                                        <div class="relative flex items-start">
                                            <div class="absolute flex items-center h-5">
                                                <input id="comments" type="checkbox"
                                                       class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                                            </div>
                                            <div class="pl-7 text-sm leading-5">
                                                <label for="comments" class="font-medium text-gray-700">Comments</label>
                                                <p class="text-gray-500">Get notified when someones posts a comment on a
                                                    posting.</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="relative flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="candidates" type="checkbox"
                                                           class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                                                </div>
                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="candidates"
                                                           class="font-medium text-gray-700">Candidates</label>
                                                    <p class="text-gray-500">Get notified when a candidate applies for a
                                                        job.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="relative flex items-start">
                                                <div class="absolute flex items-center h-5">
                                                    <input id="offers" type="checkbox"
                                                           class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                                                </div>
                                                <div class="pl-7 text-sm leading-5">
                                                    <label for="offers" class="font-medium text-gray-700">Offers</label>
                                                    <p class="text-gray-500">Get notified when a candidate accepts or
                                                        rejects an offer.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="mt-6">
                                    <legend class="text-base font-medium text-gray-900">
                                        Push Notifications
                                    </legend>
                                    <p class="text-sm leading-5 text-gray-500">These are delivered via SMS to your
                                        mobile phone.</p>
                                    <div class="mt-4">
                                        <div class="flex items-center">
                                            <input id="push_everything" name="form-input push_notifications"
                                                   type="radio"
                                                   class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                                            <label for="push_everything" class="ml-3">
                                                <span class="block text-sm leading-5 font-medium text-gray-700">Everything</span>
                                            </label>
                                        </div>
                                        <div class="mt-4 flex items-center">
                                            <input id="push_email" name="form-input push_notifications" type="radio"
                                                   class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                                            <label for="push_email" class="ml-3">
                                                <span class="block text-sm leading-5 font-medium text-gray-700">Same as
                                                    email</span>
                                            </label>
                                        </div>
                                        <div class="mt-4 flex items-center">
                                            <input id="push_nothing" name="form-input push_notifications" type="radio"
                                                   class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                                            <label for="push_nothing" class="ml-3">
                                                <span class="block text-sm leading-5 font-medium text-gray-700">No push
                                                    notifications</span>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>-->
                    </div>
                    <div class="mt-8 border-t border-gray-200 pt-5">
                        <div class="flex justify-end">
                            <!--<span class="inline-flex rounded-md shadow-sm">
                                <button type="button"
                                        class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                    Cancel
                                </button>
                            </span>-->
                            <span class="ml-3 inline-flex rounded-md shadow-sm">
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                    Save
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Layout from "../../Shared/Layout";
    import InputVal from "../../Shared/InputVal";

    export default {
        components: {InputVal},
        layout: Layout,
        data() {
            return {
                user: Object.assign({}, this.$page.user)
            }
        },
        methods: {
            createUser() {
                this.$inertia.post(this.route('users.store'), this.user);
            },
            updateUser() {
                let route = this.route('settings');

                if (this.$page.admin_edit)
                    route = this.route('users.update', this.user.id);

                this.$inertia.patch(route, this.user);
            }
        }
    }
</script>

<style scoped>

</style>
