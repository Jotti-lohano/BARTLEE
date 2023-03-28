<template>
  <div>
    <GChart
      type="PieChart"
      :options="options"
      :data="chartData"
    />    
  </div>
</template>
 
<script>
import { GChart } from "vue-google-charts";
export default {
    props : {
        chartData :  {
            type : Array,
            default : ()=> ([
                ['', ''],
            ]),
        },   
    },
  name: "PieChart",
  components: {
    GChart
  },
  data() {
    return {
      data: [],
      options: {
          colors:['red','#555'],
        pieSliceText: 'label',
          chartArea : {
            width: 140,
            height: 140,      
            backgroundColor : 'yellow',
            
          },
          colors : ['yellow','#555'],
        width: 100,
        height: 100,
        fontSize : 16,
        legend: 'none',
        slices : [{color : 'yellow',textStyle : {
             color : 'black'
        }},{color : 'black',textStyle : {
             color : 'white'
        }}],
        tooltip : {
            trigger : 'none'
        }
      }
    };
  },
  mounted(){
      this.data = this.chartData;
  },
};
</script>