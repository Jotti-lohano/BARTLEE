import Vue from 'vue';

const NoRecord = () => import('@core/components/NoRecord.vue');
const Confirm = () => import('@core/components/Popups/Confirm.vue');

Vue.mixin({
    components: {
        NoRecord,
        Confirm,
        // EmployeeTable,
    },
    computed: {
      userPermissions() {
        // return _.map();
        return this.$user.permissions?_.map(this.$user.permissions,'value'):[];
      },
      isEmployee(){
        return window.Laravel.as == 'employee';
      },
      routeParams(){
        let {params} = this.$route;
        return params;
      },
    },
    methods: {
        buildFormData(formData, data, parentKey) {

            if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
                Object.keys(data).forEach(key => {
                    this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                });
            } else {
                const value = data == null ? '' : data;

                formData.append(parentKey, value);
            }
        },
        formatDate(date, format = 'MMMM DD YYYY') {
            return this.$moment(date).format(format);
        },
        togglePasswordType(ref) {
            let field = this.$refs[ref];
            let type = field.getAttribute('type');
            if (type == 'text') {
                field.setAttribute('type', 'password');
            } else {
                field.setAttribute('type', 'text');
            }
        },
        getPasswordType(ref) {
            let field = this.$refs[ref];
            if (typeof field != 'undefined') {

                return field.getAttribute('type');
            }
        },
        addRouteQuery(newQuery) {

            this.$router.push({ query: newQuery }).catch(() => {});
        },
        serialNumber(variable, index = 0) {
            let starting = this[variable].per_page * (this[variable].current_page - 1);
            index++;
            return starting + index;
        },
        setCallback(variable,value,callback){
            this[variable] = value;
            if(callback)
            callback();
        },
        dateChecker(){
            this
        },
        CodeGenerator(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * 
            charactersLength));
            }
            return result;
         }
    }
})
