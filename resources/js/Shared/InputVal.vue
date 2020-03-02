<template>
    <div :class="groupClass">
        <label class="block text-sm font-medium leading-5 text-gray-700" :for="name" v-if="label && type !== 'checkbox'">
            {{ label }}
        </label>

        <div class="relative">
            <template v-if="type === 'textarea'">
            <textarea :id="name" cols="30" rows="10" @input="update" :placeholder="placeholder || label"
                      ref="input" :class="`input ${$page.errors[name] ? 'border border-red-500' : ''}`"
            >{{ value }}</textarea>
            </template>

            <template v-else-if="type === 'select'">
                <div class="relative">
                    <select :class="$page.errors[name] ? 'border border-red-500' : ''"
                            :id="name" :value="value" ref="select" @input="update"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-indigo-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        <option value="" disabled selected v-if="label">> {{ label }}</option>
                        <slot/>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </template>

            <!--<template v-else-if="type === 'date'">
                <datetime v-model="model" :input-id="name" @input="update"
                          :input-class="`input ${$page.errors[name] ? 'border border-red-500' : ''}`"/>
            </template>-->

            <!--<template v-else-if="type === 'image'">
                <picture-input
                    width="150"
                    height="150"
                    accept="image/jpeg,image/png"
                    :customStrings="{ drag: placeholder }"
                    radius="50"
                    :hideChangeButton="true"
                    @change="update"
                    :prefill="value"
                    :alert-on-error="false"
                />
            </template>-->

            <template v-else-if="type === 'checkbox'">
                <div class="flex items-center">
                    <input :class="$page.errors[name] ? 'border border-red-500' : ''" :id="name" :type="type"
                           class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                           :placeholder="placeholder || label" @change="update" :checked="value">
                    <label class="ml-2 block text-sm leading-5 text-gray-900" :for="name" v-if="label">
                        {{ label }}
                    </label>
                </div>
            </template>

            <template v-else>
                <input style="padding-right: 27px;"
                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-indigo-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                       :class="$page.errors[name] ? 'border border-red-500' : ''" :id="name" :type="type"
                       :placeholder="placeholder || label" @input="update" :value="value" ref="input">
            </template>
            <a href="javascript:" class="absolute text-gray-400 font-bold" v-if="withClear && value"
               @click="update('', true)"
               style="right: 0;width: 30px;top: 50%;transform: translateY(-50%);text-align: center;">
                x
            </a>
        </div>

        <p class="text-xs" v-if="subText">{{ subText }}</p>
        <p class="text-red-500 text-xs italic" v-if="$page.errors[name]">{{ $page.errors[name][0] }}</p>
    </div>
</template>

<script>
    export default {
        name: "InputVal",
        props: {
            value: {},
            label: String,
            name: String,
            placeholder: String,
            groupClass: String,
            type: {
                type: String,
                default: 'text'
            },
            withClear: {
                type: Boolean,
                default: false
            },
            subText: String
        },
        data() {
            return {
                model: this.value
            }
        },
        methods: {
            update(val, forceVal = false) {
                if (this.type === "date" || forceVal) {
                    this.model = val;
                    return this.emit(val);
                }

                if (this.type === "image") {
                    return this.emit(new File([this.dataURItoBlob(val)], "filename"));
                }

                if (this.type === "checkbox") {
                    return this.emit(!this.value);
                }

                let ref = "input";

                if (this.type === "select")
                    ref = "select";

                this.emit(this.$refs[ref].value);
            },

            emit(val) {
                this.$emit('input', val);
            },

            dataURItoBlob(dataURI) {
                // convert base64 to raw binary data held in a string
                // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
                var byteString = atob(dataURI.split(',')[1]);

                // separate out the mime component
                var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

                // write the bytes of the string to an ArrayBuffer
                var ab = new ArrayBuffer(byteString.length);

                // create a view into the buffer
                var ia = new Uint8Array(ab);

                // set the bytes of the buffer to the correct values
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }

                // write the ArrayBuffer to a blob, and you're done
                return new Blob([ab], {type: mimeString});
            }
        }
    }
</script>
