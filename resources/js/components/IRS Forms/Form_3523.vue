<template>
  <div class="container">
    <div class="row">
      <div class="position-fixed text-center" style="right: 1rem; bottom: 1rem">
        <el-button type="primary" @click="exportToPDF">Export</el-button>
      </div>

      <div class="col-12 text-center mb-3">
        <el-tag type="primary" class="d-block">
          <h4>Form 3523</h4>
        </el-tag>
      </div>

      <div class="col-12 mb-3">
        <el-switch
          class="d-block text-center mx-auto mb-2"
          v-model="toggleAlternateYear"
          active-text="2020"
          inactive-text="2019"
        ></el-switch>
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>Description</th>
            <th>Input</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">
              <!-- #5 -->
              <b>5</b> Wages for qualified services.
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field5.error" type="danger" class="mb-1"
                  >Error!</el-tag
                >
                <el-input
                  type="text"
                  v-model="field5.value"
                  placeholder="0"
                ></el-input>
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #6 -->
              <b>6</b> Cost of supplies
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field6.error" type="danger" class="mb-1"
                  >Error!</el-tag
                >
                <el-input
                  type="text"
                  v-model="field6.value"
                  placeholder="0"
                ></el-input>
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #7 -->
              <b>7</b> Rental or lease costs of computers
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field7.error" type="danger" class="mb-1"
                  >Error!</el-tag
                >
                <el-input
                  type="text"
                  v-model="field7.value"
                  placeholder="0"
                ></el-input>
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #8 -->
              <b>8</b> Enter the applicable percentage of contract research
              expenses.
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field8.error" type="danger" class="mb-1"
                  >Error!</el-tag
                >
                <el-input
                  type="text"
                  v-model="field8.value"
                  placeholder="0"
                ></el-input>
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #9 -->
              <b>9</b> Total qualified research expenses. Add line 5 through
              line 8
            </td>
            <td>
              {{ lineNineCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #10 -->
              <b>10</b> Enter fixed-base percentage, but not more than 16% (just
              enter a number 1-16 without the % character).
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field10.error" type="danger" class="mb-1"
                  >Error! Must not exceed 16%</el-tag
                >
                <el-input
                  type="text"
                  v-model="field10.value"
                  placeholder="0"
                ></el-input>
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #11 -->
              <b>11</b> Enter average annual gross receipts.
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field11.error" type="danger" class="mb-1"
                  >Error!</el-tag
                >
                <label for="">Year 1</label>
                <el-input
                  type="text"
                  v-model="field11InputYears.value_1"
                  placeholder="0"
                ></el-input>
                <label for="">Year 2</label>
                <el-input
                  type="text"
                  v-model="field11InputYears.value_2"
                  placeholder="0"
                ></el-input>
                <label for="">Year 3</label>
                <el-input
                  type="text"
                  v-model="field11InputYears.value_3"
                  placeholder="0"
                ></el-input>
                <label for="">Year 4</label>
                <el-input
                  type="text"
                  v-model="field11InputYears.value_4"
                  placeholder="0"
                ></el-input>

                <hr />
                {{ returnField11Average }}
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #12 -->
              <b>12</b> Base amount. Multiply line 11 by the percentage on line
              10
            </td>
            <td>
              {{ lineTwelveBaseAmountCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #13 -->
              <b>13</b> Subtract line 12 from line 9. If zero or less, enter -0-
            </td>
            <td>
              {{ lineThirteenCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #14 -->
              <b>14</b> Multiply line 9 by 50% (.50)
            </td>
            <td>
              {{ lineFourteenCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #15 -->
              <b>15</b> Enter the smaller of line 13 or line 14
            </td>
            <td>
              {{ lineFifteenCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #16 -->
              <b>16</b> Multiply line 15 by 15% (.15)
            </td>
            <td>
              {{ lineSixteenCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #17 -->
              <b>17a</b>
              Regular credit. Add line 4 and line 16. If you do not elect the
              reduced credit under IRC Section 280C(c), enter the result here,
              and see instructions for the schedule to attach
            </td>
            <td>
              {{ lineSeventeenACalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #17b -->
              <b>17b</b> Reduced regular credit under IRC Section 280C(c).
              Multiply line 17a by the applicable percentage below:
              <br />
              <el-radio-group v-model="field17RadioBtn">
                <el-radio label="a"
                  >87.7% (.877) for individuals, estates, and trusts</el-radio
                >
                <el-radio label="b">91.16% (.9116) for corporations</el-radio>
                <el-radio label="c">98.5% (.985) for S corporations</el-radio>
                <el-radio label="d">Leave blank</el-radio> </el-radio-group
              >> Enter the reduced credit amount. See instructions
            </td>
            <td>
              {{ lineSeventeenBCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #41 -->
              <b>41</b> Current year research credit. If you did not elect the
              reduced credit under IRC Section 280C(c), add line 17a or line 39a
              to line 40 and enter the result here. If you elected the reduced
              credit under IRC Section 280C(c), add line 17b or line 39b to line
              40 and enter the result here
            </td>
            <td>
              {{ lineSeventeenBCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #43 -->
              <b>43</b> Subtract line 42 from line 41
            </td>
            <td>
              {{ lineSeventeenBCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #45 -->
              <b>45</b> Non-passive activity credit carryover from prior year.
              (Do not include credits received through assignment.)
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field45.error" type="danger" class="mb-1"
                  >Error!</el-tag
                >
                <el-input
                  type="text"
                  v-model="field45.value"
                  placeholder="0"
                ></el-input>
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #46 -->
              <b>46</b> Total. Add line 43 through line 45
            </td>
            <td>
              {{ lineFortySixTotalCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #47 -->
              <b>47</b> Credit claimed. Enter the amount of the credit claimed
              on the current year tax return. See instructions. (Do not include
              any assigned credit claimed on form FTB 3544, Part B.)
            </td>
            <td>
              <div class="form-group">
                <el-tag v-show="field47.error" type="danger" class="mb-1"
                  >Error!</el-tag
                >
                <el-input
                  type="text"
                  v-model="field47.value"
                  placeholder="0"
                ></el-input>
              </div>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!-- #49 -->
              <b>49</b> Credit carryover available for use or assignment for
              future years. Subtract lines 47 and 48 from line 46
            </td>
            <td>
              {{ line49Calculation }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import download from "downloadjs";

import NumberFormatter from "../../utilities/NumberFormatter";

export default {
  name: "Form_3523",
  props: {
    formUrl: String,
    disableDownload: String,
  },
  data() {
    return {
      tempUrl: "",
      toggleAlternateYear: true,
      field5: {
        value: 0,
        error: false,
      },
      field6: {
        value: 0,
        error: false,
      },
      field7: {
        value: 0,
        error: false,
      },
      field8: {
        value: 0,
        error: false,
      },
      field10: {
        value: 0,
        error: false,
      },
      field11: {
        value: 0,
        error: false,
      },
      field11InputYears: {
        value_1: 0,
        value_2: 0,
        value_3: 0,
        value_4: 0,
      },
      field17RadioBtn: "",
      field45: {
        value: 0,
        error: false,
      },
      field47: {
        value: 0,
        error: false,
      },
    };
  },
  computed: {
    lineNineCalculation() {
      const a = [
        NumberFormatter.parseNumber(this.field5.value),
        NumberFormatter.parseNumber(this.field6.value),
        NumberFormatter.parseNumber(this.field7.value),
        NumberFormatter.parseNumber(this.field8.value),
      ];
      return a.reduce((a, b) => a + b, 0).toFixed(2);
    },
    lineTwelveBaseAmountCalculation() {
      return (this.field11.value * (this.field10.value / 100)).toFixed(2);
    },
    lineThirteenCalculation() {
      // Subtract line 12 from line 9. If zero or less, enter -0-
      const t = (
        this.lineNineCalculation - this.lineTwelveBaseAmountCalculation
      ).toFixed(2);
      return t <= 0 ? "-0-" : t;
    },
    lineFourteenCalculation() {
      // Multiply line 9 by 50% (.50)
      return (this.lineNineCalculation * 0.5).toFixed(2);
    },
    lineFifteenCalculation() {
      // Enter the smaller of line 13 or line 14
      return parseFloat(this.lineThirteenCalculation) <
        parseFloat(this.lineFourteenCalculation)
        ? this.lineThirteenCalculation
        : this.lineFourteenCalculation;
    },
    lineSixteenCalculation() {
      return NumberFormatter.parseNumber(
        this.lineFifteenCalculation * 0.15
      ).toFixed(2);
    },
    lineSeventeenACalculation() {
      return this.lineSixteenCalculation;
    },
    lineSeventeenBCalculation() {
      switch (this.field17RadioBtn) {
        case "a":
          return (this.lineSeventeenACalculation * 0.877).toFixed(2);
        case "b":
          return (this.lineSeventeenACalculation * 0.9116).toFixed(2);
        case "c":
          return (this.lineSeventeenACalculation * 0.985).toFixed(2);
        case "d":
          return (this.lineSeventeenACalculation * 1).toFixed(2);
      }
    },
    lineFortySixTotalCalculation() {
      // Total. Add line 43 through line 45
      return (
        NumberFormatter.parseNumber(this.field45.value) +
        NumberFormatter.parseNumber(this.lineSeventeenBCalculation)
      ).toFixed(2);
    },
    line49Calculation() {
      // Subtract lines 47 and 48 from line 46
      return (
        this.lineFortySixTotalCalculation -
        NumberFormatter.parseNumber(this.field47.value).toFixed(2)
      ).toFixed(2);
    },
    returnField11Average() {
      const _n = [
        parseFloat(this.field11InputYears.value_1),
        parseFloat(this.field11InputYears.value_2),
        parseFloat(this.field11InputYears.value_3),
        parseFloat(this.field11InputYears.value_4),
      ];
      const _avg = ((_n.reduce((a, b) => a + b, 0) || 0) / 4).toFixed(2);
      this.field11.value = _avg;
      return _avg;
    },
  },
  methods: {
    validation() {
      /* #5 */
      if (
        !NumberFormatter.isANumber(this.field5.value) &&
        !NumberFormatter.isEmpty(this.field5.value)
      ) {
        this.field5.error = false;
      } else {
        this.field5.error = true;
        return false;
      }

      /* #6 */
      if (
        !NumberFormatter.isANumber(this.field6.value) &&
        !NumberFormatter.isEmpty(this.field6.value)
      ) {
        this.field6.error = false;
      } else {
        this.field6.error = true;
        return false;
      }

      /* #7 */
      if (
        !NumberFormatter.isANumber(this.field7.value) &&
        !NumberFormatter.isEmpty(this.field7.value)
      ) {
        this.field7.error = false;
      } else {
        this.field7.error = true;
        return false;
      }

      /* #8 */
      if (
        !NumberFormatter.isANumber(this.field8.value) &&
        !NumberFormatter.isEmpty(this.field8.value)
      ) {
        this.field8.error = false;
      } else {
        this.field8.error = true;
        return false;
      }

      /* #10 */
      if (
        !NumberFormatter.isANumber(this.field10.value) &&
        !NumberFormatter.isEmpty(this.field10.value) &&
        NumberFormatter.noGreaterThan16Percent(this.field10.value)
      ) {
        this.field10.error = false;
      } else {
        this.field10.error = true;
        return false;
      }

      /* #11 */
      if (
        !NumberFormatter.isANumber(this.field11.value) &&
        !NumberFormatter.isEmpty(this.field11.value)
      ) {
        this.field11.error = false;
      } else {
        this.field11.error = true;
        return false;
      }

      /* #45 */
      if (
        !NumberFormatter.isANumber(this.field45.value) &&
        !NumberFormatter.isEmpty(this.field45.value)
      ) {
        this.field45.error = false;
      } else {
        this.field45.error = true;
        return false;
      }

      /* #47 */
      if (
        !NumberFormatter.isANumber(this.field47.value) &&
        !NumberFormatter.isEmpty(this.field47.value)
      ) {
        this.field47.error = false;
      } else {
        this.field47.error = true;
        return false;
      }

      return true;
    },
    async exportToPDF() {
      if (this.validation()) {
        this.tempUrl = this.formUrl;
        // Modify URL for 2020/2019
        if (this.toggleAlternateYear) {
          // 2020
          this.formUrl = this.tempUrl.replace(
            "Form_3523.pdf",
            "2020 Form 3523 for Sam.pdf"
          );
        } else {
          this.formUrl = this.tempUrl.replace(
            "2020 Form 3523 for Sam.pdf",
            "Form_3523.pdf"
          );
        }

        // Output to PDF and fire download event
        /* Write all contents to Final PDF */
        const existingPdfBytes = await fetch(this.formUrl).then((res) =>
          res.arrayBuffer()
        );

        const pdfDoc = await PDFDocument.load(existingPdfBytes);
        const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);

        const pages = pdfDoc.getPages();
        const firstPage = pages[0];
        const secondPage = pages[1];
        const { width, height } = firstPage.getSize();
        const COLOR = rgb(0, 0, 0);
        const baseOptions = {
          size: 10,
          font: helveticaFont,
          color: COLOR,
        };

        // #5
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field5.value),
          {
            x: 500,
            y: height / 2 + 80,
            ...baseOptions,
          }
        );

        // #6
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field6.value),
          {
            x: 500,
            y: height / 2 + 55,
            ...baseOptions,
          }
        );

        // #7
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field7.value),
          {
            x: 500,
            y: height / 2 + 30,
            ...baseOptions,
          }
        );

        // #8
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field8.value),
          {
            x: 500,
            y: height / 2 + 5,
            ...baseOptions,
          }
        );

        // #9
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineNineCalculation
          ),
          {
            x: 500,
            y: height / 2 - 20,
            ...baseOptions,
          }
        );

        // #10
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field10.value),
          {
            x: 500,
            y: height / 2 - 43,
            ...baseOptions,
          }
        );

        // #11
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field11.value),
          {
            x: 500,
            y: height / 2 - 67,
            ...baseOptions,
          }
        );

        // #12
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineTwelveBaseAmountCalculation
          ),
          {
            x: 500,
            y: height / 2 - 92,
            ...baseOptions,
          }
        );

        // #13
        if (this.lineThirteenCalculation === "-0-") {
          firstPage.drawText("-0-", {
            x: 500,
            y: height / 2 - 115,
            ...baseOptions,
          });
        } else {
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineThirteenCalculation
            ),
            {
              x: 500,
              y: height / 2 - 115,
              ...baseOptions,
            }
          );
        }

        // #14
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineFourteenCalculation
          ),
          {
            x: 500,
            y: height / 2 - 140,
            ...baseOptions,
          }
        );

        // #15
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineFifteenCalculation
          ),
          {
            x: 500,
            y: height / 2 - 165,
            ...baseOptions,
          }
        );

        // #16
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineSixteenCalculation
          ),
          {
            x: 500,
            y: height / 2 - 188,
            ...baseOptions,
          }
        );

        // #17A
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineSeventeenACalculation
          ),
          {
            x: 500,
            y: height / 2 - 220,
            ...baseOptions,
          }
        );

        // #17B
        firstPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineSeventeenBCalculation
          ),
          {
            x: 500,
            y: height / 2 - 285,
            ...baseOptions,
          }
        );

        // #41
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineSeventeenBCalculation
          ),
          {
            x: 500,
            y: height / 2 - 115,
            ...baseOptions,
          }
        );

        // #43
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineSeventeenBCalculation
          ),
          {
            x: 500,
            y: height / 2 - 155,
            ...baseOptions,
          }
        );

        // #45
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field45.value),
          {
            x: 500,
            y: height / 2 - 178,
            ...baseOptions,
          }
        );

        // #46
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineFortySixTotalCalculation
          ),
          {
            x: 500,
            y: height / 2 - 190,
            ...baseOptions,
          }
        );

        // #47
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.field47.value),
          {
            x: 500,
            y: height / 2 - 235,
            ...baseOptions,
          }
        );

        // #49
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(this.line49Calculation),
          {
            x: 500,
            y: height / 2 - 285,
            ...baseOptions,
          }
        );

        /* Save report and Download*/
        const pdfBytes = await pdfDoc.save();
        // Trigger the browser to download the PDF document
        download(pdfBytes, `IRS-3523-${Date.now()}.pdf`, "application/pdf");
      }
    },
  },
};
</script>

<style scoped>
</style>
