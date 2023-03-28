<template>
  <div>
    <GChart
      type="ColumnChart"
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
  name: "ColumnChart",
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
            textPosition: 'none',
            gridlines: {
                color: 'transparent'
            }
        },
        hAxis: {
            // textPosition: 'none' 
        },
        legend: 'none',
        bar: { groupWidth: '75%'},
        isStacked: true,
          chartArea : {left:'2%',top:10,width:'95%',height:'75%'},
        width : 500,
        fontSize : 11,
        tooltip : {
        }
      }
    };
  },
  mounted(){
      this.data = this.chartData;
  },
};
</script>