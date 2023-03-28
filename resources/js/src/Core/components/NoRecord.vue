<script>
export default {
    render: function(createElement) {
        let child;
        if (this.data.length == 0) {
            if (this.tag == 'tr') {
                child = createElement('td', {
                    attrs: {
                        class: 'text-center',
                        colspan: this.colspan,
                    }
                }, 'No data available!');
            }

            return createElement(this.tag, {
                attrs: this.$attrs
            }, [
                child,
                this.$slots.default,
            ]);
        }
        return;
    },
    props: {
        data: {
            type: Array, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: () => {
                return [];
            }
        },
        tag: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: 'div'
        },
        colspan: {
            type: Number, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: 1
        }
    }
}

</script>
