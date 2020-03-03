<template>
    <div>
        <div class="text-right mb-6">
            <span class="inline-flex rounded-md shadow-sm">
                <inertia-link :href="route('users.create')">
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                        <i class="fas fa-plus -ml-0.5 mr-1 h-4 w-4 flex items-center jusitfy-center"></i>
                        Add a user
                    </button>
                </inertia-link>
            </span>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <!--<th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>-->
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <tr v-for="user in $page.users">
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full"
                                             :src="user.avatar" :alt="`Gravatar ${user.name}`"/>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm leading-5 font-medium text-gray-900">{{ user.name }}</div>
                                        <div class="text-sm leading-5 text-gray-500">{{ user.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <!--<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-sm leading-5 text-gray-900">Director</div>
                                <div class="text-sm leading-5 text-gray-500">Human Resources</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>-->
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                {{ user.role.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                <inertia-link :href="route('users.edit', user.id)"
                                              class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">
                                    <i class="fas fa-pencil-alt"></i>
                                </inertia-link>
                                <a href="javascript:" @click="deleteUser(user)"
                                   class="ml-2 text-red-600 hover:text-red-900 focus:outline-none focus:underline">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Layout from "../../Shared/Layout";

    export default {
        layout: Layout,
        methods: {
            deleteUser(user) {
                this.snackbar({
                    showAction: true,
                    text: "Are you sure you want to delete " + user.name + "?",
                    actionTextColor: "#e02424",
                    actionText: "DELETE",
                    onActionClick: (a) => {
                        this.$inertia.delete(this.route('users.destroy', user.id))
                    }
                })
            }
        }
    }
</script>
