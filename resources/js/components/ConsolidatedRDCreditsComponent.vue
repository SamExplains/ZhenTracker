<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h5 class="mt-4">Consolidated Company R&D Credits (All)</h5>
        <hr>
        <section class="mt-3 mb-3 mt-3">
          <article v-for="(consolidated, index) in consolidatedData" :key="index">
            <div v-if="consolidated.research_and_development_consolidated.length > 0">
              <h6 class="text-primary">{{consolidated.name}}</h6>
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Return Type</th>
                  <th>Quarter</th>
                  <th>Period</th>
                  <th>Date Filed</th>
                  <th>Year</th>
                  <th>Claimed</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(rd, jindex) in consolidated.research_and_development_consolidated" :ley="jindex">
                  <td>{{ rd.return_type }}</td>
                  <td>{{ rd.quarter }}</td>
                  <td>{{ rd.period }}</td>
                  <td>{{ rd.date_return_filed }}</td>
                  <td>{{ rd.year }}</td>
                  <td>{{ rd.credit_claimed }}</td>
                </tr>
                </tbody>
              </table>
            </div>
            <div v-else>
              <h6 class="text-primary">{{consolidated.name}}</h6>
              <i>no information found at this moment.</i>
              <hr>
            </div>
          </article>
        </section>


      </div>
    </div>
  </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "ConsolidatedRDCreditsComponent",
        data() {
            return {
                consolidatedData: []
            }
        },
        async created() {
            const {data, status} = await axios.get('api/company/consolidated-rd');
            this.consolidatedData = data;
        }
    }

</script>

<style scoped>

</style>
