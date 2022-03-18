<template>
  <div class="mt-2">
    <h4 class="alert-success p-2 text-center">Common Details</h4>
    <h6>
      Fill in these common details and they will be filled in across all other
      forms.
    </h6>

    <div class="container">
      <div class="row">
        <div class="col-lg-10 col-12 bg-white mt-4 p-3 text-left">
          <div class="row">
            <div class="col-8">
              <div class="row">
                <div class="col-5 font-weight-bold mb-2">
                  Employer identification number
                </div>
                <div class="col-7 my-auto">
                  <input
                    type="text"
                    class="form-control"
                    @input="updateEINState"
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
                    @input="updateNameState"
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
                    @input="updateTradeNameState"
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
                        @input="updateAddressState"
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
                        @input="updateCityState"
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
                        @input="updateStateState"
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
                        @input="updateZipState"
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
                        @input="updateFCountryNameState"
                      />
                    </div>
                    <div class="col-12">
                      <input
                        type="text"
                        placeholder="Foreign province/country"
                        class="form-control mb-2"
                        v-model="f_countryProvince"
                        @input="updateFCountryProvinceState"
                      />
                    </div>
                    <div class="col-12">
                      <input
                        type="text"
                        placeholder="Foreign postal code"
                        class="form-control mb-2"
                        minlength="5"
                        maxlength="5"
                        @input="updateFCountryZipState"
                        v-model="f_countryZIP"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <!--                          <div class="form-check">-->
              <!--                              <h6 class="font-weight-bold bg-dark p-2 text-white mb-2">Report for this quarter <small>check-->
              <!--                                  only one box</small></h6>-->
              <!--                              <label class="form-check-label d-block mt-2">-->
              <!--                                  <input type="radio" class="form-check-input" name="personalQuarterReport"-->
              <!--                                         v-model="reportForThisQuarter" value="1">-->
              <!--                                  1: January, February, March-->
              <!--                              </label>-->
              <!--                              <label class="form-check-label d-block mt-2">-->
              <!--                                  <input type="radio" class="form-check-input" name="personalQuarterReport"-->
              <!--                                         v-model="reportForThisQuarter" value="2">-->
              <!--                                  2: April, May, June-->
              <!--                              </label>-->
              <!--                              <label class="form-check-label d-block mt-2">-->
              <!--                                  <input type="radio" class="form-check-input" name="personalQuarterReport"-->
              <!--                                         v-model="reportForThisQuarter" value="3">-->
              <!--                                  3: July, August, September-->
              <!--                              </label>-->
              <!--                              <label class="form-check-label d-block mt-2">-->
              <!--                                  <input type="radio" class="form-check-input" name="personalQuarterReport"-->
              <!--                                         v-model="reportForThisQuarter" value="4">-->
              <!--                                  4: October, November, December-->
              <!--                              </label>-->
              <!--                          </div>-->
              <!--Calendar Year-->
              <!--                          <flatpickr timeFormat="Y" v-model="calendarYear" id="personal_calendar_year"/>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Flatpickr from "../../Calendar/Flatpickr";
import * as $ from "jquery";
import { mapActions } from "vuex";

export default {
  name: "PersonalDetails",
  components: { Flatpickr },
  mounted() {
    $("#personal_calendar_year").val("");
  },
  data() {
    return {
      /* Form Variables */
      employerIdentificationNumber: null,
      name: null,
      tradeName: null,
      address: null,
      city: null,
      state: null,
      zip: null,
      f_countryName: null,
      f_countryProvince: null,
      f_countryZIP: null,
      reportForThisQuarter: null,
      creditTypeBox: null,
      calendarYear: null,
      errors: {
        ein: null,
        name: null,
        address: null,
        city: null,
        state: null,
        zip: null,
        numberOfEmployees: null,
        totalWages: null,
        withheldTax: null,
        taxableSSWages: null,
        taxableSSTips: null,
        taxableMedicalWages: null,
        taxableAMTWithholding: null,
        line5E: null,
        totalTaxesBeforeAdjustments: null,
        line10Sum: null,
        line12TotalTaxesAfterAdjustments: null,
        totalQuarterDeposits: null,
        line15Overpayment: null,
        overpaymentOption: null,
        partTwoNumberSixteen: null,
      },
    };
  },
  methods: {
    ...mapActions([
      "updateEIN",
      "updateName",
      "updateTradeName",
      "updateAddress",
      "updateState",
      "updateCity",
      "updateZip",
      "updateForeignCountryName",
      "updateForeignCountryProvince",
      "updateForeignCountryZip",
      "updateQuarterRadio",
    ]),
    updateEINState(event) {
      this.updateEIN(event.target.value);
      // console.log(event.target.value)
    },
    updateNameState(event) {
      this.updateName(event.target.value);
    },
    updateTradeNameState(event) {
      this.updateTradeName(event.target.value);
    },
    updateAddressState(event) {
      this.updateAddress(event.target.value);
    },
    updateCityState(event) {
      this.updateCity(event.target.value);
    },
    updateStateState(event) {
      this.updateState(event.target.value);
    },
    updateZipState(event) {
      this.updateZip(event.target.value);
    },
    updateFCountryNameState(event) {
      this.updateForeignCountryName(event.target.value);
    },
    updateFCountryProvinceState(event) {
      this.updateForeignCountryProvince(event.target.value);
    },
    updateFCountryZipState(event) {
      this.updateForeignCountryZip(event.target.value);
    },
    test() {
      // console.warn('Date has changed')
    },
  },
  watch: {
    reportForThisQuarter: function (val) {
      // console.log('Watching ', val);
      this.reportForThisQuarter = val;
      // this.$store.dispatch('updateQuarterRadio', val);
      this.updateQuarterRadio(val);
    },
  },
};
</script>

<style scoped>
</style>
