<template>
  <div class="text-center no-gutters bg-white p-4">
    <article v-if="overrideDate === 'No override date found'">

    Last Eligible Year<br>
    <div class="alert alert-success" role="alert">
      <b>{{ lastPayrollDate }}</b>
    </div>

    </article>

    <article v-else>
    Last Eligible Year<br>
    <div class="alert alert-primary" role="alert">
      <b>{{ overrideDate }}</b>
    </div>
    </article>

  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import * as moment from "moment";

  export default {
    name: "LastYearYouCanClaimPayrollComponent",
    computed: {
      ...mapGetters(['returnLastYearClaimablePayroll', 'returnCurrentActiveCompany']),
      lastPayrollDate() {
        // let split = this.returnLastYearClaimablePayroll.split('-');
        // return `${split[2]}-${split[1]}-${split[0]}`;
        return moment(this.returnLastYearClaimablePayroll).format('MM-DD-YYYY');
      },
      overrideDate(){
        if (this.returnCurrentActiveCompany !== null) {
          return (this.returnCurrentActiveCompany.override_date !== null) ? moment(this.returnCurrentActiveCompany.override_date).format('MM-DD-YYYY') : 'No override date found';
        } else {
          return 'No override date found'
        }
      }
    }
  }
</script>

<style scoped>

</style>
