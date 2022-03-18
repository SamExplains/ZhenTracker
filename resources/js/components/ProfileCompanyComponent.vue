<template>
  <div>
    <div>
      <div class="row justify-content-between">
        <div class="col-7 pr-0">
          <div class="bg-white p-4 mb-3">
            <last-year-you-can-claim-payroll-component />
          </div>
        </div>
        <div class="col-5" v-show="this.returnActiveUser === 'Admin'">
          <div class="bg-white p-4 mb-3">
            <el-button type="danger" @click="deleteCompany"
              >Delete Company</el-button
            >
          </div>
        </div>

        <div class="col-6 pr-0">
          <div class="bg-white p-4 mb-3">
            <h6 class="text-primary font-weight-bolder">
              Payroll Service Provider
            </h6>

            <div class="form-group">
              <label>Company Name</label>
              <el-input
                type="text"
                placeholder="Please input"
                v-model="ps_company.input"
                id="ps_company"
                maxlength="75"
                show-word-limit
              ></el-input>
            </div>

            <div class="form-group">
              <label>Individual Name</label>
              <el-input
                type="text"
                placeholder="Please input"
                v-model="ps_individual.input"
                id="ps_individual"
                maxlength="75"
                show-word-limit
              ></el-input>
            </div>

            <div class="form-group">
              <label>Email</label>
              <el-input
                type="email"
                placeholder="Please input"
                v-model="ps_email.input"
                id="ps_email"
                maxlength="75"
                show-word-limit
              ></el-input>
            </div>

            <div class="form-group">
              <label>Phone</label>
              <el-input
                type="text"
                placeholder="Please input"
                v-model="ps_phone.input"
                id="ps_phone"
                maxlength="10"
                minlength="10"
                show-word-limit
              ></el-input>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="bg-white p-4 mb-3">
            <h6 class="text-primary font-weight-bolder">
              Tax Return Service Provider
            </h6>

            <div class="form-group">
              <label>Company Name</label>
              <el-input
                type="text"
                placeholder="Please input"
                v-model="trs_company.input"
                id="trs_company"
                maxlength="75"
                show-word-limit
              ></el-input>
            </div>

            <div class="form-group">
              <label>Individual Name</label>
              <el-input
                type="text"
                placeholder="Please input"
                v-model="trs_individual.input"
                id="trs_individual"
                maxlength="75"
                show-word-limit
              ></el-input>
            </div>

            <div class="form-group">
              <label>Email</label>
              <el-input
                type="email"
                placeholder="Please input"
                v-model="trs_email.input"
                id="trs_email"
                maxlength="75"
                show-word-limit
              ></el-input>
            </div>

            <div class="form-group">
              <label>Phone</label>
              <el-input
                type="text"
                placeholder="Please input"
                v-model="trs_phone.input"
                id="trs_phone"
                maxlength="10"
                minlength="10"
                show-word-limit
              ></el-input>
            </div>
          </div>
        </div>

        <div class="col-7 pr-0">
          <div class="bg-white p-4">
            <div class="form-group">
              <label>Company Name</label>
              <el-input
                placeholder="Please input"
                v-model="companyName.name"
                id="profile-cn"
              ></el-input>
            </div>

            <div class="form-group">
              <label>Tax ID / EIN</label>
              <el-input
                type="text"
                placeholder="Please input"
                maxlength="9"
                show-word-limit
                v-model="taxID.id"
                id="profile-taxid"
              />
            </div>

            <div class="form-group">
              <label>Business Start Date</label>
              <flatpickr
                class="minimalMarginTop"
                timeFormat="m-d-Y"
                v-model="businessStartDate.date"
                id="calendar_year_bsd"
              />
            </div>

            <div class="form-group">
              <label>Year End</label>
              <br />
              <flatpickr
                class="minimalMarginTop"
                timeFormat="m-d-Y"
                v-model="yearEndDate.date"
                id="calendar_year_ye"
              />
            </div>

            <div class="form-group">
              <label>1st Income Year</label>
              <br />
              <flatpickr
                class="minimalMarginTop"
                timeFormat="m-d-Y"
                v-model="firstIncomeYear.date"
                id="calendar_year_fiy"
              />
            </div>

            <div class="form-group">
              <label class="text-danger">Update Last Eligible Year</label>
              <br />
              <flatpickr
                class="minimalMarginTop"
                timeFormat="m-d-Y"
                v-model="overrideDate.date"
                id="calendar_year_od"
              />
            </div>

            <div class="form-group">
              <el-dropdown @command="handleCommand">
                <span class="el-dropdown-link">
                  Company Type
                  <b class="alert-primary p-1" id="profile-company">{{
                    companyType
                  }}</b>
                  <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item command="C"
                    >C - Corporation</el-dropdown-item
                  >
                  <el-dropdown-item command="S"
                    >S - Corporation</el-dropdown-item
                  >
                  <el-dropdown-item command="P"
                    >P - Partnership</el-dropdown-item
                  >
                  <el-dropdown-item command="I"
                    >I - Individual</el-dropdown-item
                  >
                </el-dropdown-menu>
              </el-dropdown>
            </div>

            <div class="form-group">
              <label>Email</label>
              <el-input
                type="email"
                placeholder="Please input"
                v-model="email.input"
                id="profile-email"
              ></el-input>
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
                id="profile-phone"
              />
            </div>

            <div class="form-group">
              <label>Officer</label>
              <el-input
                placeholder="Please input"
                v-model="officer.input"
                id="profile-officer"
              ></el-input>
            </div>

            <div class="form-group">
              <label>Address</label>
              <el-input
                placeholder="Please input"
                v-model="address.input"
                id="profile-address"
              ></el-input>
            </div>

            <p
              v-show="recordError.duplicate"
              class="text-danger font-weight-bolder mb-2 mt-2"
            >
              No duplicate companies allowed (Name or TaxID already taken).
              Change Company Name / TaxID and try again.
            </p>

            <el-button type="primary" @click="onSubmit">Update</el-button>
          </div>
        </div>

        <div class="col-5">
          <key-due-dates-component />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import axios from "axios";
import LastYearYouCanClaimPayrollCalculatorComponent from "./LastYearYouCanClaimPayrollCalculatorComponent";
import Flatpickr from "./Calendar/Flatpickr";
import LastYearYouCanClaimPayrollComponent from "./LastYearYouCanClaimPayrollComponent";
import KeyDueDatesComponent from "./KeyDueDatesComponent";

export default {
  name: "ProfileCompanyComponent",
  components: {
    KeyDueDatesComponent,
    LastYearYouCanClaimPayrollComponent,
    Flatpickr,
    LastYearYouCanClaimPayrollCalculatorComponent,
  },
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
      overrideDate: {
        date: "",
        error: false,
      },
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
      officer: {
        input: "",
        error: false,
      },
      address: {
        input: "",
        error: false,
      },
      ps_company: {
        input: "",
      },
      ps_individual: {
        input: "",
      },
      ps_email: {
        input: "",
      },
      ps_phone: {
        input: "",
      },
      trs_company: {
        input: "",
      },
      trs_individual: {
        input: "",
      },
      trs_email: {
        input: "",
      },
      trs_phone: {
        input: "",
      },
      companyType: "",
    };
  },
  computed: {
    ...mapGetters([
      "returnCurrentActiveCompanyAsArray",
      "returnCurrentActiveCompany",
      "returnFinalYearPayrollClaimable",
      "returnFiscalYearEnd",
      "returnFirstIncomeYear",
      "returnFiscalTypeCalculations",
      "checkIfDOMNodeExist",
      "returnActiveUser",
    ]),
  },
  methods: {
    ...mapActions(["updateExistingCompanyObject", "onDeleteCompany"]),
    handleCommand(command) {
      // console.log('handleCommand ', command);
      this.companyType = command;
      document.getElementById("profile-company").innerText = command;
    },
    returnRearrangedDate(date) {
      // console.log('returnRearrangedDate ', date);

      const blacklist = ["n/a", null, undefined, "undefined", ""];
      if (!blacklist.includes(date)) {
        let d = date.split("-");
        const arranged = `${d[2]}-${d[0]}-${d[1]}`;
        return d[0].length === 4 ? date : arranged;
      } else {
        return null;
      }
    },
    onSubmit() {
      // console.log('onSubmit');

      // Set data for dates but only grab if the value is different
      this.businessStartDate.date = this.returnRearrangedDate(
        document.getElementById("calendar_year_bsd").value
      );
      this.yearEndDate.date = this.returnRearrangedDate(
        document.getElementById("calendar_year_ye").value
      );
      this.firstIncomeYear.date = this.returnRearrangedDate(
        document.getElementById("calendar_year_fiy").value
      );
      this.overrideDate.date = this.returnRearrangedDate(
        document.getElementById("calendar_year_od").value
      );

      const income = {
        modified: this.firstIncomeYear.date,
        calculated: this.returnFirstIncomeYear,
        current: this.returnCurrentActiveCompany.first_income_year,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.first_income_year,
          this.firstIncomeYear.date
        ),
      };

      // Date is not correct formate yyyy-mm-dd when passing to server.

      const startDate = {
        modified: this.businessStartDate.date,
        calculated: this.returnFiscalTypeCalculations.start_date,
        current: this.returnCurrentActiveCompany.business_start_date,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.business_start_date,
          this.businessStartDate.date
        ),
      };
      const endDate = {
        modified: this.yearEndDate.date,
        calculated: this.returnFiscalYearEnd,
        current: this.returnCurrentActiveCompany.business_first_year_end_date,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.business_first_year_end_date,
          this.yearEndDate.date
        ),
      };

      const override = {
        modified: this.overrideDate.date,
        current: this.returnCurrentActiveCompany.override_date,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.override_date,
          this.overrideDate.date
        ),
      };

      const compType = {
        current: this.returnCurrentActiveCompany.company_type,
        modified: this.companyType,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.company_type,
          this.companyType
        ),
      };
      const compName = {
        current: this.returnCurrentActiveCompany.name,
        modified: this.companyName.name,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.name,
          this.companyName.name
        ),
      };
      const compTax = {
        current: this.returnCurrentActiveCompany.ein,
        modified: this.taxID.id,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.ein,
          this.taxID.id
        ),
      };
      const compEmail = {
        current: this.returnCurrentActiveCompany.email,
        modified: this.email.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.email,
          this.email.input
        ),
      };
      const compPhone = {
        current: this.returnCurrentActiveCompany.phone,
        modified: this.phone.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.phone,
          this.phone.input
        ),
      };
      const compOfficer = {
        current: this.returnCurrentActiveCompany.officer,
        modified: this.officer.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.officer,
          this.officer.input
        ),
      };
      const compAddress = {
        current: this.returnCurrentActiveCompany.address,
        modified: this.address.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.address,
          this.address.input
        ),
      };

      const compPSCompanyName = {
        current: this.returnCurrentActiveCompany.payroll_provider_company_name,
        modified: this.ps_company.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.payroll_provider_company_name,
          this.ps_company.input
        ),
      };

      const compPSIndividual = {
        current:
          this.returnCurrentActiveCompany.payroll_provider_individual_name,
        modified: this.ps_individual.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.payroll_provider_individual_name,
          this.ps_individual.input
        ),
      };

      const compPSEmail = {
        current: this.returnCurrentActiveCompany.payroll_provider_email,
        modified: this.ps_email.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.payroll_provider_email,
          this.ps_email.input
        ),
      };

      const compPSPhone = {
        current: this.returnCurrentActiveCompany.payroll_provider_phone,
        modified: this.ps_phone.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.payroll_provider_phone,
          this.ps_phone.input
        ),
      };

      const compTRSCompany = {
        current: this.returnCurrentActiveCompany.tax_provider_company_name,
        modified: this.trs_company.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.tax_provider_company_name,
          this.trs_company.input
        ),
      };

      const compTRSIndividual = {
        current: this.returnCurrentActiveCompany.tax_provider_individual_name,
        modified: this.trs_individual.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.tax_provider_individual_name,
          this.trs_individual.input
        ),
      };

      const compTRSEmail = {
        current: this.returnCurrentActiveCompany.tax_provider_email,
        modified: this.trs_email.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.tax_provider_email,
          this.trs_email.input
        ),
      };

      const compTRSPhone = {
        current: this.returnCurrentActiveCompany.tax_provider_phone,
        modified: this.trs_phone.input,
        equal: this.returnValueToBeUpdated(
          this.returnCurrentActiveCompany.tax_provider_phone,
          this.trs_phone.input
        ),
      };

      // console.log('First Income Year ', income);
      // console.log('Start Date ', startDate);
      // console.log('Year End Date ', endDate);
      // console.log('Company Type ', compType);
      // console.log('Company Name ', compName);
      // console.log('Tax ID ', compTax);
      // console.log('Email ', compEmail);
      // console.log('Phone ', compPhone);
      // console.log('Officer ', compOfficer);

      axios
        .put(`/api/company/update/${this.returnCurrentActiveCompany.id}`, {
          name: compName.equal,
          ein: compTax.equal,
          business_start_date: startDate.equal,
          business_first_year_end_date: endDate.equal,
          override_date: override.equal,
          first_income_year: income.equal,
          company_type: compType.equal,
          email: compEmail.equal,
          phone: compPhone.equal,
          officer: compOfficer.equal,
          address: compAddress.equal,
          payroll_provider_company_name: compPSCompanyName.equal,
          payroll_provider_individual_name: compPSIndividual.equal,
          payroll_provider_email: compPSEmail.equal,
          payroll_provider_phone: compPSPhone.equal,
          tax_provider_company_name: compTRSCompany.equal,
          tax_provider_individual_name: compTRSIndividual.equal,
          tax_provider_email: compTRSEmail.equal,
          tax_provider_phone: compTRSPhone.equal,
        })
        .then((res) => {
          if (res.status === 200) {
            // 200 Clear Form
            // console.log("Request success", res.data);

            // Update Company and Companies objects in Store
            this.updateExistingCompanyObject(res.data);

            this.$notify({
              title: "Success",
              message: "Company was updated",
              type: "success",
            });

            this.recordError.duplicate = false;
          } else if (res.status === 400) {
            // Duplicate entry.
            // console.log("Request failed");

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
    },
    returnValueToBeUpdated(current, modified) {
      /*
       * No Null, Empty, Undefined, n/a
       * */
      const blacklist = ["n/a", null, undefined, "undefined", ""];
      // console.log(
      //   "returnValueToBeUpdated Blacklist ",
      //   blacklist.includes(modified),
      //   " Current ",
      //   current,
      //   "  Modified ",
      //   modified
      // );
      return blacklist.includes(modified) ? current : modified;
    },
    deleteCompany() {
      this.$confirm(
        "This will permanently delete the company. Continue?",
        "Warning",
        {
          confirmButtonText: "OK",
          cancelButtonText: "Cancel",
          type: "warning",
        }
      )
        .then(() => {
          this.$message({
            type: "success",
            message: "Delete completed",
          });

          // Commit to Store & Request
          this.onDeleteCompany(this.returnCurrentActiveCompany);
        })
        .catch((err) => {
          this.$message({
            type: "info",
            message: "Delete canceled",
          });

          // console.error(err);
        });
    },
  },
};
</script>

<style scoped>
</style>
