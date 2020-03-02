<template>
    <div class="flex items-center text-sm leading-5 text-gray-500">
        <template v-if="report.resolved_at">
            <i class="fas fa-check-circle flex-shrink-0 mr-1.5 h-5 w-5 text-green-400 flex items-center"></i>
            Resolved {{ !$page.report && report.resolved_at ? 'by ' + report.user.name : '' }}
        </template>
        <template v-else>
            <i class="fas fa-times-circle flex-shrink-0 mr-1.5 h-5 w-5 text-red-600 flex items-center"></i>
            Unresolved
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            report: Object
        }
    }
</script>
