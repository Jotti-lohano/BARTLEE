<template>
    <ValidationObserver ref="verifyObserver" class="modal-content" tag="div" v-slot="{handleSubmit}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="right">
                    <h6>Password Recovery</h6>
                    <form ref="verify" @submit.prevent="handleSubmit(submit)">
                        <div class="row">
                            <ValidationProvider tag="div" vid="email" name="Email" rules="required" v-slot="{errors}" class="col-12 form-group">
                                <input v-model="email" type="email" class="form-control" placeholder="Email">
                                <i class="fa fa-envelope"></i>
                                <div class="text-danger">{{errors[0]}}</div>
                            </ValidationProvider>
                        </div>
                        <button type="submit" class="can m-0" id="pwd1-btn">Continue</button>
                        <a href="javascript:void(0)" data-dismiss="modal" class="login back"><i class="fa fa-arrow-circle-left"></i>back to
                            login</a>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </ValidationObserver>
</template>
<script>
export default {
    data() {
        return {
            email: '',
        };
    },
    methods: {
        openLoginPopup() {
            $('.auth-popup').modal('show');
            bus.$emit('show-login', 'Login');
        },
        changeVerificationType() {},
        async submit(e) {
            let fd = new FormData();
            fd.append('email', this.email)
            try {
                let response = await axios.post(route('admin.password.verify'), fd);
                if (response.data.status) {
                    this.$snotify.success(response.data.msg);
                    this.$emit('change-forget-preview', { component: 'Code', email: this.email });
                } else {
                    this.$snotify.error(response.data.msg);
                }
            } catch (e) {
                // statements
                if (e.response) {
                    this.$refs.verifyObserver.setErrors(e.response.data.errors);
                }
                console.log(e);
            }
        }
    }
}

</script>
