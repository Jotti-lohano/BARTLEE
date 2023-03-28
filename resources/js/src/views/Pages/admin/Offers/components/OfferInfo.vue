<template>
    <div>
         <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="d-flex justify-content-center flex-wrap align-items-center">
                <div class="titleHead text-center">
                    <figure class="mb-0">
                        <img :src="`${detail.avatar_img}`" alt="" class="mw-100">
                    </figure>
                    <h3 class="h5 font-weight-bold">{{detail.business_name}}</h3>
                    <p class="mb-0">Dubai</p>
                </div>
            </div>
              <div class="col-md-7 m-auto my-3 pt-3">
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Busniess Username :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">  {{detail.username}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Offer Title :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">  {{detail.offer_name}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Starting Date :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">  {{detail.offer_starting_date}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Starting Time :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.offer_starting_time}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Ending Date :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.offer_ending_date}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Ending Time :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.offer_ending_time}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">For :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.offer_smiles}}</p>
                    </div>
                </div>
                <div class="d-flex mb-3 flex-wrap align-items-center">
                    <div class="labelTitle col-md-6">
                        <p class="mb-0 font-weight-600">Condition :</p>
                    </div>
                    <div class="fieldData col-md-6">
                        <p class="mb-0 text-black-50">{{detail.offer_condition}}</p>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    </div>
</template>
<script>
export default{
    props : {
        detail : {
            type : Object,
            default : ()=> ({}),
        },
    },
}
</script>