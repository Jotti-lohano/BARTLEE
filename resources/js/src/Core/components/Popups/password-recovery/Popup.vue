<template>
	<div class="forget-modal">
		<div class="modal fade" id="pwdrecovery" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
			<div class="modal-dialog modal-dialog-centered" role="document">
				<component @change-forget-preview="changeForgetPreview" :email="verified_email" :code="verified_code" :is="component"></component>

			</div>
		</div>
	</div>
	<!-- 
	<div class="forget-modal">
		<div class="modal fade" id="pwdrecovery" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered site-modal" role="document">
			</div>
		</div>
	</div>
 -->
</template>
<script>
const Email = () => import('./Email.vue');
const Code = () => import('./Code.vue');
const New = () => import('./New.vue');
export default {
	components: {
		Email,
		Code,
		New,
	},
	data() {
		return {
			component: 'Email',
			verified_email: null,
			verified_code: '',
		};
	},
	methods: {
		openLoginPopup() {
			$('.auth-popup').modal('show');
			bus.$emit('show-login', 'Login');
		},
		changeForgetPreview(data) {
			this.component = data.component;
			this.verified_email = data.email;
			this.verified_code = data.code;
		}
	},
	mounted() {
		this.component = 'Email';
		this.verified_email = null;
		this.verified_code = null;
		// bus.$on('change-forget-preview', this.changeForgetPreview);
	}
}

</script>
