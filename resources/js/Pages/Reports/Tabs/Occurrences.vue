<template>
    <div class="px-4 py-5 sm:px-0">
        <reports-list :reports="occurrences" :compact="true"/>
    </div>
</template>

<script>

    import ReportsList from "../../../Shared/ReportsList";
    export default {
        components: {ReportsList},
        computed: {
            occurrences() {
                console.log(this.$page.occurrences);
                return this.$page.occurrences;
            }
        }
    }
</script>
