<template>
  <div class="container">
    <div class="row d-none">
      <!-- Trigger the component update -->
      {{ returnEmployerIdentificationNumber() }}
      {{ returnName() }}
      {{ returnCalendarYear() }}
    </div>

    <div class="position-fixed" style="right: 1rem; bottom: 1rem">
      <button
        class="btn btn-secondary d-inline clear mb-3"
        @click="onStore8974Record"
      >
        Store
      </button>

      <div v-show="disableDownload !== 'Y'">
        <button class="btn btn-primary d-inline export" @click="exportToPDF">
          Export
        </button>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 mt-3">
        <h4 class="alert-info p-2 text-center">Form 8974</h4>
      </div>

      <!--TOP OF FORM-->
      <div class="col-lg-9 col-12 bg-white mt-4 p-3">
        <div class="row">
          <div class="col-7">
            {{ limitEIN }}
            <!--EIN-->
            <div class="form-group">
              <label for="" class="bg-dark p-2 text-white"
                >Employer identification number (EIN)</label
              >
              <input
                maxlength="12"
                minlength="12"
                type="text"
                v-model="ein"
                :class="{
                  'alert-danger': errors.ein,
                  'alert-success': errors.ein === false,
                }"
                class="form-control mt-2"
                placeholder=""
                aria-describedby="helpId"
              />
            </div>

            <!--Name-->
            <div class="form-group mt-3">
              <label for="" class="bg-dark p-2 text-white"
                >Name (not your trade name)</label
              >
              <input
                type="text"
                class="form-control mt-2"
                :class="{
                  'alert-danger': errors.companyName,
                  'alert-success': errors.companyName === false,
                }"
                v-model="companyName"
              />
            </div>

            <!--Credity Type-->
            <div class="form-check mt-3">
              <h6
                v-if="errors.creditTypeBox"
                class="p-1"
                :class="{
                  'alert-danger': errors.creditTypeBox,
                  'alert-success': errors.creditTypeBox === false,
                }"
              >
                Please select a option.
              </h6>
              <h6 class="font-weight-bold bg-dark p-2 text-white">
                The credit from Part 2, line 12, will be reported on (check only
                one box):
              </h6>
              <label class="form-check-label d-block mt-2">
                <input
                  type="radio"
                  class="form-check-input"
                  v-model="creditTypeBox"
                  name="creditType"
                  value="1"
                />
                Form 941, 941-PR, or 941-SS
              </label>
              <label class="form-check-label d-block mt-2">
                <input
                  type="radio"
                  class="form-check-input"
                  v-model="creditTypeBox"
                  name="creditType"
                  value="2"
                />
                Form 943 or 943-PR
              </label>
              <label class="form-check-label d-block mt-2">
                <input
                  type="radio"
                  class="form-check-input"
                  v-model="creditTypeBox"
                  name="creditType"
                  value="3"
                />
                Form 944 or 944(SP)
              </label>
            </div>
          </div>
          <!--Report For This Quarter-->
          <div class="col-5">
            <div
              class="form-check"
              :class="{
                'alert-danger': errors.reportForThisQuarter,
                'alert-success': errors.reportForThisQuarter === false,
              }"
            >
              <h6 class="font-weight-bold bg-dark p-2 text-white mb-2">
                Report for this quarter <small>check only one box</small>
              </h6>
              <label class="form-check-label d-block mt-2">
                <input
                  type="radio"
                  class="form-check-input"
                  name="quarterReport"
                  v-model="reportForThisQuarter"
                  value="1"
                />
                1: January, February, March
              </label>
              <label class="form-check-label d-block mt-2">
                <input
                  type="radio"
                  class="form-check-input"
                  name="quarterReport"
                  v-model="reportForThisQuarter"
                  value="2"
                />
                2: April, May, June
              </label>
              <label class="form-check-label d-block mt-2">
                <input
                  type="radio"
                  class="form-check-input"
                  name="quarterReport"
                  v-model="reportForThisQuarter"
                  value="3"
                />
                3: July, August, September
              </label>
              <label class="form-check-label d-block mt-2">
                <input
                  type="radio"
                  class="form-check-input"
                  name="quarterReport"
                  v-model="reportForThisQuarter"
                  value="4"
                />
                4: October, November, December
              </label>
            </div>

            <!--Calendar Year-->
            <label for="" class="bg-dark p-2 text-white mt-4"
              >Calendar year
              <small
                >You must select a quarter if you file Form 941, 941-PR, or
                941-SS.</small
              >
            </label>
            <div
              class="p-1"
              :class="{
                'alert-danger': errors.calendarYear,
                'alert-success': errors.calendarYear === false,
              }"
            ></div>
            <flatpickr
              timeFormat="Y"
              v-model="calendarYear"
              id="calendar_year_select"
            />
          </div>
        </div>
      </div>

      <!--MID or PART 1-->
      <div class="col-lg-12 col-12 bg-white mt-4 p-3">
        <div class="bg-dark p-2 text-white">
          Part 1
          <span class="bg-white text-dark p-1 ml-2"
            >Tell us about your income tax return</span
          >
        </div>

        <el-alert
          title="When filling out rows, make sure to select an item in Column B"
          type="info"
        >
        </el-alert>

        <div
          v-if="errors.part1Selected"
          class="alert-danger p-2"
          :class="{
            'alert-danger': errors.part1Selected,
            'alert-success': errors.part1Selected === false,
          }"
        >
          Make sure you select a return file type!
        </div>

        <!--PART 1 : Table-->
        <table class="table table-striped table-responsive text-center">
          <thead>
            <tr>
              <th></th>
              <th>(a) Ending date of income tax period</th>
              <th width="12.5%">
                (b) Income tax return filed that included Form 6765
              </th>
              <th>(c) Date income tax return was filed</th>
              <th width="14.5%">(d) EIN used on Form 6765</th>
              <th width="12.5%">
                (e) Amount from Form 6765, line 44, or if applicable, the amount
                that was allocated to your EIN
              </th>
              <th width="12.5%">
                (f) Amount of credit from column (e) taken on a previous
                period(s)
              </th>
              <th width="12.5%">
                (g) Remaining credit (subtract column (f) from column (e))
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(index, row) in maxRows">
              <td>
                <div class="mt-4">
                  <b>{{ index }}</b>
                </div>
              </td>
              <td scope="row" colspan="1">
                <flatpickr
                  timeFormat="m-d-Y"
                  :id="`a${index}`"
                  fontSize=".5rem"
                />
              </td>
              <td>
                <select class="mt-3 form-control" :id="`b${index}`">
                  <option disabled value="" selected>Select ...</option>
                  <option>1065</option>
                  <option>1120</option>
                  <option>1120S</option>
                </select>
              </td>
              <td scope="row">
                <flatpickr
                  timeFormat="m-d-Y"
                  :id="`c${index}`"
                  fontSize=".5rem"
                />
              </td>
              <td>
                <div v-if="index === 1">
                  {{ limitEIND1 }}
                  <input
                    maxlength="10"
                    minlength="10"
                    type="text"
                    class="form-control mt-3"
                    :id="`d${index}`"
                    v-model="einUsed.d1"
                  />
                </div>
                <div v-if="index === 2">
                  {{ limitEIND2 }}
                  <input
                    maxlength="10"
                    minlength="10"
                    type="text"
                    class="form-control mt-3"
                    :id="`d${index}`"
                    v-model="einUsed.d2"
                  />
                </div>
                <div v-if="index === 3">
                  {{ limitEIND3 }}
                  <input
                    maxlength="10"
                    minlength="10"
                    type="text"
                    class="form-control mt-3"
                    :id="`d${index}`"
                    v-model="einUsed.d3"
                  />
                </div>
                <div v-if="index === 4">
                  {{ limitEIND4 }}
                  <input
                    maxlength="10"
                    minlength="10"
                    type="text"
                    class="form-control mt-3"
                    :id="`d${index}`"
                    v-model="einUsed.d4"
                  />
                </div>
                <div v-if="index === 5">
                  {{ limitEIND5 }}
                  <input
                    maxlength="10"
                    minlength="10"
                    type="text"
                    class="form-control mt-3"
                    :id="`d${index}`"
                    v-model="einUsed.d5"
                  />
                </div>
              </td>
              <td>
                <input
                  v-if="index === 1"
                  type="text"
                  class="form-control mt-3"
                  :id="`e${index}`"
                  v-model="amountFromForm.e1"
                  name=""
                  placeholder=""
                />
                <input
                  v-if="index === 2"
                  type="text"
                  class="form-control mt-3"
                  :id="`e${index}`"
                  v-model="amountFromForm.e2"
                  name=""
                  placeholder=""
                />
                <input
                  v-if="index === 3"
                  type="text"
                  class="form-control mt-3"
                  :id="`e${index}`"
                  v-model="amountFromForm.e3"
                  name=""
                  placeholder=""
                />
                <input
                  v-if="index === 4"
                  type="text"
                  class="form-control mt-3"
                  :id="`e${index}`"
                  v-model="amountFromForm.e4"
                  name=""
                  placeholder=""
                />
                <input
                  v-if="index === 5"
                  type="text"
                  class="form-control mt-3"
                  :id="`e${index}`"
                  v-model="amountFromForm.e5"
                  name=""
                  placeholder=""
                />
              </td>
              <td colspan="1">
                <input
                  v-if="index === 1"
                  type="text"
                  class="form-control mt-3"
                  :id="`f${index}`"
                  v-model="amountOfCredit.f1"
                  placeholder=""
                />
                <input
                  v-if="index === 2"
                  type="text"
                  class="form-control mt-3"
                  :id="`f${index}`"
                  v-model="amountOfCredit.f2"
                  placeholder=""
                />
                <input
                  v-if="index === 3"
                  type="text"
                  class="form-control mt-3"
                  :id="`f${index}`"
                  v-model="amountOfCredit.f3"
                  placeholder=""
                />
                <input
                  v-if="index === 4"
                  type="text"
                  class="form-control mt-3"
                  :id="`f${index}`"
                  v-model="amountOfCredit.f4"
                  placeholder=""
                />
                <input
                  v-if="index === 5"
                  type="text"
                  class="form-control mt-3"
                  :id="`f${index}`"
                  v-model="amountOfCredit.f5"
                  placeholder=""
                />
              </td>
              <td>
                <div class="mt-4">
                  <b v-if="index === 1" :id="`g${index}`">{{
                    remainingRowA
                  }}</b>
                  <b v-else-if="index === 2" :id="`g${index}`">{{
                    remainingRowB
                  }}</b>
                  <b v-else-if="index === 3" :id="`g${index}`">{{
                    remainingRowC
                  }}</b>
                  <b v-else-if="index === 4" :id="`g${index}`">{{
                    remainingRowD
                  }}</b>
                  <b v-else-if="index === 5" :id="`g${index}`">{{
                    remainingRowE
                  }}</b>
                </div>
              </td>
            </tr>
            <!--TOTAL-->
            <tr>
              <td colspan="6" class="text-left">
                <b class="mr-4">6</b>Add lines 1(g) through 5(g) and enter the
                total here
              </td>
              <td colspan="2" class="bg-dark text-white font-weight-bold">
                {{ rowSixTotal }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!--BOTTOM or PART 2-->
      <div class="col-lg-9 col-12 bg-white mt-4 p-3">
        <div class="bg-dark p-2 text-white">
          Part 2
          <span class="bg-white text-dark p-1 ml-2"
            >Determine the credit that you can use this period.</span
          >
        </div>
        <div v-for="(info, index) in partTwoFieldInfo" class="row">
          <div class="col-8 bg-light p-2">
            <b class="mr-2">{{ index + 7 }}</b> {{ info }}

            <div v-if="index === 4">
              <!--CHECK THIS BOX-->
              <div class="form-check mt-3">
                <el-checkbox-group v-model="partTwoOptional">
                  <el-checkbox
                    id="p2b1"
                    value="1"
                    label="Check this box if you're a third-party payer of sick pay"
                  ></el-checkbox>
                  <el-checkbox
                    id="p2b1"
                    value="2"
                    label="Check this box if you received a Section 3121(q) Notice and Demand. See the instructions before completing line 11"
                  ></el-checkbox>
                </el-checkbox-group>
              </div>
            </div>
          </div>
          <div class="col-4 text-center p-2 my-auto">
            <div v-if="index === 0" class="font-weight-bold">
              {{ rowSixTotal }}
            </div>
            <div v-else-if="index === 1" class="form-group">
              <input type="text" class="form-control" v-model="partTwoEight" />
            </div>
            <div v-else-if="index === 2" class="form-group">
              <input type="text" class="form-control" v-model="partTwoNine" />
            </div>
            <div v-else-if="index === 3" class="form-group font-weight-bolder">
              {{ sumOfPartTwoEightAndNine }}
            </div>
            <div v-else-if="index === 4" class="form-group font-weight-bolder">
              {{ partTwoLineElevenPercentage }}
            </div>
            <div v-else-if="index === 5" class="form-group font-weight-bolder">
              {{ partTwoGreaterThan }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import download from "downloadjs";
import * as $ from "jquery";
import axios from "axios";

import Flatpickr from "../Calendar/Flatpickr";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "Form_8974",
  components: { Flatpickr },
  props: {
    disableDownload: String,
  },

  mounted() {
    this.calendarYear = $("#calendar_year_select").val();
    if (this.returnCurrentActiveCompany) {
      this.ein = this.returnCurrentActiveCompany.ein;
      this.ein =
        this.returnCurrentActiveCompany.ein.substr(0, 2) +
        " - " +
        this.returnCurrentActiveCompany.ein.substr(2);
      this.companyName = this.returnCurrentActiveCompany.name;
    }
  },
  beforeUpdate() {
    /* Only enable retrieving from Vuex if working in multi form layout */
    if (this.disableDownload === "Y") {
      // console.warn("Calendar year from Vuex is ", this.returnCalendarYear());
      this.ein =
        this.returnEmployerIdentificationNumber().substr(0, 2) +
        " - " +
        this.returnEmployerIdentificationNumber().substr(2);
      this.companyName = this.returnName();
      // $('#calendar_year_select').val(this.returnCalendarYear());
      // this.calendarYear = this.returnCalendarYear();
      // this.partTwoEight = this.returnForm941Line5AColumn2;
      // this.partTwoNine = this.returnForm941Line5BColumn2;
    }
  },
  data: function () {
    return {
      // url: '//creditracker.us-west-1.elasticbeanstalk.com/Form-8974.pdf',
      url: "https://momsinla-storage.s3-us-west-1.amazonaws.com/irs-8974/Filliable-Form-8974.pdf",
      // url: 'https://zhendash.dev/Form-8974.pdf',
      /* MAIN FORM FIELDS ######################## */
      errors: {
        ein: null,
        companyName: null,
        creditTypeBox: null,
        reportForThisQuarter: null,
        calendarYear: null,
        part1Selected: null,
        partTwo: null,
      },
      ein: "",
      creditTypeBox: null,
      companyName: "",
      reportForThisQuarter: this.returnQuarterSelected,
      calendarYear: "",
      endingDateIncomeTax: {
        a1: null,
        a2: null,
        a3: null,
        a4: null,
        a5: null,
      },
      incomeTaxReturntype: {
        b1: null,
        b2: null,
        b3: null,
        b4: null,
        b5: null,
      },
      incomeTaxDateFiled: {
        c1: null,
        c2: null,
        c3: null,
        c4: null,
        c5: null,
      },
      einUsed: {
        d1: "",
        d2: "",
        d3: "",
        d4: "",
        d5: "",
      },
      amountFromForm: {
        e1: null,
        e2: null,
        e3: null,
        e4: null,
        e5: null,
      },
      amountOfCredit: {
        f1: null,
        f2: null,
        f3: null,
        f4: null,
        f5: null,
      },
      total: null,
      partTwoEight: 0.0,
      partTwoNine: 0.0,
      thirdPartyPayer: null,
      partTwoOptional: [],
      noticeOfDemand: null,
      partTwoEleven: null,
      /* ######################################### */
      maxRows: [1, 2, 3, 4, 5],
      partTwoFieldInfo: [
        "Enter the amount from Part 1, line 6(g) .",
        "Enter the amount from Form 941 (941-PR or 941-SS),\n" +
          "line 5a, Column 2; Form 943 (943-PR), line 3; or Form\n" +
          "944 (944(SP)), line 4a, Column 2 ",
        "Enter the amount from Form 941 (941-PR or 941-SS),\n" +
          "line 5b, Column 2; or Form 944 (944(SP)), line 4b,\n" +
          "Column 2",
        "Add lines 8 and 9",
        "Multiply line 10 by 50% (0.50).",
        "Credit. Enter the smaller of line 7 or line 11. Also enter this amount on Form 941 (941-PR\n" +
          "or 941-SS), line 11; Form 943 (943-PR), line 12; or Form 944 (944(SP)), line 8",
      ],
      validation: {
        EIN_MAX_LENGTH: 12,
        ein: null,
        companyName: null,
        partOne: null,
        partTwo: null,
      },
    };
  },
  computed: {
    ...mapGetters([
      "returnQuarterSelected",
      "returnForm941Line5AColumn2",
      "returnForm941Line5BColumn2",
      "returnCurrentActiveCompany",
    ]),
    limitEIN: function () {
      if (this.ein.length === 2) this.ein += " - ";
    },
    limitEIND1: function () {
      if (this.einUsed.d1.length === 2) this.einUsed.d1 += "-";
    },
    limitEIND2: function () {
      if (this.einUsed.d2.length === 2) this.einUsed.d2 += "-";
    },
    limitEIND3: function () {
      if (this.einUsed.d3.length === 2) this.einUsed.d3 += "-";
    },
    limitEIND4: function () {
      if (this.einUsed.d4.length === 2) this.einUsed.d4 += "-";
    },
    limitEIND5: function () {
      if (this.einUsed.d5.length === 2) this.einUsed.d5 += "-";
    },
    remainingRowA: function () {
      return Number(
        (this.amountFromForm.e1 - this.amountOfCredit.f1).toFixed(2)
      );
    },
    remainingRowB: function () {
      return Number(
        (this.amountFromForm.e2 - this.amountOfCredit.f2).toFixed(2)
      );
    },
    remainingRowC: function () {
      return Number(
        (this.amountFromForm.e3 - this.amountOfCredit.f3).toFixed(2)
      );
    },
    remainingRowD: function () {
      return Number(
        (this.amountFromForm.e4 - this.amountOfCredit.f4).toFixed(2)
      );
    },
    remainingRowE: function () {
      return Number(
        (this.amountFromForm.e5 - this.amountOfCredit.f5).toFixed(2)
      );
    },
    rowSixTotal: function () {
      const rowTotals = [
        this.remainingRowA,
        this.remainingRowB,
        this.remainingRowC,
        this.remainingRowD,
        this.remainingRowE,
      ];
      return rowTotals.reduce((a, b) => a + b, 0).toFixed(2);
    },
    sumOfPartTwoEightAndNine: function () {
      return (Number(this.partTwoEight) + Number(this.partTwoNine)).toFixed(2);
    },
    partTwoGreaterThan: function () {
      const _n =
        Number(this.rowSixTotal) > Number(this.partTwoLineElevenPercentage)
          ? this.partTwoLineElevenPercentage
          : this.rowSixTotal;
      this.storeForm8974Line12(_n);
      return _n;
    },
    partTwoLineElevenPercentage: function () {
      return Number(this.sumOfPartTwoEightAndNine * 0.5).toFixed(2);
    },
  },
  methods: {
    ...mapGetters([
      "returnEmployerIdentificationNumber",
      "returnName",
      "returnCalendarYear",
    ]),
    ...mapActions(["storeForm8974Line12", "returnFormInitiatedMeta"]),
    exportToPDF: async function () {
      /*  TODO Validate all fields before exporting */
      const validated = this.validateFormFields();

      /*EIN*/
      // console.log(validated);
      if (!validated) {
        /* Prompt Error */
        // console.error("Form errors!");
        console.error("errors!");
        this.$notify({
          title: "Form 8974 has errorss!",
          message: "Please check for errors.",
          type: "error",
        });
      } else {
        /* Write all contents to Final PDF */
        const existingPdfBytes = await fetch(this.url).then((res) =>
          res.arrayBuffer()
        );
        // console.warn("Got Bytes ", existingPdfBytes);

        const pdfDoc = await PDFDocument.load(existingPdfBytes);
        // console.warn("PDF Doc", pdfDoc);

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

        /* Draw EIN */
        /* All Validation Passed */
        /* Mutate EIN */
        /*EIN*/

        let ein_mutated = this.ein.slice(0).replace(" - ", "");
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
        firstPage.drawText(this.companyName, {
          x: 145,
          y: height / 2 + 288,
          ...baseOptionsSM,
        });

        /*Draw Credit Type*/
        const ctYCoord = [252, 228, 204];
        firstPage.drawText("X", {
          x: 180,
          y: height / 2 + ctYCoord[this.creditTypeBox - 1],
          ...baseOptionsLG,
        });

        /* Draw Report For This Quarter */
        const rqYCoord = [283, 265, 247, 229];
        firstPage.drawText("X", {
          x: 424,
          y: height / 2 + rqYCoord[this.reportForThisQuarter - 1],
          ...baseOptionsLG,
        });

        /*Draw Calendar year*/
        firstPage.drawText($("#calendar_year_select").val(), {
          x: 110,
          y: height / 2 + 180,
          ...baseOptionsSM,
        });

        /* Draw Table Rows <Only draw rows where column (g) has a value! */
        /* Checks
         * 1. If value is a double
         * 2. If NOT, fill in 00 for remainder change
         * X offset is 70
         * X offset for b and d is 60
         * Y offset is 18
         * */
        // 440
        // }
        const xOffset = 70;
        const xOffsetSp = 60;
        const yOffset = 18;
        const START_X = 80;

        for (let idx = 1; idx <= 6; idx++) {
          // console.warn("LOOP ON ", idx);
          switch (idx) {
            case 1:
              // if (this.remainingRowA > 0) {
              let formattedColG = this.convertToStringAndAddDecimal(
                this.remainingRowA
              );
              // console.warn("Col G ", formattedColG);
              /* Draw A */
              firstPage.drawText(
                this.reformatDateToForwardslash($(`#a${idx}`).val()),
                {
                  x: START_X,
                  y: height / 2 + 54,
                  ...baseOptions,
                }
              );
              /* Draw B */
              firstPage.drawText($(`#b${idx}`).val(), {
                x: START_X + xOffset,
                y: height / 2 + 54,
                ...baseOptions,
              });
              /* Draw C */
              firstPage.drawText(
                this.reformatDateToForwardslash($(`#c${idx}`).val()),
                {
                  x: START_X + xOffset * 2 - 10,
                  y: height / 2 + 54,
                  ...baseOptions,
                }
              );
              /* Draw D */
              firstPage.drawText($(`#d${idx}`).val(), {
                x: START_X + xOffset * 3 - 7,
                y: height / 2 + 54,
                ...baseOptions,
              });
              /* Draw E */
              firstPage.drawText(
                this.convertToStringAndAddDecimal(Number($(`#e${idx}`).val())),
                {
                  x: START_X + xOffset * 4 - 10,
                  y: height / 2 + 54,
                  ...baseOptions,
                }
              );
              /* Draw F */
              firstPage.drawText(
                this.convertToStringAndAddDecimal(Number($(`#f${idx}`).val())),
                {
                  x: START_X + xOffset * 5 + 17 - 10,
                  y: height / 2 + 54,
                  ...baseOptions,
                }
              );
              /* Draw G */
              if (formattedColG === 0.0 || formattedColG === "0.00") {
                firstPage.drawText("0.00", {
                  x: START_X + xOffset * 6 + 10,
                  y: height / 2 + 54,
                  ...baseOptions,
                });
              } else {
                firstPage.drawText(formattedColG, {
                  x: START_X + xOffset * 6 + 10,
                  y: height / 2 + 54,
                  ...baseOptions,
                });
              }

              // }
              break;
            case 2:
              if (this.remainingRowB > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowB
                );
                // console.warn(formattedColG);
                /* Draw A */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#a${idx}`).val()),
                  {
                    x: START_X,
                    y: height / 2 + 54 - yOffset,
                    ...baseOptions,
                  }
                );
                /* Draw B */
                firstPage.drawText($(`#b${idx}`).val(), {
                  x: START_X + xOffset,
                  y: height / 2 + 54 - yOffset,
                  ...baseOptions,
                });
                /* Draw C */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#c${idx}`).val()),
                  {
                    x: START_X + xOffset * 2 - 10,
                    y: height / 2 + 54 - yOffset,
                    ...baseOptions,
                  }
                );
                /* Draw D */
                firstPage.drawText($(`#d${idx}`).val(), {
                  x: START_X + xOffset * 3 - 7,
                  y: height / 2 + 54 - yOffset,
                  ...baseOptions,
                });
                /* Draw E */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#e${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 4 - 10,
                    y: height / 2 + 54 - yOffset,
                    ...baseOptions,
                  }
                );
                /* Draw F */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#f${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 5 + 5,
                    y: height / 2 + 54 - yOffset,
                    ...baseOptions,
                  }
                );
                /* Draw G */
                firstPage.drawText(formattedColG, {
                  x: START_X + xOffset * 6 + 10,
                  y: height / 2 + 54 - yOffset,
                  ...baseOptions,
                });
              }
              break;
            case 3:
              if (this.remainingRowC > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowC
                );
                // console.warn(formattedColG);
                /* Draw A */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#a${idx}`).val()),
                  {
                    x: START_X,
                    y: height / 2 + 54 - yOffset * 2,
                    ...baseOptions,
                  }
                );
                /* Draw B */
                firstPage.drawText($(`#b${idx}`).val(), {
                  x: START_X + xOffset,
                  y: height / 2 + 54 - yOffset * 2,
                  ...baseOptions,
                });
                /* Draw C */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#c${idx}`).val()),
                  {
                    x: START_X + xOffset * 2 - 10,
                    y: height / 2 + 54 - yOffset * 2,
                    ...baseOptions,
                  }
                );
                /* Draw D */
                firstPage.drawText($(`#d${idx}`).val(), {
                  x: START_X + xOffset * 3 - 7,
                  y: height / 2 + 54 - yOffset * 2,
                  ...baseOptions,
                });
                /* Draw E */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#e${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 4 - 10,
                    y: height / 2 + 54 - yOffset * 2,
                    ...baseOptions,
                  }
                );
                /* Draw F */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#f${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 5 + 5,
                    y: height / 2 + 54 - yOffset * 2,
                    ...baseOptions,
                  }
                );
                /* Draw G */
                firstPage.drawText(formattedColG, {
                  x: START_X + xOffset * 6 + 10,
                  y: height / 2 + 54 - yOffset * 2,
                  ...baseOptions,
                });
              }
              break;
            case 4:
              if (this.remainingRowD > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowD
                );
                // console.warn(formattedColG);
                /* Draw A */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#a${idx}`).val()),
                  {
                    x: START_X,
                    y: height / 2 + 54 - yOffset * 3,
                    ...baseOptions,
                  }
                );
                /* Draw B */
                firstPage.drawText($(`#b${idx}`).val(), {
                  x: START_X + xOffset,
                  y: height / 2 + 54 - yOffset * 3,
                  ...baseOptions,
                });
                /* Draw C */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#c${idx}`).val()),
                  {
                    x: START_X + xOffset * 2 - 10,
                    y: height / 2 + 54 - yOffset * 3,
                    ...baseOptions,
                  }
                );
                /* Draw D */
                firstPage.drawText($(`#d${idx}`).val(), {
                  x: START_X + xOffset * 3 - 7,
                  y: height / 2 + 54 - yOffset * 3,
                  ...baseOptions,
                });
                /* Draw E */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#e${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 4 - 10,
                    y: height / 2 + 54 - yOffset * 3,
                    ...baseOptions,
                  }
                );
                /* Draw F */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#f${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 5 + 5,
                    y: height / 2 + 54 - yOffset * 3,
                    ...baseOptions,
                  }
                );
                /* Draw G */
                firstPage.drawText(formattedColG, {
                  x: START_X + xOffset * 6 + 10,
                  y: height / 2 + 54 - yOffset * 3,
                  ...baseOptions,
                });
              }
              break;
            case 5:
              if (this.remainingRowE > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowE
                );
                // console.warn(formattedColG);
                /* Draw A */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#a${idx}`).val()),
                  {
                    x: START_X,
                    y: height / 2 + 54 - yOffset * 4,
                    ...baseOptions,
                  }
                );
                /* Draw B */
                firstPage.drawText($(`#b${idx}`).val(), {
                  x: START_X + xOffset,
                  y: height / 2 + 54 - yOffset * 4,
                  ...baseOptions,
                });
                /* Draw C */
                firstPage.drawText(
                  this.reformatDateToForwardslash($(`#c${idx}`).val()),
                  {
                    x: START_X + xOffset * 2 - 10,
                    y: height / 2 + 54 - yOffset * 4,
                    ...baseOptions,
                  }
                );
                /* Draw D */
                firstPage.drawText($(`#d${idx}`).val(), {
                  x: START_X + xOffset * 3 - 7,
                  y: height / 2 + 54 - yOffset * 4,
                  ...baseOptions,
                });
                /* Draw E */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#e${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 4 - 10,
                    y: height / 2 + 54 - yOffset * 4,
                    ...baseOptions,
                  }
                );
                /* Draw F */
                firstPage.drawText(
                  this.convertToStringAndAddDecimal(
                    Number($(`#f${idx}`).val())
                  ),
                  {
                    x: START_X + xOffset * 5 + 5,
                    y: height / 2 + 54 - yOffset * 4,
                    ...baseOptions,
                  }
                );
                /* Draw G */
                firstPage.drawText(formattedColG, {
                  x: START_X + xOffset * 6 + 10,
                  y: height / 2 + 54 - yOffset * 4,
                  ...baseOptions,
                });
              }
              break;
            case 6:
              /* Map Totals and Part 2-7 */
              const total = this.convertToStringAndAddDecimal(this.rowSixTotal);
              firstPage.drawText(total, {
                x: START_X + xOffset * 6 + 10,
                y: height / 2 + 54 - yOffset * 5,
                ...baseOptions,
              });
              /*P2-7*/
              firstPage.drawText(total, {
                x: START_X + xOffset * 6 - 5,
                y: height / 2 + 54 - yOffset * 7 - 5,
                ...baseOptions,
              });
              break;
          }
        }

        /* Draw 8 */
        firstPage.drawText(
          this.convertToStringAndAddDecimal(this.partTwoEight),
          {
            x: START_X + xOffset * 4 - 10,
            y: height / 2 + 54 - yOffset * 10 + 1,
            ...baseOptions,
          }
        );

        /* Draw 9 */
        firstPage.drawText(
          this.convertToStringAndAddDecimal(this.partTwoNine),
          {
            x: START_X + xOffset * 4 - 10,
            y: height / 2 + 54 - yOffset * 13 + 7,
            ...baseOptions,
          }
        );

        /* Draw 10 */
        firstPage.drawText(
          this.convertToStringAndAddDecimal(this.sumOfPartTwoEightAndNine),
          {
            x: START_X + xOffset * 4 - 10,
            y: height / 2 + 54 - yOffset * 15 + 13,
            ...baseOptions,
          }
        );

        if (this.partTwoOptional.length) {
          const found = this.partTwoOptional.find((needle) => {
            return needle ===
              "Check this box if you're a third-party payer of sick pay"
              ? 1
              : 2;
          });

          /* Draw 10 CHECKBOX 1 IF Selected */
          // if (Number(found) === 1) {
          if (
            this.partTwoOptional.includes(
              "Check this box if you're a third-party payer of sick pay"
            )
          ) {
            firstPage.drawText("X", {
              x: START_X + xOffset * 2 + 32,
              y: height / 2 + 54 - yOffset * 17 + 17,
              ...baseOptionsLG,
            });
          }

          /* Draw 10 CHECKBOX 2 IF Selected */
          // if (Number(found) === 2) {
          if (
            this.partTwoOptional.includes(
              "Check this box if you received a Section 3121(q) Notice and Demand. See the instructions before completing line 11"
            )
          ) {
            firstPage.drawText("X", {
              x: START_X + xOffset - 23,
              y: height / 2 + 54 - yOffset * 17 + 3,
              ...baseOptionsLG,
            });
          }
        }

        /* Draw 11 */
        firstPage.drawText(
          this.convertToStringAndAddDecimal(this.partTwoLineElevenPercentage),
          {
            x: START_X + xOffset * 6 - 10,
            y: height / 2 + 54 - yOffset * 18 + 6,
            ...baseOptions,
          }
        );

        /* Draw 12 */
        firstPage.drawText(
          this.convertToStringAndAddDecimal(this.partTwoGreaterThan),
          {
            x: START_X + xOffset * 6 - 10,
            y: height / 2 + 54 - yOffset * 20 + 5,
            ...baseOptions,
          }
        );

        /* Save report and Download*/
        const pdfBytes = await pdfDoc.save();
        // Trigger the browser to download the PDF document
        download(pdfBytes, `IRS-8974-${Date.now()}.pdf`, "application/pdf");
        /* TODO Clear out the form */
      }
    },
    validateFormFields() {
      /* Validate fields */
      /* Finish computing or cleaning final output here */

      /*EIN validator*/
      if (this.ein.length < this.validation.EIN_MAX_LENGTH) {
        console.log("8974: EIN is wrong");
        this.errors.ein = true;
        return false;
      } else this.errors.ein = false;

      /*NAME*/
      if (this.companyName.trim().length === 0 || this.companyName === null) {
        // console.log("8974: Name is wrong");
        this.errors.companyName = true;
        return false;
      } else this.errors.companyName = false;

      /*CREDIT TYPE*/
      if (!this.creditTypeBox) {
        // console.log("8974: Credit Type Box is wrong");
        this.errors.creditTypeBox = true;
        return false;
      } else this.errors.creditTypeBox = false;

      /*Report for this quarter*/
      if (!this.reportForThisQuarter) {
        // console.log("8974: Report for this Quarter is wrong");
        this.errors.reportForThisQuarter = true;
        return false;
      } else this.errors.reportForThisQuarter = false;

      /*CALENDAR YEAR*/
      if (this.calendarYear.trim().length === 0 || this.calendarYear === null) {
        // console.log("8974: Calendar Year is wrong");
        // console.log(this.calendarYear);
        this.errors.calendarYear = true;
        return false;
      } else this.errors.calendarYear = false;

      // Check if all the boxes are empty to prompt an error
      if (
        document.getElementById("b1").value === "" &&
        document.getElementById("b2").value === "" &&
        document.getElementById("b3").value === "" &&
        document.getElementById("b4").value === "" &&
        document.getElementById("b5").value === ""
      ) {
        this.errors.part1Selected = true;
        return false;
      }
      this.errors.part1Selected = false;

      /*PART 1*/
      // if (this.rowSixTotal <= 0.00 || this.rowSixTotal <= '0.00') {
      //   console.log('8974: Part 1 is wrong');
      //   console.log(this.rowSixTotal);
      //   this.validation.partOne = false;
      //   return false;
      // } else this.validation.partOne = true;

      if (this.sumOfPartTwoEightAndNine < 0) {
        // console.log("8974: Part 2 is wrong");
        // console.log(
        //   this.sumOfPartTwoEightAndNine,
        //   typeof this.sumOfPartTwoEightAndNine
        // );
        this.errors.partTwo = true;
        return false;
      } else this.errors.partTwo = false;

      return true;
    },
    convertToStringAndAddDecimal(columnG) {
      let formatToString = columnG.toString();
      let formatToCurrency = formatToString.includes(".")
        ? formatToString
        : (formatToString += ".00");
      return formatToCurrency.replace(/\d(?=(\d{3})+\.)/g, "$&,");
    },
    reformatDateToForwardslash(d) {
      return d.replace(/-/g, "/");
    },
    clearFields() {
      this.ein = this.companyName = this.calendarYear = "";
      this.creditTypeBox =
        this.reportForThisQuarter =
        this.endingDateIncomeTax =
        this.incomeTaxReturntype =
        this.incomeTaxDateFiled =
          this.total;
      this.partTwoEight =
        this.partTwoNine =
        this.thirdPartyPayer =
        this.partTwoOptional =
        this.noticeOfDemand =
        this.partTwoEleven =
        this.validation.ein =
        this.validation.companyName =
        this.validation.partOne =
        this.validation.partTwo =
          null;
    },
    onStore8974Record: async function () {
      console.log("onStore8974Record");

      const flag = this.validateFormFields();

      if (!flag) {
        this.$notify.error({
          title: "Error",
          message: "You have errors in your form!",
        });
      } else {
        // Create the array of values for Part 1 Table
        let partOneTable = [];
        let partOneRowObj = {
          a: null,
          b: null,
          c: null,
          e: null,
          f: null,
          g: null,
        };
        let partOneTotal = 0;
        let partElevenCheckboxes = [];
        for (let idx = 1; idx <= 6; idx++) {
          console.warn("LOOP ON ", idx);
          switch (idx) {
            case 1:
              let formattedColG = this.convertToStringAndAddDecimal(
                this.remainingRowA
              );

              /* Draw A */
              partOneRowObj.a = this.reformatDateToForwardslash(
                $(`#a${idx}`).val()
              );

              /* Draw B */
              partOneRowObj.b = $(`#b${idx}`).val();

              /* Draw C */
              partOneRowObj.c = $(`#c${idx}`).val();

              /* Draw D */
              partOneRowObj.d = $(`#d${idx}`).val();

              /* Draw E */
              partOneRowObj.e = this.convertToStringAndAddDecimal(
                Number($(`#e${idx}`).val())
              );

              /* Draw F */
              partOneRowObj.f = this.convertToStringAndAddDecimal(
                Number($(`#f${idx}`).val())
              );

              /* Draw G */
              if (formattedColG === 0.0 || formattedColG === "0.00") {
                partOneRowObj.g = "0.00";
              } else {
                partOneRowObj.g = formattedColG;
              }

              partOneTable.push(partOneRowObj);
              console.warn("Row ", partOneRowObj);
              break;
            case 2:
              if (this.remainingRowB > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowB
                );
                /* Draw A */
                partOneRowObj.a = this.reformatDateToForwardslash(
                  $(`#a${idx}`).val()
                );

                /* Draw B */
                partOneRowObj.b = $(`#b${idx}`).val();

                /* Draw C */
                partOneRowObj.c = $(`#c${idx}`).val();

                /* Draw D */
                partOneRowObj.d = $(`#d${idx}`).val();

                /* Draw E */
                partOneRowObj.e = this.convertToStringAndAddDecimal(
                  Number($(`#e${idx}`).val())
                );

                /* Draw F */
                partOneRowObj.f = this.convertToStringAndAddDecimal(
                  Number($(`#f${idx}`).val())
                );

                /* Draw G */
                partOneRowObj.g = formattedColG;

                partOneTable.push(partOneRowObj);
              }
              break;
            case 3:
              if (this.remainingRowC > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowC
                );
                // console.warn(formattedColG);
                /* Draw A */
                partOneRowObj.a = this.reformatDateToForwardslash(
                  $(`#a${idx}`).val()
                );

                /* Draw B */
                partOneRowObj.b = $(`#b${idx}`).val();

                /* Draw C */
                partOneRowObj.c = $(`#c${idx}`).val();

                /* Draw D */
                partOneRowObj.d = $(`#d${idx}`).val();

                /* Draw E */
                partOneRowObj.e = this.convertToStringAndAddDecimal(
                  Number($(`#e${idx}`).val())
                );

                /* Draw F */
                partOneRowObj.f = this.convertToStringAndAddDecimal(
                  Number($(`#f${idx}`).val())
                );

                /* Draw G */
                partOneRowObj.g = formattedColG;

                partOneTable.push(partOneRowObj);
              }
              break;
            case 4:
              if (this.remainingRowD > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowD
                );
                // console.warn(formattedColG);
                /* Draw A */
                partOneRowObj.a = this.reformatDateToForwardslash(
                  $(`#a${idx}`).val()
                );

                /* Draw B */
                partOneRowObj.b = $(`#b${idx}`).val();

                /* Draw C */
                partOneRowObj.c = $(`#c${idx}`).val();

                /* Draw D */
                partOneRowObj.d = $(`#d${idx}`).val();

                /* Draw E */
                partOneRowObj.e = this.convertToStringAndAddDecimal(
                  Number($(`#e${idx}`).val())
                );

                /* Draw F */
                partOneRowObj.f = this.convertToStringAndAddDecimal(
                  Number($(`#f${idx}`).val())
                );

                /* Draw G */
                partOneRowObj.g = formattedColG;

                partOneTable.push(partOneRowObj);
              }
              break;
            case 5:
              if (this.remainingRowE > 0) {
                let formattedColG = this.convertToStringAndAddDecimal(
                  this.remainingRowE
                );
                // console.warn(formattedColG);
                /* Draw A */
                partOneRowObj.a = this.reformatDateToForwardslash(
                  $(`#a${idx}`).val()
                );

                /* Draw B */
                partOneRowObj.b = $(`#b${idx}`).val();

                /* Draw C */
                partOneRowObj.c = $(`#c${idx}`).val();

                /* Draw D */
                partOneRowObj.d = $(`#d${idx}`).val();

                /* Draw E */
                partOneRowObj.e = this.convertToStringAndAddDecimal(
                  Number($(`#e${idx}`).val())
                );

                /* Draw F */
                partOneRowObj.f = this.convertToStringAndAddDecimal(
                  Number($(`#f${idx}`).val())
                );

                /* Draw G */
                partOneRowObj.g = formattedColG;

                partOneTable.push(partOneRowObj);
              }
              break;
            case 6:
              /* Map Totals and Part 2-7 */
              partOneTotal = this.convertToStringAndAddDecimal(
                this.rowSixTotal
              );
              break;
          }
        }

        if (this.partTwoOptional.length) {
          /* Draw 10 CHECKBOX 1 IF Selected */
          // if (Number(found) === 1) {
          if (
            this.partTwoOptional.includes(
              "Check this box if you're a third-party payer of sick pay"
            )
          ) {
            partElevenCheckboxes.push(1);
          }

          /* Draw 10 CHECKBOX 2 IF Selected */
          // if (Number(found) === 2) {
          if (
            this.partTwoOptional.includes(
              "Check this box if you received a Section 3121(q) Notice and Demand. See the instructions before completing line 11"
            )
          ) {
            partElevenCheckboxes.push(2);
          }
        }

        // console.warn(
        //   this.returnCurrentActiveCompany.id,
        //   "8974",
        //   $("#calendar_year_select").val(),
        //   this.ein,
        //   this.companyName,
        //   this.creditTypeBox,
        //   this.reportForThisQuarter,
        //   " Part One Table ",
        //   partOneTable,
        //   " Part One Total ",
        //   partOneTotal,
        //   this.convertToStringAndAddDecimal(this.partTwoEight),
        //   this.convertToStringAndAddDecimal(this.partTwoNine),
        //   this.convertToStringAndAddDecimal(this.sumOfPartTwoEightAndNine),
        //   this.convertToStringAndAddDecimal(this.partTwoLineElevenPercentage),
        //   JSON.stringify(partElevenCheckboxes),
        //   this.convertToStringAndAddDecimal(this.partTwoGreaterThan)
        // );

        let { data } = await axios.post("api/company/stored/new/8974", {
          company_id: this.returnCurrentActiveCompany.id,
          form_name: "8974",
          form_year: $("#calendar_year_select").val(),
          eid: this.ein,
          name: this.companyName,
          credit_checkbox: this.creditTypeBox,
          quarter: this.reportForThisQuarter,
          part_one: JSON.stringify(partOneTable),
          part_one_total: partOneTotal,
          seven: partOneTotal,
          eight: this.convertToStringAndAddDecimal(this.partTwoEight),
          nine: this.convertToStringAndAddDecimal(this.partTwoNine),
          ten: this.convertToStringAndAddDecimal(this.sumOfPartTwoEightAndNine),
          eleven: this.convertToStringAndAddDecimal(
            this.partTwoLineElevenPercentage
          ),
          eleven_checkbox: JSON.stringify(partElevenCheckboxes),
          twelve: this.convertToStringAndAddDecimal(this.partTwoGreaterThan),
        });

        this.$notify({
          title: "Success",
          message: "Stored Form 8974 detals!",
          type: "success",
        });
      }
    },
  },
};
</script>

<style scoped>
button {
  border-radius: 0;
  width: 5rem !important;
}

.col-lg-12 {
  /*max-width: 130%;*/
  /*flex: 0 0 130%;*/
}
</style>
