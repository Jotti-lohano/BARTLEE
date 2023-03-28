<template>
    <div>
        <div class="report-section shadow p-5 rounded-15 my-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-7 m-auto my-3 pt-3">
                 <validation-observer v-slot="{handleSubmit}" class="col-12">
                <form @submit.prevent="handleSubmit(create)">
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p  for="packageName" class="mb-0 font-weight-bold">Boost Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" v-slot="{errors}" >
                            <select v-model="form.boost_name" class="form-select form-select-sm pr-5 py-2" id="Boost Name" aria-label=".form-select-sm example">
                                <option value="" selected>Select Boost Name</option>
                                <option value="1">January</option>
                                <option value="2">Febuary</option>
                                <option value="3">March</option>
                            </select>
                            <span class="text-danger">{{errors[0]}}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">Business Name :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <validation-provider tag="div" rules="required" v-slot="{errors}" >
                            <select id="Business Name" v-model="form.business_name"  class="form-select form-select-sm pr-5 py-2" aria-label=".form-select-sm example">
                                <option value="" selected>Select Business Name</option>
                                <option value="1">January</option>
                                <option value="2">Febuary</option>
                                <option value="3">March</option>
                            </select>
                            <span class="text-danger">{{errors[0]}}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">No of Clicks :</p>
                        </div>
                        <div class="fieldData col-md-6">
                             <validation-provider tag="div" rules="required" v-slot="{errors}" >
                            <input type="text"  v-model="form.num_of_clicks"   placeholder="No of Clicks" name="Number Of Click" class="form-control pr-5 py-2 h-auto">
                             <span class="text-danger">{{errors[0]}}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="d-flex mb-3 flex-wrap align-items-center">
                        <div class="labelTitle col-md-6">
                            <p class="mb-0 font-weight-bold">No of Reaches :</p>
                        </div>
                        <div class="fieldData col-md-6">
                            <validation-provider tag="div" rules="required" v-slot="{errors}" >
                            <input type="text"  v-model="form.num_of_reaches"   placeholder="No of Reaches" name="No of Reaches" class="form-control pr-5 py-2 h-auto">
                             <span class="text-danger">{{errors[0]}}</span>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="submitBtn text-center pt-5">
                        <input type="submit" value="ADD" class="submitStyle border-0 rounded-15 px-5">
                    </div>
                </form>
                 </validation-observer>
            </div>
        </div>
    </div>
    </div>
</template>


<script>
export default {
    data : ()=> ({
        form : {business_name:'' ,boost_name:''},
    }),
    methods : {
        create(){

        },
    },
}
</script>