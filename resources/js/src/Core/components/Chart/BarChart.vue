<template>
  <div>
    <GChart
      :key="refreshChart"
      type="BarChart"
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
              ['', '',{ role: 'style' }],
          ]),
      },   
  },
  name: "BarChart",
  components: {
    GChart
  },
  data() {
    return {
      data: [],
      options: {
        bold:'true',
        vAxis: {
            textStyle: {
                bold:'true',
            },
            gridlines: {
                color: 'transparent'
            }
        },
        hAxis: {
            gridlines: {
                color: 'transparent'
            },
            textPosition: 'none' 
        },
        legend: 'none',
        bar: { groupWidth: '75%'},
        isStacked: true,
          bars : 'horizontal',
          chartArea : {left:'20%',top:10,width:'50%',height:'75%'},
        width : 450,
        fontSize : 11,
        tooltip : {
        }
      },
      refreshChart : 0,
    };
  },
  watch : {
    chartData(val){
      this.refreshChart++;
    },
  },
  mounted(){
      this.data = this.chartData;
  },
};
</script>