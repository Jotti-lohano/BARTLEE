<template>
 
    <div class="modal fade" :id="el" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="bi bi-x close" data-dismiss="modal" aria-label="Close"></button>
                <div class="contentModal text-center px-md-5">
                    <h2 v-html="title"></h2>
                    <!-- <i class="bi bi-check-circle theme-primary-text"></i> -->
                    <p  v-html="subtitle"></p>
                </div>
                <div class="reset-footer text-center">                          
                    <button type="button" class="btn bg-theme-primary text-white px-4" @click="$emit('confirmed')" data-dismiss="modal" data-toggle="modal" data-target="#exampleModalCenter2">Yes</button>
                    <button type="submit" class="btn bg-theme-primary text-white px-4" @click="$emit('closed',false)" data-dismiss="modal">No</button>                
                </div>
            </div>
        </div>
    </div>
</div>
   
  
</template>
<script>
export default {
    props: {
        el: {
            type: String,
            default: 'successPopup',
        },
        title: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: true,
            default: null
        },
        subtitle: {
            type: String, // String, Number, Boolean, Function, Object, Array
            required: false,
            default: null
        }
    }
}

</script>
