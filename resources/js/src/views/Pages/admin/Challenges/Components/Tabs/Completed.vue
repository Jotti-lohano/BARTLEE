<template>
  <div
    class="tab-pane fade show active"
    id="business"
    role="tabpanel"
    aria-labelledby="business-tab"
  >
    <div class="row py-5">
      <div class="col-md-6">
        <div class="attendentContent">
          <div class="main-card card-item text-uppercase p-3">
            <div class="d-flex justify-content-between flex-wrap">
              <div class="dotted-border-shadow">
                <h4 class="poppins">
                  <a
                    href="#"
                    class="text-dark text-decoration-none font-weight-bold"
                    >{{challenge.challenge_name}}</a
                  >
                </h4>
                <p class="cart-title font-16 mb-1 text-capitalize">
                  Visit {{challenge.total_visits_required}} times between {{formatDate(`${challenge.challenge_starting_date} ${challenge.challenge_starting_time}`,'hh:mm A')}}-{{formatDate(`${challenge.challenge_ending_date} ${challenge.challenge_ending_time}`,'hh:mm A')}}
                </p>
              </div>
              <div class="dotted-border-shadow text-md-right">
                <h5 class="rubik text-right m-0">
                  <img
                    src="admin-assets/images/smile.png"
                    alt=""
                    class="w-25 mr-1"
                  />{{challenge.challenge_reward}}
                </h5>
              </div>
            </div>
            <div class="spotBox text-center">
              <p class="poppins font-16 text-center mb-0">
                <span class="text-danger">{{challenge.challenge_no_of_spots - challenge.total_visited_spots}} </span> spots left
              </p>
            </div>
          </div>
          <div class="recharge my-4 text-center text-info">

          </div>
          <h2 class="poppins text-center mb-3">Insights</h2>
          <p class="text-center m-auto">
            Only users that collected your Badge during the Event time are taken
            in consideration in these Insight
          </p>
          <div
            class="
              d-flex
              align-items-center
              justify-content-center
              border-dotted
              flex-column
              py-5
              border-top
              mt-4
            "
          >
            <h2 class="poppins">{{totalCompleted}} completed</h2>
          </div>
          <div
            class="
              d-flex
              align-items-center
              justify-content-center
              border-dotted
              flex-column
              py-5
              border-top
            "
          >
            <!-- <h2 class="poppins">+{{totalWeekCompleted}} new this week</h2> -->
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="attendeRight">
          <div
            class="
              shadow
              round
              p-3
              w-100
              d-flex
              align-items-center
              justify-content-center
              flex-column
            "
          >
            <div class="d-flex justify-content-center align-items-end">
              <div class="g-men">
                <p class="text-dark">
                  {{totalMaleCompletedPecentage}}% <span class="text-secondary">Men</span>
                </p>
              </div>
              <div class="gender text-center">
                <h4 class="poppins">GENDER</h4>
                <figure>
                  <pie-chart :chartData="completedGenderData"/>
                </figure>
              </div>
              <div class="g-women">
                <p class="text-dark">
                  {{totalFemaleCompletedPecentage}}% <span class="text-secondary">Women</span>
                </p>
              </div>
            </div>
          </div>
          <div
            class="
              shadow
              round
              p-3
              w-100
              d-flex
              align-items-strat
              justify-content-start
              flex-column
              my-4
            "
          >
            <div
              class="d-flex align-items-center jusitfy-content-between w-100"
            >
              <h4 class="poppins w-75 mb-0">AGE RANGE</h4>
            </div>
            <figure>
              <bar-chart :chartData="completedAgeRangeData"/>
            </figure>
          </div>
          <div
            class="
              shadow
              round
              p-3
              w-100
              d-flex
              align-items-strat
              justify-content-start
              flex-column
            "
          >
            <div
              class="d-flex align-items-center jusitfy-content-between w-100"
            >
              <h4 class="poppins w-75 mb-0">NATIONALITIES</h4>
            </div>
              <bar-chart :chartData="completedNationalitiesData"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
export default {
    async mounted(){
        // await this.fetch();    
    },
    props : {
        challenge : {
            type : Object,
            default : ()=> ({}),
         },
    },
    computed : {
        completedNationalitiesData(){
            if(this.challenge.completed_countries_logs !== undefined){

                return [
                    ['', '',{ role: 'style' }],
                    ...this.challenge.completed_countries_logs,
                ];
            }
            return [
                ['', '',{ role: 'style' }],
            ];
        },
        startedNationalitiesData(){
            if(this.challenge.started_countries_logs !== undefined){

                return [
                    ['', '',{ role: 'style' }],
                    ...this.challenge.started_countries_logs,
                ];
            }
            return [
                ['', '',{ role: 'style' }],
            ];
        },
        currentWeekCompletedLogs(){
            if(this.challenge.week_stats !== undefined){

                return [
                    ['', '',{ role: 'style' }],
                    ...this.challenge.week_stats,
                ];
            }
            return [
                ['', '',{ role: 'style' }],
            ];
        },
        startedAgeRangeData(){
            if(this.challenge.started_age_logs === undefined){
                return [
                    ['', '',{ role: 'style' }],
                ];
            }
            return [
                ['', '',{ role: 'style' }],
                ...this.challenge.started_age_logs,
            ];
        },
        completedAgeRangeData(){
            if(this.challenge.completed_age_logs === undefined){
                return [
                    ['', '',{ role: 'style' }],
                ];
            }
            return [
                ['', '',{ role: 'style' }],
                ...this.challenge.completed_age_logs,
            ];
        },
        startedGenderData(){
            return [
                ['', ''],
                ['Women',this.challenge.gender_started?.female || 0],
                ['Men',this.challenge.gender_started?.male || 0],
            ];
        },
        completedGenderData(){
            return [
                ['', ''],
                ['Women',this.challenge.gender_completed?.female || 0],
                ['Men',this.challenge.gender_completed?.male || 0],
            ];
        },
        totalMaleStartedPecentage(){
            if(this.challenge.gender_started?.male == 0)
                return 0
                
                return parseFloat((this.challenge.gender_started?.male / this.totalStarted ) * 100);
        },
        totalFemaleStartedPecentage(){
            if(this.challenge.gender_started?.female == 0)
                return 0
                
                return parseFloat((this.challenge.gender_started?.female / this.totalStarted ) * 100);
        },
        totalWeekStarted(){
            
            return this.challenge.current_week_started || 0;
        },
        totalMaleCompletedPecentage(){
            if(this.challenge.gender_completed?.male == 0)
                return 0
                
                return parseFloat((this.challenge.gender_completed?.male / this.totalCompleted ) * 100);
        },
        totalFemaleCompletedPecentage(){
            if(this.challenge.gender_completed?.female == 0)
                return 0
                
                return parseFloat((this.challenge.gender_completed?.female / this.totalCompleted ) * 100);
        },
        totalStarted(){
            return this.challenge.gender_started?.male + this.challenge.gender_started?.female;
        },
        totalCompleted(){
            return this.challenge.gender_completed?.male + this.challenge.gender_completed?.female;
        },
        totalRewardedValue(){
            return this.challenge.challenge_reward * this.totalCompleted;
        },
        currentWeekRewardedValue(){
            return this.challenge.challenge_reward * parseInt(this.challenge.total_week_winners);
        },
    },
    methods : {
        ...mapActions('admin',['get']),
    },
}
</script>