<template>
    <div class="px-4 py-5 sm:px-0">
        <info-item>
            <template v-slot:title>
                Git remote
            </template>
            {{ git.remote }}
        </info-item>
        <info-item>
            <template v-slot:title>
                Git message
            </template>
            {{ git.message }}
        </info-item>
        <info-item>
            <template v-slot:title>
                Git tag
            </template>
            {{ git.tag }}
        </info-item>
        <info-item>
            <template v-slot:title>
                Git hash
            </template>
            {{ git.hash }}
        </info-item>
        <info-item>
            <template v-slot:title>
                Git is dirty?
            </template>
            {{ git.isDirty }}
        </info-item>
    </div>
</template>

<script>
    import InfoItem from "../../../Shared/InfoItem";

    export default {
        components: {InfoItem},
        computed: {
            git() {
                return this.$page.report.vars.git
            }
        }
    }
</script>
