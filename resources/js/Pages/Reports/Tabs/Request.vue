<template>
    <div class="px-4 py-5 sm:px-0">
        <dl>
            <info-item>
                <template v-slot:title>
                    URL
                </template>
                {{ request.url }}
            </info-item>
            <info-item>
                <template v-slot:title>
                    Method
                </template>
                {{ request.method }}
            </info-item>
            <info-item>
                <template v-slot:title>
                    IP
                </template>
                {{ request.ip }}
            </info-item>
            <info-item>
                <template v-slot:title>
                    User Agent
                </template>
                {{ request.useragent }}
            </info-item>
        </dl>

        <hr class="my-6">

        <info-item>
            <h2 class="text-lg font-bold">Headers</h2>
        </info-item>

        <info-item v-for="(value, key) in request.headers" :key="key">
            <template v-slot:title>
                {{ key }}
            </template>
            <span v-html="value.join('<br>')"></span>
        </info-item>

        <hr class="my-6">

        <info-item>
            <h2 class="text-lg font-bold">Session</h2>
        </info-item>

        <info-item v-for="(value, key) in data.session" :key="key">
            <template v-slot:title>
                {{ key }}
            </template>
            <pre v-if="typeof value === 'object'"
                 class="bg-gray-100 p-2">{{ JSON.stringify(value, undefined, 2) }}</pre>
            <span v-html="value" v-else></span>
        </info-item>

        <hr class="my-6">

        <info-item>
            <h2 class="text-lg font-bold">Query String</h2>
        </info-item>

        <info-item v-for="(value, key) in data.queryString" :key="key">
            <template v-slot:title>
                {{ key }}
            </template>
            <span v-html="value"></span>
        </info-item>

        <hr class="my-6">

        <info-item>
            <h2 class="text-lg font-bold">Body</h2>
        </info-item>

        <info-item v-for="(value, key) in data.body" :key="key">
            <template v-slot:title>
                {{ key }}
            </template>
            <span v-html="value"></span>
        </info-item>

        <hr class="my-6">

        <info-item>
            <h2 class="text-lg font-bold">Files</h2>
        </info-item>

        <info-item v-for="(value, key) in data.files" :key="key">
            <template v-slot:title>
                {{ key }}
            </template>
            <span v-html="value"></span>
        </info-item>

        <hr class="my-6">

        <info-item>
            <h2 class="text-lg font-bold">Cookies</h2>
        </info-item>

        <info-item v-for="(value, key) in cookies" :key="key">
            <template v-slot:title>
                {{ key }}
            </template>
            <span v-html="value"></span>
        </info-item>
    </div>
</template>

<script>
    import InfoItem from "../../../Shared/InfoItem";

    export default {
        components: {InfoItem},
        computed: {
            request() {
                return this.$page.report.vars.request;
            },
            data() {
                return this.$page.report.vars.request_data;
            },
            cookies() {
                const rawCookies = this.request.headers.cookie.join(";").split(";");
                let cookies = {};
                rawCookies.forEach(raw => {
                    let parts = raw.split("=");
                    cookies[parts[0].trim()] = parts[1].trim();
                });
                return cookies;
            }
        }
    }
</script>
