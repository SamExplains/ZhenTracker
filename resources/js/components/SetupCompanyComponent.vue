<template>
  <div class="row justify-content-between">
    <div class="col-12">
      <div class="bg-white p-4">
        <div class="form-group">
          <label>Company Name</label>
          <el-input
            placeholder="Please input"
            v-model="companyName.name"
          ></el-input>
          <small class="text-danger" v-show="companyName.error"
            >Enter company name</small
          >
        </div>

        <div class="form-group">
          <label>Tax ID / EIN</label>
          <el-input
            type="text"
            placeholder="Please input"
            maxlength="9"
            show-word-limit
            v-model="taxID.id"
          />
          <small class="text-danger" v-show="taxID.error"
            >Enter full 9 number tax id</small
          >
        </div>

        <div class="form-group">
          <label>Business Start Date</label>
          <flatpickr
            class="minimalMarginTop"
            timeFormat="m-d-Y"
            v-model="businessStartDate.date"
            id="calendar_year_bsd_setup"
          />
        </div>

        <div class="form-group">
          <label>Year End</label>
          <br />
          <flatpickr
            class="minimalMarginTop"
            timeFormat="m-d-Y"
            v-model="yearEndDate.date"
            id="calendar_year_ye_setup"
          />
        </div>

        <div class="form-group">
          <label>1st Income Year</label>
          <br />
          <flatpickr
            class="minimalMarginTop"
            timeFormat="m-d-Y"
            v-model="firstIncomeYear.date"
            id="calendar_year_fiy_setup"
          />
        </div>

        <div class="form-group">
          <el-dropdown @command="handleCommand">
            <span class="el-dropdown-link">
              Company Type <b class="alert-primary p-1">{{ companyType }}</b>
              <i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item command="C">C - Corporation</el-dropdown-item>
              <el-dropdown-item command="S">S - Corporation</el-dropdown-item>
              <el-dropdown-item command="P">P - Partnership</el-dropdown-item>
              <el-dropdown-item command="I">I - Individual</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
          <small class="text-danger" v-show="companyTypeError"
            >Enter company type</small
          >
        </div>

        <div class="form-group">
          <label>Email</label>
          <el-input
            type="email"
            placeholder="Please input"
            v-model="email.input"
          ></el-input>
          <small class="text-danger" v-show="email.error">Enter email</small>
        </div>

        <div class="form-group">
          <label>Address</label>
          <el-input
            placeholder="Please input"
            v-model="address.input"
          ></el-input>
          <small class="text-danger" v-show="address.error"
            >Enter address</small
          >
        </div>

        <div class="form-group">
          <label>Phone</label>
          <el-input
            type="text"
            placeholder="Please input"
            maxlength="10"
            minlength="10"
            show-word-limit
            v-model="phone.input"
          />
          <small class="text-danger" v-show="phone.error"
            >Enter phone number</small
          >
        </div>

        <div class="form-group">
          <label>Officer</label>
          <el-input
            placeholder="Please input"
            v-model="officer.input"
          ></el-input>
          <small class="text-danger" v-show="officer.error"
            >Enter officer name</small
          >
        </div>

        <p
          v-show="recordError.duplicate"
          class="text-danger font-weight-bolder mb-2 mt-2"
        >
          No duplicate companies allowed (Name or TaxID already taken). Change
          Company Name / TaxID and try again.
        </p>

        <el-button type="primary" @click="onSubmit">Submit</el-button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import axios from "axios";
import Flatpickr from "./Calendar/Flatpickr";

export default {
  name: "SetupCompanyComponent",
  components: { Flatpickr },
  data() {
    return {
      recordError: {
        duplicate: false,
      },
      companyName: {
        name: "",
        error: false,
      },
      taxID: {
        id: "",
        error: false,
      },
      businessStartDate: {
        date: "",
        error: false,
      },
      yearEndDate: {
        date: "",
        error: false,
      },
      // firstIncomeYear: {
      //   date: this.returnFirstIncomeYear,
      //   error: false
      // },
      firstIncomeYear: {
        date: "",
        error: false,
      },
      finalPayrollDate: {
        date: this.returnFinalYearPayrollClaimable,
      },
      email: {
        input: "",
        error: false,
      },
      phone: {
        input: "",
        error: false,
      },
      address: {
        input: "",
        error: false,
      },
      officer: {
        input: "",
        error: false,
      },
      companyType: "",
      companyTypeError: false,
    };
  },
  computed: {
    ...mapGetters([
      "returnFinalYearPayrollClaimable",
      "returnFiscalYearEnd",
      "returnFirstIncomeYear",
    ]),
  },
  methods: {
    ...mapActions(["setCalendarYearCalculation", "storeNewCompanySetup"]),
    handleCommand(command) {
      this.companyType = command;
    },
    onSubmit() {
      // Update models with values
      this.businessStartDate.date = document.getElementById(
        "calendar_year_bsd_setup"
      ).value;
      this.yearEndDate.date = document.getElementById(
        "calendar_year_ye_setup"
      ).value;
      this.firstIncomeYear.date = document.getElementById(
        "calendar_year_fiy_setup"
      ).value;

      /*
       * Run calculation @ backend
       * */
      if (this.validation()) {
        axios
          .post("/api/company", {
            companyName: this.companyName.name,
            taxID: this.taxID.id,
            businessStartDate: this.businessStartDate.date,
            yearEndDate: this.yearEndDate.date,
            firstIncomeYear: this.firstIncomeYear.date,
            companyType: this.companyType,
            email: this.email.input,
            phone: this.phone.input,
            officer: this.officer.input,
            address: this.address.input,
          })
          .then((res) => {
            if (res.data.status === 200) {
              // 200 Clear Form
              /*
               * Add company to Store
               * */
              // console.log("Request success");

              // Add blank Company R&D and Forms
              this.$notify({
                title: "Success",
                message: "Company was saved",
                type: "success",
              });

              this.storeNewCompanySetup(res.data.company);
              this.recordError.duplicate = false;
            } else if (res.data.status === 400) {
              // Duplicate entry.
              // console.log("Request failed ", res.data);
              this.$notify({
                title: "Failed",
                message: "Could not save company",
                type: "error",
              });
              this.recordError.duplicate = true;
            }
          })
          .catch((err) => {
            // console.warn("Error ", err);
          });
      } else {
        this.$notify({
          title: "Failed",
          message: "Check form errors",
          type: "error",
        });
      }
    },
    validation() {
      let count = 0;

      if (this.companyName.name === "") {
        this.companyName.error = true;
        count++;
      } else this.companyName.error = false;

      if (this.taxID.id === "" || this.taxID.id.length < 9) {
        this.taxID.error = true;
        count++;
      } else this.taxID.error = false;

      if (this.companyType === "") {
        this.companyTypeError = true;
        count++;
      } else this.companyTypeError = false;

      if (this.email.input === "") {
        this.email.error = true;
        count++;
      } else this.email.error = false;

      if (this.phone.input === "") {
        this.phone.error = true;
        count++;
      } else this.phone.error = false;

      if (this.officer.input === "") {
        this.officer.error = true;
        count++;
      } else this.officer.error = false;

      return count === 0;
    },
  },
};
</script>

<style>
.minimalMarginTop {
  margin-top: -1rem !important;
}
</style>
