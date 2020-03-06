<template>
    <div class="flex items-center text-sm leading-5 text-gray-500">
        <template v-if="count">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                Occurred {{ count }} time{{ count !== 1 ? 's' : '' }}
            </span>
        </template>
        <span :class="count ? 'ml-2' : ''">
            <template v-if="report.resolved_at">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Resolved {{ !$page.report && report.resolved_at ? 'by ' + report.user.name : '' }}
                </span>
            </template>
            <template v-else>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Unresolved
                </span>
            </template>
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            report: Object,
            count: Number
        }
    }
</script>
