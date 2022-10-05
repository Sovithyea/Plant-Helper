<template>
    <div class="pb-5">
        <label class="mt-n2">{{ label }}</label>
        <ckeditor
            @change="change"
            :editor="editor"
            v-model="model"
            :config="editorOption"
        ></ckeditor>
    </div>
</template>
<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
    props: {
        value: {},
        label: {
            type: String,
            default: null,
        },
    },
    data: () => ({
        editor: ClassicEditor,
        editorOption: {},
    }),
    computed: {
        model: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit("input", value);
            },
        },
    },
    methods: {
        change() {
            this.$emit("change", this.value);
        },
    },
};
</script>

<style>
.ck-editor {
    margin-top: 10px !important;
}
.ck-editor__editable {
    height: 250px;
}
</style>
