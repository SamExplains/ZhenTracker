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
      <div class="table-custom-style" style="width: 150%">
        <h5 class="text-primary mb-4">
          Overview Billing Table for {{ this.returnCurrentActiveCompany.name }}
        </h5>
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
          <div class="cell-column-head d-inline d-block my-auto bg-light">
            Year of Study
          </div>
          <div class="cell-column-head d-inline d-block bg-light">
            Credits from <br />
            Study
          </div>
          <div class="cell-column-head d-inline d-block my-auto bg-light">Credits Type</div>
          <div class="cell-column-head d-inline d-block my-auto bg-light">Claim Type</div>
          <div
            class="cell-column-head d-inline d-block my-auto bg-light"
            v-for="(column, index) in parsed941records"
            :key="index"
          >
            {{ column.period.substr(0, 4) + " " + column.quarter }}
          </div>
          <div class="cell-column-head d-inline d-block my-auto bg-dark">-</div>
        </div>
        <div v-for="(credit, index) in records" :key="index">
          <!-- Data Row 1 -->
          <div class="d-flex">
            <div class="cell-data d-inline d-block my-auto year-cell-color">
              <b class="font-weight-bolder">{{ credit.ET.year }}</b>
            </div>
            <div
              class="cell-data d-inline d-block my-auto font-weight-extra-bold"
            >
              {{ credit.ET.credit_amount }}
            </div>
            <div class="cell-data d-inline d-block my-auto text-left">
              <!-- Payroll / Income Radio -->
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Payroll
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                  Income Tax
                </label>
              </div>
            </div>
            <div class="cell-data d-inline d-block my-auto text-left">
              <!-- Payroll / Income Radio -->
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                  <label class="form-check-label" for="flexRadioDefault1">
                    Claimed
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                  <label class="form-check-label" for="flexRadioDefault2">
                    Advanced
                  </label>
                </div>
            </div>
            <!-- Data rows 5 ~ N-1 -->
            <div
              class="cell-data d-inline d-block my-auto font-weight-extra-bold"
              v-for="(columnItem, itemIndex) in credit.NFO"
              :key="itemIndex"
            >
              {{ columnItem.credit_claimed }}
            </div>
            <!-- Remaining END -->
            <div
              ref="remaining"
              class="
                cell-data
                d-inline d-block
                my-auto
                remaining-cell-color
                font-weight-extra-bold
              "
            >
              {{ calculateRemaning(index, credit.ET.credit_amount) }}
              {{
                updateRemainingBalance(
                  index,
                  calculateRemaning(index, credit.ET.credit_amount)
                )
              }}
            </div>
          </div>
          <!-- Data Row 2 -->
          <div class="d-flex">
            <div class="cell-data d-inline d-block my-auto bg-white"></div>
            <div class="cell-data d-inline d-block my-auto bg-white"></div>
            <div class="cell-data d-inline d-block my-auto whitelight text-left">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Payroll
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                  Income Tax
                </label>
              </div>
            </div>
            <div class="cell-data d-inline d-block my-auto bg-white text-left">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Claimed
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                  Advanced
                </label>
              </div>
            </div>
            <div
              class="cell-data d-inline d-block my-auto bg-white"
              v-for="(item, itemIndex) in credit.NFO"
              :key="itemIndex"
            >
              <b class="font-weight-extra-bold">{{
                item.credits_advanced > 0 ? item.credits_advanced : "-"
              }}</b>
            </div>
            <!-- Total -->
            <div
              class="
                cell-data
                d-inline d-block
                my-auto
                remaining-cell-color
                font-weight-extra-bold
              "
            >
              {{ calculateCreditsAdvancedRemaning(index) }}
            </div>
          </div>
          <!-- Row 3 -->
          <div class="d-flex">
            <div class="cell d-inline d-block my-auto bg-white"></div>
            <div class="cell d-inline d-block my-auto bg-light">
<!--              {{ credit.ET.credits_advanced || 0 }}-->
            </div>
            <div class="cell d-inline d-block my-auto bg-light"></div>
            <div class="cell d-inline d-block my-auto bg-light"></div>
            <!--Dropdown -->
            <div
              class="cell-dropdown d-inline d-block my-auto bg-light text-left"
              v-for="(item, itemIndex) in credit.NFO"
              :key="itemIndex"
              v-if="item.credit_claimed > 0">
              <div class="form-check">
                <input class="form-check-input" type="radio" :name="'flexRadioDefault-'+index+'-'+itemIndex" :id="'papercheck-'+index+'-'+itemIndex">
                <label class="form-check-label" :for="'papercheck-'+index+'-'+itemIndex">
                  Paper Check
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" :name="'flexRadioDefault-'+index+'-'+itemIndex" :id="'advanced-'+index+'-'+itemIndex">
                <label class="form-check-label" :for="'advanced-'+index+'-'+itemIndex">
                  Advanced
                </label>
              </div>
            </div>
            <div v-else class="cell-dropdown d-inline d-block my-auto bg-light text-center"></div>
          </div>
          <!-- Notes Row 4-->
          <div class="d-flex">
            <div class="cell d-inline d-block my-auto notes-cell-color">
              Notes
            </div>
            <div class="cell-note d-inline d-block my-auto bg-dark"></div>
            <div class="cell-note d-inline d-block my-auto bg-dark"></div>
            <div class="cell-note d-inline d-block my-auto bg-dark"></div>
            <!-- Show  Note for selected item-->
            <div
              class="cell-dropdown d-inline d-block my-auto bg-light"
              v-for="(notes, noteIndex) in credit.NFO"
              :key="noteIndex"
            >
              <el-button
                v-if="notes.credit_claimed > 0"
                @click="showActiveNoteForm(index, noteIndex, notes)"
                >O [{{ index }}] [{{ noteIndex }}]</el-button
              >
              <div v-else class="p-2">-</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <el-button class="mt-3" style="margin-left: -1rem"
          >Save Table</el-button
        >
      </div>

      <!-- Notes Form -->
      <div class="col-12 mt-5 pl-0" v-if="active">
        <h4>Note for {{ activeYearAndQuarter }}</h4>
        <div class="note-cell">
          <h6 class="note-label p-2 my-auto">Total Refund Recieved</h6>
          <div class="note-field my-auto">
            {{ active.total_refund_recieved }}
          </div>
        </div>

        <div class="note-cell">
          <h6 class="note-label p-2 my-auto">Method</h6>
          <div class="note-field my-auto">{{ active.selected_method }}</div>
        </div>

        <div class="note-cell">
          <h6 class="note-label p-2 my-auto">Billing Date</h6>
          <div class="note-field my-auto">
            <el-input placeholder="Please input" v-model="billingDate"></el-input>
          </div>
        </div>

        <div class="note-cell">
          <h6 class="note-label p-2 my-auto">Payment Date</h6>
          <div class="note-field my-auto">
            <el-input placeholder="Please input" v-model="paymentDate"></el-input>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-6 col-12">
            <h5 class="note-label p-2 my-auto">Invoice Attachments</h5>
            <div class="note-cell">
              <div class="note-field my-auto">field</div>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <h5 class="note-label p-2 my-auto">Notes</h5>
            <div class="note-cell">
              <div class="note-field my-auto">field</div>
            </div>          </div>
        </div>



        <el-button class="mt-3">Update</el-button>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  data() {
    return {
      records: [],
      parsed1120records: [],
      parsed941records: [],
      table941Data: [], // [ []... ]
      rowTwoSeletectData: [], // This will be populated after table 941 is created. This will be a 2D array of [ [1120 (N)] [ 941 (N) ] ]
      rowThreeNotes: [], // Holds Objects {...}. This will be populated after table 941 is created. This will be a 2D array of [ [1120 (N)] [ 941 (N) ] ]
      active: false, // Hold object showing active selected record to add notes too.
      activeYearAndQuarter: null,
      billingDate: null,
      paymentDate:null,
      invoiceAttachments:[],
      notes:[],
      options: [
        {
          value: "Paper Check",
          label: "Paper Check",
        },
        {
          value: "Advanced",
          label: "Advanced",
        },
      ],
    };
  },
  created() {
    this.computeTableData();
  },
  computed: {
    ...mapGetters([
      "returnActiveCompanyResearchAndDevelopmentData",
      "returnCurrentActiveCompany",
    ]),
  },
  watch: {
    returnCurrentActiveCompany() {
      // Clear old data
      this.records = [];
      this.parsed1120records = [];
      this.parsed941records = [];
      this.table941Data = [];
      // Reload data
      this.computeTableData();
      // Reload component
      this.$forceUpdate();
    },
  },
  methods: {
    ...mapActions(["handleBillingRecordUpdate"]),
    computeTableData() {
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

      // Parse records that are advanced
      // console.log(this.parsed941records);

      // Fill rowTwoSeletectData and rowThreeNotes
      this.parsed1120records.forEach((el) => {
        let record = [];
        let notes = [];
        /**
         * Notes record format
         * Billing Date
         * Payment Date
         * Invoice Attachments
         * Notes (more than 1 like a list)
         */
        let noteObject = {
          billing_date: "",
          payment_date: "",
          invoice_attachments: [],
          notes: [], //Holds objects { date, note, id}
        };
        this.parsed941records.forEach((ele) => {
          record.push("");
          notes.push(noteObject);
        });
        this.rowTwoSeletectData.push(record);
        this.rowThreeNotes.push(notes);
      });

      // console.log("Record ", this.rowTwoSeletectData);

      this.returnActiveCompanyResearchAndDevelopmentData.forEach(
        (el, index) => {
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
        }
      );

      // console.log(this.parsed1120records);
      // console.log(this.parsed941records);
      // console.log(this.parsed1120records);
      // console.log(this.table941Data);

      // Merge both sources into 1 source
      // This needs to create each 1120s 941 records array with the elements from the index before and after which will be blank
      // Take into account if the next item is the end
      this.parsed1120records.forEach((el, index) => {
        if (index === 0) {
          // console.log("FIRST!");
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
          // console.log("END!");
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
          // console.log(
          //   "MIDDLE with a 941 Length of ",
          //   this.parsed941records.length
          // );
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
    calculateRemaning(index, credits_from_study) {
      // If Index is > 0 do not subtract the study credit from above but instead add previous years plus this years total minus the credits_advanceds
      // Get and add values from 941 from 1120 record NFO
      // console.log(
      //   "Remmaining with ",
      //   index,
      //   " with ",
      //   credits_from_study,
      //   "   ",
      //   this.table941Data[index]
      // );

      // credit_claimed
      let values = 0;
      this.table941Data[index].forEach((el) => {
        values += Number(el.credit_claimed);
      });

      return index === 0
        ? credits_from_study > values
          ? (credits_from_study - values).toFixed(2)
          : (values - credits_from_study).toFixed(2)
        : values.toFixed(2);
    },
    updateRemainingBalance(index, values) {
      // console.log("test ", values);
      // Add the remainder credits from the previous index and update previous to 0
      // const previous = Number(
      //   document.getElementById("remaining_" + (index - 1)).textContent
      // );

      // Reset previous to 0
      // document.getElementById("remaining_" + (index - 1)).textContent = 0;

      let previous = 0;
      let updatedValues = 0;

      setTimeout(() => {
        if (index > 0) {
          previous = Number(this.$refs.remaining[index - 1].textContent);
          console.log("Previous ", previous);
          /**
           * Check for
           * If prvious is less than or equal to 0
           * If previous is positive but less than current subtract backwards
           */
          if (previous <= 0) {
            // Add
            console.log("We have a negative or zero");
            // Subtract up with Values
            updatedValues = Number(values + previous).toFixed(2);
          } else {
            console.log("We have a positive");
            // Check which side is greater to subtract propery
            if (previous > values) {
              console.log("We can use previous to subtract");
              // Subtract up with Values
              updatedValues = Number(previous - values).toFixed(2);
            } else {
              console.log("We can use values to subtract");
              // Subtract up with Values
              updatedValues = Number(values - previous).toFixed(2);
            }
          }

          // Finish up the logic for below
          // Update running balances as its not working with larges data like IceKredit

          // Update previous remaining from above
          this.$refs.remaining[index - 1].textContent = 0;

          // update current valuee
          this.$refs.remaining[index].textContent = updatedValues;
          // console.log("Update occured ", previous, "  ", updatedValues);
        }
      }, 150);
    },
    calculateCreditsAdvancedRemaning(index) {
      // Get and add values from 941 from 1120 record NFO
      // console.log(
      //   "Remmaining with ",
      //   index,
      //   " with ",
      //   this.table941Data[index]
      // );

      // credit_claimed
      let values = 0;

      this.table941Data[index].forEach((el) => {
        values += Number(el.credits_advanced);
      });
      return values.toFixed(2);
    },
    showActiveNoteForm(index1120, index941, credit) {
      // Reset to update the values if radio buttons are toggled
      this.active = null;
      console.error('ShowAdtiveForm')
      this.activeYearAndQuarter =
        credit.period.substring(0, 4) + "  " + credit.quarter;
      this.active = this.rowThreeNotes[index1120][index941];
      // Attach refund recieved
      this.active.total_refund_recieved = credit.credit_claimed;
      // Attach method
      // Check which radio is selected
      // Check not updating when new option selected and open button is pressed
      const paperCheckFlag = document.getElementById(`papercheck-${index1120}-${index941}`).checked;
      const advancedFlag = document.getElementById(`advanced-${index1120}-${index941}`).checked
      if( !paperCheckFlag && !advancedFlag) {
      //  No radios are selected
        console.log('No radios selected')
        this.active.selected_method = 'NULL'
      } else if (paperCheckFlag) {
        this.active.selected_method = 'PAPER CHECK'
        console.log('Papercheck')
      } else {
        this.active.selected_method = 'ADVANCED'
        console.log('Advanced')
      }
      // this.active.selected_method = this.rowTwoSeletectData[index1120][index941];

      // console.log(index1120);
      // console.log(index941);
      // console.log(this.active);
    },
  },
};
</script>

<style lang="scss" scoped>
.font-weight-extra-bold {
  font-weight: 900;
}
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
.cell-column-head {
  min-width: 8rem;
  padding: 1rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
  min-height: 5rem !important;
}
.cell {
  min-width: 8rem;
  padding: 1rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
  min-height: 4rem !important;
}
.cell-dropdown {
  min-width: 8rem;
  max-width: 8rem;
  min-height: 4rem !important;
  padding: 0.5rem;
  text-align: center;
  border-bottom: 1px solid black;
  border-right: 1px solid black;
}
.cell-note {
  min-width: 8rem;
  max-width: 8rem;
  min-height: 4rem !important;
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
  min-height: 4rem !important;

}

.notes-cell-color {
  background-color: #ffee93;
}

.remaining-cell-color {
  background-color: #adf7b69c;
}
.year-cell-color {
  background-color: #809bce86;
}
.table-custom-style {
  cursor: pointer !important;
}

.note-cell {
  padding: 0;
}
.note-label {
  width: 15rem !important;
  display: inline-block;
  font-weight: bolder;
}

.note-field {
  padding: 0.3rem;
  display: inline-block;
}
</style>
