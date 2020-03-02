<template>
    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 sm:py-1">
        <dd class="text-sm leading-5 font-medium text-gray-500 text-right" style="word-break: break-all;">
            <slot name="title"/>
        </dd>
        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-3" style="word-break: break-all;">
            <slot/>
        </dt>
    </div>
</template>

<script>
    export default {}
</script>
