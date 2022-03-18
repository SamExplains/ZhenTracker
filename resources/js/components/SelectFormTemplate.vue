<template>
  <div class="container-fluid bg-white p-4">
    <el-tabs type="border-card" @tab-click="handleClick" class="table col-12">
      <el-tab-pane label="Forms">
        <div
          class="row justify-content-center"
          v-if="this.returnCurrentActiveCompany !== null"
        >
          <table v-show="!isFillingOut" class="table col-12">
            <thead>
              <tr>
                <th width="90%">Form</th>
              </tr>
            </thead>
            <tbody v-for="(form, index) in forms">
              <tr :class="{ 'bg-light': index % 2 === 0 }">
                <td>
                  <div class="container">
                    <div class="row">
                      <div class="col-12">
                        <div
                          class="
                            card-header
                            bg-dark
                            text-white
                            font-weight-bold
                          "
                        >
                          {{ form.title }}
                        </div>
                      </div>
                      <div class="col-3 mt-2">
                        <img :src="form.imageSource" class="img-fluid" alt="" />
                      </div>
                      <div class="col-9 my-auto">
                        <h4>
                          <span class="text-primary">{{ form.title }}:</span>
                          {{ form.name }}
                        </h4>
                        <button
                          class="btn btn-primary mt-3"
                          v-on:click="setActiveForm(form.code)"
                        >
                          Select {{ form.title }}
                        </button>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="row justify-content-center" v-else>
          <div class="col-12">Select a company in order to conitue.</div>
        </div>

        <div class="col-12" id="formScrollToPlaceholder"></div>

        <!-- '8974', '941', '941_2020', '941X', '941X2020', '941SB', '6765', '3523', '8821' -->
        <form_8974
          v-show="this.active.formCode === '8974'"
          :disableDownload="'N'"
        />
        <form_941
          v-show="this.active.formCode === '941'"
          :formUrl="type_941_url"
          :disableDownload="'N'"
        />
        <form_941-s
          v-show="this.active.formCode === '941SB'"
          :formUrl="type_941s_url"
          :disableDownload="'N'"
        />
        <form_941-x
          v-show="this.active.formCode === '941X'"
          :formUrl="type_941x_url"
          :disableDownload="'N'"
        />
        <x2021
          v-show="this.active.formCode === '941X2021'"
          :formUrl="type_941x2021_url"
          :disableDownload="'N'"
        />
        <x2020
          v-show="this.active.formCode === '941X2020'"
          :formUrl="type_941x2020_url"
          :disableDownload="'N'"
        />
        <form_6765
          v-show="this.active.formCode === '6765'"
          :formUrl="type_6765_url"
          :disableDownload="'N'"
        />
        <form_3523
          v-show="this.active.formCode === '3523'"
          :formUrl="type_3523_url"
          :disableDownload="'N'"
        />
        <form_8821
          v-show="this.active.formCode === '8821'"
          :formUrl="type_8821_url"
          :disableDownload="'N'"
        />
        <form_941_2020_-component
          v-show="this.active.formCode === '941_2020'"
          :formUrl="type_941_2020_url"
          :disableDownload="'N'"
        />

        <form_941_2021_-component
          v-show="this.active.formCode === '941_2021'"
          :formUrl="type_941_2021_url"
          :disableDownload="'N'"
        />
      </el-tab-pane>

      <el-tab-pane label="Stored Forms History">
        There is a total of {{ history }} records stored.
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";

import Form_8974 from "./IRS Forms/Form_8974";
import Form_941 from "./IRS Forms/Form_941";
import Form_941S from "./IRS Forms/Form_941S";
import Form_941X from "./IRS Forms/Form_941X";
import PersonalDetails from "./IRS Forms/common/PersonalDetails";
import Form_6765 from "./IRS Forms/Form_6765";
import Form_3523 from "./IRS Forms/Form_3523";
import Form_8821 from "./IRS Forms/Form_8821";
import Form_941_2020_Component from "./IRS Forms/Form_941_2020_Component";
import Form_941_2021_Component from "./IRS Forms/Form_941_2021_Component.vue";
import Form_941X_2020 from "./IRS Forms/Form_941X_2020";
import X2020 from "./IRS Forms/X2020";
import X2021 from "./IRS Forms/X2021.vue";
import { error } from "pdf-lib";

export default {
  components: {
    X2021,
    X2020,
    Form_941_2020_Component,
    Form_941_2021_Component,
    Form_8821,
    Form_3523,
    Form_6765,
    Form_941X,
    PersonalDetails,
    Form_941,
    Form_8974,
    Form_941S,
    Form_941X_2020,
  },
  props: {
    type_8974: String,
    type_941: String,
    type_941_url: String,
    type_941s_url: String,
    type_941s: String,
    type_941x_url: String,
    type_941x: String,
    type_941x2020_url: String,
    type_941x2020: String,
    type_941x2021_url: String,
    type_941x2021: String,
    type_6765: String,
    type_6765_url: String,
    type_3523: String,
    type_3523_url: String,
    type_8821: String,
    type_8821_url: String,
    type_941_2020: String,
    type_941_2020_url: String,
    type_941_2021: String,
    type_941_2021_url: String,
  },
  computed: {
    ...mapGetters(["returnCurrentActiveCompany"]),
  },
  data: function () {
    return {
      history: [],
      active: {
        formCode: null,
        allowedCodes: [
          "8974",
          "941",
          "941_2020",
          "941_2021",
          "941X",
          "941X2020",
          "941X2021",
          "941SB",
          "6765",
          "3523",
          "8821",
        ],
      },
      forms: [
        {
          title: "Form 8974",
          imageSource: this.type_8974,
          name: "Qualified Small Business Payroll Tax Credit for Increasing Research Activities",
          code: "8974",
        },
        {
          title: "Form 941 (Rev. June 2021)",
          imageSource: this.type_941_2021,
          name: "Employer's Quarterly Federal Tax Return",
          code: "941_2021",
        },
        {
          title: "Form 941 (April 2020), 941 (July 2020)",
          imageSource: this.type_941_2020,
          name: "Employer's Quarterly Federal Tax Return",
          code: "941_2020",
        },
        {
          title: "Form 941 (2019)",
          imageSource: this.type_941,
          name: "Employer's Quarterly Federal Tax Return",
          code: "941",
        },
        {
          title: "Form 941–X Rev. July 2021",
          imageSource: this.type_941x,
          name: "Adjusted Employers Quarterly Federal Tax Return or Claim for Refund",
          code: "941X2021",
        },
        {
          title: "Form 941–X Rev. July 2020, 941–X Rev. October 2020",
          imageSource: this.type_941x,
          name: "Adjusted Employers Quarterly Federal Tax Return or Claim for Refund",
          code: "941X2020",
        },
        {
          title: "Form 941–X 2017",
          imageSource: this.type_941x,
          name: "Adjusted Employers Quarterly Federal Tax Return or Claim for Refund",
          code: "941X",
        },
        {
          title: "Schedule B",
          imageSource: this.type_941s,
          name: "Report of Tax Liability for Semiweekly Schedule Depositors",
          code: "941SB",
        },
        {
          title: "Form 6765 / Includes Years 2019 / 2020",
          imageSource: this.type_6765,
          name: "Credit for Increasing Research Activities",
          code: "6765",
        },
        {
          title: "Form 3523 / Includes Years 2019 / 2020",
          imageSource: this.type_3523,
          name: "Research Credit",
          code: "3523",
        },
        {
          title: "Form 8821",
          imageSource: this.type_8821,
          name: "Tax Information Authorization",
          code: "8821",
        },
      ],
      activeForm_8974: false,
      activeForm_941: false,
      activeForm_941X: false,
      activeForm_941X2021: false,
      activeForm_941X2020: false,
      activeForm_941_Schedule_B: false,
      activeForm_6765: false,
      activeForm_3523: false,
      activeForm_8821: false,
      activeForm_941_2020: false,
      activeForm_941_2021: false,
      checkedForms: [],
      isFillingOut: false,
      showPersonal: true,
      setActive: {
        t8974: false,
        t941: false,
        t941X: false,
        tX2020: false,
        t941SB: false,
        t6765: false,
        t3523: false,
        t8821: false,
        t941_2020: false,
        t941_2021: false,
      },
      errors: {
        form8974: false,
        form941: false,
        form941X: false,
        form941X2020: false,
        form941SB: false,
        form6765: false,
        form3523: false,
      },
    };
  },
  methods: {
    ...mapGetters(["returnTitle"]),
    setActiveForm(arg) {
      // console.error(arg);
      this.active.allowedCodes.filter((el) => {
        el === arg ? (this.active.formCode = arg) : "";
      });

      // Scroll to
      $("html, body").animate(
        {
          scrollTop: $("#formScrollToPlaceholder").offset().top,
        },
        800,
        function () {
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = $("#formScrollToPlaceholder");
        }
      );
    },
    continueWithSelectedForms() {
      // console.log(this.checkedForms);
      // console.warn('Add in form 8974 if 941 or 941X is present.');
      if (this.checkedForms.length > 1) this.isFillingOut = true;
    },
    returnToStart() {
      this.isFillingOut = !this.isFillingOut;
    },
    sendDownloadEvent() {
      /*
       * Check which forms are selected
       * Try to download form 8974.
       * */
      if (this.checkedForms.includes("8974")) {
        const _validated = this.$refs.form8974.validateFormFields();
        if (_validated) {
          this.$refs.form8974.exportToPDF();
          this.errors.form8974 = false;
        } else {
          /* Toggle Error on Tab*/
          this.errors.form8974 = true;
        }
      }

      if (this.checkedForms.includes("941")) {
        const _validated = this.$refs.form941.validateFormFields();
        if (_validated) {
          this.$refs.form941.exportToPDF();
          this.errors.form941 = false;
        } else {
          /* Toggle Error on Tab*/
          this.errors.form941 = true;
        }
      }

      if (this.checkedForms.includes("941X")) {
        const _validated = this.$refs.form941X.validation();
        // console.warn("941X Validation with a value of ", _validated);
        if (_validated) {
          this.$refs.form941X.exportToPDF();
          this.errors.form941X = false;
        } else {
          /* Toggle Error on Tab*/
          this.errors.form941X = true;
        }
      }

      if (this.checkedForms.includes("941SB")) {
        const _validated = this.$refs.form941SB.validation();
        if (_validated) {
          this.$refs.form941SB.exportToPDF();
          this.errors.form94SB1 = false;
        } else {
          /* Toggle Error on Tab*/
          this.errors.form941SB = true;
        }
      }

      if (this.checkedForms.includes("6765")) {
        /* This form has 3 validations due to individual pieces */
        const _validated =
          (this.$refs.form6765.validationSectionA() &&
            this.$refs.form6765.validationSectionCandD()) ||
          (this.$refs.form6765.validationSectionB() &&
            this.$refs.form6765.validationSectionCandD());
        if (_validated) {
          this.$refs.form6765.exportToPDF();
          this.errors.form6765 = false;
        } else {
          /* Toggle Error on Tab*/
          this.errors.form6765 = true;
        }
      }
    },
    async handleClick(tab, event) {
      // console.log(tab, event);
      if (tab.index == "1") {
        let { data } = await axios.get(
          `/api/company/stored/${this.returnCurrentActiveCompany.id}`
        );
        this.history = data.length;
      }
    },
  },
};
</script>

<style scoped>
button {
  border-radius: 0;
}
</style>
