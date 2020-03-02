<template>
    <div class="flex">
        <div class="flex-shrink-0" style="width: 330px">
            <div class="text-right bg-gray-200 p-4 text-sm text-gray-500 select-none">
                <span class="border-b cursor-pointer" style="border-style: dotted"
                      @click="expandVendorFrames = !expandVendorFrames">
                        {{ expandVendorFrames ? 'Collapse' : 'Expand' }} vendor frames
                    </span>
            </div>
            <div class="flex flex-col-reverse">
                <div class="flex cursor-pointer border-b overflow-hidden select-none relative"
                     v-for="(frame, i) in frames" :key="i"
                     v-if="frame.file !== 'unknown' && (expandVendorFrames || frame.is_application_frame)"
                     @click="activeFrameId = i" :class="activeFrameId === i ? 'bg-indigo-100' : ''">
                    <div
                        class="w-10 flex items-center justify-center text-gray-500 text-sm border-r-2 flex-shrink-0 py-4"
                        :class="borderColor(frame, i)">
                        {{ i + 1 }}
                    </div>
                    <div class="text-xs px-2 py-3" style="word-break: break-word;"
                         :class="frame.is_application_frame ? 'text-indigo-700' : 'text-gray-600'"
                         v-html="formatFileName(frame.file)">
                    </div>
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4 bg-gray-100 text-gray-600 absolute right-0 bottom-0">
                          :{{ frame.line_number }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex-grow min-w-0" v-if="activeFrame">
            <div class="bg-gray-200 px-6 py-4">
                <span class="text-gray-600">{{ activeFrame.class }}::{{ activeFrame.method }}</span><br>
                <span v-html="formatFileName(activeFrame.file) + ':' + activeFrame.line_number"></span>
            </div>
            <div class="flex">

                <div class="bg-gray-200">
                    <p v-for="(code, nr) in activeFrame.code_snippet" :key="nr"
                       style="line-height: 2" class="text-gray-500 text-xs px-2 select-none"
                       :class="parseInt(activeFrame.line_number) === parseInt(nr) ? 'bg-indigo-200' : ''">
                        {{ nr }}
                    </p>
                </div>

                <div class="flex-grow overflow-auto min-w-0">
                    <div class="min-w-full" style="width: fit-content;">
                        <pre v-for="(code, nr) in activeFrame.code_snippet" :key="nr"
                             class="text-xs px-2 hover:bg-indigo-100 max-w-full"
                             :class="parseInt(activeFrame.line_number) === parseInt(nr) ? 'bg-indigo-100' : ''"
                             style="line-height: 2;height: 24px;" v-html="highlightedCode(code)"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import hljs from 'highlight.js/lib/highlight';
    hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));

    export default {
        data() {
            return {
                activeFrameId: this.$page.report.vars.frames.length - 1,
                expandVendorFrames: false,
            };
        },
        created() {
            this.highlightState = null;
        },
        computed: {
            activeFrame() {
                return this.frames[this.activeFrameId];
            },
            frames() {
                return Object.assign([], this.$page.report.vars.frames).reverse()
            }
        },
        methods: {
            formatFileName(file) {
                file = file.split("/");
                file[file.length - 1] = `<span class="font-semibold">${file[file.length - 1]}</span>`;
                return file.join("/");
            },

            borderColor(frame, i) {
                if (frame.is_application_frame) {
                    if (this.activeFrameId === i)
                        return "border-indigo-700";
                    else
                        return "border-indigo-200";
                }

                if (this.activeFrameId === i)
                    return "border-gray-400";
                else
                    return "border-gray-200";
            },

            highlightedCode(code) {
                const result = hljs.highlight('php', code || '', true, this.highlightState);
                this.highlightState = result.top;
                return result.value || '&nbsp;';
            },
        }
    }
</script>
