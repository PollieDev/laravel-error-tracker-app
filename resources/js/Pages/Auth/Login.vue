<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-24 w-auto" :src="$page.app.logos.dark" alt="Workflow" />
            <h2 class="text-center text-3xl leading-9 font-extrabold text-gray-900 mt-6">
                Sign in to your account
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form @submit.prevent="login">
                    <input-val name="email" v-model="form.email" label="Email address"/>
                    <input-val type="password" name="password" v-model="form.password" label="Password" class="mt-4"/>
                    <input-val type="checkbox" name="remember" v-model="form.remember" label="Remember me?" class="mt-4"/>

                    <!--<div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" v-model="form.remember"
                                   class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                            <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
                                Remember me
                            </label>
                        </div>

                        &lt;!&ndash;<div class="text-sm leading-5">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                Forgot your password?
                            </a>
                        </div>&ndash;&gt;
                    </div>-->

                    <div class="mt-6">
                      <span class="block w-full rounded-md shadow-sm">
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                          Sign in
                        </button>
                      </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import InputVal from "../../Shared/InputVal";
    export default {
        components: {InputVal},
        data() {
            return {
                form: {
                    email: "",
                    password: "",
                    remember: true
                }
            }
        },
        methods: {
            login() {
                this.$inertia.post(this.route('login'), this.form);
            }
        }
    }
</script>
