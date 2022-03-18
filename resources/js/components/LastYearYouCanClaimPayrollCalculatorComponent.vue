<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h6 class="font-weight-bolder">Calendar / Fiscal Calculator</h6>
        <table class="table table-striped mt-3">
          <thead>
          <tr>
            <th>Title</th>
            <th>Value</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>Business Start Date</td>
            <td>{{ returnFiscalTypeCalculations.start_date }}</td>
          </tr>
          <tr>
            <td>Year End</td>
            <td>{{ returnFiscalTypeCalculations.year_end_date }}</td>
          </tr>
          <tr>
            <td>1st Income Year</td>
            <td>{{ returnFiscalTypeCalculations.first_income_year }}</td>
          </tr>
          <tr>
            <td class="font-weight-bolder text-primary my-auto">Final Claimable Payroll Year</td>
            <td class="font-weight-bolder text-primary my-auto">
              {{ returnFiscalTypeCalculations.last_year_payroll_claimable }}
            </td>
          </tr>

          <tr>
            <td class="font-weight-bolder">1</td>
            <td>{{ returnFiscalTypeCalculations.year_one }}</td>
          </tr>

          <tr>
            <td class="font-weight-bolder">2</td>
            <td>{{ returnFiscalTypeCalculations.year_two }}</td>
          </tr>

          <tr>
            <td class="font-weight-bolder">3</td>
            <td>{{ returnFiscalTypeCalculations.year_three }}</td>
          </tr>

          <tr>
            <td class="font-weight-bolder">4</td>
            <td>{{ returnFiscalTypeCalculations.year_four }}</td>
          </tr>

          <tr>
            <td class="font-weight-bolder">5</td>
            <td>{{ returnFiscalTypeCalculations.year_five }}</td>
          </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex"

  export default {
    name: "LastYearYouCanClaimPayrollCalculatorComponent",
    computed: {
      ...mapGetters(['returnCalculationStartDate', 'returnFiscalTypeCalculations'])
    }
  }
</script>

<style scoped>

</style>
