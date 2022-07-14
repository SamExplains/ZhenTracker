<template>
  <div class="row bg-white p-4 m-1">
    <div class="col-12">
      <h5 class="text-primary">Tracking Credits</h5>

      <!--<div class="float-right mb-3">-->
      <!--<el-button-group>-->
      <!--<el-button @click="onTriggerSort('default')">Default Sort</el-button>-->
      <!--<el-button @click="onTriggerSort('period')"-->
      <!--&gt;Sort by Period (ascending)-->
      <!--</el-button-->
      <!--&gt;-->
      <!--</el-button-group>-->
      <!--</div>-->

      <details class="p-2 mb-5">
        <summary>
          Click to reveal <span class="font-weight-bold">Record Sorting</span>
        </summary>
        <draggable
          class="mt-3"
          v-model="returnActiveCompanyResearchAndDevelopmentDataSortable"
          group="people"
          @start="drag = true"
          @end="drag = false"
        >
          <div
            v-for="(
              element, index
            ) in returnActiveCompanyResearchAndDevelopmentDataSortable"
            :key="element.id"
            :id="`draggable-${element.id}`"
            style="cursor: move"
            class="alterate-color p-3"
            @dragstart="handleDragStart(element.id)"
            @dragend="dragend(element.id, index)"
          >
            <div class="row">
              <div class="col">
                {{ element.return_type }}
              </div>
              <div class="col">
                {{ element.quarter }}
              </div>
              <div class="col">
                {{ element.period }}
              </div>
              <div class="col">
                {{ element.date_return_filed }}
              </div>
              <div class="col">
                {{ element.credit_amount }}
              </div>
              <div class="col">
                {{ element.credit_claimed }}
              </div>
              <div class="col">
                {{ rowByRowCalculation(index) }}
              </div>
              <div class="col">
                {{ parseFloat(element.credit_received).toFixed(2) }}
              </div>
              <div class="col">
                {{ element.date_check }}
              </div>
            </div>
          </div>
        </draggable>
      </details>

      <hr />

      <div class="row">
        <div class="col-12">
          <h4>Input these fields only when using Quick 8974.</h4>
        </div>
        <div class="col-12 col-md-4 col-lg-4">
          <h6>
            8). Enter the amount from Form 941 (941-PR or 941-SS), line 5a,
            Column 2; Form 943 (943-PR), line 3; or Form 944 (944(SP)), line 4a,
            Column 2
          </h6>
          <div class="form-group">
            <input
              v-model="quick8"
              type="number"
              class="form-control mt-4"
              aria-describedby="helpId"
              placeholder="0"
            />
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4">
          <h6>
            9). Enter the amount from Form 941 (941-PR or 941-SS), line 5b,
            Column 2; or Form 944 (944(SP)), line 4b, Column 2
          </h6>
          <input
            v-model="quick9"
            type="number"
            class="form-control mt-4"
            aria-describedby="helpId"
            placeholder="0"
          />
        </div>
      </div>

      <table
        class="
          table table-responsive table-sm table-striped
          text-center
          table-hover
        "
      >
        <thead>
          <tr>
            <th>Return Type</th>
            <th>Quarter</th>
            <th>Period <br />(yyyy-mm-dd)</th>
            <th>Date Return Filed</th>
            <!--          <th>Year</th>-->
            <th class="text-danger">Form Amount</th>
            <th>
              Credits <br />
              Advanced
            </th>
            <th class="text-primary">Claimed</th>
            <th>Credit Available</th>
            <th class="text-success">Credits Received</th>
            <th>Check Date <br />(yyyy-mm-dd)</th>
            <th>
              Download<br />
              / Store
            </th>
            <th>Update</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(
              rad, index
            ) in returnActiveCompanyResearchAndDevelopmentDataSortable"
            :key="index"
            :id="`table-row-${index}`"
          >
            <td>
              <p class="mt-2">
                {{ rad.return_type }}
              </p>
            </td>
            <td>
              <p class="mt-2">{{ rad.quarter }}</p>
            </td>
            <td>
              <!-- Period -->
              <!-- <p class="mt-2">{{ rad.period }}</p> -->
              <div class="d-inline-block">
                <input
                  type="date"
                  class="form-control"
                  style="width: 10rem !important"
                  placeholder="yyyy-mm-dd"
                  :id="`check_period-${rad.id}`"
                  v-bind:value="rad.period"
                />
                <!-- <flatpickr
                              style="width: 125px !important"
                              m
                              class="minimalMarginTop"
                              :default="rad.period"
                              timeFormat="Y-m-d"
                              v-on:updatedDate="updateCheckDate"
                              :id="`check_period-${rad.id}`"
                            />
                            {{ isDateEmpty(rad.period, `check_period-${rad.id}`) }} -->
              </div>
            </td>
            <td>
              <p class="mt-2">{{ rad.date_return_filed }}</p>
            </td>
            <td style="width: 200px" class="text-danger font-weight-bolder">
              <div class="input-group mb-3">
                <input
                  :id="`updatedAmount_${rad.id}`"
                  style="width: 7rem !important"
                  type="number"
                  step="0.01"
                  class="form-control"
                  placeholder="0.0"
                  aria-describedby="basic-addon2"
                  v-bind:value="parseFloat(rad.credit_amount).toFixed(2)"
                />
              </div>
            </td>
            <!-- Credits Advanced -->
            <td class="text-primary font-weight-bolder mx-auto">
              <input
                :id="`creditAdvanced_${rad.id}`"
                style="width: 7rem !important"
                type="number"
                step="0.01"
                class="form-control"
                placeholder="0.0"
                aria-describedby="basic-addon2"
                v-bind:value="parseFloat(rad.credits_advanced).toFixed(2) || 0"
              />
            </td>
            <td style="width: 200px" class="text-primary font-weight-bolder">
              <div class="input-group mb-3">
                <input
                  :id="`updatedClaimed_${rad.id}`"
                  style="width: 7rem !important"
                  type="number"
                  step="0.01"
                  placeholder="0.0"
                  class="form-control"
                  aria-describedby="basic-addon2"
                  v-bind:value="parseFloat(rad.credit_claimed).toFixed(2)"
                />
                <!-- <div class="input-group-append">
                              <button
                                class="btn btn-outline-secondary"
                                type="button"
                                @click="onUpdateAmountClaimed(rad.id)"
                              >
                                <i class="el-icon-edit"></i>
                              </button>
                            </div> -->
              </div>
            </td>
            <td>
              <!--Available-->
              <!-- <p class="mt-2">{{ rowByRowCalculation(index) }}</p> -->
              <p class="mt-2">{{ rowByRowCalculation(index) }}</p>
            </td>
            <td style="width: 200px">
              <div class="input-group mb-3">
                <input
                  :id="`updatedReceived_${rad.id}`"
                  type="number"
                  step="0.01"
                  class="form-control"
                  style="width: 7rem !important"
                  placeholder="0.0"
                  aria-describedby="basic-addon2"
                  v-bind:value="parseFloat(rad.credit_received).toFixed(2)"
                />
                <!-- <div class="input-group-append">
                              <button
                                class="btn btn-outline-secondary"
                                type="button"
                                @click="onUpdateCreditReceived(rad.id)"
                              >
                                <i class="el-icon-edit"></i>
                              </button>
                            </div> -->
              </div>
            </td>
            <!--Check Date-->
            <td style="width: 200px">
              <div class="d-inline-block">
                <input
                  type="date"
                  class="form-control"
                  style="width: 10rem !important"
                  placeholder="yyyy-mm-dd"
                  :id="`check_date-${rad.id}`"
                  v-bind:value="rad.date_check"
                />
                <!-- <flatpickr
                              style="width: 125px !important"
                              class="minimalMarginTop"
                              :default="rad.date_check"
                              timeFormat="Y-m-d"
                              v-on:updatedDate="updateCheckDate"
                              :id="`check_date-${rad.id}`"
                            />
                            {{ isDateEmpty(rad.date_check, `check_date-${rad.id}`) }} -->
              </div>
              <!-- <button
                          style="
                            border-top-left-radius: 0;
                            border-bottom-left-radius: 0;
                            margin-left: -0.25rem;
                          "
                          class="btn btn-outline-secondary"
                          @click="onUpdateDateCheck(rad.id, `check_date-${rad.id}`)"
                        >
                          <i class="el-icon-edit"></i>
                        </button> -->
            </td>
            <td>
              <el-button
                v-if="rad.return_type !== '1120' && rad.return_type !== '1120S'"
                type="success"
                size="mini"
                @mouseover.native="onMouseoverHighlight(index, rad.return_type)"
                @mouseleave.native="
                  onMouseoverLeaveUnhighlight(index, rad.return_type)
                "
                @click="exportTo8974Form(index, rad.id)"
              >
                <!-- <el-button
                v-if="rad.return_type !== '1120'"
                type="success"
                size="mini"
                @mouseover.native="onMouseoverHighlight(index, rad.return_type)"
                @mouseleave.native="
                  onMouseoverLeaveUnhighlight(index, rad.return_type)
                "
                @click="returnSlicedRecordsAtIndexGiven(rad.id)"
              > -->
                8974 <i class="el-icon-download"></i>
              </el-button>
              <br />
              <el-button
                type="primary"
                size="mini"
                class="mt-2"
                plain
                v-if="rad.return_type !== '1120' && rad.return_type !== '1120S'"
                @mouseover.native="onMouseoverHighlight(index, rad.return_type)"
                @mouseleave.native="
                  onMouseoverLeaveUnhighlight(index, rad.return_type)
                "
                @click="onStore8974(index, rad.id)"
                >Store <i class="el-icon-document-add"></i
              ></el-button>
            </td>
            <td>
              <el-button
                type="primary"
                size="mini"
                @click="updateRecord(rad.id)"
              >
                <i class="el-icon-edit"></i>
              </el-button>
            </td>
            <td>
              <el-button
                type="danger"
                size="mini"
                @click="deleteRecord(rad.id)"
              >
                <i class="el-icon-delete"></i>
              </el-button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Add New Credits -->
    <div class="row mt-5 bg-light p-2">
      <table class="table col-12">
        <thead>
          <tr>
            <th>Return Type</th>
            <th>Quarter</th>
            <th>Year</th>
            <th>Period</th>
            <th>Date Return Filed</th>
            <th>Form Amount</th>
            <th>Credit Advance</th>
            <th>Claimed</th>
            <th>Credit Available</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">
              <el-dropdown @command="handleCommand">
                <span class="el-dropdown-link">
                  Return
                  <h4>{{ returnType.selected }}</h4>
                  <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item
                    :command="
                      companyTypeToFormConversion(
                        this.returnCurrentActiveCompany.company_type
                      )
                    "
                  >
                    {{
                      companyTypeToFormConversion(
                        this.returnCurrentActiveCompany.company_type
                      )
                    }}
                  </el-dropdown-item>
                  <el-dropdown-item command="941">941</el-dropdown-item>
                  <el-dropdown-item command="941X">941X</el-dropdown-item>
                </el-dropdown-menu>
              </el-dropdown>
              <small v-if="returnType.error" class="text-danger d-block"
                >Select a return type
              </small>
            </td>
            <td>
              <section v-show="quarter.display">
                <el-dropdown @command="handleQuarterCommand">
                  <span class="el-dropdown-link">
                    Quarter
                    <h4>{{ quarter.selected }}</h4>
                    <i class="el-icon-arrow-down el-icon--right"></i>
                  </span>
                  <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item command="Q1">Q1</el-dropdown-item>
                    <el-dropdown-item command="Q2">Q2</el-dropdown-item>
                    <el-dropdown-item command="Q3">Q3</el-dropdown-item>
                    <el-dropdown-item command="Q4">Q4</el-dropdown-item>
                  </el-dropdown-menu>
                </el-dropdown>
                <small v-if="quarter.error" class="text-danger d-block"
                  >Select a quarter
                </small>
              </section>
            </td>
            <td>
              <flatpickr
                class="minimalMarginTop"
                timeFormat="Y"
                v-on:updatedDate="updateYear"
                id="rad_year"
              />
              <small v-if="year.error" class="text-danger d-block"
                >Select a year
              </small>
            </td>
            <td>
              <flatpickr
                class="minimalMarginTop"
                timeFormat="m-d-Y"
                v-on:updatedDate="updatePeriod"
                id="rad_period"
              />
              <small v-if="period.error" class="text-danger d-block"
                >Select a date
              </small>
            </td>
            <td>
              <flatpickr
                class="minimalMarginTop"
                timeFormat="m-d-Y"
                v-on:updatedDate="updateDateReturnFiled"
                id="rad_date_filed"
              />
              <small v-if="dateReturnedFiled.error" class="text-danger d-block"
                >Select a date
              </small>
            </td>
            <!-- Form Amount -->
            <td>
              <el-input
                v-if="
                  returnType.selected !== '941' &&
                  returnType.selected !== '941X'
                "
                v-model="amount.input"
              />
              <b class="d-block" v-else>0</b>
              <small v-if="amount.error" class="text-danger d-block"
                >Enter a value
              </small>
            </td>
            <td>
              <el-input
                v-if="
                  returnType.selected !== '941' &&
                  returnType.selected !== '941X'
                "
                v-model="advanced.input"
              />
              <b class="d-block" v-else>0</b>
              <small v-if="advanced.error" class="text-danger d-block"
                >Enter a value
              </small>
            </td>
            <td>
              <el-input v-model="claimed.input" />
              <small v-if="claimed.error" class="text-danger d-block"
                >Enter a value
              </small>
            </td>
            <td>
              <p class="mt-2">{{ returnCalculatedCreditsAvailable }}</p>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="col-12">
        <el-button type="success" @click="onNewCredit">Add Credit</el-button>
      </div>
    </div>
  </div>
</template>

<script>
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import download from "downloadjs";
import { mapActions, mapGetters } from "vuex";
import draggable from "vuedraggable";
import axios from "axios";
import Flatpickr from "./Calendar/Flatpickr";
import * as $ from "jquery";
import "jquery-sortablejs";

export default {
  name: "ResearchAndDevelopmentCreditsComponent",
  components: { Flatpickr },
  data() {
    return {
      quick8: 0,
      quick9: 0,
      url: "https://momsinla-storage.s3-us-west-1.amazonaws.com/irs-8974/Filliable-Form-8974.pdf",
      quarter: {
        selected: "",
        display: true,
        error: false,
      },
      year: {
        year: "",
        error: false,
      },
      period: {
        date: "",
        error: false,
      },
      dateReturnedFiled: {
        date: "",
        error: false,
      },
      amount: {
        input: 0,
        error: false,
      },
      claimed: {
        input: 0,
        error: false,
      },
      advanced: {
        input: 0,
        error: false,
      },
      received: {
        input: "0",
        error: false,
      },
      returnType: {
        selected: "",
        error: false,
      },
      runningCreditAvailable: 0,
      activeAccumulation: 0,
      recordsObjArr: [],
    };
  },
  updated() {
    if (this.returnCurrentActiveCompany !== null) {
      if (
        this.returnCurrentActiveCompany.company_type ===
        this.returnType.selected
      ) {
        this.returnType.selected = this.companyTypeToFormConversion(
          this.returnCurrentActiveCompany.company_type
        );
      }
    }
  },
  computed: {
    ...mapGetters([
      "returnActiveCompanyResearchAndDevelopmentData",
      "returnCurrentActiveCompany",
      "returnTotalCompanyCreditsAvailable",
      "returnTotalCompanyCreditsRemaining",
      "returnTotalCompanyCreditsAmount",
      "returnTotalCompanyCreditsClaimed",
      "returnSlicedRecordsAtIndexGivenArr",
      "returnSlicedRecordsAtIndexGivenAccumulationValue",
      "returnTotalCompanyCreditsAdvanced",
    ]),
    returnActiveCompanyResearchAndDevelopmentDataSortable: {
      get() {
        return this.returnActiveCompanyResearchAndDevelopmentData;
      },
      set(value) {
        /*
         * Use a method to return a copy of the store data
         * This copy can be rearranged without affecting all other records.
         * Value returns the whole re-sorted items in an array [{...}],
         * Send them to STORE and update a local copy
         * This local copy is then returned and a column is saved into the DB that will
         * ... be used when initially retrieved to arrange the list based on how it was last arranged
         * */
        // console.warn('Setting sortable list ', value);
        let sortedIndexes = [];
        // Get a copy of the indexes to update the Company <sorted> and the Store <sorted>
        //TODO Make sure to update the record / values when there are records deleted!!!
        value.forEach((el) => {
          sortedIndexes.push(el.id);
        });
        this.onUpdateSortableList({ v: value, i: sortedIndexes });
        this.$notify({
          title: "Success",
          message: "Record sorting success",
          type: "success",
        });
      },
    },
    returnCalculatedCreditsAvailable() {
      const blacklist = ["941", "941X"];
      // returnTotalCompanyCreditsAdvanced
      const current = blacklist.includes(this.returnType.selected)
        ? (
            parseFloat(this.returnTotalCompanyCreditsAmount) +
            parseFloat(this.returnTotalCompanyCreditsAdvanced) -
            parseFloat(this.returnTotalCompanyCreditsClaimed) -
            parseFloat(this.amount.input)
          ).toFixed(2)
        : (
            parseFloat(this.returnTotalCompanyCreditsAmount) +
            parseFloat(this.returnTotalCompanyCreditsAdvanced) -
            parseFloat(this.returnTotalCompanyCreditsClaimed) +
            parseFloat(this.amount.input)
          ).toFixed(2);
      // console.warn(
      //   "returnCalculatedCreditsAvailable ",
      //   this.returnTotalCompanyCreditsAmount,
      //   this.returnTotalCompanyCreditsClaimed,
      //   this.amount.input
      // );
      // const n1 = (blacklist.includes(this.returnType.selected)) ? current : parseFloat(this.amount.input);
      const n1 = current;
      const n2 = parseFloat(this.claimed.input);
      const calculation = n1 - n2;
      return isNaN(calculation) ? 0 : calculation.toFixed(2);
    },
  },
  methods: {
    ...mapActions([
      "updateCompanyWithNewCreditAndForm",
      "updateResearchRecord",
      "deleteResearchRecord",
      "onUpdateResearchAndDevelopmentCreditReceived",
      "onUpdateResearchAndDevelopmentCreditAmount",
      "onUpdateResearchAndDevelopmentCreditClaimed",
      "onUpdateRDDateCheck",
      "onTriggerSort",
      "onUpdateSortableList",
      "returnSlicedRecordsAtIndexGiven",
      "resetSlicedRecordsAtIndexGivenAccumulation",
    ]),
    isDateEmpty(date, elemenId) {
      let _v = $(`#${elemenId}`);

      setTimeout(() => {
        date !== null ? $(`#${elemenId}`).val(date) : $(`#${elemenId}`).val("");
      }, 500);
    },
    companyTypeToFormConversion(type) {
      // console.log("companyTypeToFormConversion ", type);
      switch (type) {
        case "C":
          return "1120";
        case "S":
          return "1120S";
        case "P":
          return "1065";
        case "I":
          return "1040";
      }
    },
    onNewCredit() {
      if (this.validation()) {
        const errorCodes = [400, 404, 500];

        axios
          .post(`api/company/new-credit`, {
            company_id: this.returnCurrentActiveCompany.id,
            return_type: this.returnType.selected,
            quarter: this.quarter.selected,
            year: this.year.year,
            period: this.reformatDate(this.period.date),
            date_return_filed: this.reformatDate(this.dateReturnedFiled.date),
            credit_amount: this.amount.input,
            credit_claimed: this.claimed.input,
            credits_advanced: this.advanced.input,
            credit_available: this.returnCalculatedCreditsAvailable,
            credit_received: this.received.input,
          })
          .then((res) => {
            if (res.status === 200) {
              // [ {...}, {...} ] Returns Array of Objects
              /*
               * Validate
               * Send request
               * Update store if OK
               * Show notification Success/Error
               * Add check in store for 'n/a' values
               * */
              // console.log("On new credit!", res.data);
              this.updateCompanyWithNewCreditAndForm(res.data);
              this.$notify({
                title: "Success",
                message: `New Credit added to Company ${this.returnCurrentActiveCompany.name}`,
                type: "success",
              });
            }

            if (errorCodes.includes(res.status)) {
              this.$notify({
                title: "Failed",
                message: "Credit failed to save",
                type: "error",
              });
            }
          });
      } else {
        // Notify of error
        this.$notify({
          title: "Failed",
          message: "Please check for errors",
          type: "error",
        });
      }
    },
    updatePeriod(event) {
      this.period.date = event;
    },
    updateDateReturnFiled(event) {
      this.dateReturnedFiled.date = event;
    },
    reformatDate(d) {
      const _d = d.split("-");
      return `${_d[2]}-${_d[0]}-${_d[1]}`;
    },
    validation() {
      /* Return Type */
      if (this.returnType.selected === "") {
        this.returnType.error = true;
        return false;
      } else this.returnType.error = false;

      /* Quarter */
      if (this.quarter.selected === "") {
        this.quarter.error = true;
        return false;
      } else this.quarter.error = false;

      /* Year */
      if (this.year.year === "") {
        this.year.error = true;
        return false;
      } else this.year.error = false;

      /* Period */
      if (this.period.date === "") {
        this.period.error = true;
        return false;
      } else this.period.error = false;

      /* Date Return Filed */
      if (this.dateReturnedFiled.date === "") {
        this.dateReturnedFiled.error = true;
        return false;
      } else this.dateReturnedFiled.error = false;

      /* Amount */
      if (this.amount.input === "") {
        this.amount.error = true;
        return false;
      } else this.amount.error = false;

      /* Claimed */
      if (this.claimed.input === "") {
        this.claimed.error = true;
        return false;
      } else this.claimed.error = false;

      return true;
    },
    handleCommand(command) {
      // console.log("R&D handleCommand ", command);
      this.returnType.selected = command;
      switch (command) {
        case "941":
        case "941X":
          this.quarter.selected = "";
          this.quarter.display = true;
          this.amount.input = 0;
          break;
        default:
          this.quarter.selected = "--";
          this.quarter.display = false;
          this.amount.input = "";
      }
    },
    updateYear(event) {
      this.year.year = event;
    },
    handleQuarterCommand(command) {
      this.quarter.selected = command;
    },
    updateRecord(id) {
      const r = {
        id: id,
        period: $(`#check_period-${id}`).val() || "",
        formAmount: $(`#updatedAmount_${id}`).val(),
        claimed: $(`#updatedClaimed_${id}`).val(),
        advanced: $(`#creditAdvanced_${id}`).val(),
        recieved: $(`#updatedReceived_${id}`).val(),
        checkDate: $(`#check_date-${id}`).val() || "",
      };

      // console.log(r);

      this.updateResearchRecord(r); // record is the local data for the selected row to PATCH and UPDATE Store.
      this.$notify({
        title: "Success",
        message: "Row was updated.",
        type: "success",
      });
    },
    deleteRecord(id) {
      // console.log("deleteRecord ", id);
      this.deleteResearchRecord(id);

      this.$notify({
        title: "Success",
        message: "Credit was deleted.",
        type: "success",
      });
    },
    onUpdateCreditReceived(rID) {
      // rad is the R&D Object
      const ur = parseFloat(
        document.getElementById(`updatedReceived_${rID}`).value
      ).toFixed(2);
      this.onUpdateResearchAndDevelopmentCreditReceived({
        id: rID,
        received: ur,
      });
    },
    onUpdateAmountReceived(rID) {
      // rad is the R&D Object
      const ur = parseFloat(
        document.getElementById(`updatedAmount_${rID}`).value
      ).toFixed(2);
      this.onUpdateResearchAndDevelopmentCreditAmount({ id: rID, amount: ur });
    },
    onUpdateAmountClaimed(rID) {
      // rad is the R&D Object
      const ur = parseFloat(
        document.getElementById(`updatedClaimed_${rID}`).value
      ).toFixed(2);
      this.onUpdateResearchAndDevelopmentCreditClaimed({
        id: rID,
        claimed: ur,
      });
    },
    rowByRowCalculation(index) {
      const amountArr = [];
      const claimedArr = [];
      const advancedArr = [];
      // If FIRST RECORD
      // Record In Between
      // FINAL Record returnActiveCompanyResearchAndDevelopmentData.length for Max Array Length
      // updatedClaimed_
      // creditAdvanced_${rad.id} -> credit_advanced
      if (index === 0) {
        amountArr.push(
          this.returnActiveCompanyResearchAndDevelopmentData[index]
            .credit_amount
        );
        advancedArr.push(
          this.returnActiveCompanyResearchAndDevelopmentData[index]
            .credits_advanced
        );
        claimedArr.push(
          this.returnActiveCompanyResearchAndDevelopmentData[index]
            .credit_claimed
        );
        // return amountArr[0] - advancedArr[0] - claimedArr[0];
        return amountArr[0] - advancedArr[0] - claimedArr[0];
      } else {
        //Add in Previous & Current
        for (let i = 0; i <= index; i++) {
          amountArr.push(
            this.returnActiveCompanyResearchAndDevelopmentData[i].credit_amount
          );
          advancedArr.push(
            this.returnActiveCompanyResearchAndDevelopmentData[i]
              .credits_advanced
          );
          claimedArr.push(
            this.returnActiveCompanyResearchAndDevelopmentData[i].credit_claimed
          );
        }
        // Calculate Each
        const totalAmount = [];
        amountArr.forEach((c) => {
          parseFloat(c) ? totalAmount.push(parseFloat(c)) : 0;
        });

        const totalAdvancedAmount = [];
        advancedArr.forEach((c) => {
          parseFloat(c) ? totalAdvancedAmount.push(parseFloat(c)) : 0;
        });

        const totalClaimed = [];
        claimedArr.forEach((c) => {
          parseFloat(c) ? totalClaimed.push(parseFloat(c)) : 0;
        });

        const runningAmount = totalAmount.reduce((a, b) => a + b, 0);
        const runningAdvancedAmount = totalAdvancedAmount.reduce(
          (a, b) => a + b,
          0
        );
        const runningClaimed = totalClaimed.reduce((a, b) => a + b, 0);

        return (runningAmount - runningAdvancedAmount - runningClaimed).toFixed(
          2
        );
        // return (runningAmount - runningClaimed).toFixed(2);
      }
    },
    updateCheckDate(date) {
      //date_check
      // console.warn("updateCheckDate ", date);
    },
    onUpdateDateCheck(elemId, elemSelector) {
      const _v = document.getElementById(elemSelector).value;
      // console.warn("onUpdateDateCheck ", elemId, "  ", _v);
      this.onUpdateRDDateCheck({ id: elemId, data: _v });
    },
    handleDragStart(elemId) {
      let el = document.getElementById(`draggable-${elemId}`);
      el.style.backgroundColor = "#fff2a8";
    },
    dragend(draggedId, tableIndex) {
      // 2,1 means moved UP
      let el = document.getElementById(`draggable-${draggedId}`);
      let tr = document.getElementById(`table-row-${tableIndex}`);
      tr.style.backgroundColor = "#fff2a8";
      tr.style.transition = "all ease-in-out .5s";

      setTimeout(() => {
        //Reset color based on Index background-color: rgba(0, 0, 0, 0.05);
        //draggable row

        //Even
        if (tableIndex % 2 === 0) {
          el.style.backgroundColor = "rgba(0, 0, 0, 0.05)";
          tr.style.backgroundColor = "rgba(0, 0, 0, 0.05)";
        } else {
          el.style.backgroundColor = "white";
          tr.style.backgroundColor = "white";
        }

        el.style.transition = "all ease-in-out .25s";
        tr.style.transition = "all ease-in-out .25s";
      }, 1500);
    },
    onSaveSortedList() {
      // console.warn("onSaveSortedList");
      /*
       * Only uses 1120 records
       * Highlight records that are going to be used
       * Alert if nothing can be used
       * Alert when the form was generated
       * When you hover over the button highlight all of the 1120 records that will be used
       * */
    },
    convertToStringAndAddDecimal(columnG) {
      // console.error('ColumnG ', columnG)
      // console.error(
      //   "ISSUE >> convertToStringAndAddDecimal << ColumnG ",
      //   columnG
      // );
      let formatToString = columnG.toString();
      // let formatToString = columnG === undefined ? "" : columnG.toString();

      let formatToCurrency = formatToString.includes(".")
        ? formatToString
        : (formatToString += ".00");
      return formatToCurrency.replace(/\d(?=(\d{3})+\.)/g, "$&,");
    },
    exportTo8974Form: async function (index, recordID) {
      /**
       * Create Array of Objects [{...}] with the necesary information and calculations to post to forms when printing
       * Use RecordID to get a copy of all record objects UP to that RecordID
       * Run calculations and Seperate
       * STOP at 1120
       * ELSE  continue through till REACH 1120 THEN PUSH TO ARR
       */
      let tableRecords = [];

      // Cut the records based on the ones that were highlighted
      this.returnSlicedRecordsAtIndexGiven(recordID);

      const slicedRecords = this.returnSlicedRecordsAtIndexGivenArr;
      // console.log("SLICED ", slicedRecords);
      // console.error(slicedRecords);

      // this.returnSlicedRecordsAtIndexGivenAccumulationValue
      // console.warn(
      //   "Sliced Records Accumulation Value ",
      //   this.returnSlicedRecordsAtIndexGivenAccumulationValue
      // );

      // Export to PDF
      const existingPdfBytes = await fetch(this.url).then((res) =>
        res.arrayBuffer()
      );

      const pdfDoc = await PDFDocument.load(existingPdfBytes);

      const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);

      const pages = pdfDoc.getPages();
      const firstPage = pages[0];
      const { width, height } = firstPage.getSize();
      const COLOR = rgb(0, 0, 0);
      const baseOptions = {
        size: 10,
        font: helveticaFont,
        color: COLOR,
      };
      const baseOptionsSM = {
        size: 8,
        font: helveticaFont,
        color: COLOR,
      };
      const baseOptionsLG = {
        size: 15,
        font: helveticaFont,
        color: COLOR,
      };

      // record that pushed the button
      const _selectedRecord = document.getElementById(`table-row-${index}`);
      // calendar year selected
      let calendarYear = document
        .getElementById(`check_period-${recordID}`)
        .value.split("-")[0]; //yyyy-mm-dd
      let calendarMonth = parseInt(
        document.getElementById(`check_period-${recordID}`).value.split("-")[1]
      ); //yyyy-mm-dd
      let calendarMonthNumberQuarter = 0;

      let ein_mutated = this.returnCurrentActiveCompany.ein
        .slice(0)
        .replace(" - ", "");
      ein_mutated.split("");
      for (let i = 0; i < 9; i++) {
        let ein_XCoord = [160, 185, 225, 250, 275, 300, 325, 350, 375];

        firstPage.drawText(ein_mutated[i], {
          x: ein_XCoord[i],
          y: height / 2 + 312.5,
          ...baseOptionsSM,
        });
      }

      /*Draw Name*/
      firstPage.drawText(this.returnCurrentActiveCompany.name, {
        x: 145,
        y: height / 2 + 288,
        ...baseOptionsSM,
      });

      if (calendarMonth > 0 && calendarMonth < 4) {
        calendarMonthNumberQuarter = 0;
      } else if (calendarMonth < 7) {
        calendarMonthNumberQuarter = 1;
      } else if (calendarMonth < 10) {
        calendarMonthNumberQuarter = 2;
      } else if (calendarMonth >= 10) {
        calendarMonthNumberQuarter = 3;
      }

      /*Draw Credit Type*/
      const ctYCoord = [252, 228, 204];
      firstPage.drawText("X", {
        x: 180,
        y: height / 2 + ctYCoord[1 - 1],
        ...baseOptionsLG,
      });

      /* Draw Report For This Quarter */
      const rqYCoord = [283, 265, 247, 229];
      firstPage.drawText("X", {
        x: 424,
        y: height / 2 + rqYCoord[calendarMonthNumberQuarter],
        ...baseOptionsLG,
      });

      /*Draw Calendar year*/
      firstPage.drawText(calendarYear, {
        x: 110,
        y: height / 2 + 180,
        ...baseOptionsSM,
      });

      // Part 1
      const xOffset = 70;
      const xOffsetSp = 60;
      const yOffset = 18;
      const START_X = 80;
      let records = [];
      let remainders = [];
      let advancedArr = [];
      // Get records to save
      for (let idx = 0; idx <= index; idx++) {
        let row = document.getElementById(`table-row-${idx}`);
        /*
         * row.cells[...n]
         * 0 - return type ... .cells[0].innerText
         * 2 - period ... .cells[2].childNodes[0].childNodes[0].value 'yyyy-mm-dd'
         * 3 - date return filed ... document.getElementById('table-row-0').cells[3].textContent
         * 4 - form amount ... .cells[4].childNodes[0].childNodes[0].value
         * 5 - claimed ... .cells[5].childNodes[0].childNodes[0].value
         *
         * */
        const rType = row.firstChild.innerText;
        const returnType = row.cells[0].innerText;
        const period = row.cells[2].childNodes[0].childNodes[0].value;
        const dateReturnFiled = row.cells[3].textContent;
        const formAmount = row.cells[4].childNodes[0].childNodes[0].value;

        const advanced = row.cells[5].childNodes[0].value;
        // Should now be 6 because of the new addional field inbetween
        const claimed = row.cells[6].childNodes[0].childNodes[0].value;

        if (rType === "1120" || rType === "1120S") {
          // Push a copy of the record to iterate over
          const calculation = Number(
            parseFloat(formAmount) - parseFloat(claimed)
          ).toFixed(2);
          records.push({
            returnType,
            period,
            dateReturnFiled,
            formAmount,
            claimed,
            calculation,
          });
        } // if ... 1120
        if (idx !== index) {
          // Push advanced credit fields as elements to array for calculations later
          advancedArr.push(parseFloat(advanced || 0).toFixed(2));
          // console.warn("Advanced ", advanced, "  ", advancedArr);
        }
      }

      // Calculate all advancedArr elements to use below
      const calcAdvancedArr = advancedArr
        .reduce(function (a, b) {
          return parseFloat(a || 0) + parseFloat(b || 0);
        }, 0)
        .toFixed(2);

      // console.error("We have an advanced calculation of ", calcAdvancedArr);

      // Holds Column G Calculations in an Array [...]
      let columnGCalculations = [];
      // Hold Col Fs when doing calculations for later fields if necessary
      let columnFCalculations = [];

      // Holds the calculations for columns F and G
      let colFandG = [];
      // console.error(
      //   "We have a TOTAL accumulation of ",
      //   this.returnSlicedRecordsAtIndexGivenAccumulationValue
      // );

      records.forEach((el, elIndex) => {
        // Part 1 Table
        /*
         * This needs to find the total number of 1120s and go based off that
         * Should not exceed 5!
         * */
        // console.warn("Records with an index of ", elIndex);

        // Calculation of E – F
        remainders.push(parseFloat(el.calculation || 0));

        switch (elIndex) {
          case 0:
            console.warn("Triggered 0");
            /* Draw A */
            firstPage.drawText(el.period, {
              x: START_X,
              y: height / 2 + 54,
              ...baseOptions,
            });
            /* Draw B */
            firstPage.drawText(el.returnType, {
              x: START_X + xOffset,
              y: height / 2 + 54,
              ...baseOptions,
            });
            /* Draw C */
            firstPage.drawText(el.dateReturnFiled, {
              x: START_X + xOffset * 2 - 10,
              y: height / 2 + 54,
              ...baseOptions,
            });
            /* Draw D */
            firstPage.drawText(this.returnCurrentActiveCompany.ein, {
              x: START_X + xOffset * 3 - 7,
              y: height / 2 + 54,
              ...baseOptions,
            });
            /* Draw E */
            firstPage.drawText(el.formAmount, {
              x: START_X + xOffset * 4 - 10,
              y: height / 2 + 54,
              ...baseOptions,
            });

            colFandG = this.handleAccumulationCalculation(
              elIndex,
              this.returnSlicedRecordsAtIndexGivenAccumulationValue,
              el.formAmount,
              [records[0].formAmount],
              calcAdvancedArr
            );

            columnFCalculations.push(records[0].formAmount);
            console.warn("*********** ", colFandG);

            /* Draw F */
            // firstPage.drawText(slicedRecords[0].CALCULATION.toString() || "0", {
            firstPage.drawText(colFandG[0].toString() || "0", {
              x: START_X + xOffset * 5 + 17 - 10,
              y: height / 2 + 54,
              ...baseOptions,
            });

            // Calculate E – F and put into columnGCalculations
            // columnGCalculations.push(
            //   parseFloat(el.formAmount - slicedRecords[0].CALCULATION).toFixed(
            //     2
            //   )
            // );
            columnGCalculations.push(parseFloat(colFandG[1]).toFixed(2));

            // console.warn("Record Slot 1 G: ", columnGCalculations[0]);

            /* Draw G */
            // firstPage.drawText(columnGCalculations[0].toString() || "0.0", {
            firstPage.drawText(colFandG[1].toString() || "0.0", {
              x: START_X + xOffset * 6 + 10,
              y: height / 2 + 54,
              ...baseOptions,
            });

            break;
          case 1:
            // console.warn("Triggered 1");
            /* Draw A */
            firstPage.drawText(el.period, {
              x: START_X,
              y: height / 2 + 54 - yOffset,
              ...baseOptions,
            });
            /* Draw B */
            firstPage.drawText(el.returnType, {
              x: START_X + xOffset,
              y: height / 2 + 54 - yOffset,
              ...baseOptions,
            });
            /* Draw C */
            firstPage.drawText(el.dateReturnFiled, {
              x: START_X + xOffset * 2 - 10,
              y: height / 2 + 54 - yOffset,
              ...baseOptions,
            });
            /* Draw D */
            firstPage.drawText(this.returnCurrentActiveCompany.ein, {
              x: START_X + xOffset * 3 - 7,
              y: height / 2 + 54 - yOffset,
              ...baseOptions,
            });
            /* Draw E */
            firstPage.drawText(el.formAmount, {
              x: START_X + xOffset * 4 - 10,
              y: height / 2 + 54 - yOffset,
              ...baseOptions,
            });

            // Calculates Column F
            colFandG = this.handleAccumulationCalculation(
              elIndex,
              this.returnSlicedRecordsAtIndexGivenAccumulationValue,
              el.formAmount,
              [records[0].formAmount, records[1].formAmount],
              calcAdvancedArr
            );

            // console.warn("Column F and G calculations returned ", colFandG);

            columnFCalculations.push(colFandG[0]);

            /* Draw F */
            // firstPage.drawText(el.claimed, {
            // firstPage.drawText(slicedRecords[1].CALCULATION.toString() || "0", {
            if (this.returnCurrentActiveCompany.name === "Baylx Inc") {
              // slicedRecords
              firstPage.drawText(
                slicedRecords[elIndex].CALCULATION.toString() || "0",
                {
                  x: START_X + xOffset * 5 + 5,
                  y: height / 2 + 54 - yOffset,
                  ...baseOptions,
                }
              );
            } else {
              firstPage.drawText(colFandG[0].toString() || "0", {
                x: START_X + xOffset * 5 + 5,
                y: height / 2 + 54 - yOffset,
                ...baseOptions,
              });
            }

            if (this.returnCurrentActiveCompany.name === "Baylx Inc") {
              // Weird edge case where only on Bayyx it has issues
              // Calculate E – F and put into columnGCalculations
              // returnSlicedRecordsAtIndexGiven returns the records sums to be added [{...CALCULATION }, {...}]
              columnGCalculations.push(
                parseFloat(
                  el.formAmount - slicedRecords[1].CALCULATION
                ).toFixed(2)
              );
            } else {
              columnGCalculations.push(parseFloat(colFandG[1]).toFixed(2));
            }

            // console.warn("Record Slot 2 G: ", columnGCalculations[1]);

            /* Draw G */
            // firstPage.drawText(columnGCalculations[1].toString() || "0.0", {
            if (this.returnCurrentActiveCompany.name === "Baylx Inc") {
              // Draw the correct amount due to some wierd issue only with Baylyx
              firstPage.drawText(
                columnGCalculations[
                  columnGCalculations.length - 1
                ].toString() || "0.0",
                {
                  x: START_X + xOffset * 6 + 10,
                  y: height / 2 + 54 - yOffset,
                  ...baseOptions,
                }
              );
            } else {
              firstPage.drawText(colFandG[1].toString() || "0.0", {
                x: START_X + xOffset * 6 + 10,
                y: height / 2 + 54 - yOffset,
                ...baseOptions,
              });
            }

            break;
          case 2:
            // console.warn("Triggered 2");
            /* Draw A */
            firstPage.drawText(el.period, {
              x: START_X,
              y: height / 2 + 54 - yOffset * 2,
              ...baseOptions,
            });
            /* Draw B */
            firstPage.drawText(el.returnType, {
              x: START_X + xOffset,
              y: height / 2 + 54 - yOffset * 2,
              ...baseOptions,
            });
            /* Draw C */
            firstPage.drawText(el.period, {
              x: START_X + xOffset * 2 - 10,
              y: height / 2 + 54 - yOffset * 2,
              ...baseOptions,
            });
            /* Draw D */
            firstPage.drawText(this.returnCurrentActiveCompany.ein, {
              x: START_X + xOffset * 3 - 7,
              y: height / 2 + 54 - yOffset * 2,
              ...baseOptions,
            });
            /* Draw E */
            firstPage.drawText(el.formAmount, {
              x: START_X + xOffset * 4 - 10,
              y: height / 2 + 54 - yOffset * 2,
              ...baseOptions,
            });

            colFandG = this.handleAccumulationCalculation(
              elIndex,
              this.returnSlicedRecordsAtIndexGivenAccumulationValue,
              el.formAmount,
              [columnFCalculations[0], columnFCalculations[1]],
              calcAdvancedArr
            );

            columnFCalculations.push(colFandG[0]);

            /* Draw F */
            // firstPage.drawText(slicedRecords[2].CALCULATION.toString() || "0", {
            firstPage.drawText(colFandG[0].toString() || "0", {
              x: START_X + xOffset * 5 + 5,
              y: height / 2 + 54 - yOffset * 2,
              ...baseOptions,
            });
            // Calculate E – F and put into columnGCalculations
            // columnGCalculations.push(
            //   parseFloat(el.formAmount - slicedRecords[2].CALCULATION).toFixed(
            //     2
            //   )
            // );
            columnGCalculations.push(parseFloat(colFandG[1]).toFixed(2));

            /* Draw G */
            // firstPage.drawText(columnGCalculations[2].toString() || "0.0", {
            firstPage.drawText(colFandG[1].toString() || "0.0", {
              x: START_X + xOffset * 6 + 10,
              y: height / 2 + 54 - yOffset * 2,
              ...baseOptions,
            });
            break;
          case 3:
            // console.warn("Triggered 3");
            /* Draw A */
            firstPage.drawText(el.period, {
              x: START_X,
              y: height / 2 + 54 - yOffset * 3,
              ...baseOptions,
            });
            /* Draw B */
            firstPage.drawText(el.returnType, {
              x: START_X + xOffset,
              y: height / 2 + 54 - yOffset * 3,
              ...baseOptions,
            });
            /* Draw C */
            firstPage.drawText(el.dateReturnFiled, {
              x: START_X + xOffset * 2 - 10,
              y: height / 2 + 54 - yOffset * 3,
              ...baseOptions,
            });
            /* Draw D */
            firstPage.drawText(this.returnCurrentActiveCompany.ein, {
              x: START_X + xOffset * 3 - 7,
              y: height / 2 + 54 - yOffset * 3,
              ...baseOptions,
            });
            /* Draw E */
            firstPage.drawText(el.formAmount, {
              x: START_X + xOffset * 4 - 10,
              y: height / 2 + 54 - yOffset * 3,
              ...baseOptions,
            });

            colFandG = this.handleAccumulationCalculation(
              elIndex,
              this.returnSlicedRecordsAtIndexGivenAccumulationValue,
              el.formAmount,
              [
                columnFCalculations[0],
                columnFCalculations[1],
                columnFCalculations[2],
              ],
              calcAdvancedArr
            );

            columnFCalculations.push(colFandG[0]);

            /* Draw F */
            // firstPage.drawText(slicedRecords[3].CALCULATION.toString() || "0", {
            firstPage.drawText(colFandG[0].toString() || "0", {
              x: START_X + xOffset * 5 + 5,
              y: height / 2 + 54 - yOffset * 3,
              ...baseOptions,
            });

            // Calculate E – F and put into columnGCalculations
            // columnGCalculations.push(
            //   parseFloat(el.formAmount - slicedRecords[3].CALCULATION).toFixed(
            //     2
            //   )
            // );
            columnGCalculations.push(parseFloat(colFandG[1]).toFixed(2));

            /* Draw G */
            // firstPage.drawText(columnGCalculations[3].toString() || "0.0", {
            firstPage.drawText(colFandG[1].toString() || "0.0", {
              x: START_X + xOffset * 6 + 10,
              y: height / 2 + 54 - yOffset * 3,
              ...baseOptions,
            });
            break;
          case 4:
            // console.warn("Triggered 4");
            /* Draw A */
            firstPage.drawText(el.period, {
              x: START_X,
              y: height / 2 + 54 - yOffset * 4,
              ...baseOptions,
            });
            /* Draw B */
            firstPage.drawText(el.returnType, {
              x: START_X + xOffset,
              y: height / 2 + 54 - yOffset * 4,
              ...baseOptions,
            });
            /* Draw C */
            firstPage.drawText(el.dateReturnFiled, {
              x: START_X + xOffset * 2 - 10,
              y: height / 2 + 54 - yOffset * 4,
              ...baseOptions,
            });
            /* Draw D */
            firstPage.drawText(this.returnCurrentActiveCompany.ein, {
              x: START_X + xOffset * 3 - 7,
              y: height / 2 + 54 - yOffset * 4,
              ...baseOptions,
            });
            /* Draw E */
            firstPage.drawText(el.formAmount, {
              x: START_X + xOffset * 4 - 10,
              y: height / 2 + 54 - yOffset * 4,
              ...baseOptions,
            });
            /* Draw F */
            firstPage.drawText(slicedRecords[4].CALCULATION.toString() || "0", {
              x: START_X + xOffset * 5 + 5,
              y: height / 2 + 54 - yOffset * 4,
              ...baseOptions,
            });

            // Calculate E – F and put into columnGCalculations
            columnGCalculations.push(
              parseFloat(el.formAmount - slicedRecords[4].CALCULATION).toFixed(
                2
              )
            );
            // columnGCalculations.push(parseFloat(colFandG[1]).toFixed(2));

            /* Draw G */
            firstPage.drawText(columnGCalculations[4].toString() || "0.0", {
              x: START_X + xOffset * 6 + 10,
              y: height / 2 + 54 - yOffset * 4,
              ...baseOptions,
            });
            break;
        }
      });

      // Calculate the G colunn Only

      // Print the G Columns

      /* Map Totals and Part 2-7 */
      // const total = this.convertToStringAndAddDecimal(this.rowSixTotal);
      console.error("We got these so far ", columnGCalculations);
      const sum = columnGCalculations
        .reduce(function (a, b) {
          return parseFloat(a || 0) + parseFloat(b || 0);
        }, 0)
        .toFixed(2);

      // console.error("We are doing the final calculations");

      // console.warn('Our total SUM IS ', typeof sum, ' ', sum);
      // #6
      // columnGCalculations
      firstPage.drawText(sum.toString(), {
        x: START_X + xOffset * 6 + 10,
        y: height / 2 + 54 - yOffset * 5,
        ...baseOptions,
      });
      /*P2-7*/
      firstPage.drawText(sum.toString(), {
        x: START_X + xOffset * 6 - 5,
        y: height / 2 + 54 - yOffset * 7 - 5,
        ...baseOptions,
      });

      /* Draw 8 */
      firstPage.drawText(this.convertToStringAndAddDecimal(this.quick8), {
        x: START_X + xOffset * 4 - 10,
        y: height / 2 + 54 - yOffset * 10 + 1,
        ...baseOptions,
      });

      /* Draw 9 */
      firstPage.drawText(this.convertToStringAndAddDecimal(this.quick9), {
        x: START_X + xOffset * 4 - 10,
        y: height / 2 + 54 - yOffset * 13 + 7,
        ...baseOptions,
      });

      const n10 = parseFloat(this.quick8) + parseFloat(this.quick9);

      /* Draw 10 */
      firstPage.drawText(this.convertToStringAndAddDecimal(n10), {
        x: START_X + xOffset * 4 - 10,
        y: height / 2 + 54 - yOffset * 15 + 13,
        ...baseOptions,
      });

      const n11 = parseFloat(
        (parseFloat(this.quick8) + parseFloat(this.quick9)) * 0.5
      ).toFixed(2);

      /* Draw 11 */
      firstPage.drawText(this.convertToStringAndAddDecimal(n11), {
        x: START_X + xOffset * 6 - 10,
        y: height / 2 + 54 - yOffset * 18 + 6,
        ...baseOptions,
      });

      const n12 = Number(sum) > Number(n11) ? n11 : sum;

      /* Draw 12 */
      firstPage.drawText(this.convertToStringAndAddDecimal(n12), {
        x: START_X + xOffset * 6 - 10,
        y: height / 2 + 54 - yOffset * 20 + 5,
        ...baseOptions,
      });

      // Baylyx should be 33789.82

      // Reset state.returnSlicedRecordsAtIndexGivenAccumulation  to 0
      this.resetSlicedRecordsAtIndexGivenAccumulation();

      /* Save report and Download*/
      const pdfBytes = await pdfDoc.save();

      // Trigger the browser to download the PDF document
      download(pdfBytes, `IRS-8974-${Date.now()}.pdf`, "application/pdf");
    },
    onMouseoverHighlight(index, returnType) {
      /**
       * Determine IF calculations should be made BASED on how many 1120s exist.
       * Grab all record IDs for quick grabbing info during iteration
       * Use 2 seperate data arrays, one for 1120 one for the calculations with all IDS
       */
      for (let i = 0; i <= index; i++) {
        let row = document.getElementById(`table-row-${i}`);
        const rType = row.firstChild.innerText;
        if (rType === "1120") {
          row.style.backgroundColor = "#c2ffb4";
          row.style.transition = "all ease-in-out .5s";
        }
      }

      // console.warn("onMouseoverHighlight ", index, " ", returnType);
    },
    onMouseoverLeaveUnhighlight(index, returnType) {
      // console.warn("onMouseoverLeaveUnhighlight", index, " ", returnType);

      //Reset color based on Index background-color: rgba(0, 0, 0, 0.05);
      //draggable row

      for (let i = 0; i <= index; i++) {
        let row = document.getElementById(`table-row-${i}`);
        const rType = row.firstChild.innerText;
        if (rType === "1120") {
          //Even
          if (i % 2 === 0) {
            row.style.backgroundColor = "rgba(0, 0, 0, 0.05)";
          } else {
            row.style.backgroundColor = "white";
          }

          row.style.transition = "all ease-in-out .05s";
        }
      }
    },
    handleAccumulationCalculation(
      index,
      totalAccumulation,
      formAmount,
      columnFValuesArray,
      calculatedAdvancedValues
    ) {
      //columnFValuesArray is passed in as an array of past and present Col  F values as an array
      /**
       * --------------------------------------------------------
       * SUM(C3:C15) = totalAccumulation
       * H3...H5 = formAmount
       * I3...I5 = columnFValuesArray
       *
       * ========================================================
       * A | =IF(SUM(C3:C15)>H3,H3,SUM(C3:C15))
       * B | =IF((SUM(C3:C15)-I3)>H4,H4,SUM(C3:C15)-I3)
       * C | =IF((SUM(C3:C15)-(I3+I4))>H5,H5, SUM(C3:C15)-(I3+I4))
       * D | =IF((SUM(C3:C15)-(I3+I4 +I5))>H5,H5, SUM(C3:C15)-(I3+I4+I5))
       * ========================================================
       */
      // Hold local valus to be returned
      // console.warn(
      //   "handleAccumulationCalculation totalAccumulation is ",
      //   totalAccumulation
      // );
      let columnF = 0;
      let columnG = 0;

      // A
      if (index === 0) {
        columnF =
          parseFloat(totalAccumulation - calculatedAdvancedValues) >
          parseFloat(formAmount)
            ? formAmount
            : parseFloat(totalAccumulation) -
              parseFloat(calculatedAdvancedValues);
        columnG = parseFloat(formAmount - columnF).toFixed(2);
        console.warn("ROW 0 TA ", calculatedAdvancedValues);
      }

      // B | =IF((SUM(C3:C15)-I3)>H4,H4,SUM(C3:C15)-I3)
      if (index === 1) {
        let ta = parseFloat(
          parseFloat(totalAccumulation) -
            parseFloat(calculatedAdvancedValues) -
            parseFloat(columnFValuesArray[0])
        ).toFixed(2);

        // Subtract the advanced calculation
        // ta = ta - calculatedAdvancedValues;

        // console.warn("ROW 2 TA ", calculatedAdvancedValues);
        console.warn("ROW  TA ", calculatedAdvancedValues);

        // IF((SUM(G8)-I3)>H4,H4,SUM(G8)-I3)
        // columnF = ta > formAmount ? formAmount : ta < 0 ? 0 : ta;
        columnF =
          ta > parseFloat(formAmount)
            ? parseFloat(formAmount < 0 ? 0 : formAmount).toFixed(2)
            : ta < 0
            ? 0
            : ta;
        columnG = parseFloat(formAmount - columnF).toFixed(2);
      }

      // C | =IF(($H$7-(I3+I4))>H5,H5, $H$7-(I3+I4))
      if (index === 2) {
        let ta = parseFloat(
          totalAccumulation - calculatedAdvancedValues
        ).toFixed(2);
        let sum = parseFloat(
          parseFloat(columnFValuesArray[0]) + parseFloat(columnFValuesArray[1])
        ).toFixed(2);
        // Subtract sum from ta
        ta = parseFloat(parseFloat(ta) - parseFloat(sum)).toFixed(2);
        columnF =
          ta > parseFloat(formAmount)
            ? parseFloat(formAmount).toFixed(2)
            : ta < 0
            ? 0
            : ta;
        columnG = parseFloat(formAmount - columnF).toFixed(2);
      }

      // D | =IF((SUM(C3:C15)-(I3+I4 +I5))>H5,H5, SUM(C3:C15)-(I3+I4+I5))
      if (index === 3) {
        let ta = parseFloat(
          totalAccumulation - calculatedAdvancedValues
        ).toFixed(2);
        let sum = parseFloat(
          parseFloat(columnFValuesArray[0]) +
            parseFloat(columnFValuesArray[1]) +
            parseFloat(columnFValuesArray[2])
        ).toFixed(2);
        ta = parseFloat(parseFloat(ta) - parseFloat(sum)).toFixed(2);
        columnF =
          ta > parseFloat(formAmount)
            ? parseFloat(formAmount).toFixed(2)
            : ta < 0
            ? 0
            : ta;
        columnG = parseFloat(formAmount - columnF).toFixed(2);
      }

      // Should return 2 numbers [columnF, columnG]
      return [columnF, columnG];
    },
    onAddNewRecordToBeParsedLater(recordObj) {
      console.warn("New Record being added ", recordObj);
      this.recordsObjArr.push(recordObj);
    },
    onStore8974(index, recordID) {
      // Clear varable
      this.recordsObjArr = [];
      // Output all data out
      let tableRecords = [];

      // Cut the records based on the ones that were highlighted
      this.returnSlicedRecordsAtIndexGiven(recordID);

      const slicedRecords = this.returnSlicedRecordsAtIndexGivenArr;

      // record that pushed the button
      const _selectedRecord = document.getElementById(`table-row-${index}`);

      // calendar year selected
      let calendarYear = document
        .getElementById(`check_period-${recordID}`)
        .value.split("-")[0]; //yyyy-mm-dd

      let calendarMonth = parseInt(
        document.getElementById(`check_period-${recordID}`).value.split("-")[1]
      ); //yyyy-mm-dd
      let ein_mutated = this.returnCurrentActiveCompany.ein;

      // Name
      // this.returnCurrentActiveCompany.name;
      // Quarter
      let calendarMonthNumberQuarter = 0;

      // Quarter
      if (calendarMonth > 0 && calendarMonth < 4) {
        calendarMonthNumberQuarter = 0;
      } else if (calendarMonth < 7) {
        calendarMonthNumberQuarter = 1;
      } else if (calendarMonth < 10) {
        calendarMonthNumberQuarter = 2;
      } else if (calendarMonth >= 10) {
        calendarMonthNumberQuarter = 3;
      }

      // Save table as Array of objects
      // {a,b,c,d,e,f,g}
      let records = [];
      let remainders = [];
      let advancedArr = [];

      // Get records to save
      for (let idx = 0; idx <= index; idx++) {
        let row = document.getElementById(`table-row-${idx}`);
        /*
         * row.cells[...n]
         * 0 - return type ... .cells[0].innerText
         * 2 - period ... .cells[2].childNodes[0].childNodes[0].value 'yyyy-mm-dd'
         * 3 - date return filed ... document.getElementById('table-row-0').cells[3].textContent
         * 4 - form amount ... .cells[4].childNodes[0].childNodes[0].value
         * 5 - claimed ... .cells[5].childNodes[0].childNodes[0].value
         *
         * */
        const rType = row.firstChild.innerText;
        const returnType = row.cells[0].innerText;
        const period = row.cells[2].childNodes[0].childNodes[0].value;
        const dateReturnFiled = row.cells[3].textContent;
        const formAmount = row.cells[4].childNodes[0].childNodes[0].value;
        // const claimed = row.cells[5].childNodes[0].childNodes[0].value;
        const advanced = row.cells[5].childNodes[0].value;

        // Should now be 6 because of the new addional field inbetween
        const claimed = row.cells[6].childNodes[0].childNodes[0].value;

        if (rType === "1120" || rType === "1120S") {
          // Push a copy of the record to iterate over
          const calculation = Number(
            parseFloat(formAmount) - parseFloat(claimed)
          ).toFixed(2);
          records.push({
            returnType,
            period,
            dateReturnFiled,
            formAmount,
            claimed,
            calculation,
          });
        } // if ... 1120
        if (idx !== index) {
          // Push advanced credit fields as elements to array for calculations later
          advancedArr.push(parseFloat(advanced || 0).toFixed(2));
          // console.warn("Advanced ", advanced, "  ", advancedArr);
        }
      }

      // Calculate all advancedArr elements to use below
      const calcAdvancedArr = advancedArr
        .reduce(function (a, b) {
          return parseFloat(a || 0) + parseFloat(b || 0);
        }, 0)
        .toFixed(2);

      let columnGCalculations = [];
      let columnFCalculations = [];
      let colFandG = [];

      records.forEach((el, elIndex) => {
        // For writting to database later
        let recordObj = { a: 0, b: 0, c: 0, d: 0, e: 0, f: 0, g: 0 };
        // Part 1 Table
        /*
         * This needs to find the total number of 1120s and go based off that
         * Should not exceed 5!
         * */
        // console.warn("Records with an index of ", elIndex);

        // Calculation of E – F
        remainders.push(parseFloat(el.calculation || 0));

        let colFandG = [];

        // Common object properties here
        /* Draw A */
        recordObj.a = el.period;
        recordObj.b = el.returnType;
        recordObj.c = el.dateReturnFiled;
        recordObj.d = this.returnCurrentActiveCompany.ein;
        recordObj.e = el.formAmount;

        if (elIndex === 0) {
          colFandG = this.handleAccumulationCalculation(
            elIndex,
            this.returnSlicedRecordsAtIndexGivenAccumulationValue,
            el.formAmount,
            [records[0].formAmount],
            calcAdvancedArr
          );
        } else if (elIndex === 1) {
          colFandG = this.handleAccumulationCalculation(
            elIndex,
            this.returnSlicedRecordsAtIndexGivenAccumulationValue,
            el.formAmount,
            [records[0].formAmount, records[1].formAmount],
            calcAdvancedArr
          );
        } else if (elIndex === 2) {
          colFandG = this.handleAccumulationCalculation(
            elIndex,
            this.returnSlicedRecordsAtIndexGivenAccumulationValue,
            el.formAmount,
            [columnFCalculations[0], columnFCalculations[1]],
            calcAdvancedArr
          );
        } else if (elIndex === 3) {
          colFandG = this.handleAccumulationCalculation(
            elIndex,
            this.returnSlicedRecordsAtIndexGivenAccumulationValue,
            el.formAmount,
            [
              columnFCalculations[0],
              columnFCalculations[1],
              columnFCalculations[2],
            ],
            calcAdvancedArr
          );
        }

        if (elIndex === 4) {
          recordObj.f = slicedRecords[4].CALCULATION.toString();
          recordObj.g = columnGCalculations[4].toString();
        } else {
          recordObj.f = colFandG[0].toString();
          recordObj.g = colFandG[1].toString();
        }
        columnFCalculations.push(records[0].formAmount);
        columnGCalculations.push(parseFloat(colFandG[1]).toFixed(2));
        console.warn("Before pushing record ", recordObj);
        this.onAddNewRecordToBeParsedLater(recordObj);
      });

      // #6
      const sum = columnGCalculations
        .reduce(function (a, b) {
          return parseFloat(a || 0) + parseFloat(b || 0);
        }, 0)
        .toFixed(2);
      // #7
      sum.toString();
      // #8
      this.convertToStringAndAddDecimal(this.quick8);
      // #9
      this.convertToStringAndAddDecimal(this.quick9);
      // #10
      const n10 = parseFloat(this.quick8) + parseFloat(this.quick9);
      this.convertToStringAndAddDecimal(n10);
      // #11
      const n11 = parseFloat(
        (parseFloat(this.quick8) + parseFloat(this.quick9)) * 0.5
      ).toFixed(2);
      this.convertToStringAndAddDecimal(n11);
      // #12
      const n12 = Number(sum) > Number(n11) ? n11 : sum;
      this.convertToStringAndAddDecimal(n12);
      this.resetSlicedRecordsAtIndexGivenAccumulation();

      console.error("Records to be saved ", this.recordsObjArr);

      axios.post("api/company/stored/new/8974", {
        company_id: this.returnCurrentActiveCompany.id,
        form_name: "8974",
        form_year: "2021",
        eid: ein_mutated,
        name: this.returnCurrentActiveCompany.name,
        credit_checkbox: 0,
        quarter: calendarMonthNumberQuarter,
        part_one: JSON.stringify(this.recordsObjArr),
        part_one_total: sum.toString(),
        seven: sum.toString(),
        eight: this.convertToStringAndAddDecimal(this.quick8),
        nine: this.convertToStringAndAddDecimal(this.quick9),
        ten: this.convertToStringAndAddDecimal(n10),
        eleven: this.convertToStringAndAddDecimal(n11),
        eleven_checkbox: JSON.stringify([]),
        twelve: this.convertToStringAndAddDecimal(n12),
      });

      this.$notify({
        title: "Success",
        message: "Record stored successfully.",
        type: "success",
      });
    },
  },
};
</script>

<style scoped>
button {
  border-radius: 0;
}

/*even*/
.alterate-color {
  cursor: move;
}
.alterate-color:nth-child(2n + 1) {
  background-color: #eaeaea;
}
</style>
