<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-5 col-12 bg-white p-4 mb-3">
        <credits-chart-component />
      </div>

      <div class="col-lg-3 col-6 mb-3 mr-0 pr-0">
        <checklist-component />
      </div>

      <div class="col-lg-4 col-6 mb-3 mr-0 pr-0">
        <last-year-you-can-claim-payroll-component />

        <section class="bg-white p-4 mt-3">
          <recent-events-component />
        </section>
      </div>

      <div class="col-lg-6 col-12 ml-0 pl-0 mr-0 pr-0">
        <new-checklist-item />
      </div>

      <div class="col-lg-6 col-12 mr-0 pr-0">
        <section class="bg-white p-4">
          <h5 class="font-weight-bolder">New Company Event</h5>
          <new-event-component />
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import NewEventComponent from "./NewEventComponent";
import RecentEventsComponent from "./RecentEventsComponent";
import NextEligibleQuarterComponent from "./NextEligibleQuarterComponent";
import LastYearYouCanClaimPayrollComponent from "./LastYearYouCanClaimPayrollComponent";
import CreditsChartComponent from "./CreditChartComponent";
import ChecklistComponent from "./ChecklistComponent";
import NewChecklistItem from "./NewChecklistItem";

export default {
  name: "DashboardComponent",
  components: {
    NewChecklistItem,
    ChecklistComponent,
    CreditsChartComponent,
    LastYearYouCanClaimPayrollComponent,
    NextEligibleQuarterComponent,
    RecentEventsComponent,
    NewEventComponent,
  },
};
</script>

<style scoped>
</style>
