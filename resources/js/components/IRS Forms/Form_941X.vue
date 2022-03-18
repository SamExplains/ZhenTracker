<template>
  <div class="row justify-content-center">
    <div class="row d-none">
      {{ returnEmployerIdentificationNumber() }}
      {{ returnName() }}
      {{ returnTradeName() }}
      {{ returnAddress() }}
      {{ returnCity() }}
      {{ returnState() }}
      {{ returnZip() }}
      {{ returnForeignName() }}
      {{ returnForeignProvince() }}
      {{ returnForeignZip() }}
      {{ returnForm8974Line12() }}
    </div>

    <div class="col-12 mt-3 mb-3">
      <h4 class="alert-info p-2 text-center">Form 941 X</h4>
    </div>

    <!--TOP OF FORM-->
    <div class="col-lg-10 col-12 bg-white mt-4 p-3 text-left">
      <div class="row">
        <div class="position-fixed" style="right: 1rem; bottom: 1rem">
          <div v-show="disableDownload !== 'Y'">
            <button
              class="btn btn-primary d-inline export"
              @click="exportToPDF"
            >
              Export
            </button>
          </div>
        </div>

        <div
          class="col-12"
          :class="{
            'alert-danger': errors.formTypeSelected,
            'alert-success': errors.formTypeSelected === false,
          }"
        >
          <h6>
            Select the form year you would like to use.
            <b>{{ formTypeSelected }}</b>
          </h6>
          <el-radio-group v-model="formTypeSelected">
            <el-radio :label="'2017'">941X 2017</el-radio>
            <!-- <el-radio :label="'2020J'">941X July 2020</el-radio>
            <el-radio :label="'2020O'">941X October 2020</el-radio> -->
          </el-radio-group>
        </div>

        <div class="col-8">
          <div class="row">
            <div class="col-5 font-weight-bold mb-2">
              Employer identification number
            </div>
            <div class="col-7 my-auto">
              <input
                type="text"
                class="form-control"
                :class="{
                  'is-invalid': errors.employerIdentificationNumber,
                  'is-valid': errors.employerIdentificationNumber === false,
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

            <!--Trade Name-->
            <div class="col-5 font-weight-bold mb-2">Trade Name</div>
            <div class="col-7 my-auto">
              <input
                type="text"
                class="form-control mb-2"
                :class="{
                  'is-invalid': errors.tradeName,
                  'is-valid': errors.tradeName === false,
                }"
                minlength="1"
                v-model="tradeName"
              />
            </div>

            <!--Address-->
            <div class="col-5 font-weight-bold mb-2">Address</div>
            <div class="col-7 my-auto">
              <div class="row">
                <div class="col-12">
                  <input
                    type="text"
                    placeholder="Number     Street"
                    class="form-control mb-2"
                    :class="{
                      'is-invalid': errors.address,
                      'is-valid': errors.address === false,
                    }"
                    minlength="1"
                    v-model="address"
                  />
                </div>
                <div class="col-12">
                  <input
                    type="text"
                    placeholder="City"
                    class="form-control mb-2"
                    :class="{
                      'is-invalid': errors.city,
                      'is-valid': errors.city === false,
                    }"
                    v-model="city"
                  />
                </div>
                <div class="col-12">
                  <input
                    type="text"
                    placeholder="State"
                    class="form-control mb-2 text-uppercase"
                    :class="{
                      'is-invalid': errors.state,
                      'is-valid': errors.state === false,
                    }"
                    minlength="2"
                    maxlength="2"
                    v-model="state"
                  />
                </div>
                <div class="col-12">
                  <input
                    type="text"
                    placeholder="ZIP"
                    class="form-control mb-2"
                    :class="{
                      'is-invalid': errors.zip,
                      'is-valid': errors.zip === false,
                    }"
                    minlength="5"
                    maxlength="5"
                    v-model="zip"
                  />
                </div>
                <div class="col-12">
                  <input
                    type="text"
                    placeholder="Foreign country name"
                    class="form-control mb-2"
                    v-model="f_countryName"
                  />
                </div>
                <div class="col-12">
                  <input
                    type="text"
                    placeholder="Foreign province/country"
                    class="form-control mb-2"
                    v-model="f_countryProvince"
                  />
                </div>
                <div class="col-12">
                  <input
                    type="text"
                    placeholder="Foreign postal code"
                    class="form-control mb-2"
                    minlength="5"
                    maxlength="5"
                    v-model="f_countryZIP"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div v-show="errors.correctionType" class="alert alert-danger p-2">
            Select correction type
          </div>

          <div class="form-check">
            <h6 class="font-weight-bold bg-dark p-2 text-white mb-2">
              Return You're Correcting ...
            </h6>
            <p>Check the type of return you're correcting.</p>
            <label class="form-check-label d-block mt-2">
              <input
                type="radio"
                class="form-check-input"
                name="correctionType"
                v-model="correctionType"
                value="1"
              />
              941
            </label>
            <label class="form-check-label d-block mt-2">
              <input
                type="radio"
                class="form-check-input"
                name="correctionType"
                v-model="correctionType"
                value="2"
              />
              941-SS
            </label>
          </div>
          <div class="form-check">
            <h6 class="font-weight-bold bg-dark p-2 text-white mb-2 mt-2">
              Report for this quarter <small>check only one box</small>
            </h6>

            <div
              v-show="errors.reportForThisQuarter"
              class="alert alert-danger p-2"
            >
              Select correction type
            </div>

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

          <h6 class="font-weight-bold bg-dark p-2 text-white mb-2 mt-2">
            Enter the calendar year of the quarter you're correcting.
          </h6>
          <flatpickr
            timeFormat="m-d-Y"
            v-model="calendarYear"
            v-on:updatedDate="logNewDate"
            class="mt-2"
            id="form_941X_calendar_year_select"
          />

          <h6 class="font-weight-bold bg-dark p-2 text-white mb-2 mt-2">
            Enter the date you discovered errors.
          </h6>
          <flatpickr
            timeFormat="m-d-Y"
            v-model="dateDiscoveredError"
            v-on:updatedDate="logNewErrorDate"
            class="mt-2"
            id="form_941X_dateDiscoveredError"
          />
        </div>

        <div class="col-12 mt-2 mb-2">
          Read the separate instructions before completing this form. Use this
          form to correct errors you made on Form 941 or 941-SS. Use a separate
          Form 941-X for each quarter that needs correction. Type or print
          within the boxes. You MUST complete all three pages. Don't attach this
          form to Form 941 or 941-SS.
        </div>
      </div>
    </div>

    <!--#############-->
    <!--###### Part 1-->
    <!--############-->
    <div class="col-lg-10 col-12 bg-white p-3">
      <div class="row">
        <div class="col-12">
          <div class="bg-dark p-2 text-white mb-3">
            Part 1
            <span class="bg-white text-dark p-1 ml-2"
              >Select ONLY one process. See page 4 for additional
              guidance.</span
            >
          </div>

          <div
            v-show="errors.partOneProcessType"
            class="alert alert-danger p-2"
          >
            Select one process
          </div>

          <div class="form-check">
            <label class="form-check-label mb-2">
              <input
                class="form-check-input"
                type="radio"
                v-model="partOneProcessType"
                name="partOneProcessType"
                value="1"
              />
              <b>1.</b> Adjusted employment tax return. Check this box if you
              underreported amounts. Also check this box if you overreported
              amounts and you would like to use the adjustment process to
              correct the errors. You must check this box if you're correcting
              both underreported and overreported amounts on this form. The
              amount shown on line 21, if less than zero, may only be applied as
              a credit to your Form 941, Form 941-SS, or Form 944 for the tax
              period in which you're filing this form.
            </label>

            <label class="form-check-label mb-2">
              <input
                class="form-check-input"
                type="radio"
                v-model="partOneProcessType"
                name="partOneProcessType"
                value="2"
              />
              <b>2.</b> Claim. Check this box if you overreported amounts only
              and you would like to use the claim process to ask for a refund or
              abatement of the amount shown on line 21. Don't check this box if
              you're correcting ANY underreported amounts on this form.
            </label>
          </div>
        </div>
      </div>
    </div>

    <!--#############-->
    <!--###### Part 2-->
    <!--############-->
    <div class="col-lg-10 col-12 bg-white p-3">
      <div class="bg-dark p-2 text-white mb-3">
        Part 2
        <span class="bg-white text-dark p-1 ml-2"
          >Complete the certifications.</span
        >
      </div>
      <div class="row">
        <!--#########-->
        <!--##### #3-->
        <!--#########-->
        <div class="col-12">
          <div class="form-check form-check-inline">
            <label class="form-check-label">
              <input
                class="form-check-input"
                type="radio"
                v-model="part2Number3"
                value="1"
              />
              <b>3.</b> I certify that I've filed or will file Forms W-2, Wage
              and Tax Statement, or Forms W-2c, Corrected Wage and Tax
              Statement, as required.
              <p>
                <b>Note:</b> If you're correcting underreported amounts only, go
                to Part 3 on page 2 and skip lines 4 and 5. If you're correcting
                overreported amounts, for purposes of the certifications on
                lines 4 and 5, Medicare tax doesn't include Additional Medicare
                Tax. Form 941-X can't be used to correct overreported amounts of
                Additional Medicare Tax unless the amounts weren't withheld from
                employee wages or an adjustment is being made for the current
                year.
              </p>
            </label>
          </div>
        </div>

        <!--#########-->
        <!--##### #4-->
        <!--#########-->
        <div class="col-12">
          <b>4.</b> If you checked line 1 because you're adjusting overreported
          amounts, check all that apply. You must check at least one box. I
          certify that:

          <table class="table table-striped mt-2">
            <thead>
              <tr>
                <th></th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="row">
                  <input type="checkbox" v-model="part2Number4" value="a" />
                </td>
                <td>
                  <b>a.</b> I repaid or reimbursed each affected employee for
                  the overcollected federal income tax or Additional Medicare
                  Tax for the current year and the overcollected social security
                  tax and Medicare tax for current and prior years. For
                  adjustments of employee social security tax and Medicare tax
                  overcollected in prior years, I have a written statement from
                  each affected employee stating that he or she hasn't claimed
                  (or the claim was rejected) and won't claim a refund or credit
                  for the overcollection.
                </td>
              </tr>
              <tr>
                <td scope="row">
                  <input type="checkbox" v-model="part2Number4" value="b" />
                </td>
                <td>
                  <b>b.</b> The adjustments of social security tax and Medicare
                  tax are for the employer’s share only. I couldn't find the
                  affected employees or each affected employee didn't give me a
                  written statement that he or she hasn't claimed (or the claim
                  was rejected) and won't claim a refund or credit for the
                  overcollection.
                </td>
              </tr>
              <tr>
                <td scope="row">
                  <input type="checkbox" v-model="part2Number4" value="c" />
                </td>
                <td>
                  <b>c.</b> The adjustment is for federal income tax, social
                  security tax, Medicare tax, or Additional Medicare Tax that I
                  didn't withhold from employee wages.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!--#########-->
        <!--##### #5-->
        <!--#########-->
        <div class="col-12">
          <b>5.</b> If you checked line 2 because you're claiming a refund or
          abatement of overreported employment taxes, check all that apply. You
          must check at least one box. I certify that:

          <table class="table table-striped mt-2">
            <thead>
              <tr>
                <th></th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="row">
                  <input type="checkbox" v-model="part2Number5" value="a" />
                </td>
                <td>
                  <b>a.</b> I repaid or reimbursed each affected employee for
                  the overcollected social security tax and Medicare tax. For
                  claims of employee social security tax and Medicare tax
                  overcollected in prior years, I have a written statement from
                  each affected employee stating that he or she hasn't claimed
                  (or the claim was rejected) and won't claim a refund or credit
                  for the overcollection.
                </td>
              </tr>
              <tr>
                <td scope="row">
                  <input type="checkbox" v-model="part2Number5" value="b" />
                </td>
                <td>
                  <b>b.</b> I have a written consent from each affected employee
                  stating that I may file this claim for the employee’s share of
                  social security tax and Medicare tax. For refunds of employee
                  social security tax and Medicare tax overcollected in prior
                  years, I also have a written statement from each affected
                  employee stating that he or she hasn't claimed (or the claim
                  was rejected) and won't claim a refund or credit for the
                  overcollection.
                </td>
              </tr>
              <tr>
                <td scope="row">
                  <input type="checkbox" v-model="part2Number5" value="c" />
                </td>
                <td>
                  <b>c.</b> The claim for social security tax and Medicare tax
                  is for the employer’s share only. I couldn't find the affected
                  employees; or each affected employee didn't give me a written
                  consent to file a claim for the employee’s share of social
                  security tax and Medicare tax; or each affected employee
                  didn't give me a written statement that he or she hasn't
                  claimed (or the claim was rejected) and won't claim a refund
                  or credit for the overcollection.
                </td>
              </tr>
              <tr>
                <td scope="row">
                  <input type="checkbox" v-model="part2Number5" value="d" />
                </td>
                <td>
                  <b>d.</b> The claim is for federal income tax, social security
                  tax, Medicare tax, or Additional Medicare Tax that I didn't
                  withhold from employee wages.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!--Name, EIN, Quarter and Date -->
        <div class="col-12">
          <table class="table text-center">
            <thead>
              <tr>
                <th>Name</th>
                <th>Employer identification number (EIN)</th>
                <th>Correcting quarter</th>
                <th>Correcting calendar year</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="row">{{ name }}</td>
                <td>{{ employerIdentificationNumber }}</td>
                <td>{{ reportForThisQuarter }}</td>
                <td>{{ calendarYear }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!--#############-->
    <!--###### Part 3-->
    <!--############-->
    <div class="col-lg-12 col-12 bg-white p-3">
      <div class="bg-dark p-2 text-white mb-3">
        Part 3
        <span class="bg-white text-dark p-1 ml-2"
          >Enter the corrections for this quarter. If any line doesn't apply,
          leave it blank.</span
        >
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Description</th>
            <th>Column 1 Total corrected amount (for ALL employees)</th>
            <th>
              Column 2 Amount originally reported or as previously corrected
              (for ALL employees)
            </th>
            <th>
              Column 3 Difference (If this amount is a negative number, use a
              minus sign.)
            </th>
            <th>Column 4 Tax correction</th>
          </tr>
        </thead>
        <tbody>
          <!--P3 #14-->
          <tr>
            <td
              v-if="
                formTypeSelected === '2020J' || formTypeSelected === '2020O'
              "
            >
              16. Qualified small business payroll tax credit for increasing
              research activities (Form 941 or 941-SS, line 11a; you must attach
              Form 8974)
            </td>
            <td v-else>
              14. Qualified small business payroll tax credit for increasing
              research activities (Form 941 or 941-SS, line 11; you must attach
              Form 8974)
            </td>
            <td>
              <el-input
                placeholder="Please input"
                v-model="part3.number14.column1"
              ></el-input>
            </td>
            <td>
              <el-input
                placeholder="Please input"
                v-model="part3.number14.column2"
              ></el-input>
            </td>
            <td>
              {{ lineFourteenDifference }}
            </td>
            <td>
              {{ returnCorrectedCreditBalance }}
            </td>
          </tr>
          <tr>
            <td>19. Combine the amounts on lines 7–18 of Column 4 .</td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              {{ returnCorrectedCreditBalance }}
            </td>
          </tr>
          <tr>
            <td>
              <p>
                21. Total. Combine the amounts on lines 19 and 20a of Column 4.
              </p>
              <p>If line 21 is less than zero:</p>
              <p>
                • If you checked line 1, this is the amount you want applied as
                a credit to your Form 941 for the tax period in which you're
                filing this form. (If you're currently filing a Form 944,
                Employer’s ANNUAL Federal Tax Return, see the instructions.) •
                If you checked line 2, this is the amount you want refunded or
                abated. If line 21 is more than zero, this is the amount you
                owe. Pay this amount by the time you file this return. For
                information on how to pay, see Amount you owe in the
                instructions.
              </p>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              {{ returnCorrectedCreditBalance }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-lg-12 col-12 bg-white p-3">
      <div class="bg-dark p-2 text-white mb-3">
        Part 4:
        <span class="bg-white text-dark p-1 ml-2"
          >Explain your corrections for this quarter</span
        >
      </div>
      <div class="row">
        <div class="col-12">
          <!--#22-->
          <el-checkbox v-model="part4.line22" class="d-block"
            >22. Check here if any corrections you entered on a line include
            both underreported and overreported amounts. Explain both your
            underreported and overreported amounts on line 24.</el-checkbox
          >
          <!--#23-->
          <el-checkbox v-model="part4.line23"
            >23. Check here if any corrections involve reclassified workers.
            Explain on line 24.
          </el-checkbox>
          <!--#24 : 27 lines total-->
          <p>
            24. You must give us a detailed explanation of how you determined
            your corrections. See the instructions.
          </p>
          <!--          <el-input-->
          <!--            type="textarea"-->
          <!--            :autosize="{ minRows: 5}"-->
          <!--            placeholder="Please input"-->
          <!--            v-model="part4.line24">-->
          <!--          </el-input>-->

          <div
            v-for="(row, index) in part4Line24Contents"
            class="col-12"
            :class="index % 2 > 0 ? 'bg-light' : ''"
          >
            <div class="form-group">
              <label>{{ index }}</label>
              <input
                type="text"
                maxlength="100"
                class="form-control"
                v-model="part4Line24Contents[index]"
              />
            </div>
          </div>

          <!-- Max Len is 97-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import download from "downloadjs";
import * as $ from "jquery";
import { mapGetters } from "vuex";

export default {
  name: "Form_941X",
  props: {
    formUrl: String,
    disableDownload: String,
  },
  beforeUpdate() {
    if (this.disableDownload === "Y") {
      // this.part3.number14.column1 = this.returnForm8974Line12();
      this.employerIdentificationNumber =
        this.returnEmployerIdentificationNumber();
      this.name = this.returnName();
      this.tradeName = this.returnTradeName();
      this.address = this.returnAddress();
      this.city = this.returnCity();
      this.state = this.returnState();
      this.zip = this.returnZip();
      this.f_countryName = this.returnForeignName();
      this.f_countryProvince = this.returnForeignProvince();
      this.f_countryZIP = this.returnForeignZip();
      this.qualifiedSmallBusinessPayroll = this.returnForm8974Line12();
    }
  },
  mounted() {
    this.url = this.formUrl;
    this.unmodifiedUrl = this.formUrl;
    this.calendarYear = this.returnCalendarYear();
    this.dateDiscoveredError = this.returnCurrentErrorCalendarYear();
    // console.log('Form 941X component with url is ', this.url);
    if (this.returnCurrentActiveCompany) {
      this.employerIdentificationNumber = this.returnCurrentActiveCompany.ein;
      this.name = this.returnCurrentActiveCompany.name;
    }
  },
  watch: {
    part4Line24Contents: function () {
      // console.log(this.part4Line24Contents);
    },
  },
  data() {
    return {
      // Name Portion
      formTypeSelected: "",
      url: null,
      unmodifiedUrl: null,
      employerIdentificationNumber: "",
      name: "",
      tradeName: "",
      address: "",
      city: "",
      state: "",
      zip: "",
      f_countryName: "",
      f_countryProvince: "",
      f_countryZIP: "",
      correctionType: null,
      reportForThisQuarter: null,
      calendarYear: null,
      dateDiscoveredError: null,
      //Part 1
      partOneProcessType: null,
      part2Number3: null,
      part2Number4: [],
      part2Number5: [],
      // Part 2
      part3: {
        number6: {
          column1: 0,
          column2: 0,
          column3: 0,
        },
        number7: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number8: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number9: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number10: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number11: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number12: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number13: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number14: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number15: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number16: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number17: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number18: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number19: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number20a: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number20b: {
          column1: 0,
          column2: 0,
          column3: 0,
          column4: 0,
        },
        number21: {
          column4: 0,
        },
      },
      part4: {
        line22: false,
        line23: false,
        line24: "",
      },
      part4Line24Contents: [
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
      ],
      // Errors
      errors: {
        formTypeSelected: null,
        employerIdentificationNumber: null,
        name: null,
        address: null,
        city: null,
        state: null,
        zip: null,
        correctionType: null,
        reportForThisQuarter: null,
        partOneProcessType: null,
      },
    };
  },
  methods: {
    ...mapGetters(["returnForm8974Line12"]),
    ...mapGetters([
      "returnEmployerIdentificationNumber",
      "returnName",
      "returnTradeName",
      "returnAddress",
      "returnCity",
      "returnState",
      "returnZip",
      "returnForeignName",
      "returnForeignProvince",
      "returnForeignZip",
      "returnForm8974Line12",
    ]),
    exportToPDF: async function () {
      // console.log('exportToPDF');

      // console.log('Validation results');
      if (this.validation()) {
        // console.log('Validation success');

        // Reset Url
        this.url = this.unmodifiedUrl;

        if (this.formTypeSelected === "2020J") {
          this.url = this.url.replace("form 941X.pdf", "form 941X 2020J.pdf");
          // console.error('2020J Was Selected: URL: ', this.url);
        }

        if (this.formTypeSelected === "2020O") {
          this.url = this.url.replace(
            "form 941X.pdf",
            "form 941X 2020 Q3 Form 941X Official IRS FORM.pdf"
          );
          // console.error('2020O Was Selected: URL: ', this.url);
        }

        /* Write all contents to Final PDF */
        const existingPdfBytes = await fetch(this.url).then((res) =>
          res.arrayBuffer()
        );

        const pdfDoc = await PDFDocument.load(existingPdfBytes);
        const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);

        const pages = pdfDoc.getPages();
        const firstPage = pages[0];
        const secondPage = pages[1];
        const thirdPage = pages[2];
        const fourthPage = pages[3];
        const { width, height } = firstPage.getSize();
        const COLOR = rgb(0, 0, 0);
        const baseOptions = {
          size: 10,
          font: helveticaFont,
          color: COLOR,
        };

        let ein_mutated = this.employerIdentificationNumber.split("");
        for (let i = 0; i < 9; i++) {
          let ein_XCoordinate = [160, 185, 225, 250, 275, 300, 325, 350, 375];

          firstPage.drawText(ein_mutated[i], {
            x: ein_XCoordinate[i],
            y: height / 2 + 318,
            ...baseOptions,
          });
        }

        firstPage.drawText(this.name, {
          x: 150,
          y: height / 2 + 295,
          ...baseOptions,
        });

        /*  IF – TradeName */
        if (this.tradeName !== null) {
          firstPage.drawText(this.tradeName, {
            x: 135,
            y: height / 2 + 270,
            ...baseOptions,
          });
        }

        /*Address*/
        firstPage.drawText(this.address, {
          x: 95,
          y: height / 2 + 245,
          ...baseOptions,
        });

        /*City*/
        firstPage.drawText(this.city, {
          x: 95,
          y: height / 2 + 215,
          ...baseOptions,
        });

        /*State*/
        firstPage.drawText(this.state, {
          x: 285,
          y: height / 2 + 215,
          ...baseOptions,
        });

        /*ZIP*/
        firstPage.drawText(this.zip, {
          x: 325,
          y: height / 2 + 215,
          ...baseOptions,
        });

        /* IF – Foreign Country*/
        if (this.f_countryName !== null) {
          firstPage.drawText(this.f_countryName.toString(), {
            x: 95,
            y: height / 2 + 185,
            ...baseOptions,
          });
        }

        /* IF – Foreign Province*/
        if (this.f_countryProvince !== null) {
          firstPage.drawText(this.f_countryProvince.toString(), {
            x: 235,
            y: height / 2 + 185,
            ...baseOptions,
          });
        }

        /* IF – Foreign Province*/
        if (this.f_countryZIP !== null) {
          firstPage.drawText(this.f_countryZIP.toString(), {
            x: 335,
            y: height / 2 + 185,
            ...baseOptions,
          });
        }

        if (parseInt(this.correctionType) === 1) {
          // console.warn('Value of 1 ', this.correctionType);
          firstPage.drawText("x", {
            x: 430,
            y: height / 2 + 292,
            ...baseOptions,
          });
        } else {
          // console.warn('Value of 2 ', this.correctionType);
          firstPage.drawText("x", {
            x: 430,
            y: height / 2 + 273,
            ...baseOptions,
          });
        }

        /* Report for this quarter */
        switch (this.reportForThisQuarter) {
          case "1":
            firstPage.drawText("x", {
              x: 430,
              y: height / 2 + 237,
              ...baseOptions,
            });
            break;
          case "2":
            firstPage.drawText("x", {
              x: 430,
              y: height / 2 + 220,
              ...baseOptions,
            });
            break;
          case "3":
            firstPage.drawText("x", {
              x: 430,
              y: height / 2 + 200,
              ...baseOptions,
            });
            break;
          case "4":
            firstPage.drawText("x", {
              x: 430,
              y: height / 2 + 184,
              ...baseOptions,
            });
            break;
        }

        // Calendar Year Quarter
        const _cYear = this.calendarYear.split("-");
        firstPage.drawText(_cYear[2], {
          x: 430,
          y: height / 2 + 140,
          ...baseOptions,
        });

        // Date found error
        const _errorFoundYear = this.dateDiscoveredError.split("-");
        firstPage.drawText(_errorFoundYear[0], {
          x: 428,
          y: height / 2 + 86,
          ...baseOptions,
        });

        firstPage.drawText(_errorFoundYear[1], {
          x: 450,
          y: height / 2 + 86,
          ...baseOptions,
        });

        firstPage.drawText(_errorFoundYear[2], {
          x: 472,
          y: height / 2 + 86,
          ...baseOptions,
        });

        if (parseInt(this.partOneProcessType) === 1) {
          // Part 2 #1
          firstPage.drawText("x", {
            x: 47,
            y: height / 2 + 103,
            ...baseOptions,
          });
        } else {
          // Part 2 #1
          firstPage.drawText("x", {
            x: 47,
            y: height / 2 + 46,
            ...baseOptions,
          });
        }

        // Part 2 Number 3
        if (parseInt(this.part2Number3) === 1) {
          firstPage.drawText("x", {
            x: 47,
            y: height / 2 - 3,
            ...baseOptions,
          });
        }

        // Part 2 Number 4
        if (this.part2Number4.length) {
          // Draw a/b/c if exists
          if (this.part2Number4.includes("a")) {
            firstPage.drawText("x", {
              x: 68,
              y: height / 2 - 87,
              ...baseOptions,
            });
          }

          if (this.part2Number4.includes("b")) {
            firstPage.drawText("x", {
              x: 68,
              y: height / 2 - 128,
              ...baseOptions,
            });
          }

          if (this.part2Number4.includes("c")) {
            firstPage.drawText("x", {
              x: 68,
              y: height / 2 - 165,
              ...baseOptions,
            });
          }
        }

        // Part 2 Number 5
        if (this.part2Number5.length) {
          // Draw a/b/c if exists
          if (this.part2Number5.includes("a")) {
            firstPage.drawText("x", {
              x: 68,
              y: height / 2 - 225,
              ...baseOptions,
            });
          }

          if (this.part2Number5.includes("b")) {
            firstPage.drawText("x", {
              x: 68,
              y: height / 2 - 255,
              ...baseOptions,
            });
          }

          if (this.part2Number5.includes("c")) {
            firstPage.drawText("x", {
              x: 68,
              y: height / 2 - 296,
              ...baseOptions,
            });
          }

          if (this.part2Number5.includes("d")) {
            firstPage.drawText("x", {
              x: 68,
              y: height / 2 - 334,
              ...baseOptions,
            });
          }
        }

        /* Page 2 & 3 Name and Other Info ##########*/
        // Name
        secondPage.drawText(this.name, {
          x: 50,
          y: height / 2 + 340,
          ...baseOptions,
        });

        thirdPage.drawText(this.name, {
          x: 50,
          y: height / 2 + 340,
          ...baseOptions,
        });

        if (
          this.formTypeSelected === "2020J" ||
          this.formTypeSelected === "2020O"
        ) {
          fourthPage.drawText(this.name, {
            x: 50,
            y: height / 2 + 340,
            ...baseOptions,
          });

          fourthPage.drawText(this.employerIdentificationNumber, {
            x: 325,
            y: height / 2 + 340,
            ...baseOptions,
          });

          fourthPage.drawText(this.reportForThisQuarter, {
            x: 530,
            y: height / 2 + 351,
            ...baseOptions,
          });

          fourthPage.drawText(_cYear[2], {
            x: 530,
            y: height / 2 + 330,
            ...baseOptions,
          });
        }

        // EIN
        secondPage.drawText(this.employerIdentificationNumber, {
          x: 325,
          y: height / 2 + 340,
          ...baseOptions,
        });

        thirdPage.drawText(this.employerIdentificationNumber, {
          x: 325,
          y: height / 2 + 340,
          ...baseOptions,
        });

        // Correcting Quarter
        secondPage.drawText(this.reportForThisQuarter, {
          x: 530,
          y: height / 2 + 351,
          ...baseOptions,
        });

        thirdPage.drawText(this.reportForThisQuarter, {
          x: 530,
          y: height / 2 + 351,
          ...baseOptions,
        });

        // year
        secondPage.drawText(_cYear[2], {
          x: 530,
          y: height / 2 + 330,
          ...baseOptions,
        });

        thirdPage.drawText(_cYear[2], {
          x: 530,
          y: height / 2 + 330,
          ...baseOptions,
        });

        // Line 14 Col-1
        secondPage.drawText(this.part3.number14.column1.toString(), {
          x: 200,
          y: height / 2 + 10,
          ...baseOptions,
        });

        secondPage.drawText(this.part3.number14.column2.toString(), {
          x: 300,
          y: height / 2 + 10,
          ...baseOptions,
        });

        secondPage.drawText(this.lineFourteenDifference.toString(), {
          x: 390,
          y: height / 2 + 10,
          ...baseOptions,
        });

        secondPage.drawText(this.returnCorrectedCreditBalance.toString(), {
          x: 515,
          y: height / 2 + 10,
          ...baseOptions,
        });

        // Line 19
        secondPage.drawText(this.returnCorrectedCreditBalance.toString(), {
          x: 515,
          y: height / 2 - 132,
          ...baseOptions,
        });

        // Line 21
        secondPage.drawText(this.returnCorrectedCreditBalance.toString(), {
          x: 515,
          y: height / 2 - 210,
          ...baseOptions,
        });

        // Part 4 Line 22
        if (this.part4.line22) {
          thirdPage.drawText("x", {
            x: 47,
            y: height / 2 + 303,
            ...baseOptions,
          });
        }

        // Part 4 Line 23
        if (this.part4.line23) {
          thirdPage.drawText("x", {
            x: 47,
            y: height / 2 + 280,
            ...baseOptions,
          });
        }

        if (this.part4Line24Contents.length > 0) {
          const MAX_SENTENCE_LEN = 105;
          this.part4Line24Contents.forEach((sentence, index) => {
            thirdPage.drawText(sentence.substr(0, MAX_SENTENCE_LEN), {
              x: 62,
              y: index === 0 ? height / 2 + 240 : height / 2 + 240 - 12 * index,
              size: 5,
              ...baseOptions,
            });
          });
        }

        /* Save report and Download*/
        const pdfBytes = await pdfDoc.save();
        // Trigger the browser to download the PDF document
        download(pdfBytes, `IRS-941-X-${Date.now()}.pdf`, "application/pdf");
      } else {
        // console.log('Validation failed')
      }
    },
    validation() {
      if (this.formTypeSelected === "") {
        this.errors.formTypeSelected = true;
        return false;
      } else this.errors.formTypeSelected = false;

      if (this.employerIdentificationNumber.length < 9) {
        // console.warn('EID is too short');
        this.errors.employerIdentificationNumber = true;
        return false;
      } else {
        this.errors.employerIdentificationNumber = false;
      }

      if (this.name === "") {
        // console.warn('No name inputted.');
        this.errors.name = true;
        return false;
      } else {
        this.errors.name = false;
      }

      if (this.address === "") {
        // console.warn('No address');
        this.errors.address = true;
        return false;
      } else {
        this.errors.address = false;
      }

      if (this.city === "") {
        // console.warn('No city');
        this.errors.city = true;
        return false;
      } else {
        this.errors.city = false;
      }

      if (this.state === "") {
        // console.warn('No state');
        this.errors.state = true;
        return false;
      } else {
        this.errors.state = false;
      }

      if (this.zip.length < 5) {
        // console.warn('No ZIP');
        this.errors.zip = true;
        return false;
      } else {
        this.errors.zip = false;
      }

      if (this.correctionType === null) {
        // console.warn('No correction selected');
        this.errors.correctionType = true;
        return false;
      } else {
        this.errors.correctionType = false;
      }

      if (this.reportForThisQuarter === null) {
        // console.warn('No quarter selected');
        this.errors.reportForThisQuarter = true;
        return false;
      } else {
        this.errors.reportForThisQuarter = false;
      }

      if (this.partOneProcessType === null) {
        // console.warn('No Part 1 process type selected');
        this.errors.partOneProcessType = true;
        return false;
      } else {
        this.errors.partOneProcessType = false;
      }

      return true;
    },
    returnCalendarYear() {
      return $("#form_941X_calendar_year_select").val();
    },
    returnCurrentErrorCalendarYear() {
      return $("#form_941X_dateDiscoveredError").val();
    },
    logNewDate(newDate) {
      this.calendarYear = newDate;
    },
    logNewErrorDate(newDate) {
      this.dateDiscoveredError = newDate;
    },
  },
  computed: {
    ...mapGetters(["returnCurrentActiveCompany"]),
    lineFourteenDifference: function () {
      return (
        parseFloat(this.part3.number14.column1).toFixed(2) -
        parseFloat(this.part3.number14.column2).toFixed(2)
      ).toFixed(2);
    },
    returnCorrectedCreditBalance: function () {
      return -this.lineFourteenDifference;
    },
  },
};
</script>

<style scoped>
</style>
