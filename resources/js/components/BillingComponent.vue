<template>
  <div class="container-fluid">
    <div class="row bg-white p-4">
      <div class="col-12">
        <h5 class="text-primary">Billing</h5>

        <table
          class="
            table table-striped table-responsive
            text-center
            table-sm table-hover
          "
        >
          <thead class="thead-inverse">
            <tr>
              <th>Return Type</th>
              <th>Quarter</th>
              <th>Period</th>
              <th>Date Return Filed</th>
              <th>Study Year</th>
              <th class="text-primary">Claimed</th>
              <th class="text-success">Credits Received</th>
              <th>Fees</th>
              <th>Payment Date</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(credit, index) in this
                .returnActiveCompanyResearchAndDevelopmentData"
              :key="index"
            >
              <td scope="row">
                <p class="mt-2">{{ credit.return_type }}</p>
              </td>
              <td>
                <p class="mt-2">{{ credit.quarter }}</p>
              </td>
              <td>
                <p class="mt-2">{{ credit.period }}</p>
              </td>
              <td>
                <p class="mt-2">{{ credit.date_return_filed }}</p>
              </td>
              <td>
                <input
                  :id="`sy${credit.id}`"
                  class="form-control"
                  type="text"
                  placeholder="study year"
                  v-bind:value="credit.study_year"
                  maxlength="15"
                />
              </td>
              <td>
                <p class="mt-2">
                  {{ parseFloat(credit.credit_claimed).toFixed(2) }}
                </p>
              </td>
              <td>
                <p class="mt-2">
                  {{ parseFloat(credit.credit_received).toFixed(2) }}
                </p>
              </td>
              <td>
                <input
                  :id="`fe${credit.id}`"
                  class="form-control"
                  type="text"
                  placeholder="fees"
                  v-bind:value="credit.fees"
                  maxlength="15"
                />
              </td>
              <td>
                <input
                  :id="`pd${credit.id}`"
                  class="form-control"
                  type="text"
                  placeholder="payment date"
                  v-bind:value="credit.payment_date"
                  maxlength="15"
                />
              </td>
              <td>
                <el-button
                  class="mt-1"
                  type="primary"
                  size="mini"
                  @click="onHandleBillingRecordUpdate(credit.id)"
                  >update</el-button
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  computed: {
    ...mapGetters(["returnActiveCompanyResearchAndDevelopmentData"]),
  },
  methods: {
    ...mapActions(["handleBillingRecordUpdate"]),
    onHandleBillingRecordUpdate(_record_id) {
      /**
       * sy - study year
       * fe - fees
       * pd - payment due
       */
      const _sy = document.getElementById(`sy${_record_id}`).value;
      const _fe = document.getElementById(`fe${_record_id}`).value;
      const _pd = document.getElementById(`pd${_record_id}`).value;
      let updates = {};
      let invalid = 0;

      if (_sy !== "") updates.study_year = _sy;
      else invalid++;

      if (_fe !== "") updates.fees = _fe;
      else invalid++;

      if (_pd !== "") updates.payment_date = _pd;
      else invalid++;

      if (_sy !== "" || _fe !== "" || _pd !== "") {
        this.handleBillingRecordUpdate({ id: _record_id, pay: updates });
        this.$notify({
          title: "Success",
          message: "Record updated.",
          type: "success",
        });
      } else {
        this.$notify({
          title: "Failed",
          message: "Could not update. Invalid data",
          type: "error",
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
