<template>
  <div class="container-fluid p-0">
    <div class="bg-white p-4 overflow-auto">
      <!-- <div class="col-12">
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
      </div> -->
      <!-- <div :style="{ width: this.parsed941records.length * 12.15 + 'rem' }"> -->
      <div style="width: 150%">
        <h5 class="text-primary">Overview Table</h5>
        <table
          class="
            table table-striped table-responsive
            text-center
            table-sm table-hover
          "
        >
          <thead class="thead-inverse">
            <tr>
              <th>Year of Study</th>
              <th>Credits from Study</th>
              <th>Credits Type</th>
              <th>---</th>
              <th v-for="(column, index) in parsed941records" :key="index">
                {{ column.period.substr(0, 4) + " " + column.quarter }}
              </th>
              <th>Remaining</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              1
            </tr>
            <tr>
              2
            </tr>
            <tr>
              Notes
            </tr>
          </tbody>
        </table>
        <!-- Header -1 -->
        <div class="d-flex">
          <div
            class="
              cell-header-1
              d-inline d-block
              my-auto
              font-weight-bolder
              bg-light
            "
          >
            Credits Summary
          </div>
          <div
            class="
              cell-header-2
              d-inline d-block
              my-auto
              font-weight-bolder
              bg-light
            "
            :style="{
              'min-width': this.parsed941records.length * 8 + 'rem',
            }"
          >
            Utilization
          </div>
          <div
            class="
              cell-header-3
              d-inline d-block
              my-auto
              font-weight-bolder
              bg-light
            "
          >
            Remaining
          </div>
        </div>
        <!-- Header -2 -->
        <div class="d-flex">
          <div class="cell d-inline d-block my-auto bg-light">
            Year of Study
          </div>
          <div class="cell d-inline d-block bg-light">
            Credits from <br />
            Study
          </div>
          <div class="cell d-inline d-block my-auto bg-light">Credits Type</div>
          <div class="cell d-inline d-block my-auto bg-dark"></div>
          <div
            class="cell d-inline d-block my-auto bg-light"
            v-for="(column, index) in parsed941records"
            :key="index"
          >
            {{ column.period.substr(0, 4) + " " + column.quarter }}
          </div>
          <div class="cell d-inline d-block my-auto bg-dark"></div>
        </div>
        <!-- Data -->
        <div v-for="(credit, index) in records" :key="index">
          <div class="d-flex">
            <div class="cell-data d-inline d-block my-auto">
              <b class="font-weight-bolder">{{ credit.ET.year }}</b>
            </div>
            <div class="cell-data d-inline d-block my-auto">
              {{ credit.ET.credit_amount }}
            </div>
            <div class="cell-data d-inline d-block my-auto">Row 1</div>
            <div class="cell-data d-inline d-block my-auto">Row 1</div>
            <!-- Data rows 5 ~ N-1 -->
            <div
              class="cell-data d-inline d-block my-auto"
              v-for="(columnItem, itemIndex) in credit.NFO"
              :key="itemIndex"
            >
              {{ columnItem.credit_claimed }}
            </div>
            <!-- Remaining END -->
            <div class="cell-data d-inline d-block my-auto text-success">
              remaining
            </div>
          </div>
          <div class="d-flex">
            <div class="cell d-inline d-block my-auto bg-light">Row 2</div>
            <div class="cell d-inline d-block my-auto bg-light">
              {{ credit.ET.credits_advanced || 0 }}
            </div>
          </div>
          <div class="d-flex">
            <div class="cell d-inline d-block my-auto bg-light">Notes row</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      records: [],
      parsed1120records: [],
      parsed941records: [],
      table941Data: [], // [ []... ]
    };
  },
  beforeMount() {
    let collection = []; // Holds [ {ET:[], NFO: []} ]
    let collectionRecord = { ET: {}, NFO: [] };
    let count = 0;

    this.parsed1120records =
      this.returnActiveCompanyResearchAndDevelopmentData.filter(
        (el) => el.return_type == 1120
      );

    this.parsed941records =
      this.returnActiveCompanyResearchAndDevelopmentData.filter(
        (el) => el.return_type != 1120
      );

    this.returnActiveCompanyResearchAndDevelopmentData.forEach((el, index) => {
      // console.log(el);
      if (el.return_type == 1120) {
        if (count === 0) {
          collectionRecord.ET = el;
          count++;
        } else {
          collectionRecord.ET = el;
          // Push
          this.table941Data.push(collectionRecord.NFO);
          // collection.push(collectionRecord);
          // Reset
          collectionRecord = { ET: {}, NFO: [] };
          // increment
          count++;
        }
      } else {
        collectionRecord.NFO.push(el);
        // check if last element to PUSH
        if (
          index ===
          this.returnActiveCompanyResearchAndDevelopmentData.length - 1
        ) {
          // console.log("Last element is 941!");
          collectionRecord.ET = el;
          // Push
          this.table941Data.push(collectionRecord.NFO);
          // collection.push(collectionRecord);
          // Reset
          collectionRecord = { ET: {}, NFO: [] };
        }
      }
    });

    // console.log(this.parsed1120records);
    // console.log(this.parsed941records);
    // console.log(this.parsed1120records);
    // console.log(this.table941Data);

    // Merge both sources into 1 source
    // This needs to create each 1120s 941 records array with the elements from the index before and after which will be blank
    // Take into account if the next item is the end
    this.parsed1120records.forEach((el, index) => {
      if (index === 0) {
        console.log("FIRST!");
        // Fill the remaining with blank
        const limit = this.parsed941records.length; // Max rows excluding the Remaiing column which is very last
        let end = [];
        // Get amount left to finish which is (0+1) - LIMIT
        for (let i = 0; i < limit - this.table941Data[index].length; i++) {
          end.push({ credit_claimed: "-" });
        }

        this.records.push({
          ET: el,
          NFO: [...this.table941Data[index], ...end],
        });
      } else if (index === this.parsed1120records.length - 1) {
        let count = 0;
        let start = [];
        // END!
        // Check if we are at the end
        console.log("END!");
        // Reverse loop from our current index to count the records total
        for (let i = index - 1; i >= 0; i--) {
          // console.log("Previous set had ", this.table941Data[i].length);
          count += this.table941Data[i].length;
        }
        // Fill the empty array before concat
        for (let j = 0; j < count; j++) {
          start.push({ credit_claimed: "-" });
        }

        // console.log("We have ", count, " records to fill");

        this.records.push({
          ET: el,
          NFO: [...start, ...this.table941Data[index]],
        });
      } else if (index >= 1) {
        console.log(
          "MIDDLE with a 941 Length of ",
          this.parsed941records.length
        );
        const limit = this.parsed941records.length; // Max rows excluding the Remaiing column which is very last
        let start = [];
        let startCount = 0;
        let end = [];
        let endCount = [];
        let adjustedNFO = [];

        // console.log("Records set ", this.table941Data);

        /**
         * Fill the start up to the current index
         * Fill the end from the current index +1
         */

        // fill start
        // this.table941Data[index - 1].forEach((el) => {
        //   start.push({ credit_claimed: "-" });
        // });

        // Count the amount of records before the actual middle record
        for (let a = 0; a < index; a++) {
          startCount += this.table941Data[a].length;
        }

        // fill start
        for (let sc = 0; sc < startCount; sc++) {
          start.push({ credit_claimed: "-" });
        }

        // TODO Fill middle if empty

        // fill end
        // Get amount left to finish which is (0+1) - LIMIT
        // The 7 needs to be replaced with the total of records before the current index
        endCount = limit - (start.length + this.table941Data[index].length);
        for (let i = 0; i < endCount; i++) {
          end.push({ credit_claimed: "-" });
        }

        // fill middle if no records exist

        adjustedNFO = [...start, ...this.table941Data[index], ...end];
        // Push
        this.records.push({ ET: el, NFO: adjustedNFO });
      }
    });

    // console.log(this.records);
  },
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
.cell-header-1 {
  min-width: 32rem;
  padding: 0.5rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
}
.cell-header-2 {
  padding: 0.5rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
}
.cell-header-3 {
  min-width: 8rem;
  padding: 0.5rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
}
.cell {
  min-width: 8rem;
  padding: 0.5rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
}
.cell-data {
  min-width: 8rem;
  padding: 0.5rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
}
</style>
