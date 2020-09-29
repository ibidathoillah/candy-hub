<template>
    <div>
        <template v-if="richtext">
            <trumbowyg class="form-control"
                    rows="8"
                    :value="value"
                    @tbw-change="updateValue($event.target.value)"
                    @tbw-paste="updateValue($event.target.value)"
                    :required="required"
                    svg-path="/candy-hub/images/trumbowyg.svg"
                    :config="config"
                    :placeholder="placeholder">
                {{ value }}
            </trumbowyg>
        </template>
        <template v-else>
            <textarea class="form-control"
                  rows="8"
                  :value="value"
                  @input="updateValue($event.target.value)"
                  :required="required"
                  :placeholder="placeholder"
                  :disabled="disabled">
                {{ value }}
            </textarea>
        </template>
    </div>
</template>

<script>
    import trumbowyg from 'vue-trumbowyg';
    // Import editor css
    import 'trumbowyg/dist/ui/trumbowyg.css';
    import 'trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.min.css';
    import 'trumbowyg/dist/plugins/cleanpaste/trumbowyg.cleanpaste.js';
    import 'trumbowyg/dist/plugins/colors/trumbowyg.colors.min.js';
    import 'trumbowyg/dist/plugins/fontfamily/trumbowyg.fontfamily.min.js';
    import 'trumbowyg/dist/plugins/fontsize/trumbowyg.fontsize.min.js';

    export default {
        data() {
            return {
                config: {
                    tagsToRemove: ['script', 'link', 'xml'],
                     btns: [
        ['viewHTML'],
        ['undo', 'redo'], // Only supported in Blink browsers
        ['formatting'],
        ['strong', 'em', 'del'],
        ['superscript', 'subscript'],
        ['link'],
        ['insertImage'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
        ['unorderedList', 'orderedList'],
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen'],
        ['foreColor', 'backColor'],
        ['fontsize'],
        ['fontfamily']
    ],
        plugins: {
         colors: {
            colorList: ['3e3690','bb9a5d','2dc0dd','fdd10a','23a0bc',
            'ffffff', '000000', 'eeece1', '1f497d', '4f81bd', 'c0504d', '9bbb59', '8064a2', '4bacc6', 'f79646', 'ffff00',
            'f2f2f2', '7f7f7f', 'ddd9c3', 'c6d9f0', 'dbe5f1', 'f2dcdb', 'ebf1dd', 'e5e0ec', 'dbeef3', 'fdeada', 'fff2ca',
            'd8d8d8', '595959', 'c4bd97', '8db3e2', 'b8cce4', 'e5b9b7', 'd7e3bc', 'ccc1d9', 'b7dde8', 'fbd5b5', 'ffe694',
            'bfbfbf', '3f3f3f', '938953', '548dd4', '95b3d7', 'd99694', 'c3d69b', 'b2a2c7', 'b7dde8', 'fac08f', 'f2c314',
            'a5a5a5', '262626', '494429', '17365d', '366092', '953734', '76923c', '5f497a', '92cddc', 'e36c09', 'c09100',
            '7f7f7f', '0c0c0c', '1d1b10', '0f243e', '244061', '632423', '4f6128', '3f3151', '31859b', '974806', '7f6000'
        ]
        },
        fontfamily: {
            fontList: [
                {name: 'Arial', family: 'Arial, Helvetica, sans-serif'},
                {name: 'Open Sans', family: '\'Open Sans\', sans-serif'},
                {name: "Modern Era Black Italic", family: "Modern Era Black Italic"},
                {name: "Modern Era Black", family: "Modern Era Black"},
                {name: "Modern Era Bold Italic", family: "Modern Era Bold Italic"},
                {name: "Modern Era Bold", family: "Modern Era Bold"},
                {name: "Modern Era ExtraBold Italic", family: "Modern Era ExtraBold Italic"},
                {name: "Modern Era ExtraBold", family: "Modern Era ExtraBold"},
                {name: "Modern Era Light Italic", family: "Modern Era Light Italic"},
                {name: "Modern Era Italic", family: "Modern Era Italic"},
                {name: "Modern Era Light", family: "Modern Era Light"},
                {name: "Modern Era Medium Italic", family: "Modern Era Medium Italic"},
                {name: "Modern Era Medium", family: "Modern Era Medium"},
                {name: "Modern Era Mono Bold", family: "Modern Era Mono Bold"},
                {name: "Modern Era Mono ExtraBold", family: "Modern Era Mono ExtraBold"},
                {name: "Modern Era Mono Medium", family: "Modern Era Mono Medium"},
                {name: "Modern Era Mono Regular", family: "Modern Era Mono Regular"},
                {name: "Modern Era Regular", family: "Modern Era Regular"},
            ]
        }
    }
                },
            }
        },
        watch: {
            disabled() {
                this.setState();
            }
        },
        mounted() {
            this.setState();
        },
        props: {
            richtext: {
                type: Boolean,
                default: false
            },
            value: {
                type: String
            },
            required: {
                type: Boolean
            },
            placeholder: {
                type: String
            },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            setState() {
                if (this.richtext) {
                    let textarea = this.$children[0].$el;
                    $(textarea).trumbowyg(this.disabled ? 'disable' : 'enable');
                }
            },
            updateValue: function (value) {
                this.$emit('input', value);
            }
        },
        components: {
          trumbowyg
        }
    }
</script>