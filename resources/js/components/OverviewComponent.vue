<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 bg-white p-4 mb-3">
        <h5>Consolidated Companies Overview</h5>
      </div>

      <div class="col-7 bg-white p-4 mb-3">
        <apexchart
          ref="chart"
          id="mychart"
          width="725"
          type="bar"
          :options="chartOptions"
          :series="series"
        />
      </div>

      <div class="col-5 mb-3 mr-0 pr-0">
        <div class="no-gutters bg-white p-4 scrollView">
          Aggregated Checklist

          <!--Iterate through companies-->
          <div
            class="mt-4"
            v-for="(company, index) in this.returnAllCompanies"
            :key="index"
          >
            <h6 class="text-primary font-weight-bolder">
              {{ company.name }} 's latest checklist
            </h6>

            <div
              v-if="company.checklists.length > 0 && jndex < 5"
              v-for="(item, jndex) in company.checklists"
              class="p-2 bg-light mt-2 mb-2"
              :key="jndex"
            >
              {{ item.item }}
            </div>

            <hr />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import VueApexCharts from "vue-apexcharts";
import axios from "axios";

export default {
  name: "OverviewComponent",
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      chartOptions: {
        xaxis: {
          categories: ["Total Credits", "Credits Filed", "Credits Received"],
        },
        colors: [
          "rgba(255, 99, 132, 0.75)",
          "rgba(54, 162, 235, 0.75)",
          "rgba(75, 192, 192, 0.75)",
        ],
        plotOptions: {
          bar: {
            distributed: true,
          },
        },
      },
      series: [
        {
          name: "Amount",
          data: [100, 100, 100],
        },
      ],
    };
  },
  computed: {
    ...mapGetters(["returnConsolidatedTotalCredits", "returnAllCompanies"]),
  },
  async mounted() {
    const { data } = await axios.get("api/company/consolidated");
    this.$refs.chart.updateSeries([
      {
        data: [
          Number.parseFloat(data.total).toFixed(2),
          Number.parseFloat(data.filed).toFixed(2),
          Number.parseFloat(data.received).toFixed(2),
        ],
      },
    ]);
  },
};
</script>

<style lang="scss" scoped>
.scrollView {
  overflow: scroll;
  height: 32rem;
}
</style>
