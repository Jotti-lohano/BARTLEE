<template>
    <div class="row py-5">
        <div class="col-md-6">
            <div class="attendentContent">
                <div class="main-card card-item mb-4 d-flex flex-column position-relative p-3">
                    <div class="d-flex align-items-center">
                        <div class="w-100 px-2">
                            <h5 class="poppins mb-0"><img :src="`admin-assets/images/smile.png`" alt="" class="w-25 mr-1"><a href="./offer-detail.php" class="text-dark">{{offer.offer_smiles || 0 }}</a></h5>
                        </div>
                        <div class="w-100 px-2 text-center">
                            <figure class="mb-0">
                                <img :src="`admin-assets/images/switch.png`" alt="">
                            </figure>
                        </div>
                        <div class="w-100 px-2 text-right d-flex align-items-center edit-option">
                            <h5 class="poppins mb-0 w-75"><a href="#" class="text-dark text-decoration-none">{{offer.offer_name}}</a></h5>
                        </div>
                    </div>
                </div>
                <h2 class="poppins text-center mb-3">Insights</h2>
                <p class="text-center m-auto">Only users that collected your Badge during the Event time are taken in consideration in these Insight</p>
                <div class="d-flex align-items-center justify-content-center border-dotted flex-column py-5">
                    <figure>
                        <img class="mw-100" :src="`admin-assets/images/smile.png`" alt="">
                    </figure>
                    <h2 class="poppins">{{offer.collected || 0}} collected</h2>
                    <h2 class="poppins text-secondary mb-0">+{{offer.collected_weekly}} new this week</h2>
                </div>
                <div class="d-flex align-items-center justify-content-center border-dotted flex-column py-5 border-top border-bottom mb-5">
                    <h2 class="poppins">{{offer.redeemed}} Redeem</h2>
                    <h2 class="poppins text-secondary mb-0">+{{offer.redeemed_weekly}} new this week</h2>
                </div>
                <div class="shadow round p-3 flex-wrap d-flex align-items-end justify-content-center flex-column">
                    <div class="d-flex align-items-center jusitfy-content-between w-100">
                        <h4 class="poppins w-75 mb-0">REDEEMS</h4>
                        <!-- <select name="filter" id="" class="site-input bg-white w-25 border form-select">
                            <option value="All">All</option>
                            <option value="All">All</option>
                        </select> -->
                    </div>
                    <figure>
                        <column-chart :chartData="redeemWeekStats"/>
                        <!-- <img class="mw-100" :src="`admin-assets/images/completed-chart.png`" alt=""> -->
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="attendeRight">
                <div class="shadow round p-3 w-100 d-flex align-items-center justify-content-center flex-column">
                    <div class="d-flex justify-content-center align-items-end">
                        <div class="g-men">
                            <p class="text-dark">{{maleRedeemedPercentage}}% <span class="text-secondary">Men</span></p>
                        </div>
                        <div class="gender text-center">
                            <h4 class="poppins">GENDER</h4>
                            <figure>
                                <pie-chart :chartData="redeemgenderData"/>
                                <!-- <img class="mw-100" :src="`admin-assets/images/round-chart.png`" alt=""> -->
                            </figure>
                        </div>
                        <div class="g-women">
                            <p class="text-dark">{{femaleRedeemedPercentage}}% <span class="text-secondary">Women</span></p>
                        </div>
                    </div>
                </div>
                <div class="shadow round p-3 w-100 d-flex align-items-strat justify-content-start flex-column my-4">
                    <div class="d-flex align-items-center jusitfy-content-between w-100">
                        <h4 class="poppins w-75 mb-0">AGE RANGE</h4>
                        <!-- <select name="filter" id="" class="site-input bg-white w-25 form-select">
                            <option value="All">All</option>
                            <option value="All">All</option>
                        </select> -->
                    </div>
                    <figure>
                        <bar-chart :chartData="redeemAgeRangeData"/>
                        <!-- <img class="mw-100" :src="`admin-assets/images/numb-chart.png`" alt=""> -->
                    </figure>
                </div>
                <div class="shadow round p-3 w-100 d-flex align-items-strat justify-content-start flex-column">
                    <div class="d-flex align-items-center jusitfy-content-between w-100">
                        <h4 class="poppins w-75 mb-0">NATIONALITIES</h4>
                        <!-- <select name="filter" id="" class="site-input bg-white w-25 form-select">
                            <option value="All">All</option>
                            <option value="All">All</option>
                        </select> -->
                    </div>
                    <figure>
                        <bar-chart :chartData="redeemednationalitiesData"/>
                        <!-- <img class="mw-100" :src="`admin-assets/images/lang-chart.png`" alt=""> -->
                    </figure>
                </div>
                <div class="shadow round p-3 d-flex align-items-end justify-content-center flex-column mt-5">
                    <div class="d-flex align-items-center jusitfy-content-between w-100">
                        <h4 class="poppins w-75 mb-0">RESIDENCY</h4>
                        <!-- <select name="filter" id="" class="site-input bg-white w-25 form-select">
                            <option value="All">All</option>
                            <option value="All">All</option>
                        </select> -->
                    </div>
                    <figure>
                        <bar-chart :chartData="redeemednationalitiesData"/>
                        <!-- <img class="mw-100" :src="`admin-assets/images/lang-chart.png`" alt=""> -->
                    </figure>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props : {
        offer : {
            type : Object,
            default : ()=> ({}),
        },
    },
    computed : {
        redeemgenderData(){
            return [
                ['', ''],
                ['Women',this.offer.female_redeems || 0],
                ['Men',this.offer.male_redeems || 0],
            ];
        },
        maleRedeemedPercentage(){
            if(this.offer.male_redeems == 0)
                return 0                
                return parseFloat((this.offer.male_redeems / this.offer.redeemed ) * 100);
        },
        femaleRedeemedPercentage(){
            if(this.offer.female_redeems == 0)
                return 0                
                return parseFloat((this.offer.female_redeems / this.offer.redeemed ) * 100);
        },
        redeemWeekStats(){
            if(this.offer.redeem_week_stats === undefined){
                return [
                    ['', '',{ role: 'style' }],
                ];
            }
            return [
                ['', '',{ role: 'style' }],
                ...this.offer.redeem_week_stats,
            ];
        },
        redeemAgeRangeData(){
            if(this.offer.redeem_age_logs === undefined){
                return [
                    ['', '',{ role: 'style' }],
                ];
            }
            return [
                ['', '',{ role: 'style' }],
                ...this.offer.redeem_age_logs,
            ];
        },
        redeemednationalitiesData(){
            if(this.offer.redeemed_countries_logs !== undefined){

                return [
                    ['', '',{ role: 'style' }],
                    ...this.offer.redeemed_countries_logs,
                ];
            }

            return [
                ['', '',{ role: 'style' }],
            ];
        },
    },
}
</script>