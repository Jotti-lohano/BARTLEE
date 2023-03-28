<template>
    <div class="col-md-12">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="business" role="tabpanel" aria-labelledby="business-tab">
                <div class="row py-5">
                    <div class="col-md-6">
                        <div class="attendentContent">
                            <div class="main-card card-item mb-4">
                                <div class="d-flex align-items-end p-3 flex-wrap">
                                    <div class="dotted-border-shadow w-100">
                                        <h4 class="poppins text-capitalize">{{event.event_name}}</h4>
                                        <p class="cart-title font-14">{{event.event_name}}</p>
                                        <div class="from-date d-inline-block mx-1">
                                            <p class="font-13"><strong>From</strong><span class="d-block">{{event.event_starting_time}}</span> </p>
                                        </div>
                                        <div class="from-date d-inline-block mx-1">
                                            <p class="font-13"><strong>Until</strong><span class="d-block">{{event.event_starting_time}}</span> </p>
                                        </div>
                                    </div>
                                    <div class="dotted-border-shadow w-100">
                                        <h5 class="poppins font-weight-bold text-right">{{event.type}}</h5>
                                    </div>
                                </div>
                            </div>
                            <h2 class="poppins text-center mb-3">Insights</h2>
                            <p class="text-center m-auto">Only users that collected your Badge during the Event time are taken in consideration in these Insight</p>
                            <div class="d-flex align-items-center justify-content-center border-dotted flex-column py-5 border-top mt-4">
                                <h2 class="poppins">{{event.attended_count}} attended</h2>
                            </div>
                            <div class="d-flex align-items-center justify-content-center border-dotted flex-column py-5 border-top">
                                <h2 class="poppins">{{attendanceRate}}% attendance rate </h2>
                            </div>
                            <div class="d-flex align-items-center justify-content-center border-dotted py-5 border-top gap-15 flex-column">
                                <div class="progression-bar text-center w-100">
                                    <div class="progress-range mb-4">
                                        <div class="progress-fill"></div>
                                    </div>
                                    <p class="poppins mb-0">{{event.another_events_attended}}</p>
                                    <p class="poppins text-dark mb-0">Attended another of your events</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="attendeRight">
                            <div class="shadow round p-3 w-100 d-flex align-items-center justify-content-center flex-column">
                                <div class="d-flex justify-content-center align-items-end">
                                    <div class="g-men">
                                        <p class="text-dark">{{maleAttended}}% <span class="text-secondary">Men</span></p>
                                    </div>
                                    <div class="gender text-center">
                                        <h4 class="poppins">GENDER</h4>
                                        <figure>
                                            <pie-chart :chartData="genderData"/>
                                            <!-- <img class="mw-100" :src="`./admin/images/round-chart.png`" alt=""> -->
                                        </figure>
                                    </div>
                                    <div class="g-women">
                                        <p class="text-dark">{{femaleAttended}}% <span class="text-secondary">Women</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="shadow round p-3 w-100 d-flex align-items-strat justify-content-start flex-column my-4">
                                <div class="d-flex align-items-center jusitfy-content-between w-100">
                                    <h4 class="poppins w-75 mb-0">AGE RANGE</h4>
                                </div>
                                <figure>
                                    <bar-chart :chartData="attendedAgeRangeData"/>                                    
                                    <!-- <img class="mw-100" :src="`./admin/images/numb-chart.png`" alt=""> -->
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
                                    <bar-chart :chartData="nationalitiesData"/>
                                    <!-- <img class="mw-100" :src="`./admin/images/lang-chart.png`" alt=""> -->
                                </figure>
                            </div>
                            <div class="shadow round p-3 d-flex align-items-end justify-content-center flex-column mt-5">
                                <div class="d-flex align-items-center jusitfy-content-between w-100">
                                    <h4 class="poppins w-75 mb-0">RESIDENCY</h4>
                                </div>
                                <figure>
                                    <bar-chart :chartData="nationalitiesData"/>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                <div class="row py-5">
                    <div class="col-md-6">
                        <div class="attendentContent">
                            <div class="main-card card-item mb-4">
                                <div class="d-flex align-items-end p-3 flex-wrap">
                                    <div class="dotted-border-shadow w-100">
                                        <h4 class="poppins text-capitalize">{{event.event_name}}</h4>
                                        <p class="cart-title font-14">{{event.event_description}}</p>
                                        <div class="from-date d-inline-block mx-1">
                                            <p class="font-13"><strong>From</strong><span class="d-block">{{event.event_starting_time}}</span> </p>
                                        </div>
                                        <div class="from-date d-inline-block mx-1">
                                            <p class="font-13"><strong>Until</strong><span class="d-block">{{event.event_starting_time}}</span> </p>
                                        </div>
                                    </div>
                                    <div class="dotted-border-shadow w-100">
                                        <h5 class="poppins font-weight-bold text-right">{{event.type}}</h5>
                                    </div>
                                </div>
                            </div>
                            <h2 class="poppins text-center mb-3">Insights</h2>
                            <p class="text-center m-auto">Only users that collected your Badge during the Event time are taken in consideration in these Insight</p>
                            <div class="d-flex align-items-center justify-content-center border-dotted flex-column py-5 border-top mt-4">
                                <h2 class="poppins">{{event.total_saved}} saved</h2>
                            </div>
                            <div class="d-flex align-items-center justify-content-center border-dotted flex-column py-5 border-top">
                                <h2 class="poppins">{{savedRate}}% saved rate </h2>
                            </div>
                            <div class="d-flex align-items-center justify-content-center border-dotted py-5 border-top gap-15 flex-column">
                                <div class="progression-bar text-center w-100">
                                    <div class="progress-range mb-4">
                                        <div class="progress-fill"></div>
                                    </div>
                                    <p class="poppins mb-0">{{event.another_events_attended}}</p>
                                    <p class="poppins text-dark mb-0">Attended another of your events</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="attendeRight">
                            <div class="shadow round p-3 w-100 d-flex align-items-center justify-content-center flex-column">
                                <div class="d-flex justify-content-center align-items-end">
                                    <div class="g-men">
                                        <p class="text-dark">{{maleSaved}}% <span class="text-secondary">Men</span></p>
                                    </div>
                                    <div class="gender text-center">
                                        <h4 class="poppins">GENDER</h4>
                                        <figure>
                                            <pie-chart :chartData="savedGenderData"/>
                                            <!-- <img class="mw-100" :src="`./admin/images/round-chart.png`" alt=""> -->
                                        </figure>
                                    </div>
                                    <div class="g-women">
                                        <p class="text-dark">{{femaleSaved}}% <span class="text-secondary">Women</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="shadow round p-3 w-100 d-flex align-items-strat justify-content-start flex-column my-4">
                                <div class="d-flex align-items-center jusitfy-content-between w-100">
                                    <h4 class="poppins w-75 mb-0">AGE RANGE</h4>
                                </div>
                                    <bar-chart :chartData="savedAgeRangeData"/>                                    
                                <figure>
                                    <!-- <img class="mw-100" :src="`./admin/images/numb-chart.png`" alt=""> -->
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
                                    <bar-chart :chartData="savednationalitiesData"/>
                                <figure>
                                    <!-- <img class="mw-100" :src="`./admin/images/lang-chart.png`" alt=""> -->
                                </figure>
                            </div>
                            <div class="shadow round p-3 d-flex align-items-end justify-content-center flex-column mt-5">
                                <div class="d-flex align-items-center jusitfy-content-between w-100">
                                    <h4 class="poppins w-75 mb-0">RESIDENCY</h4>
                                </div>
                                    <bar-chart :chartData="savednationalitiesData"/>
                                <figure>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props : {
        event : {
            type : Object,
            default : ()=> ({}),
        },
    },
    computed : {
        genderData(){
            return [
                ['', ''],
                ['Women',this.event.female_attended || 0],
                ['Men',this.event.male_attended || 0],
            ];
        },
        savedGenderData(){
            return [
                ['', ''],
                ['Women',this.event.female_saved || 0],
                ['Men',this.event.male_saved || 0],
            ];
        },
        nationalitiesData(){
            if(this.event.attended_countries_logs !== undefined){

                return [
                    ['', '',{ role: 'style' }],
                    ...this.event.attended_countries_logs,
                ];
            }
            return [
                ['', '',{ role: 'style' }],
            ];
        },
        savednationalitiesData(){
            if(this.event.saved_countries_logs !== undefined){

                return [
                    ['', '',{ role: 'style' }],
                    ...this.event.saved_countries_logs,
                ];
            }
            return [
                ['', '',{ role: 'style' }],
            ];
        },
        attendedAgeRangeData(){
            if(this.event.attended_age_logs === undefined){
                return [
                    ['', '',{ role: 'style' }],
                ];
            }
            return [
                ['', '',{ role: 'style' }],
                ...this.event.attended_age_logs,
            ];
        },
        savedAgeRangeData(){
            if(this.event.saved_age_logs === undefined){
                return [
                    ['', '',{ role: 'style' }],
                ];
            }
            return [
                ['', '',{ role: 'style' }],
                ...this.event.saved_age_logs,
            ];
        },
        attendanceRate(){
            if(this.event.attended_count == 0)
                return 0
                return parseFloat((this.event.attended_count / this.event.clicks_count ) * 100).toFixed();
        },
        savedRate(){
            if(this.event.saved_events_count == 0)
                return 0
                return parseFloat((this.event.total_saved / this.event.clicks_count ) * 100).toFixed();
        },
        savedRateWeekly(){
            if(this.event.saved_events_count == 0)
                return 0
                return parseFloat((this.event.saved_events_count / this.event.total_saved ) * 100).toFixed();
            //     total_saved_rate => total_saved / total_clicks * 100 
            // current_week_saved_rate => saved_events / total_saved * 100
        },
        maleAttended(){
            if(this.event.attended_count == 0)
                return 0
                
                return parseFloat((this.event.male_attended / this.event.attended_count ) * 100).toFixed();
        },
        femaleAttended(){
            if(this.event.attended_count == 0)
                return 0
                
                return parseFloat((this.event.female_attended / this.event.attended_count ) * 100).toFixed();
        },
        maleSaved(){
            if(this.event.saved_events_count == 0)
                return 0
                
                return parseFloat((this.event.male_saved / this.event.saved_events_count ) * 100).toFixed();
        },
        femaleSaved(){
            if(this.event.saved_events_count == 0)
                return 0
                
                return parseFloat((this.event.female_saved / this.event.saved_events_count ) * 100).toFixed();
        }
    },
}
</script>