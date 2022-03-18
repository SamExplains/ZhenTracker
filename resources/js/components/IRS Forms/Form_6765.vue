<template>
  <div class="container">
    <div class="d-none">
      {{ this.returnName() }}
      {{ this.returnEmployerIdentificationNumber() }}
    </div>

    <div class="row">
      <div class="position-fixed text-center" style="right: 1rem; bottom: 1rem">
        <el-button type="primary" @click="exportToPDF">Export</el-button>
      </div>

      <div class="col-12 text-center mb-3">
        <el-tag type="primary" class="d-block">
          <h4>Form 6765</h4>
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

      <div class="col-6">
        <div class="form-group">
          <label>Name(s) shown on return</label>
          <el-tag v-show="name.error" type="danger" class="mb-1">Error!</el-tag>
          <el-input
            type="text"
            v-model="name.value"
            placeholder="John Doe"
          ></el-input>
        </div>
      </div>

      <div class="col-3">
        <div class="form-group">
          <label>Identifying number</label>
          <el-tag v-show="identifyingNumber.error" type="danger" class="mb-1"
            >Error!</el-tag
          >
          <el-input
            type="text"
            v-model="identifyingNumber.value"
            placeholder="0"
          ></el-input>
        </div>
      </div>

      <div class="col-3">
        <div class="form-group">
          <label>Completing Section A?</label>
          <el-switch
            class="d-block text-center mx-auto"
            v-model="toggleSectionA"
            active-text="Section A"
            inactive-text="Section B"
          >
          </el-switch>
        </div>
      </div>
    </div>

    <!--SECTION A ONLY IF Toggled-->
    <div class="row" v-show="toggleSectionA">
      <div class="col-12">
        <el-tag type="success"> Section A </el-tag>
      </div>

      <table class="table table-striped mt-3">
        <thead>
          <tr>
            <th>Description</th>
            <th>Input</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">
              <!--#5-->
              <b>5.</b> Wages for qualified services (do not include wages used
              in figuring the work opportunity credit)
            </td>
            <td>
              <el-tag v-show="sectionA.field5.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field5.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#6-->
              <b>6.</b> Cost of supplies
            </td>
            <td>
              <el-tag v-show="sectionA.field6.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field6.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#7-->
              <b>7.</b> Rental or lease costs of computers (see instructions)
            </td>
            <td>
              <el-tag v-show="sectionA.field7.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field7.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#8-->
              <b>8.</b> Enter the applicable percentage of contract research
              expenses. See instructions
            </td>
            <td>
              <el-tag v-show="sectionA.field8.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field8.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#9-->
              <b>9.</b> Total qualified research expenses. Add lines 5 through 8
            </td>
            <td>
              {{ totalQualifiedResearchExpense }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#10-->
              <b>10.</b> Enter fixed-base percentage, but not more than 16%
              (0.16) (see instructions)
            </td>
            <td>
              <el-tag v-show="sectionA.field10.error" type="danger" class="mb-1"
                >Error! Must not exceed 16%</el-tag
              >
              <el-input placeholder="00.00" v-model="sectionA.field10.value" />
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#11-->
              <b>11.</b> Enter average annual gross receipts. See instructions
              <br />
              Enter your Prior Year 1 - 4 Sales in the following 4 fields.
              Starts from 1 (top) ... 4.
            </td>
            <td>
              <!--            <el-tag v-show="sectionA.field11.error" type="danger" class="mb-1">Error!</el-tag>-->
              <!--            <el-input v-model="sectionA.field11.value" placeholder="0"></el-input>-->

              <!--Yr1-->
              <el-tag
                v-show="sectionA.field11.priorYr1.error"
                type="danger"
                class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field11.priorYr1.value"
                placeholder="0"
              ></el-input>

              <!--Yr2-->
              <el-tag
                v-show="sectionA.field11.priorYr2.error"
                type="danger"
                class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field11.priorYr2.value"
                placeholder="0"
              ></el-input>

              <!--Yr3-->
              <el-tag
                v-show="sectionA.field11.priorYr3.error"
                type="danger"
                class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field11.priorYr3.value"
                placeholder="0"
              ></el-input>

              <!--Yr4-->
              <el-tag
                v-show="sectionA.field11.priorYr4.error"
                type="danger"
                class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field11.priorYr4.value"
                placeholder="0"
              ></el-input>

              <b>Average </b> {{ averageLineEleven }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#12-->
              <b>12.</b> Multiply line 11 by the percentage on line 10
            </td>
            <td>
              {{ lineTwelveCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#13-->
              <b>13.</b> Subtract line 12 from line 9. If zero or less, enter
              -0-
            </td>
            <td>
              {{ lineThirteenCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#14-->
              <b>14.</b> Multiply line 9 by 50% (0.50)
            </td>
            <td>
              {{ lineFourteenCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#15-->
              <b>15.</b> Enter the smaller of line 13 or line 14
            </td>
            <td>
              {{ smallerOfLineThirteenOrFourteen }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#16-->
              <b>16.</b> Add lines 1, 4, and 15
            </td>
            <td>
              {{ smallerOfLineThirteenOrFourteen }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#17-->
              <b>17.</b> Are you electing the reduced credit under section 280C?
              <div>
                If “Yes,” multiply line 16 by 15.8% (0.158). If “No,” multiply
                line 16 by 20% (0.20) and see the instructions for the statement
                that must be attached. Members of controlled groups or
                businesses under common control, see instructions for the
                statement that must be attached
              </div>
            </td>
            <td>
              <el-switch
                class="d-block text-center mx-auto mb-2"
                v-model="sectionA.field17Checkbox"
                active-text="Yes"
                inactive-text="No"
              >
              </el-switch>
              {{ lineSeventeenCalculation }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!--SECTION B ONLY IF A IS NOT Toggled-->
    <div class="row" v-show="!toggleSectionA">
      <div class="col-12">
        <el-tag type="success"> Section B </el-tag>
      </div>

      <table class="table table-striped mt-3">
        <thead>
          <tr>
            <th>Description</th>
            <th>Input</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td scope="row">
              <!--#24-->
              <b>24.</b> Wages for qualified services (do not include wages used
              in figuring the work opportunity credit)
            </td>
            <td>
              <el-tag v-show="sectionA.field5.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field5.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#25-->
              <b>25</b> Cost of supplies
            </td>
            <td>
              <el-tag v-show="sectionA.field6.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field6.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#26-->
              <b>26.</b> Rental or lease costs of computers (see instructions)
            </td>
            <td>
              <el-tag v-show="sectionA.field7.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field7.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#27-->
              <b>27.</b> Enter the applicable percentage of contract research
              expenses. See instructions
            </td>
            <td>
              <el-tag v-show="sectionA.field8.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field8.value"
                placeholder="0.00"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#28-->
              <b>28.</b> Total qualified research expenses. Add lines 24 through
              27
            </td>
            <td>
              {{ totalQualifiedResearchExpense }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#29-->
              <b>29.</b> Enter your total qualified research expenses for the
              prior 3 tax years. If you had no qualified research expenses in
              any one of those years, skip lines 30 and 31.
              <b
                >Yes means you had expense. No means you didn't, so enter a
                0.</b
              >
              <br />
              Enter the <em>Prior Yr1,Yr2 and Yr3 QRE</em> in the following
              fields. Starts from 1 (top) ... 3.
            </td>
            <td>
              <el-switch
                class="d-block text-center mx-auto mb-2"
                v-model="sectionA.field29Checkbox"
                active-text="Yes"
                inactive-text="No"
              >
              </el-switch>

              <!--Yr1-->
              <el-tag
                v-show="sectionA.field29.priorYr1.error"
                type="danger"
                class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field29.priorYr1.value"
                placeholder="0"
              ></el-input>

              <!--Yr2-->
              <el-tag
                v-show="sectionA.field29.priorYr2.error"
                type="danger"
                class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field29.priorYr2.value"
                placeholder="0"
              ></el-input>

              <!--Yr3-->
              <el-tag
                v-show="sectionA.field29.priorYr3.error"
                type="danger"
                class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field29.priorYr3.value"
                placeholder="0"
              ></el-input>

              <b>Total </b> {{ averageLineTwentyNine }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#30-->
              <b>30.</b> Divide line 29 by 6.0
            </td>
            <td>
              {{ lineThirtyCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#31-->
              <b>31.</b> Subtract line 30 from line 28. If zero or less, enter
              -0-
            </td>
            <td>
              {{ lineThirtyOneCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#32-->
              <b>32.</b> Multiply line 31 by 14% (0.14). If you skipped lines 30
              and 31, multiply line 28 by 6% (0.06)
            </td>
            <td>
              {{ lineThirtyTwoCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#33-->
              <b>33.</b> Add lines 23 and 32
            </td>
            <td>
              {{ lineThirtyTwoCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#34-->
              <b>34.</b> Are you electing the reduced credit under section 280C?
              ▶ Yes No If “Yes,” multiply line 33 by 79% (0.79). If “No,” enter
              the amount from line 33 and see the line 17 instructions for the
              statement that must be attached. Members of controlled groups or
              businesses under common control, see instructions for the
              statement that must be attached
            </td>
            <td>
              <el-switch
                class="d-block text-center mx-auto mb-2"
                v-model="sectionA.field34Checkbox"
                active-text="Yes"
                inactive-text="No"
              >
              </el-switch>

              {{ lineThirtyFourCalculation }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!--Section C & D-->
    <div class="row">
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
              <!--#36-->
              <b>36.</b> Subtract line 35 from line 17 or line 34 (whichever
              applies). If zero or less, enter -0-
            </td>
            <td>
              {{ lineThirtySixCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#38-->
              <b>38.</b> Add lines 36 and 37 . . . . . . . . . . . . . . . . . .
              . . . . . . . . .
              <br />
              • Estates and trusts, go to line 39.
              <br />
              • Partnerships and S corporations not electing the payroll tax
              credit, stop here and report this amount on Schedule K.
              <br />
              • Partnerships and S corporations electing the payroll tax credit,
              complete Section D and report on Schedule K the amount on this
              line reduced by the amount on line 44.
              <br />
              • Eligible small businesses, stop here and report the credit on
              Form 3800, Part III, line 4i. See instructions for the definition
              of eligible small business.
              <br />
              • Filers other than eligible small businesses, stop here and
              report the credit on Form 3800, Part III, line 1c.
              <br />
              Note: Qualified small business filers, other than partnerships and
              S corporations, electing the payroll tax credit must complete Form
              3800 before completing Section D.
            </td>
            <td>
              {{ lineThirtySixCalculation }}
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#41-->
              <b>41.</b> Check this box if you are a qualified small business
              electing the payroll tax credit. See instructions
            </td>
            <td>
              <el-switch
                class="d-block text-center mx-auto mb-2"
                v-model="sectionA.field41Checkbox"
                active-text="Yes"
                inactive-text="No"
              >
              </el-switch>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#42-->
              <b>42.</b> Enter the portion of line 36 elected as a payroll tax
              credit (do not enter more than $250,000). See instructions
            </td>
            <td>
              <el-tag v-show="sectionA.field42.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field42.value"
                placeholder="0"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#43-->
              <b>43.</b> General business credit carryforward from the current
              year (see instructions). Partnerships and S corporations, skip
              this line and go to line 44
            </td>
            <td>
              <el-tag v-show="sectionA.field43.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field43.value"
                placeholder="0"
              ></el-input>
            </td>
          </tr>
          <tr>
            <td scope="row">
              <!--#44-->
              <b>44.</b> Partnerships and S corporations, enter the smaller of
              line 36 or line 42. All others, enter the smallest of line 36,
              line 42, or line 43. Enter here and on the applicable line of Form
              8974, Part 1, column (e). Members of controlled groups or
              businesses under common control, see instructions for the
              statement that must be attached
            </td>
            <td>
              <el-tag v-show="sectionA.field44.error" type="danger" class="mb-1"
                >Error!</el-tag
              >
              <el-input
                v-model="sectionA.field44.value"
                placeholder="0"
              ></el-input>
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
import { mapGetters } from "vuex";

import NumberFormatter from "../../utilities/NumberFormatter";

export default {
  props: {
    formUrl: String,
    disableDownload: String,
  },
  data() {
    return {
      tempUrl: "",
      toggleAlternateYear: true,
      toggleSectionA: true,
      name: {
        value: "",
        // value: 'John Doe',
        error: false,
      },
      identifyingNumber: {
        value: "",
        // value: 123,
        error: false,
      },
      sectionA: {
        field5: {
          error: false,
          // value: '',
          value: 0,
        },
        field6: {
          error: false,
          // value: '',
          value: 0,
        },
        field7: {
          error: false,
          // value: '',
          value: 0,
        },
        field8: {
          error: false,
          // value: '',
          value: 0,
        },
        field10: {
          error: false,
          // value: '',
          value: 0,
        },
        field11: {
          error: false,
          // value: '',
          value: 0,
          priorYr1: {
            error: false,
            // value: '',
            value: 0,
          },
          priorYr2: {
            error: false,
            // value: '',
            value: 0,
          },
          priorYr3: {
            error: false,
            // value: '',
            value: 0,
          },
          priorYr4: {
            error: false,
            // value: '',
            value: 0,
          },
        },
        field12: {
          error: false,
          // value: '',
          value: 0,
        },
        field13: {
          error: false,
          // value: '',
          value: 0,
        },
        field14: {
          error: false,
          // value: '',
          value: 0,
        },
        field15: {
          error: false,
          // value: '',
          value: 0,
        },
        field16: {
          error: false,
          // value: '',
          value: 0,
        },
        field17Checkbox: true,
        field17: {
          error: false,
          // value: '',
          value: 0,
        },
        field29Checkbox: true,
        field29: {
          error: false,
          // value: '',
          value: 0,
          priorYr1: {
            error: false,
            // value: '',
            value: 0,
          },
          priorYr2: {
            error: false,
            // value: '',
            value: 0,
          },
          priorYr3: {
            error: false,
            // value: '',
            value: 0,
          },
        },
        field34Checkbox: true,
        field41Checkbox: true,
        field42: {
          error: false,
          // value: '',
          value: 0,
        },
        field43: {
          error: false,
          // value: '',
          value: 0,
        },
        field44: {
          error: false,
          // value: '',
          value: 0,
        },
      },
    };
  },
  mounted() {
    if (this.returnCurrentActiveCompany) {
      this.identifyingNumber.value = this.returnCurrentActiveCompany.ein;
      this.name.value = this.returnCurrentActiveCompany.name;
    }
  },
  beforeUpdate() {
    if (this.disableDownload === "Y") {
      // console.warn("Form 6765 Download Disabled");
      this.name.value = this.returnName();
      this.identifyingNumber.value = this.returnEmployerIdentificationNumber();
    }
  },
  computed: {
    ...mapGetters(["returnCurrentActiveCompany"]),
    totalQualifiedResearchExpense: function () {
      let values = [
        NumberFormatter.parseNumber(this.sectionA.field5.value),
        NumberFormatter.parseNumber(this.sectionA.field6.value),
        NumberFormatter.parseNumber(this.sectionA.field7.value),
        NumberFormatter.parseNumber(this.sectionA.field8.value),
      ];

      return parseFloat(values.reduce((a, b) => a + b, 0).toFixed(2));
    },
    averageLineEleven: function () {
      const arr = [
        NumberFormatter.parseNumber(this.sectionA.field11.priorYr1.value),
        NumberFormatter.parseNumber(this.sectionA.field11.priorYr2.value),
        NumberFormatter.parseNumber(this.sectionA.field11.priorYr3.value),
        NumberFormatter.parseNumber(this.sectionA.field11.priorYr4.value),
      ];
      return (arr.reduce((a, b) => a + b, 0) / arr.length).toFixed(2);
    },
    lineTwelveCalculation: function () {
      //  Divide % by 100
      return (
        (NumberFormatter.parseNumber(this.sectionA.field10.value) / 100) *
        NumberFormatter.parseNumber(this.averageLineEleven)
      ).toFixed(2);
    },
    lineThirteenCalculation: function () {
      //  Condition: If less than 0 return -0-
      const t = (
        this.totalQualifiedResearchExpense - this.lineTwelveCalculation
      ).toFixed(2);
      return t <= 0 ? "-0-" : t;
    },
    lineFourteenCalculation: function () {
      return (this.totalQualifiedResearchExpense * 0.5).toFixed(2);
    },
    smallerOfLineThirteenOrFourteen: function () {
      const L13 = Number(this.lineThirteenCalculation);
      const L14 = Number(this.lineFourteenCalculation);

      // Check for -0-
      if (L13 === "-0-") {
        return L14;
      }

      // return `These numbers are ${L13} and ${L14}`;
      return L14 > L13 ? L13 : L14;
    },
    lineSeventeenCalculation: function () {
      // If “Yes,” multiply line 16 by 15.8% (0.158). If “No,” multiply line 16 by 20% (0.20)
      if (this.sectionA.field17Checkbox) {
        return (this.smallerOfLineThirteenOrFourteen * 0.158).toFixed(2);
      } else return (this.smallerOfLineThirteenOrFourteen * 0.2).toFixed(2);
    },
    averageLineTwentyNine: function () {
      const arr = [
        NumberFormatter.parseNumber(this.sectionA.field29.priorYr1.value),
        NumberFormatter.parseNumber(this.sectionA.field29.priorYr2.value),
        NumberFormatter.parseNumber(this.sectionA.field29.priorYr3.value),
      ];
      return arr.reduce((a, b) => a + b, 0).toFixed(2);
    },
    lineThirtyCalculation: function () {
      return (
        NumberFormatter.parseNumber(this.averageLineTwentyNine) / 6.0
      ).toFixed(2);
    },
    lineThirtyOneCalculation: function () {
      //  Condition: If less than 0 return -0-
      const t = (
        this.totalQualifiedResearchExpense - this.lineThirtyCalculation
      ).toFixed(2);
      return t <= 0 ? "-0-" : t;
    },
    lineThirtyTwoCalculation: function () {
      // console.log(
      //   "lineThirtyTwoCalculation with a check value of ",
      //   this.sectionA.field29Checkbox
      // );
      // Multiply line 31 by 14% (0.14). If you skipped lines 30 and 31, multiply line 28 by 6% (0.06)
      if (
        NumberFormatter.parseNumber(this.sectionA.field29.priorYr1.value) ===
          0 ||
        NumberFormatter.parseNumber(this.sectionA.field29.priorYr2.value) ===
          0 ||
        NumberFormatter.parseNumber(this.sectionA.field29.priorYr3.value) === 0
      )
        return (this.lineThirtyOneCalculation * 0.06).toFixed(2);

      if (!this.sectionA.field29Checkbox) {
        return (this.totalQualifiedResearchExpense * 0.06).toFixed(2);
      } else return (this.lineThirtyOneCalculation * 0.14).toFixed(2);
    },
    lineThirtyFourCalculation: function () {
      if (this.sectionA.field34Checkbox) {
        return (this.lineThirtyTwoCalculation * 0.79).toFixed(2);
      } else return this.lineThirtyTwoCalculation;
    },
    lineThirtySixCalculation: function () {
      // Subtract line 35 from line 17 or line 34 (whichever applies). If zero or less, enter -0-
      // Return based on which side of the form is active
      if (this.toggleSectionA) return this.lineSeventeenCalculation;
      else return this.lineThirtyFourCalculation;
    },
  },
  methods: {
    ...mapGetters(["returnName", "returnEmployerIdentificationNumber"]),
    async exportToPDF() {
      const that = this;

      //  Run Validator A, B, C&D
      if (
        (this.validationSectionA() && this.validationSectionCandD()) ||
        (this.validationSectionB() && this.validationSectionCandD())
      ) {
        this.tempUrl = this.formUrl;
        // Modify URL for 2020/2019 Form
        if (this.toggleAlternateYear) {
          // 2020
          this.formUrl = this.tempUrl.replace(
            "form_6765.pdf",
            "2020 Form 6765 for Sam.pdf"
          );
        } else {
          this.formUrl = this.tempUrl.replace(
            "2020 Form 6765 for Sam.pdf",
            "form_6765.pdf"
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

        // Name
        firstPage.drawText(this.name.value, {
          x: 50,
          y: height / 2 + 293,
          ...baseOptions,
        });

        // Identifying Number
        firstPage.drawText(this.identifyingNumber.value.toString(), {
          x: 475,
          y: height / 2 + 293,
          ...baseOptions,
        });

        // SECTION A ONLY
        if (this.toggleSectionA) {
          // #5
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field5.value
            ),
            {
              x: 415,
              y: height / 2 + 195,
              ...baseOptions,
            }
          );

          // #6
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field6.value
            ),
            {
              x: 415,
              y: height / 2 + 182,
              ...baseOptions,
            }
          );

          // #7
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field7.value
            ),
            {
              x: 415,
              y: height / 2 + 169,
              ...baseOptions,
            }
          );

          // #8
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field8.value
            ),
            {
              x: 415,
              y: height / 2 + 158,
              ...baseOptions,
            }
          );

          // #9
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.totalQualifiedResearchExpense
            ),
            {
              x: 415,
              y: height / 2 + 147,
              ...baseOptions,
            }
          );

          // #10
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field10.value
            ),
            {
              x: 415,
              y: height / 2 + 134,
              ...baseOptions,
            }
          );

          // #11
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.averageLineEleven
            ),
            {
              x: 415,
              y: height / 2 + 122,
              ...baseOptions,
            }
          );

          // #12
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineTwelveCalculation
            ),
            {
              x: 415,
              y: height / 2 + 111,
              ...baseOptions,
            }
          );

          // #13
          // TODO If 0 returns, outputs -0-.00. Fix that
          if (this.lineThirteenCalculation === "-0-") {
            firstPage.drawText("0", {
              x: 415,
              y: height / 2 + 99,
              ...baseOptions,
            });
          } else {
            firstPage.drawText(
              NumberFormatter.convertToStringAndAddDecimal(
                this.lineThirteenCalculation
              ),
              {
                x: 415,
                y: height / 2 + 99,
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
              x: 415,
              y: height / 2 + 87,
              ...baseOptions,
            }
          );

          // #15
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.smallerOfLineThirteenOrFourteen
            ),
            {
              x: 515,
              y: height / 2 + 75,
              ...baseOptions,
            }
          );

          // #16
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.smallerOfLineThirteenOrFourteen
            ),
            {
              x: 515,
              y: height / 2 + 63,
              ...baseOptions,
            }
          );

          if (this.sectionA.field17Checkbox) {
            // #17 YES Checkmark
            firstPage.drawText("x", {
              x: 338,
              y: height / 2 + 51,
              ...baseOptions,
            });
          } else {
            // #17 NO Checkmark
            firstPage.drawText("x", {
              x: 377,
              y: height / 2 + 51,
              ...baseOptions,
            });
          }

          // #17
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineSeventeenCalculation
            ),
            {
              x: 515,
              y: height / 2 + 15,
              ...baseOptions,
            }
          );
        } else {
          // SECTION B ONLY
          // #24
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field5.value
            ),
            {
              x: 415,
              y: height / 2 - 105,
              ...baseOptions,
            }
          );

          // #25
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field6.value
            ),
            {
              x: 415,
              y: height / 2 - 117,
              ...baseOptions,
            }
          );

          // #26
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field7.value
            ),
            {
              x: 415,
              y: height / 2 - 129,
              ...baseOptions,
            }
          );

          // #27
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.sectionA.field8.value
            ),
            {
              x: 415,
              y: height / 2 - 153,
              ...baseOptions,
            }
          );

          // #28
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.totalQualifiedResearchExpense
            ),
            {
              x: 415,
              y: height / 2 - 165,
              ...baseOptions,
            }
          );

          // #29
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.averageLineTwentyNine
            ),
            {
              x: 415,
              y: height / 2 - 189,
              ...baseOptions,
            }
          );

          // #30
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineThirtyCalculation
            ),
            {
              x: 415,
              y: height / 2 - 201,
              ...baseOptions,
            }
          );

          // #31
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineThirtyOneCalculation
            ),
            {
              x: 415,
              y: height / 2 - 213,
              ...baseOptions,
            }
          );

          // #32
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineThirtyTwoCalculation
            ),
            {
              x: 515,
              y: height / 2 - 225,
              ...baseOptions,
            }
          );

          // #33
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineThirtyTwoCalculation
            ),
            {
              x: 515,
              y: height / 2 - 237,
              ...baseOptions,
            }
          );

          // #34 Checkbox
          if (this.sectionA.field34Checkbox) {
            // #34 YES Checkmark
            firstPage.drawText("x", {
              x: 337,
              y: height / 2 - 249,
              ...baseOptions,
            });
          } else {
            // #34 NO Checkmark
            firstPage.drawText("x", {
              x: 377,
              y: height / 2 - 249,
              ...baseOptions,
            });
          }

          // #34
          firstPage.drawText(
            NumberFormatter.convertToStringAndAddDecimal(
              this.lineThirtyFourCalculation
            ),
            {
              x: 515,
              y: height / 2 - 285,
              ...baseOptions,
            }
          );
        }

        // SECTION C & D
        // #36
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineThirtySixCalculation
          ),
          {
            x: 515,
            y: height / 2 + 290,
            ...baseOptions,
          }
        );

        // #38
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.lineThirtySixCalculation
          ),
          {
            x: 515,
            y: height / 2 + 267,
            ...baseOptions,
          }
        );

        if (this.sectionA.field41Checkbox) {
          // #41
          secondPage.drawText("x", {
            x: 469,
            y: height / 2 + 63,
            ...baseOptions,
          });
        }

        // #42
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.sectionA.field42.value
          ),
          {
            x: 515,
            y: height / 2 + 50,
            ...baseOptions,
          }
        );

        // #43
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.sectionA.field43.value
          ),
          {
            x: 515,
            y: height / 2 + 20,
            ...baseOptions,
          }
        );

        // #44
        secondPage.drawText(
          NumberFormatter.convertToStringAndAddDecimal(
            this.sectionA.field44.value
          ),
          {
            x: 515,
            y: height / 2 - 30,
            ...baseOptions,
          }
        );

        /* Save report and Download*/
        const pdfBytes = await pdfDoc.save();
        // Trigger the browser to download the PDF document
        download(pdfBytes, `IRS-6765-${Date.now()}.pdf`, "application/pdf");
      }
    },
    validationSectionA() {
      /* #5 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field5.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field5.value)
      ) {
        this.sectionA.field5.error = false;
      } else {
        this.sectionA.field5.error = true;
        return false;
      }

      /* #6 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field6.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field6.value)
      ) {
        this.sectionA.field6.error = false;
      } else {
        this.sectionA.field6.error = true;
        return false;
      }

      /* #7 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field7.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field7.value)
      ) {
        this.sectionA.field7.error = false;
      } else {
        this.sectionA.field7.error = true;
        return false;
      }

      /* #8 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field8.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field8.value)
      ) {
        this.sectionA.field8.error = false;
      } else {
        this.sectionA.field8.error = true;
        return false;
      }

      /* #10 */
      /* Not greater than .1600 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field10.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field10.value) &&
        NumberFormatter.noGreaterThan16Percent(this.sectionA.field10.value)
      ) {
        this.sectionA.field10.error = false;
      } else {
        this.sectionA.field10.error = true;
        return false;
      }

      /* #11 Y1 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field11.priorYr1.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field11.priorYr1.value)
      ) {
        this.sectionA.field11.priorYr1.error = false;
      } else {
        this.sectionA.field11.priorYr1.error = true;
        return false;
      }

      /* #11 Y2 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field11.priorYr2.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field11.priorYr2.value)
      ) {
        this.sectionA.field11.priorYr2.error = false;
      } else {
        this.sectionA.field11.priorYr2.error = true;
        return false;
      }

      /* #11 Y3 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field11.priorYr3.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field11.priorYr3.value)
      ) {
        this.sectionA.field11.priorYr3.error = false;
      } else {
        this.sectionA.field11.priorYr3.error = true;
        return false;
      }

      /* #11 Y4 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field11.priorYr4.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field11.priorYr4.value)
      ) {
        this.sectionA.field11.priorYr4.error = false;
      } else {
        this.sectionA.field11.priorYr4.error = true;
        return false;
      }

      return true; // all fields passed
    },
    validationSectionB() {
      /* #5 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field5.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field5.value)
      ) {
        this.sectionA.field5.error = false;
      } else {
        this.sectionA.field5.error = true;
        return false;
      }

      /* #6 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field6.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field6.value)
      ) {
        this.sectionA.field6.error = false;
      } else {
        this.sectionA.field6.error = true;
        return false;
      }

      /* #7 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field7.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field7.value)
      ) {
        this.sectionA.field7.error = false;
      } else {
        this.sectionA.field7.error = true;
        return false;
      }

      /* #8 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field8.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field8.value)
      ) {
        this.sectionA.field8.error = false;
      } else {
        this.sectionA.field8.error = true;
        return false;
      }

      /* 29 */
      if (this.sectionA.field29Checkbox) {
        /* #11 Y1 */
        if (
          !NumberFormatter.isANumber(this.sectionA.field29.priorYr1.value) &&
          !NumberFormatter.isEmpty(this.sectionA.field29.priorYr1.value)
        ) {
          this.sectionA.field29.priorYr1.error = false;
        } else {
          this.sectionA.field29.priorYr1.error = true;
          return false;
        }

        /* #11 Y2 */
        if (
          !NumberFormatter.isANumber(this.sectionA.field29.priorYr2.value) &&
          !NumberFormatter.isEmpty(this.sectionA.field29.priorYr2.value)
        ) {
          this.sectionA.field29.priorYr2.error = false;
        } else {
          this.sectionA.field29.priorYr2.error = true;
          return false;
        }

        /* #11 Y3 */
        if (
          !NumberFormatter.isANumber(this.sectionA.field29.priorYr3.value) &&
          !NumberFormatter.isEmpty(this.sectionA.field29.priorYr3.value)
        ) {
          this.sectionA.field29.priorYr3.error = false;
        } else {
          this.sectionA.field29.priorYr3.error = true;
          return false;
        }
      } else {
        this.sectionA.field29.error = false;
      }

      return true;
    },
    validationSectionCandD() {
      if (this.name.value.length === 0) {
        this.name.error = true;
        return false;
      } else this.name.error = false;

      if (this.identifyingNumber.value.length === 0) {
        this.identifyingNumber.error = true;
        return false;
      } else this.identifyingNumber.error = false;

      if (this.sectionA.field41Checkbox) {
        /* #42 */
        if (
          !NumberFormatter.isANumber(this.sectionA.field42.value) &&
          !NumberFormatter.isEmpty(this.sectionA.field42.value)
        ) {
          this.sectionA.field42.error = false;
        } else {
          this.sectionA.field42.error = true;
          return false;
        }
      }

      /* #43 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field43.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field43.value)
      ) {
        this.sectionA.field43.error = false;
      } else {
        this.sectionA.field43.error = true;
        return false;
      }

      /* #44 */
      if (
        !NumberFormatter.isANumber(this.sectionA.field44.value) &&
        !NumberFormatter.isEmpty(this.sectionA.field44.value)
      ) {
        this.sectionA.field44.error = false;
      } else {
        this.sectionA.field44.error = true;
        return false;
      }

      return true;
    },
  },
};
</script>
