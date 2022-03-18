<template>
  <section>
    <h6>
      Next eligible quarter
      <b class="font-weight-bolder"
        ><u>{{ determineNextEligibleQuarter.neq }}</u></b
      >
    </h6>
    <h6 class="text-danger">
      Due date
      <b
        ><u>{{ determineNextEligibleQuarter.dd }}</u></b
      >
    </h6>
  </section>
</template>

<script>
import * as moment from "moment";
import { mapGetters } from "vuex";

export default {
  name: "NextEligibleQuarterComponent",
  data() {
    return {
      dueDate: "n/a",
    };
  },
  computed: {
    ...mapGetters(["returnLastYearClaimablePayroll"]),
    determineNextEligibleQuarter() {
      const finalYear = moment(this.returnLastYearClaimablePayroll).year();
      const finalYearMonth = moment(
        this.returnLastYearClaimablePayroll
      ).month();
      const currentYear = moment(Date.now()).year();
      const currentYearMonth = moment(Date.now()).month();
      const nextEligibleQuarter = moment(Date.now()).add(1, "year").year();
      const dueDateNext = moment(
        this.returnLastYearClaimablePayroll
          .toString()
          .replace(/^.{4}/g, nextEligibleQuarter.toString())
      ).format("MM-DD-YYYY");
      const dueDateCurrent = moment(this.returnLastYearClaimablePayroll).format(
        "MM-DD-YYYY"
      );

      // console.log({
      //   finalYear,
      //   finalYearMonth,
      //   currentYear,
      //   currentYearMonth,
      //   nextEligibleQuarter,
      //   dueDateNext,
      //   dueDateCurrent
      // });

      /*
          IF the final claimable year is less than current year
            Next eligible quarter is +1 year
            Due Date would be final_date_payroll_claim M/D with next eligible year which was calculated above
          ----
          ELSE IF the final claimable year is equal to current year
            IF
              the final claim month is less then current month next quarter is This Final Year
              Due Date would be this final year
            ELSE
              there is no due date or eligible quarter to output
          ----
          ELSE
            return calculation error
        **/

      if (currentYear < finalYear) {
        return { neq: nextEligibleQuarter, dd: dueDateNext };
      } else if (currentYear === finalYear) {
        if (currentYearMonth < finalYearMonth) {
          return { neq: finalYear, dd: dueDateCurrent };
        } else {
          // console.log('Final Year is EQUAL to Current Year');
          return {
            neq: "Not eligible for next quarter",
            dd: "No due date available",
          };
        }
      } else {
        return {
          neq: "Not eligible for next quarter",
          dd: "No due date available",
        };
      }
    },
  },
};
</script>

<style scoped>
</style>
