<template>
  <div class="container-fluid">
    <div class="row bg-white">

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
        {{ returnQuarterSelected() }}
        {{ returnForm8974Line12() }}
        {{ returnScheduleBMonthOneTaxLiability }}
        {{ returnScheduleBMonthTwoTaxLiability }}
        {{ returnScheduleBMonthThreeTaxLiability }}
      </div>

      <div class="position-fixed" style="right: 1rem; bottom:1rem;">

        <div>
          <button class="btn btn-primary d-inline export" @click="exportToPDF">Export</button>
        </div>
      </div>

      <div class="row justify-content-center">

        <div class="col-12 mt-3 mb-3">
          <h4 class="alert-info p-2 text-center">Form 941 2020</h4>
        </div>

        <!--TOP OF FORM-->
        <div class="col-lg-10 col-12 bg-white mt-4 p-3 text-left">

          <div class="row">
            <div class="col-8">
              <div class="row">

                <div class="col-12" :class="{'alert-danger': errors.formTypeSelected, 'alert-success': (errors.formTypeSelected===false)}">
                  <h6>Select the form year you would like to use. <b>{{ formTypeSelected }}</b> </h6>
                  <el-radio-group v-model="formTypeSelected">
                    <!-- <el-radio :label="'2019'">941 2019</el-radio> -->
                    <el-radio :label="'2020A'">941 April 2020</el-radio>
                    <el-radio :label="'2020J'">941 July 2020</el-radio>
                  </el-radio-group>
                </div>

                <div class="col-5 font-weight-bold mb-2">
                  Employer identification number
                </div>
                <div class="col-7 my-auto">
                  <input type="text" class="form-control"
                         :class="{'is-invalid': errors.ein, 'is-valid': (errors.ein===false)}"
                         v-model="employerIdentificationNumber"
                         minlength="9"
                         maxlength="9">
                </div>

                <!--Name-->
                <div class="col-5 font-weight-bold mb-2">
                  Name
                </div>
                <div class="col-7 my-auto">
                  <input type="text" class="form-control mb-2"
                         :class="{'is-invalid': errors.name, 'is-valid': (errors.name===false)}"
                         minlength="1"
                         v-model="name">
                </div>

                <!--Trade Name-->
                <div class="col-5 font-weight-bold mb-2">
                  Trade Name
                </div>
                <div class="col-7 my-auto">
                  <input type="text" class="form-control mb-2"
                         :class="{'is-invalid': errors.tradeName, 'is-valid': (errors.tradeName===false)}"
                         minlength="1"
                         v-model="tradeName">
                </div>

                <!--Address-->
                <div class="col-5 font-weight-bold mb-2">
                  Address
                </div>
                <div class="col-7 my-auto">

                  <div class="row">
                    <div class="col-12">
                      <input type="text" placeholder="Number     Street"
                             class="form-control mb-2"
                             :class="{'is-invalid': errors.address, 'is-valid': (errors.address===false)}"
                             minlength="1"
                             v-model="address">
                    </div>
                    <div class="col-12">
                      <input type="text" placeholder="City"
                             class="form-control mb-2"
                             :class="{'is-invalid': errors.city, 'is-valid': (errors.city===false)}"
                             v-model="city">
                    </div>
                    <div class="col-12">
                      <input type="text" placeholder="State"
                             class="form-control mb-2 text-uppercase"
                             :class="{'is-invalid': errors.state, 'is-valid': (errors.state===false)}"
                             minlength="2" maxlength="2"
                             v-model="state">
                    </div>
                    <div class="col-12">
                      <input type="text" placeholder="ZIP"
                             class="form-control mb-2"
                             :class="{'is-invalid': errors.zip, 'is-valid': (errors.zip===false)}"
                             minlength="5" maxlength="5"
                             v-model="zip">
                    </div>
                    <div class="col-12">
                      <input type="text" placeholder="Foreign country name" class="form-control mb-2"
                             v-model="f_countryName">
                    </div>
                    <div class="col-12">
                      <input type="text" placeholder="Foreign province/country" class="form-control mb-2"
                             v-model="f_countryProvince">
                    </div>
                    <div class="col-12">
                      <input type="text" placeholder="Foreign postal code"
                             class="form-control mb-2" minlength="5" maxlength="5"
                             v-model="f_countryZIP">
                    </div>
                  </div>

                </div>

              </div>
            </div>
            <div class="col-4">
              <div class="form-check">
                <h6 class="font-weight-bold bg-dark p-2 text-white mb-2">Report for this quarter <small>check
                  only one box</small></h6>
                <label class="form-check-label d-block mt-2">
                  <input type="radio" class="form-check-input" name="quarterReport"
                         v-model="reportForThisQuarter" value="1">
                  1: January, February, March
                </label>
                <label class="form-check-label d-block mt-2">
                  <input type="radio" class="form-check-input" name="quarterReport"
                         v-model="reportForThisQuarter" value="2">
                  2: April, May, June
                </label>
                <label class="form-check-label d-block mt-2">
                  <input type="radio" class="form-check-input" name="quarterReport"
                         v-model="reportForThisQuarter" value="3">
                  3: July, August, September
                </label>
                <label class="form-check-label d-block mt-2">
                  <input type="radio" class="form-check-input" name="quarterReport"
                         v-model="reportForThisQuarter" value="4">
                  4: October, November, December
                </label>
              </div>
            </div>

          </div>
        </div>

        <!--Part 1 OF FORM-->
        <div class="col-lg-10 col-12 bg-white mt-4 p-3">
          <div class="bg-dark p-2 text-white mb-3">Part 1 <span class="bg-white text-dark p-1 ml-2">Answer these questions for this quarter</span>
          </div>


          <!--###########-->
          <!--1 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[0].id}}</b>{{partTwoFieldInfo[0].description}}
            </div>
            <div class="col-4 my-auto">
              <input type="text" placeholder="Fill in"
                     class="form-control"
                     :class="{'is-invalid': errors.numberOfEmployees, 'is-valid': (errors.numberOfEmployees===false)}"
                     v-model="numberOfEmployees">
            </div>
          </div>

          <!--###########-->
          <!--2 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[1].id}}</b>{{partTwoFieldInfo[1].description}}
            </div>
            <div class="col-4 my-auto">
              <input type="text" placeholder="Fill in"
                     class="form-control"
                     :class="{'is-invalid': errors.totalWages, 'is-valid': (errors.totalWages===false)}"
                     v-model="totalWages">
            </div>
          </div>

          <!--###########-->
          <!--3 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[2].id}}</b>{{partTwoFieldInfo[2].description}}
            </div>
            <div class="col-4 my-auto">
              <input type="text" placeholder="Fill in"
                     class="form-control"
                     :class="{'is-invalid': errors.withheldTax, 'is-valid': (errors.withheldTax===false)}"
                     v-model="withheldTax">
            </div>
          </div>

          <!--###########-->
          <!--4 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[3].id}}</b>{{partTwoFieldInfo[3].description}}
            </div>
            <div class="col-4 my-auto">
              <div class="form-check">
                <label class="form-check-label">
                  <el-checkbox v-model="noWages">Check and go to line 6</el-checkbox>

                </label>
              </div>
            </div>
          </div>

          <!--###########-->
          <!--5a #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[4].id}}</b>{{partTwoFieldInfo[4].description}}
            </div>
            <div class="col-4 my-auto">
              <div class="row">
                <div class="col-6">
                  <input type="text" class="form-control" v-model="taxableSSWages">
                </div>
                <div class="col-6 my-auto">{{taxable5A}}</div>
              </div>
            </div>
          </div>

          <!--###########-->
          <!--5ai #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[5].id}}</b>{{partTwoFieldInfo[5].description}}
            </div>
            <div class="col-4 my-auto">
              <div class="row">
                <div class="col-6">
                  <input type="text" class="form-control" v-model="qualifiedSickLeaveWages">
                </div>
                <div class="col-6 my-auto">{{taxable5AI}}</div>
              </div>
            </div>
          </div>

          <!--###########-->
          <!--5aii #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[6].id}}</b>{{partTwoFieldInfo[6].description}}
            </div>
            <div class="col-4 my-auto">
              <div class="row">
                <div class="col-6">
                  <input type="text" class="form-control" v-model="qualifiedFamilyLeaveWages">
                </div>
                <div class="col-6 my-auto">{{taxable5AII}}</div>
              </div>
            </div>
          </div>

          <!--###########-->
          <!--5b #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[7].id}}</b>{{partTwoFieldInfo[7].description}}
            </div>
            <div class="col-4 my-auto">
              <div class="row">
                <div class="col-6">
                  <input type="text" class="form-control" v-model="taxableSSTips">
                </div>
                <div class="col-6 my-auto">{{taxable5B}}</div>
              </div>
            </div>
          </div>

          <!--###########-->
          <!--5c #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[8].id}}</b>{{partTwoFieldInfo[8].description}}
            </div>
            <div class="col-4 my-auto">
              <div class="row">
                <div class="col-6">
                  <input type="text" class="form-control" v-model="taxableMedicalWages">
                </div>
                <div class="col-6 my-auto">{{taxable5C}}</div>
              </div>
            </div>
          </div>

          <!--###########-->
          <!--5d #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[9].id}}</b>{{partTwoFieldInfo[9].description}}
            </div>
            <div class="col-4 my-auto">
              <div class="row">
                <div class="col-6">
                  <input type="text" class="form-control" v-model="taxableAMTWithholding">
                </div>
                <div class="col-6 my-auto">{{taxable5D}}</div>
              </div>
            </div>
          </div>

          <!--###########-->
          <!--5e #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[10].id}}</b>{{partTwoFieldInfo[10].description}}
            </div>
            <div class="col-4 my-auto text-center"
                 :class="{'alert-danger': errors.line5E, 'alert-success': (errors.line5E===false)}"
            >{{ line5E }}
            </div>
          </div>

          <!--###########-->
          <!--5f #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[11].id}}</b>{{partTwoFieldInfo[11].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="section3121">
            </div>
          </div>

          <!--###########-->
          <!--6 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[12].id}}</b>{{partTwoFieldInfo[12].description}}
            </div>
            <div class="col-4 my-auto text-center"
                 :class="{'alert-danger': errors.totalTaxesBeforeAdjustments, 'alert-success': (errors.totalTaxesBeforeAdjustments===false)}">
              {{totalTaxesBeforeAdjustments}}
            </div>
          </div>

          <!--###########-->
          <!--7 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[13].id}}</b>{{partTwoFieldInfo[13].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="currentFractionsOfCents">
            </div>
          </div>

          <!--###########-->
          <!--8 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[14].id}}</b>{{partTwoFieldInfo[14].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="currentSickPay">
            </div>
          </div>

          <!--###########-->
          <!--9 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[15].id}}</b>{{partTwoFieldInfo[15].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="currentTipAndGroupTerm">
            </div>
          </div>

          <!--###########-->
          <!--10 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[16].id}}</b>{{partTwoFieldInfo[16].description}}
            </div>
            <div class="col-4 my-auto text-center">{{line10Sum}}</div>
          </div>

          <!--###########-->
          <!--11 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[17].id}}</b>{{partTwoFieldInfo[17].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="qualifiedSmallBusinessPayroll">
            </div>
          </div>

          <!--###########-->
          <!--11b #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[18].id}}</b>{{partTwoFieldInfo[18].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="nonrefundableSickAndFamily">
            </div>
          </div>

          <!--###########-->
          <!--11c #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[19].id}}</b>{{partTwoFieldInfo[19].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="nonrefundableEmployee">
            </div>
          </div>

          <!--###########-->
          <!--11d #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[20].id}}</b>{{partTwoFieldInfo[20].description}}
            </div>
            <div class="col-4 my-auto text-center">
              {{ line11D }}
            </div>
          </div>

          <!--###########-->
          <!--12 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[21].id}}</b>{{partTwoFieldInfo[21].description}}
            </div>
            <div class="col-4 my-auto text-center">{{ line12TotalTaxesAfterAdjustments }}</div>
          </div>

          <!--###########-->
          <!--13 / 13a #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[22].id}}</b>{{partTwoFieldInfo[22].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="totalQuarterDeposits">
            </div>
          </div>

          <!--###########-->
          <!--13b #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[23].id}}</b>{{partTwoFieldInfo[23].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="deferredShareSocialSecurity">
            </div>
          </div>

          <!--###########-->
          <!--13c #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[24].id}}</b>{{partTwoFieldInfo[24].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="refundableFamily">
            </div>
          </div>

          <!--###########-->
          <!--13d #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[25].id}}</b>{{partTwoFieldInfo[25].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="refundableEmployee">
            </div>
          </div>

          <!--###########-->
          <!--13e #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[26].id}}</b>{{partTwoFieldInfo[26].description}}
            </div>
            <div class="col-4 my-auto text-center">
              {{ line13eTotalDepositsDeferrals }}
            </div>
          </div>

          <!--###########-->
          <!--13f #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[27].id}}</b>{{partTwoFieldInfo[27].description}}
            </div>
            <div class="col-4 my-auto text-center">
              <input type="text" class="form-control" placeholder="Fill in" v-model="totalAdvancesRecieved">
            </div>
          </div>

          <!--###########-->
          <!--13g #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[28].id}}</b>{{partTwoFieldInfo[28].description}}
            </div>
            <div class="col-4 my-auto text-center">
              {{ line13gTotalDepositsLessAdvances }}
            </div>
          </div>

          <!--###########-->
          <!--14 #########-->
          <!--###########-->
          <div class="row mb-2">
            <div class="col-8 my-auto">
              <b class="mr-3">{{partTwoFieldInfo[29].id}}</b>{{partTwoFieldInfo[29].description}}
            </div>
            <div class="col-4 my-auto text-center">{{ line14BalanceDue }}</div>
          </div>

          <!--###########-->
          <!--15 #########-->
          <!--###########-->
          <div class="row mb-2 bg-light">
            <div class="col-8">
              <b class="mr-3">{{partTwoFieldInfo[30].id}}</b>{{partTwoFieldInfo[30].description}}
            </div>
            <div class="col-4 text-center"
                 :class="{'alert-danger': errors.overpaymentOption, 'alert-success': (errors.overpaymentOption===false)}">
              <div class="row">
                <div class="col-12 mb-2">{{line15Overpayment}}</div>
                <div class="col-6">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="OverpaymentOption" v-model="overpaymentOption"
                             value="1">
                      Apply to next return
                    </label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="OverpaymentOption"
                             v-model="overpaymentOption" value="2" checked>
                      Send a refund
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!--Part 2 OF FORM-->
        <div class="col-lg-10 col-12 bg-white mt-4">
          <div class="bg-dark p-2 text-white">Part 2 <span class="bg-white text-dark p-1 ml-2">Tell us about your deposit schedule and tax liability for this quarter</span>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group bg-light p-2">
                <label for="">Name</label>
                <p v-model="name">{{name}}</p>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group bg-light p-2">
                <label for="">Employer identification number (EIN)</label>
                <p v-model="employerIdentificationNumber">{{employerIdentificationNumber}}</p>
              </div>
            </div>

            <div class="col-12"
                 :class="{'alert-danger': errors.partTwoNumberSixteen, 'alert-success': (errors.partTwoNumberSixteen===false)}">
              <h6>16 Check one:</h6>
              <div class="mb-3">
                <input type="radio" value="1" v-model="partTwoNumberSixteen" name="partTwoNumberSixteen"
                       class="d-inline mr-3">
                Line
                12 on
                this
                return
                is less than
                $2,500 or line 12 on the return for the prior quarter was less than $2,500, and you didn’t
                incur a $100,000 next-day deposit obligation during the current quarter. If line 12 for the prior quarter
                was less than $2,500 but
                line 12 on this return is $100,000 or more, you must provide a record of your federal tax liability. If
                you are a monthly schedule
                depositor, complete the deposit schedule below; if you are a semiweekly schedule depositor, attach
                Schedule B (Form 941). Go to
                Part 3.
              </div>
              <div class="mb-3 bg-light">
                <input type="radio" value="2" v-model="partTwoNumberSixteen" name="partTwoNumberSixteen"
                       class="d-inline mr-3">
                You
                were a
                monthly
                schedule
                depositor for the entire quarter. Enter your tax liability for each month and total
                liability for the quarter, then go to Part 3.
                <h6 class="font-weight-bold mt-3">Tax Liability</h6>
                <div>
                  <span class="mr-3 font-weight-bold">Month 1</span> <input type="text"
                                                                            class="form-control mb-2 sixteenB d-inline"
                                                                            v-model="month1">
                </div>
                <div>
                  <span class="mr-3 font-weight-bold">Month 2</span> <input type="text"
                                                                            class="form-control mb-2 sixteenB d-inline"
                                                                            v-model="month2">
                </div>
                <div>
                  <span class="mr-3 font-weight-bold">Month 3</span><input type="text"
                                                                           class="form-control mb-2 sixteenB d-inline"
                                                                           v-model="month3">
                </div>
                <div>
                                  <span class="font-weight-bolder mr-3">Total liability for quarter. <small>Total must
                                      equal line
                                      12</small></span> {{line16TotalLiability}}
                </div>
                <div class="font-weight-bolder mt-2">
                  Current Line 12 Sum <span class="ml-2 alert-success p-2">{{ line12TotalTaxesAfterAdjustments }}</span>
                </div>

              </div>
              <div class="mb-3">
                <input type="radio" value="3" v-model="partTwoNumberSixteen" name="partTwoNumberSixteen"
                       class="d-inline mr-3">
                You
                were a
                semiweekly
                schedule
                depositor for any part of this quarter. Complete Schedule B (Form 941),
                Report of Tax Liability for Semiweekly Schedule Depositors, and attach it to Form 941.
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import {PDFDocument, rgb, StandardFonts} from 'pdf-lib';
  import download from 'downloadjs';
  import {mapActions, mapGetters} from "vuex";

  export default {
        name: "Form_941_2020_Component",
        props: {
            formUrl: String,
        },
        mounted() {
            this.url = this.formUrl;
            this.unmodifiedUrl = this.formUrl;
            // console.error('Mounted 941 2020 A/J ', this.formUrl);
          if (this.returnCurrentActiveCompany) {
            this.employerIdentificationNumber = this.returnCurrentActiveCompany.ein;
            this.name = this.returnCurrentActiveCompany.name;
          }
        },
        data() {
            return {
                url: null,
                unmodifiedUrl: null,
                use2020Title: false,
                formTypeSelected: '',
                partTwoFieldInfo: [
                    {
                        id: '1',
                        model: 'f5f',
                        description: 'Number of employees who received wages, tips, or other compensation for the pay period including: Sept. 12 (Quarter 3) or Dec. 12 (Quarter 4)'
                    },
                    {id: '2', model: 'f5f', description: 'Wages, tips, and other compensation'},
                    {
                        id: '3',
                        model: 'f5f',
                        description: 'Federal income tax withheld from wages, tips, and other compensation '
                    },
                    {
                        id: '4',
                        model: 'f5f',
                        description: 'If no wages, tips, and other compensation are subject to social security or Medicare tax'
                    },
                    {id: '5a', model: 'f5f', description: 'Taxable social security wages'},
                    {id: '5ai', model: 'f5f', description: '(i) Qualified sick leave wages'},
                    {id: '5aii', model: 'f5f', description: '(ii) Qualified family leave wages'},
                    {id: '5b', model: 'f5f', description: 'Taxable social security tips .'},
                    {id: '5c', model: 'f5f', description: 'Taxable Medicare wages & tips'},
                    {
                        id: '5d',
                        model: 'f5f',
                        description: 'Taxable wages & tips subject to Additional Medicare Tax withholding'
                    },
                    {id: '5e', model: 'f5f', description: 'Add Column 2 from lines 5a, 5b, 5c, and 5d'},
                    {
                        id: '5f',
                        model: 'f5f',
                        description: 'Section 3121(q) Notice and Demand—Tax due on unreported tips (see instructions)'
                    },
                    {id: '6', model: 'f5f', description: 'Total taxes before adjustments. Add lines 3, 5e, and 5f'},
                    {id: '7', model: 'f5f', description: 'Current quarter’s adjustment for fractions of cents'},
                    {id: '8', model: 'f5f', description: 'Current quarter’s adjustment for sick pay'},
                    {
                        id: '9',
                        model: 'f5f',
                        description: 'Current quarter’s adjustments for tips and group-term life insurance'
                    },
                    {id: '10', model: 'f5f', description: 'Total taxes after adjustments. Combine lines 6 through 9'},
                    {
                        id: '11a',
                        model: 'f5f',
                        description: 'Qualified small business payroll tax credit for increasing research activities. Attach Form 8974'
                    },
                    {
                        id: '11b',
                        model: 'f5f',
                        description: 'Nonrefundable portion of credit for qualified sick and family leave wages from Worksheet 1'
                    },
                    {
                        id: '11c',
                        model: 'f5f',
                        description: 'Nonrefundable portion of employee retention credit from Worksheet 1'
                    },
                    {
                        id: '11d',
                        model: 'f5f',
                        description: 'Total nonrefundable credits. Add lines 11a, 11b, and 11c'
                    },
                    {
                        id: '12',
                        model: 'f5f',
                        description: 'Total taxes after adjustments and credits. Subtract line 11 from line 10'
                    },
                    {
                        id: '13',
                        model: 'f5f',
                        description: 'Total deposits for this quarter, including overpayment applied from a prior quarter and overpayments applied from Form 941-X, 941-X (PR), 944-X, or 944-X (SP) filed in the current quarter'
                    },
                    {
                        id: '13b',
                        model: 'f5f',
                        description: 'Deferred amount of the employer share of social security tax'
                    },
                    {
                        id: '13c',
                        model: 'f5f',
                        description: 'Refundable portion of credit for qualified sick and family leave wages from Worksheet 1'
                    },
                    {
                        id: '13d',
                        model: 'f5f',
                        description: 'Refundable portion of employee retention credit from Worksheet 1'
                    },
                    {
                        id: '13e',
                        model: 'f5f',
                        description: 'Total deposits, deferrals, and refundable credits. Add lines 13a, 13b, 13c, and 13d'
                    },
                    {
                        id: '13f',
                        model: 'f5f',
                        description: 'Total advances received from filing Form(s) 7200 for the quarter'
                    },
                    {
                        id: '13g',
                        model: 'f5f',
                        description: 'Total deposits, deferrals, and refundable credits less advances. Subtract line 13f from line 13e'
                    },
                    {
                        id: '14',
                        model: 'f5f',
                        description: 'Balance due. If line 12 is more than line 13g, enter the difference and see instructions'
                    },
                    {
                        id: '15',
                        model: 'f5f',
                        description: 'Overpayment. If line 13g is more than line 12, enter the difference'
                    }
                ],
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
                /* Field ID for generated fields in Part1 */
                numberOfEmployees: null,
                totalWages: null,
                withheldTax: 0,
                noWages: false,
                taxableSSWages: null,
                qualifiedSickLeaveWages: null,
                qualifiedFamilyLeaveWages: null,
                taxableSSTips: null,
                taxableMedicalWages: null,
                taxableAMTWithholding: null,
                section3121: 0,
                currentFractionsOfCents: 0,
                currentSickPay: 0,
                currentTipAndGroupTerm: 0,
                qualifiedSmallBusinessPayroll: 0, //11
                nonrefundableSickAndFamily: 0,
                nonrefundableEmployee: 0,
                totalRefundableCredits: 0,
                totalQuarterDeposits: 0, // 13 / 13a
                deferredShareSocialSecurity: 0,
                refundableFamily: 0,
                refundableEmployee: 0,
                totalDepositsDeferralsandRefundable: 0,
                totalAdvancesRecieved: 0,
                totalDepositsLessAdvances: 0,
                overpaymentOption: null,
                partTwoNumberSixteen: null,
                month1: 0,
                month2: 0,
                month3: 0,
                errors: {
                    formTypeSelected: null,
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
                }
            }
        },
        computed: {
            ...mapGetters([
                'returnScheduleBMonthOneTaxLiability',
                'returnScheduleBMonthTwoTaxLiability',
                'returnScheduleBMonthThreeTaxLiability',
                'returnScheduleBQuarterTotalTaxLiability',
                'returnCurrentActiveCompany'
            ]),
            taxable5A: function () {
                const _n = Number((this.taxableSSWages * 0.124).toFixed(2));
                this.storeForm941Line5AColumn2(_n);
                return _n;
            },
            taxable5AI() {
                const _n = Number((this.qualifiedSickLeaveWages * 0.062).toFixed(2));
                return _n;
            },
            taxable5AII() {
                const _n = Number((this.qualifiedFamilyLeaveWages * 0.062).toFixed(2));
                return _n;
            },
            taxable5B: function () {
                const _n = Number((this.taxableSSTips * 0.124).toFixed(2));
                this.storeForm941Line5BColumn2(_n);
                return _n;
            },
            taxable5C: function () {
                return Number((this.taxableMedicalWages * 0.029).toFixed(2))
            },
            taxable5D: function () {
                return Number((this.taxableAMTWithholding * 0.009).toFixed(2))
            },
            line5E: function () {
                const sums = [this.taxable5A, this.taxable5AI, this.taxable5AII, this.taxable5B, this.taxable5C, this.taxable5D];
                return parseFloat((sums.reduce((a, b) => a + b, 0)).toFixed(2))
            },
            totalTaxesBeforeAdjustments: function () {
                const amounts = [parseFloat(this.withheldTax), this.line5E, parseFloat(this.section3121)];
                return (amounts.reduce((a, b) => a + b, 0)).toFixed(2)
            },
            line10Sum: function () {
                const amounts = [parseFloat(this.totalTaxesBeforeAdjustments), parseFloat(this.currentFractionsOfCents), parseFloat(this.currentSickPay), parseFloat(this.currentTipAndGroupTerm)];
                const total = (amounts.reduce((a, b) => a + b, 0)).toFixed(2);
                this.totalQuarterDeposits = total;
                return total;
            },
            line11D() {
                const amounts = [parseFloat(this.qualifiedSmallBusinessPayroll), parseFloat(this.nonrefundableSickAndFamily), parseFloat(this.nonrefundableEmployee)];
                const total = (amounts.reduce((a, b) => a + b, 0)).toFixed(2);
                this.totalRefundableCredits = total;
                return total;
            },
            line12TotalTaxesAfterAdjustments: function () {
                return (parseFloat(this.line10Sum) - parseFloat(this.line11D)).toFixed(2)
            },
            line13eTotalDepositsDeferrals(){
                const amounts = [parseFloat(this.totalQuarterDeposits), parseFloat(this.deferredShareSocialSecurity), parseFloat(this.refundableFamily), parseFloat(this.refundableEmployee)];
                const total = (amounts.reduce((a, b) => a + b, 0)).toFixed(2);
                this.totalDepositsDeferralsandRefundable = total;
                return total;
            },
            line13gTotalDepositsLessAdvances(){
                let total = (parseFloat(this.line13eTotalDepositsDeferrals) - parseFloat(this.totalAdvancesRecieved)).toFixed(2);
                this.totalDepositsLessAdvances = total;
                return total;
            },
            line14BalanceDue: function () {
                // console.log()
                if (parseFloat(this.line12TotalTaxesAfterAdjustments) > parseFloat(this.line13gTotalDepositsLessAdvances)) {
                    return (parseFloat(this.line12TotalTaxesAfterAdjustments) - parseFloat(this.line13gTotalDepositsLessAdvances)).toFixed(2)
                } else return 0
            },
            line15Overpayment: function () {
                if (parseFloat(this.line13gTotalDepositsLessAdvances) > parseFloat(this.line12TotalTaxesAfterAdjustments)) {
                    return (parseFloat(this.line13gTotalDepositsLessAdvances) - parseFloat(this.line12TotalTaxesAfterAdjustments)).toFixed(2)
                } else return 0
            },
            line16TotalLiability: function () {
                const amounts = [parseFloat(this.month1), parseFloat(this.month2), parseFloat(this.month3)];

                // Add condition here if working with multi forms to use computed over standard
                // if(this.disableDownload === 'Y') {
                //   return this.returnScheduleBQuarterTotalTaxLiability;
                // } else {
                return (amounts.reduce((a, b) => a + b, 0)).toFixed(2);
                // }
            },
        },
        methods: {
            ...mapGetters(['returnEmployerIdentificationNumber', 'returnName', 'returnTradeName', 'returnAddress',
                'returnCity', 'returnState', 'returnZip', 'returnForeignName', 'returnForeignProvince', 'returnForeignZip',
                'returnQuarterSelected', 'returnForm941Line5AColumn2', 'returnForm8974Line12']),
            ...mapActions(['storeForm941Line5AColumn2', 'storeForm941Line5BColumn2']),
            validateFormFields: function () {

                if(this.formTypeSelected === '') {
                  this.errors.formTypeSelected = true;
                  return false
                } else this.errors.formTypeSelected = false;

                if (this.employerIdentificationNumber === null || this.employerIdentificationNumber.trim().length < 9) {
                    this.errors.ein = true;
                    return false
                } else this.errors.ein = false;

                if (this.name === null || this.name.trim().length < 1) {
                    this.errors.name = true;
                    return false
                } else this.errors.name = false;

                if (this.address === null || this.address.trim().length < 1) {
                    this.errors.address = true;
                    return false
                } else this.errors.address = false;

                if (this.city === null || this.city.trim().length < 1) {
                    this.errors.city = true;
                    return false
                } else this.errors.city = false;

                if (this.state === null || this.state.trim().length < 1) {
                    this.errors.state = true;
                    return false
                } else this.errors.state = false;

                if (this.zip === null || this.zip.trim().length < 1) {
                    this.errors.zip = true;
                    return false
                } else this.errors.zip = false;

                if (parseFloat(this.numberOfEmployees) < 0 || this.numberOfEmployees === null) {
                    this.errors.numberOfEmployees = true;
                    return false
                } else this.errors.numberOfEmployees = false;

                if (parseFloat(this.totalWages) < 0 || this.totalWages === null) {
                    this.errors.totalWages = true;
                    return false
                } else this.errors.totalWages = false;

                if (parseFloat(this.withheldTax) < 0) {
                    this.errors.withheldTax = true;
                    return false
                } else this.errors.withheldTax = false;

                /*5E, Only check if no wages #4 is false */
                if (!this.noWages) {
                    if (parseFloat(this.line5E) <= 0) {
                        this.errors.line5E = true;
                        return false
                    } else this.errors.line5E = false;
                } else this.errors.line5E = false;

                /*6*/
                if (parseFloat(this.totalTaxesBeforeAdjustments) <= 0) {
                    this.errors.totalTaxesBeforeAdjustments = true;
                    return false
                } else this.errors.totalTaxesBeforeAdjustments = false;

                /*10*/
                if (parseFloat(this.line10Sum) <= 0) {
                    this.errors.line10Sum = true;
                    return false
                } else this.errors.line10Sum = false;

                /*12*/
                if (parseFloat(this.line12TotalTaxesAfterAdjustments) <= 0) {
                    this.errors.line12TotalTaxesAfterAdjustments = true;
                    return false
                } else this.errors.line12TotalTaxesAfterAdjustments = false;

                /*13*/
                if (parseFloat(this.totalQuarterDeposits) <= 0) {
                    this.errors.totalQuarterDeposits = true;
                    return false
                } else this.errors.totalQuarterDeposits = false;

                /*15*/
                if (parseFloat(this.line15Overpayment) < 0) {
                    this.errors.line15Overpayment = true;
                    return false
                } else this.errors.line15Overpayment = false;

                /* Overpayment Option */
                switch (parseInt(this.overpaymentOption)) {
                    case 1:
                        this.errors.overpaymentOption = false;
                        break;
                    case 2:
                        this.errors.overpaymentOption = false;
                        break;
                    default:
                        // console.log('No Overpayment Option Selected!');
                        this.errors.overpaymentOption = true;
                        return false;
                }

                /*16*/
                if (this.partTwoNumberSixteen === null) {
                    this.errors.partTwoNumberSixteen = true;
                    return false
                } else this.errors.partTwoNumberSixteen = false;

                return true;
            },
            isNumberRegex(_input) {
                const reg = new RegExp(/^[0-9]+([,.][0-9]+)?$/g);
                return reg.test(_input);
            },
            exportToPDF: async function () {

                /*  TODO Validate all fields before exporting */
                const validated = this.validateFormFields();

                /*EIN*/
                // console.log(validated);
                if (!validated) {
                    /* Prompt Error */
                    // console.error('Form errors!');
                } else {

                    // Reset Url
                    this.url = this.unmodifiedUrl;

                    if(this.formTypeSelected === '2020J') {
                      // console.warn('2020J SELECTED with URL : ', this.url);
                      this.url = this.url.replace('Form_941_2020A.pdf','Form_941_2020J.pdf');
                      // console.warn('2020J SELECTED with ALTERED URL : ', this.url);
                    }

                    /* Write all contents to Final PDF */
                    // const existingPdfBytes = await fetch(this.url).then(res => res.arrayBuffer());
                    const existingPdfBytes = await fetch(this.url).then(res => res.arrayBuffer());

                    const pdfDoc = await PDFDocument.load(existingPdfBytes);
                    const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);

                    const pages = pdfDoc.getPages();
                    const firstPage = pages[0];
                    const secondPage = pages[1];
                    const thirdPage = pages[2];
                    const {width, height} = firstPage.getSize();
                    const COLOR = rgb(0, 0, 0);
                    const baseOptions = {
                        size: 10,
                        font: helveticaFont,
                        color: COLOR,
                    };
                    const baseYOffset = 23;

                    /*EIN
                    * clone name
                    * mutate
                    * output
                    * */
                    let ein_mutated = this.employerIdentificationNumber.split('');
                    for (let i = 0; i < 9; i++) {
                        let ein_XCoord = [160, 185, 225, 250, 275, 300, 325, 350, 375];

                        firstPage.drawText(ein_mutated[i], {
                            x: ein_XCoord[i],
                            y: height / 2 + 318,
                            ...baseOptions
                        });
                    }

                    firstPage.drawText(this.name, {
                        x: 150,
                        y: height / 2 + 295,
                        ...baseOptions
                    });

                    /*  IF – TradeName */
                    if (this.tradeName !== null) {
                        firstPage.drawText(this.tradeName, {
                            x: 135,
                            y: height / 2 + 270,
                            ...baseOptions
                        });
                    }

                    /*Address*/
                    firstPage.drawText(this.address, {
                        x: 95,
                        y: height / 2 + 245,
                        ...baseOptions
                    });

                    /*City*/
                    firstPage.drawText(this.city, {
                        x: 95,
                        y: height / 2 + 215,
                        ...baseOptions
                    });

                    /*State*/
                    firstPage.drawText(this.state, {
                        x: 285,
                        y: height / 2 + 215,
                        ...baseOptions
                    });

                    /*ZIP*/
                    firstPage.drawText(this.zip, {
                        x: 325,
                        y: height / 2 + 215,
                        ...baseOptions
                    });

                    /* IF – Foreign Country*/
                    if (this.f_countryName !== null) {
                        firstPage.drawText(this.f_countryName.toString(), {
                            x: 95,
                            y: height / 2 + 185,
                            ...baseOptions
                        });
                    }

                    /* IF – Foreign Province*/
                    if (this.f_countryProvince !== null) {
                        firstPage.drawText(this.f_countryProvince.toString(), {
                            x: 235,
                            y: height / 2 + 185,
                            ...baseOptions
                        });
                    }

                    /* IF – Foreign Province*/
                    if (this.f_countryZIP !== null) {
                        firstPage.drawText(this.f_countryZIP.toString(), {
                            x: 335,
                            y: height / 2 + 185,
                            ...baseOptions
                        });
                    }

                    /* Report for this quarter */
                    switch (this.reportForThisQuarter) {
                        case '1':
                            firstPage.drawText('x', {
                                x: 427,
                                y: height / 2 + 294,
                                ...baseOptions
                            });
                            break;
                        case '2':
                            firstPage.drawText('x', {
                                x: 427,
                                y: height / 2 + 277,
                                ...baseOptions
                            });
                            break;
                        case '3':
                            firstPage.drawText('x', {
                                x: 427,
                                y: height / 2 + 260,
                                ...baseOptions
                            });
                            break;
                        case '4':
                            firstPage.drawText('x', {
                                x: 427,
                                y: height / 2 + 243,
                                ...baseOptions
                            });
                            break;
                    }

                    /* Number Of Employees */
                    firstPage.drawText(parseInt(this.numberOfEmployees).toString(), {
                        x: 455,
                        y: height / 2 + 115,
                        ...baseOptions
                    });

                    /* 2: Wages... */
                    firstPage.drawText(this.convertToStringAndAddDecimal(this.totalWages), {
                        x: 455,
                        y: height / 2 + 91,
                        ...baseOptions
                    });

                    /* 3: Federal... */
                    firstPage.drawText(this.convertToStringAndAddDecimal(this.withheldTax), {
                        x: 455,
                        y: height / 2 + 68,
                        ...baseOptions
                    });

                    /* 4: If no wages... */
                    if (this.noWages) {
                        firstPage.drawText('x', {
                            x: 449,
                            y: height / 2 + 43,
                            ...baseOptions
                        });
                    }
                    else {
                        /* 5A */
                        if (parseFloat(this.taxableSSWages)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxableSSWages), {
                                x: 225,
                                y: height / 2 + 13,
                                ...baseOptions
                            });

                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxable5A), {
                                x: 360,
                                y: height / 2 + 13,
                                ...baseOptions
                            });
                        }

                        /* 5A i */
                        if (parseFloat(this.qualifiedSickLeaveWages)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.qualifiedSickLeaveWages), {
                                x: 225,
                                y: height / 2 - 5,
                                ...baseOptions
                            });

                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxable5AI), {
                                x: 360,
                                y: height / 2 - 5,
                                ...baseOptions
                            });
                        }


                        /* 5A ii */
                        /* 5A i */
                        if (parseFloat(this.qualifiedFamilyLeaveWages)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.qualifiedFamilyLeaveWages), {
                                x: 225,
                                y: height / 2 - 23,
                                ...baseOptions
                            });

                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxable5AII), {
                                x: 360,
                                y: height / 2 - 23,
                                ...baseOptions
                            });
                        }

                        /* 5B */
                        if (parseFloat(this.taxableSSTips)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxableSSTips), {
                                x: 225,
                                y: height / 2 - 42,
                                ...baseOptions
                            });

                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxable5B), {
                                x: 360,
                                y: height / 2 - 42,
                                ...baseOptions
                            });
                        }

                        /* 5C */
                        if (parseFloat(this.taxableMedicalWages)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxableMedicalWages), {
                                x: 225,
                                y: height / 2 - 60,
                                ...baseOptions
                            });

                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxable5C), {
                                x: 360,
                                y: height / 2 - 60,
                                ...baseOptions
                            });
                        }

                        /* 5D */
                        if (parseFloat(this.taxableAMTWithholding)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxableAMTWithholding), {
                                x: 225,
                                y: height / 2 - 83,
                                ...baseOptions
                            });

                            firstPage.drawText(this.convertToStringAndAddDecimal(this.taxable5D), {
                                x: 360,
                                y: height / 2 - 83,
                                ...baseOptions
                            });
                        }

                        /* 5E */
                        if (parseFloat(this.line5E)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.line5E), {
                                x: 455,
                                y: height / 2 - 108,
                                ...baseOptions
                            });
                        }

                        /* 5F */
                        if (parseFloat(this.section3121)) {
                            firstPage.drawText(this.convertToStringAndAddDecimal(this.section3121), {
                                x: 455,
                                y: height / 2 - 133,
                                ...baseOptions
                            });
                        }
                    }


                    /* 6 */
                    if (this.totalTaxesBeforeAdjustments) {
                        firstPage.drawText(this.convertToStringAndAddDecimal(this.totalTaxesBeforeAdjustments), {
                            x: 455,
                            y: height / 2 - 155,
                            ...baseOptions
                        });
                    }

                    /* 7 */
                    if (parseFloat(this.currentFractionsOfCents)) {
                        firstPage.drawText(this.convertToStringAndAddDecimal(this.currentFractionsOfCents), {
                            x: 455,
                            y: height / 2 - 180,
                            ...baseOptions
                        });
                    }

                    /* 8 */
                    if (parseFloat(this.currentSickPay)) {
                        firstPage.drawText(this.convertToStringAndAddDecimal(this.currentSickPay), {
                            x: 455,
                            y: height / 2 - 205,
                            ...baseOptions
                        });
                    }

                    /* 9 */
                    if (parseFloat(this.currentTipAndGroupTerm)) {
                        firstPage.drawText(this.convertToStringAndAddDecimal(this.currentTipAndGroupTerm), {
                            x: 455,
                            y: height / 2 - 227,
                            ...baseOptions
                        });
                    }

                    /* 10 */
                    firstPage.drawText(this.convertToStringAndAddDecimal(this.line10Sum), {
                        x: 455,
                        y: height / 2 - 250,
                        ...baseOptions
                    });

                    /* 11 A */
                    if (parseFloat(this.qualifiedSmallBusinessPayroll)) {
                        firstPage.drawText(this.convertToStringAndAddDecimal(this.qualifiedSmallBusinessPayroll), {
                            x: 455,
                            y: height / 2 - 275,
                            ...baseOptions
                        });
                    }

                    /* 11 b */
                    if (parseFloat(this.nonrefundableSickAndFamily)) {
                        firstPage.drawText(this.convertToStringAndAddDecimal(this.nonrefundableSickAndFamily), {
                            x: 455,
                            y: height / 2 - 300,
                            ...baseOptions
                        });
                    }

                    /* 11 c */
                    if (parseFloat(this.nonrefundableEmployee)) {
                        firstPage.drawText(this.convertToStringAndAddDecimal(this.nonrefundableEmployee), {
                            x: 455,
                            y: height / 2 - 325,
                            ...baseOptions
                        });
                    }

                    /***** PAGE 2 *****/
                    /* 11 d */
                    if (parseFloat(this.line11D)) {
                        secondPage.drawText(this.convertToStringAndAddDecimal(this.line11D), {
                            x: 455,
                            y: height / 2 + 295,
                            ...baseOptions
                        });
                    }

                    /* 12 */
                    secondPage.drawText(this.convertToStringAndAddDecimal(this.line12TotalTaxesAfterAdjustments), {
                        x: 455,
                        y: height / 2 + 270,
                        ...baseOptions
                    });

                    /* 13 / 13 a */
                    secondPage.drawText(this.convertToStringAndAddDecimal(this.totalQuarterDeposits), {
                        x: 455,
                        y: height / 2 + 240,
                        ...baseOptions
                    });

                    /* 13 b */
                    if (parseFloat(this.deferredShareSocialSecurity)) {
                      secondPage.drawText(this.convertToStringAndAddDecimal(this.deferredShareSocialSecurity), {
                          x: 455,
                          y: height / 2 + 215,
                          ...baseOptions
                      });
                    }

                    /* 13 c */
                    if (parseFloat(this.refundableFamily)) {
                      secondPage.drawText(this.convertToStringAndAddDecimal(this.refundableFamily), {
                          x: 455,
                          y: height / 2 + 192,
                          ...baseOptions
                      });
                    }

                    /* 13 d */
                    if (parseFloat(this.refundableEmployee)) {
                      secondPage.drawText(this.convertToStringAndAddDecimal(this.refundableEmployee), {
                          x: 455,
                          y: height / 2 + 168,
                          ...baseOptions
                      });
                    }

                    /* 13 e */
                    if (parseFloat(this.line13eTotalDepositsDeferrals)) {
                      secondPage.drawText(this.convertToStringAndAddDecimal(this.line13eTotalDepositsDeferrals), {
                          x: 455,
                          y: height / 2 + 143,
                          ...baseOptions
                      });
                    }

                    /* 13 f */
                    if (parseFloat(this.totalAdvancesRecieved)) {
                      secondPage.drawText(this.convertToStringAndAddDecimal(this.totalAdvancesRecieved), {
                          x: 455,
                          y: height / 2 + 118,
                          ...baseOptions
                      });
                    }

                    /* 13 g */
                    if (parseFloat(this.line13gTotalDepositsLessAdvances)) {
                      secondPage.drawText(this.convertToStringAndAddDecimal(this.line13gTotalDepositsLessAdvances), {
                          x: 455,
                          y: height / 2 + 95,
                          ...baseOptions
                      });
                    }

                    /* 14 */
                    if (parseFloat(this.line14BalanceDue)) {
                        secondPage.drawText(this.convertToStringAndAddDecimal(this.line14BalanceDue), {
                            x: 455,
                            y: height / 2 + 70,
                            ...baseOptions
                        });
                    }

                    /* 15 */
                    secondPage.drawText(this.convertToStringAndAddDecimal(this.line15Overpayment), {
                        x: 310,
                        y: height / 2 + 50,
                        ...baseOptions
                    });

                    /* Overpayment Option */
                    switch (parseInt(this.overpaymentOption)) {
                        case 1:
                            secondPage.drawText('x', {
                                x: 448,
                                y: height / 2 + 50,
                                ...baseOptions
                            });
                            break;
                        case 2:
                            secondPage.drawText('x', {
                                x: 521,
                                y: height / 2 + 50,
                                ...baseOptions
                            });
                            break;
                    }

                    secondPage.drawText(this.name.toString(), {
                        x: 50,
                        y: height / 2 + 330,
                        ...baseOptions
                    });

                    thirdPage.drawText(this.name.toString(), {
                        x: 50,
                        y: height / 2 + 330,
                        ...baseOptions
                    });

                    const mutatedEIN = this.employerIdentificationNumber.substr(0, 2) + '-' +
                      this.employerIdentificationNumber.substr(2);
                      secondPage.drawText(mutatedEIN.toString(), {
                          x: 420,
                          y: height / 2 + 330,
                          ...baseOptions
                      });
                      thirdPage.drawText(mutatedEIN.toString(), {
                          x: 420,
                          y: height / 2 + 330,
                          ...baseOptions
                    });

                    switch (parseInt(this.partTwoNumberSixteen)) {
                        case 1:
                            /* Option 1*/
                            secondPage.drawText('x', {
                                x: 112,
                                y: height / 2 - 8,
                                ...baseOptions
                            });
                            break;
                        case 2:
                            /* Option 2 MUST VALIDATE ALL BOXES*/
                            secondPage.drawText('x', {
                                x: 112,
                                y: height / 2 - 55,
                                ...baseOptions
                            });

                            /*Write Month 1 IF*/
                            if (parseFloat(this.month1) > 0) {
                                secondPage.drawText(this.convertToStringAndAddDecimal(parseFloat(this.month1)), {
                                    x: 250,
                                    y: height / 2 - 88,
                                    ...baseOptions
                                });
                            }
                            /*Write Month 2 IF*/
                            if (parseFloat(this.month2) > 0) {
                                secondPage.drawText(this.convertToStringAndAddDecimal(parseFloat(this.month2)), {
                                    x: 250,
                                    y: height / 2 - 109,
                                    ...baseOptions
                                });
                            }
                            /*Write Month 3 IF*/
                            if (parseFloat(this.month3) > 0) {
                                secondPage.drawText(this.convertToStringAndAddDecimal(parseFloat(this.month3)), {
                                    x: 250,
                                    y: height / 2 - 130,
                                    ...baseOptions
                                });
                            }
                            /*Write Total IF*/
                            if (parseFloat(this.line16TotalLiability) > 0) {
                                secondPage.drawText(this.convertToStringAndAddDecimal(parseFloat(this.line16TotalLiability)), {
                                    x: 250,
                                    y: height / 2 - 155,
                                    ...baseOptions
                                });
                            }

                            if (this.line16TotalLiability !== this.line12TotalTaxesAfterAdjustments) {
                                // console.log('Line 12/16 Mismatch!');
                                this.errors.partTwoNumberSixteen = true;
                                return false;
                            } else this.errors.partTwoNumberSixteen = false;

                            break;
                        case 3:
                            /* Option 3*/
                            secondPage.drawText('x', {
                                x: 112,
                                y: height / 2 - 172,
                                ...baseOptions
                            });
                            break;
                    }

                    /* Save report and Download*/
                    const pdfBytes = await pdfDoc.save();
                    // Trigger the browser to download the PDF document
                    download(pdfBytes, `IRS-941-2020-${Date.now()}.pdf`, "application/pdf");

                    /* TODO Clear out the form */
                }
            },
            convertToStringAndAddDecimal(_number) {
                let formatToString = _number.toString();
                let formatToCurrency = (formatToString.includes('.')) ? formatToString : formatToString += '.00';
                return formatToCurrency.replace(/\d(?=(\d{3})+\.)/g, '$&,');
            },
        }
    }
</script>

<style scoped>
  button {
    border-radius: 0;
    width: 5rem !important;
  }

  .clear {
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    -moz-border-radius-topright: 1rem !important;
    -moz-border-radius-topleft: 1rem !important;
    -webkit-border-top-left-radius: 1rem !important;
  }

  .export {
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
    -moz-border-radius-bottomright: 1rem !important;
    -moz-border-radius-bottomleft: 1rem !important;
    -webkit-border-bottom-left-radius: 1rem !important;
  }

  .sixteenB {
    width: 15rem !important;
  }
</style>
}
</script>

<
style
scoped >

< /style>
