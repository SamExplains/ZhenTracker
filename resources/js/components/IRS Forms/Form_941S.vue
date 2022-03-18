<template>
  <div class="container">
    <div class="d-none">
      {{ this.returnEmployerIdentificationNumber() }}
      {{ this.returnName() }}
      {{ this.returnQuarterSelected() }}
    </div>

    <div
      class="position-fixed"
      style="right: 1rem; bottom: 12rem; background: white; padding: 1rem"
    >
      <div
        v-show="errors.liabilityMonthOne"
        class="alert-danger p-2 text-center text-danger font-weight-bolder mb-2"
      >
        Error in Table 1
      </div>

      <div
        v-show="errors.liabilityMonthTwo"
        class="alert-danger p-2 text-center text-danger font-weight-bolder mb-2"
      >
        Error in Table 2
      </div>

      <div
        v-show="errors.liabilityMonthThree"
        class="alert-danger p-2 text-center text-danger font-weight-bolder mb-2"
      >
        Error in Table 3
      </div>

      <div
        v-show="errors.totalLiabilityForQuarter"
        class="alert-danger p-2 text-center text-danger font-weight-bolder mb-2"
      >
        Check all tables for bad input
      </div>

      <h6>Total liability for quarter</h6>
      <div class="text-right text-success font-weight-bolder">
        <h4>{{ totalLiabilityForQuarter }}</h4>
      </div>
    </div>
    <div class="position-fixed" style="right: 1rem; bottom: 1rem">
      <div>
        <button class="btn btn-danger d-inline clear mb-3">Clear</button>
      </div>

      <div>
        <button
          class="btn btn-secondary d-inline clear mb-3"
          @click="onStoreScheduleBRecord"
        >
          Store
        </button>
      </div>

      <div v-show="disableDownload !== 'Y'">
        <button class="btn btn-primary d-inline export" @click="exportToPDF">
          Export
        </button>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 mt-3 mb-3">
        <h4 class="alert-info p-2 text-center">Form 941 Schedule B</h4>
      </div>

      <!--TOP OF FORM-->
      <div class="col-lg-10 col-12 bg-white mt-4 p-3 text-left">
        <div class="row">
          <div class="col-8">
            <div class="row">
              <div class="col-5 font-weight-bold mb-2">
                Employer identification number
              </div>
              <div
                class="col-7 my-auto"
                :class="{
                  'is-invalid': errors.ein,
                  'is-valid': errors.ein === false,
                }"
              >
                <input
                  type="text"
                  class="form-control"
                  :class="{
                    'is-invalid': errors.ein,
                    'is-valid': errors.ein === false,
                  }"
                  v-model="employerIdentificationNumber"
                  minlength="9"
                  maxlength="9"
                />
              </div>

              <!--Name-->
              <div class="col-5 font-weight-bold mb-2">Name</div>
              <div class="col-7 my-auto">
                <input
                  type="text"
                  class="form-control mb-2"
                  :class="{
                    'is-invalid': errors.name,
                    'is-valid': errors.name === false,
                  }"
                  minlength="1"
                  v-model="name"
                />
              </div>

              <!--Calendar Year-->
              <div class="col-5 font-weight-bold mb-2">Calendar year</div>
              <div
                class="col-7 my-auto"
                :class="{
                  'is-invalid': errors.calendarYear,
                  'is-valid': errors.calendarYear === false,
                }"
              >
                <flatpickr
                  timeFormat="Y"
                  v-model="calendarYear"
                  id="sb_calendar_year_select"
                />
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="form-check">
              <h6 class="alert-danger p-1" v-show="errors.reportForThisQuarter">
                Select a quarter
              </h6>
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
          </div>
          <div class="col-12 font-weight-bold mt-3 mb-3">
            Use this schedule to show your TAX LIABILITY for the quarter; don't
            use it to show your deposits. When you file this form with Form 941
            or Form 941-SS, don't change your tax liability by adjustments
            reported on any Forms 941-X or 944-X. You must fill out this form
            and attach it to Form 941 or Form 941-SS if you're a semiweekly
            schedule depositor or became one because your accumulated tax
            liability on any day was $100,000 or more. Write your daily tax
            liability on the numbered space that corresponds to the date wages
            were paid. See Section 11 in Pub. 15 for details.
          </div>

          <!--Schedule Table Map Mo.1-->
          <div class="col-12 mb-3">
            <div class="w-50">
              <h6 class="alert-warning p-1">Tax liability for month 1</h6>
              <div class="display-4 text-right bg-light">
                {{ monthOneTableSum }}
              </div>
            </div>
          </div>

          <div
            v-for="(month1, index) in monthOneTable"
            class="col-3"
            :class="index % 2 > 0 ? 'bg-light' : ''"
          >
            <div v-show="index !== 0" class="form-group">
              <label>{{ index }}</label>
              <input
                type="text"
                class="form-control"
                v-model="monthOneTable[index]"
              />
            </div>
          </div>

          <!--Schedule Table Map Mo.2-->
          <div class="col-12 mb-3">
            <div class="w-50">
              <h6 class="alert-warning p-1">Tax liability for month 2</h6>
              <div class="display-4 text-right bg-light">
                {{ monthTwoTableSum }}
              </div>
            </div>
          </div>

          <div
            v-for="(month2, index) in monthTwoTable"
            class="col-3"
            :class="index % 2 > 0 ? 'bg-light' : ''"
          >
            <div v-show="index !== 0" class="form-group">
              <label>{{ index }}</label>
              <input
                type="text"
                class="form-control"
                v-model="monthTwoTable[index]"
              />
            </div>
          </div>

          <!--Schedule Table Map Mo.3-->
          <div class="col-12 mb-3">
            <div class="w-50">
              <h6 class="alert-warning p-1">Tax liability for month 3</h6>
              <div class="display-4 text-right bg-light">
                {{ monthThreeTableSum }}
              </div>
            </div>
          </div>

          <div
            v-for="(month3, index) in monthThreeTable"
            class="col-3"
            :class="index % 2 > 0 ? 'bg-light' : ''"
          >
            <div v-show="index !== 0" class="form-group">
              <label>{{ index }}</label>
              <input
                type="text"
                class="form-control"
                v-model="monthThreeTable[index]"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import * as $ from "jquery";
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import download from "downloadjs";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "Form_941_Schedule_B",
  mounted() {
    // console.log('Schedule B Url is ', this.formUrl )
    if (this.returnCurrentActiveCompany) {
      this.employerIdentificationNumber = this.returnCurrentActiveCompany.ein;
      this.name = this.returnCurrentActiveCompany.name;
    }
  },
  props: {
    formUrl: String,
    disableDownload: String,
  },
  beforeUpdate() {
    if (this.disableDownload === "Y") {
      this.employerIdentificationNumber =
        this.returnEmployerIdentificationNumber();
      this.name = this.returnName();
      this.calendar = this.returnQuarterSelected();
    }
  },
  data() {
    return {
      url: this.formUrl,
      /* Form Variables */
      employerIdentificationNumber: "",
      name: "",
      calendarYear: "",
      reportForThisQuarter: null,
      /* Month 1 table generator/map */
      monthOneTable: [
        "table1",
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
      ],
      /* Month 2 table generator/map */
      monthTwoTable: [
        "table2",
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
      ],
      /* Month 3 table generator/map */
      monthThreeTable: [
        "table3",
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
      ],
      errors: {
        ein: null,
        name: null,
        calendarYear: null,
        reportForThisQuarter: null,
        liabilityMonthOne: null,
        liabilityMonthTwo: null,
        liabilityMonthThree: null,
        totalLiabilityForQuarter: null,
      },
    };
  },
  methods: {
    ...mapGetters([
      "returnEmployerIdentificationNumber",
      "returnName",
      "returnQuarterSelected",
    ]),
    ...mapActions([
      "storeFormScheduleBTaxLiabilityMonthOne",
      "storeFormScheduleBTaxLiabilityMonthTwo",
      "storeFormScheduleBTaxLiabilityMonthThree",
      "storeFormScheduleBTotalQuarterLiability",
    ]),
    validation: function () {
      /*EIN*/
      if (this.employerIdentificationNumber.length < 9) {
        this.errors.ein = true;
        return false;
      } else this.errors.ein = false;

      /*Name*/
      if (this.name.trim().length === 0) {
        this.errors.name = true;
        return false;
      } else this.errors.name = false;

      /*Calendar*/
      if ($("#sb_calendar_year_select").val().length === 0) {
        this.errors.calendarYear = true;
        return false;
      } else this.errors.calendarYear = false;

      /*Report for this Quarter*/
      if (this.reportForThisQuarter == null) {
        this.errors.reportForThisQuarter = true;
        return false;
      } else this.errors.reportForThisQuarter = false;

      /*Month 1 Liability */
      if (this.monthOneTableSum == null || isNaN(this.monthOneTableSum)) {
        this.errors.liabilityMonthOne = true;
        return false;
      } else this.errors.liabilityMonthOne = false;

      /*Month 2 Liability */
      if (this.monthTwoTableSum == null || isNaN(this.monthTwoTableSum)) {
        this.errors.liabilityMonthTwo = true;
        return false;
      } else this.errors.liabilityMonthTwo = false;

      /*Month 3 Liability */
      if (this.monthThreeTableSum == null || isNaN(this.monthThreeTableSum)) {
        this.errors.liabilityMonthThree = true;
        return false;
      } else this.errors.liabilityMonthThree = false;

      /* Quarter Liability */
      if (
        this.totalLiabilityForQuarter == null ||
        isNaN(this.totalLiabilityForQuarter.replace(/,/g, ""))
      ) {
        this.errors.totalLiabilityForQuarter = true;
        // console.error(this.totalLiabilityForQuarter);
        return false;
      } else this.errors.totalLiabilityForQuarter = false;

      return true;
    },
    exportToPDF: async function () {
      if (!this.validation()) {
        // console.error('Form errors!');
      } else {
        /* Write all contents to Final PDF */
        const existingPdfBytes = await fetch(this.url).then((res) =>
          res.arrayBuffer()
        );

        const pdfDoc = await PDFDocument.load(existingPdfBytes);
        const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);

        const pages = pdfDoc.getPages();
        const _page = pages[0];
        const { width, height } = _page.getSize();
        const COLOR = rgb(0, 0, 0);
        const _options = {
          size: 10,
          font: helveticaFont,
          color: COLOR,
        };

        // console.log(typeof this.calendarYear , ' has a value of ', this.calendarYear);

        /*Write EIN*/
        let ein_mutated = this.employerIdentificationNumber.split("");
        for (let i = 0; i < 9; i++) {
          let ein_XCoord = [155, 180, 220, 245, 270, 295, 320, 345, 370];

          _page.drawText(ein_mutated[i], {
            x: ein_XCoord[i],
            y: height / 2 + 295,
            ..._options,
          });
        }

        /*Write Name*/
        _page.drawText(this.name, {
          x: 140,
          y: height / 2 + 270,
          ..._options,
        });

        /*Write Calendar Year*/
        let calendarYear_mutated = $("#sb_calendar_year_select").val();
        calendarYear_mutated.split("");
        for (let i = 0; i < 4; i++) {
          let xCoord = [155, 180, 203, 230];

          _page.drawText(calendarYear_mutated[i], {
            x: xCoord[i],
            y: height / 2 + 245,
            ..._options,
          });
        }

        /* Report for this quarter */
        switch (this.reportForThisQuarter) {
          case "1":
            _page.drawText("x", {
              x: 424,
              y: height / 2 + 280, //294
              ..._options,
            });
            break;
          case "2":
            _page.drawText("x", {
              x: 424,
              y: height / 2 + 261,
              ..._options,
            });
            break;
          case "3":
            _page.drawText("x", {
              x: 424,
              y: height / 2 + 243,
              ..._options,
            });
            break;
          case "4":
            _page.drawText("x", {
              x: 424,
              y: height / 2 + 226,
              ..._options,
            });
            break;
        }

        // Write first table
        this.writeTableToPDF(_page, height, _options, this.monthOneTable);
        this.writeTableToPDF(_page, height, _options, this.monthTwoTable);
        this.writeTableToPDF(_page, height, _options, this.monthThreeTable);

        /* Save report and Download*/
        const pdfBytes = await pdfDoc.save();
        // Trigger the browser to download the PDF document
        download(
          pdfBytes,
          `IRS-941-Schedule-B-${Date.now()}.pdf`,
          "application/pdf"
        );
      }
    },
    convertToStringAndAddDecimal(_number) {
      let formatToString = _number.toString();
      let formatToCurrency = formatToString.includes(".")
        ? formatToString
        : (formatToString += ".00");
      return formatToCurrency.replace(/\d(?=(\d{3})+\.)/g, "$&,");
    },
    writeTableToPDF(_page, height, _options, tableArr) {
      // *N* is STARTING POINT
      // OFFSET X is 107 for All Tables
      // [ *53*, 155, 257, 357 ]
      // OFFSET Y is 18
      // OFFSET Y for Shifting Tables is *155*
      // [ *133*, 115 , 97 ] ROW *** 1
      // [ *-22*, ... ] ROW *** 2
      // [ *-180*, ... ] ROW *** 3

      const X = [53, 155, 257, 357];
      const Y = [133, -22, -180];
      let yCoordinate;
      const yOff = 18;

      tableArr.forEach((item, index) => {
        // ✅ Ignore Index 0
        // ✅ Modify the X coordinate based on Index 0 i.e ['table1', 'table2',...]

        if (item === "table1") {
          //  Update yCoordinate
          yCoordinate = Y[0];
          // Write the Months Liability
          _page.drawText(
            this.convertToStringAndAddDecimal(this.monthOneTableSum),
            {
              x: X[3] + yOff * 5.5,
              y: height / 2 + (yCoordinate - 15),
              ..._options,
            }
          );

          // console.error('We are on Table 1, with a Y Coordinate of ', yCoordinate);
        }

        if (item === "table2") {
          //  Update yCoordinate
          yCoordinate = Y[1];
          // Write the Months Liability
          _page.drawText(
            this.convertToStringAndAddDecimal(this.monthTwoTableSum),
            {
              x: X[3] + yOff * 5.5,
              y: height / 2 + (yCoordinate - 15),
              ..._options,
            }
          );
          // console.error('We are on Table 2, with a Y Coordinate of ', yCoordinate);
        }

        if (item === "table3") {
          //  Update yCoordinate
          yCoordinate = Y[2];
          // Write the Months Liability
          _page.drawText(
            this.convertToStringAndAddDecimal(this.monthThreeTableSum),
            {
              x: X[3] + yOff * 5.5,
              y: height / 2 + (yCoordinate - 15),
              ..._options,
            }
          );
          // console.error('We are on Table 3, with a Y Coordinate of ', yCoordinate);
        }

        /* Write Total Liability */
        _page.drawText(
          this.convertToStringAndAddDecimal(this.totalLiabilityForQuarter),
          {
            x: X[3] + yOff * 5.5,
            y: height / 2 + (Y[2] - X[1]),
            ..._options,
          }
        );

        // Update xOffset based on table and Index
        // Conditions for 1-8  9-16  17-24  25-31

        // console.warn('Item\'s value is ', item, ' with and index of type ', typeof index , ' and a index of ', index);
        /* Ignore 0 */
        if (index > 24) {
          // console.warn('Column 4 with an index of ', index);
          if (parseFloat(item) > 0) {
            _page.drawText(
              this.convertToStringAndAddDecimal(parseFloat(item).toFixed(2)),
              {
                x: X[3],
                y: height / 2 + (yCoordinate - yOff * (index - 25)),
                ..._options,
              }
            );
          }
        } else if (index > 16) {
          // console.warn('Column 3 with an index of ', index);
          if (parseFloat(item) > 0) {
            _page.drawText(
              this.convertToStringAndAddDecimal(parseFloat(item).toFixed(2)),
              {
                x: X[2],
                y: height / 2 + (yCoordinate - yOff * (index - 17)),
                ..._options,
              }
            );
          }
        } else if (index > 8) {
          // console.warn('Column 2 with an index of ', index);
          if (parseFloat(item) > 0) {
            _page.drawText(
              this.convertToStringAndAddDecimal(parseFloat(item).toFixed(2)),
              {
                x: X[1],
                y: height / 2 + (yCoordinate - yOff * (index - 9)),
                ..._options,
              }
            );
          }
        } else if (index >= 1) {
          // console.warn('Column 1');

          if (parseFloat(item) > 0) {
            _page.drawText(
              this.convertToStringAndAddDecimal(parseFloat(item).toFixed(2)),
              {
                x: X[0],
                y: height / 2 + (yCoordinate - yOff * (index - 1)),
                ..._options,
              }
            );
          }
        }
      });
    },
    async onStoreScheduleBRecord() {
      /*Report for this Quarter*/
      if (this.reportForThisQuarter == null) {
        this.errors.reportForThisQuarter = true;
      } else this.errors.reportForThisQuarter = false;

      if (this.errors.reportForThisQuarter) {
        this.$notify.error({
          title: "Error",
          message: "Please select a quarter.",
        });
      } else {
        // Make sure Calendar Year is always Selected before saving
        // For the month tables remove the first element and add up all values in the month for that months liability
        const monthOne = this.monthOneTable.filter((x) => x !== "table1");
        const monthTwo = this.monthTwoTable.filter((x) => x !== "table2");
        const monthThree = this.monthThreeTable.filter((x) => x !== "table3");

        // Make request here and post data
        const { data } = await axios.post("api/company/stored/new/b", {
          company_id: this.returnCurrentActiveCompany.id,
          form_name: "Schedule B",
          form_year: $("#sb_calendar_year_select").val(),
          eid: this.employerIdentificationNumber,
          name: this.name,
          quarter: this.reportForThisQuarter,
          month_one: JSON.stringify(monthOne),
          month_one_tax_liability: this.monthOneTableSum.toString(),
          month_two: JSON.stringify(monthTwo),
          month_two_tax_liability: this.monthTwoTableSum.toString(),
          month_three: JSON.stringify(monthThree),
          month_three_tax_liability: this.monthThreeTableSum.toString(),
          total_liability: this.totalLiabilityForQuarter.toString(),
        });

        this.$notify({
          title: "Success",
          message: "Record stored successfully.",
          type: "success",
        });
      }
    },
  },
  computed: {
    ...mapGetters(["returnCurrentActiveCompany"]),
    monthOneTableSum: function () {
      let mutatedMonthOne = this.monthOneTable.slice();
      mutatedMonthOne.shift();
      const _final = mutatedMonthOne
        .reduce((a, b) => parseFloat(a) + parseFloat(b), 0)
        .toFixed(2);
      this.storeFormScheduleBTaxLiabilityMonthOne(_final);
      return _final;
    },
    monthTwoTableSum: function () {
      let mutatedMonthTwo = this.monthTwoTable.slice();
      mutatedMonthTwo.shift();
      const _final = mutatedMonthTwo
        .reduce((a, b) => parseFloat(a) + parseFloat(b), 0)
        .toFixed(2);
      this.storeFormScheduleBTaxLiabilityMonthTwo(_final);
      return _final;
    },
    monthThreeTableSum: function () {
      let mutatedMonthThree = this.monthThreeTable.slice();
      mutatedMonthThree.shift();
      const _final = mutatedMonthThree
        .reduce((a, b) => parseFloat(a) + parseFloat(b), 0)
        .toFixed(2);
      this.storeFormScheduleBTaxLiabilityMonthThree(_final);
      return _final;
    },
    totalLiabilityForQuarter: function () {
      const totals = [
        this.monthOneTableSum,
        this.monthTwoTableSum,
        this.monthThreeTableSum,
      ];
      const _final = this.convertToStringAndAddDecimal(
        totals.reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2)
      );
      this.storeFormScheduleBTotalQuarterLiability(_final);
      return _final;
    },
  },
};
</script>

<style scoped>
button {
  border-radius: 0;
  width: 5rem !important;
}
</style>
