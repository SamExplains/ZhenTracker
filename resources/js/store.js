import Vue from "vue";
import Vuex from "vuex"
import axios from 'axios';
import { isNull } from "lodash";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    // Logged in User
    user: {},
    companyAssociatedTo: {},
    intro: 'Welcome to Application Container',
    selectedMenu: 2,
    companies: [], // Array of Objects
    company: {},
    companyRaD: [], // Array of Objects
    companyForms: [], // Array of Objects,
    companyChecklist: [],
    companyKeyDates: [],
    powerAttorneyStatementWorkForms: [], // Array of Objects,
    allCompanyEvents: [], // Array of Objects
    userNamesAndAssociations: [], // Array of Objects
    creditsAvailable: 0,
    creditsClaimed: 0,
    creditsReceived: 0,
    calculationStartDate: '1/1/1000',
    fiscalCalendarCalculations: {},
    // For Custom Form Uploading Info
    formMeta: {
      id: '',
      fileColumn: ''
    },

    /* Interactive Form */
    title: 'Welcome to our Multiform!',
    employerIdentificationNumber: 'XXXXXXXXX',
    name: '',
    tradeName: '',
    address: '',
    city: '',
    state: '',
    zip: '',
    foreignCountryName: '',
    foreignCountryProvince: '',
    foreignCountryZip: '',
    reportForThisQuarter: 1,
    calendarYear: '',
    form941Line5AColumn2: 0.00,
    form941Line5BColumn2: 0.00,
    form8974Line12: 0.00,
    formScheduleBTaxLiabilityMonthOne: 0,
    formScheduleBTaxLiabilityMonthTwo: 0,
    formScheduleBTaxLiabilityMonthThree: 0,
    formScheduleBTotalQuarterLiability: 0,

    // Analyzer
    qualifyingQuestionsClaimYears: [], // [ { year: String } ... ]
    financialDataSelectedTabYear: "",
    // Product Informatoin : Possibly reset in newCompany if not attached on initial
    productInformationArr: [], // [ {..id<uuid>...name...description...value} ]
    activeProjectRecord: {}, // The active record used to return for New and Delete projects

    // Credits | Array used for selected 8974 printing
    returnSlicedRecordsAtIndexGivenArr: [],
    // Credits Accumulation when using quick 8974. This variable is used
    // In the final output to calculate the Column G
    returnSlicedRecordsAtIndexGivenAccumulation: 0

  },
  getters: {
    returnIntro: state => {
      return state.intro;
    },
    returnSelectedMenu: state => {
      return state.selectedMenu;
    },
    returnCurrentActiveCompany: state => {
      return (Object.keys(state.company).length === 0) ? null : state.company;
    },
    returnCurrentActiveCompanyAsArray: state => {
      return (Object.keys(state.company).length === 0) ? null : [state.company];
    },
    returnAllCompanies: state => {
      return state.companies;
    },
    returnCompanyNameAndEID: state => {
      return (Object.keys(state.company).length === 0) ? [] : [state.company.name, state.company.ein];
    },
    returnActiveCompanyResearchAndDevelopmentData: state => {
      // Sort the records based on the sorted User saved column
      if (state.company.sorted !== undefined) {
        if (JSON.parse(state.company.sorted) !== null) {
          state.companyRaD.sort(function (a, b) {
            return JSON.parse(state.company.sorted).indexOf(a.id) - JSON.parse(state.company.sorted).indexOf(b.id);
          });
        }
      }

      return state.companyRaD;
    },
    returnActiveCompanyAlerts: state => {
      return state.allCompanyEvents;
    },
    returnTotalCompanyCreditsAvailable: state => {
      if (state.companyRaD.length) {
        const creditsAvailableArr = [];
        const creditsArr = state.companyRaD.forEach(c => {
          (parseFloat(c.credit_available)) ? creditsAvailableArr.push(parseFloat(c.credit_available)) : ''
        });
        return creditsAvailableArr.reduce((a, b) => a + b, 0) || 0.00;
      }

      return 0;
    },
    returnTotalCompanyCreditsRemaining: state => {
      if (state.companyRaD.length) {
        return parseFloat(state.companyRaD[state.companyRaD.length - 1].credit_available).toFixed(2);
      }
      return 0;
    },
    returnTotalCompanyCreditsClaimed: state => {
      if (state.companyRaD.length) {
        // credit_claimed:
        const creditsClaimedArr = [];
        const creditsArr = state.companyRaD.forEach(c => {
          (parseFloat(c.credit_claimed)) ? creditsClaimedArr.push(parseFloat(c.credit_claimed)) : ''
        });
        return creditsClaimedArr.reduce((a, b) => a + b, 0) || 0.00;
      }

      return 0;
    },
    returnTotalCompanyCreditsReceived: state => {
      if (state.companyRaD.length) {
        // credit_received:
        const creditsReceivedArr = [];
        const creditsArr = state.companyRaD.forEach(c => {
          (parseFloat(c.credit_received)) ? creditsReceivedArr.push(parseFloat(c.credit_received)) : ''
        });
        return creditsReceivedArr.reduce((a, b) => a + b, 0) || 0.00;
      }

      return 0;
    },
    returnTotalCompanyCreditsAmount: state => {
      if (state.companyRaD.length) {
        const creditsAmountArr = [];
        const creditsArr = state.companyRaD.forEach(c => {
          (parseFloat(c.credit_amount)) ? creditsAmountArr.push(parseFloat(c.credit_amount)) : ''
        });
        return creditsAmountArr.reduce((a, b) => a + b, 0) || 0.00;
      }

      return 0;
    },
    // Return total amount of Credits Advanced
    returnTotalCompanyCreditsAdvanced: state => {
      if (state.companyRaD.length) {
        const creditsAmountArr = [];
        const creditsArr = state.companyRaD.forEach(c => {
          (parseFloat(c.credits_advanced)) ? creditsAmountArr.push(parseFloat(c.credits_advanced)) : ''
        });
        return creditsAmountArr.reduce((a, b) => a + b, 0) || 0.00;
      }

      return 0;
    },
    returnLastYearClaimablePayroll: state => {
      return state.company.final_date_payroll_claim || Date.now();
    },
    returnCalculationStartDate: state => {
      return state.calculationStartDate;
    },
    returnFiscalTypeCalculations: state => {
      return state.fiscalCalendarCalculations;
    },
    returnFiscalYearEnd: state => {
      return state.fiscalCalendarCalculations.year_end_date || 'n/a';
    },
    returnFirstIncomeYear: state => {
      return state.fiscalCalendarCalculations.first_income_year || 'n/a';
    },
    returnFinalYearPayrollClaimable: state => {
      return state.fiscalCalendarCalculations.last_year_payroll_claimable || 'n/a';
    },
    returnCompanyForms: state => {
      return state.companyForms;
    },
    returnStoredCompanyEvents: state => {
      return state.allCompanyEvents;
    },
    returnTitle: state => {
      return state.title;
    },
    returnEmployerIdentificationNumber: state => {
      return state.employerIdentificationNumber;
    },
    returnName: state => {
      return state.name;
    },
    returnTradeName: state => {
      return state.tradeName;
    },
    returnAddress: state => {
      return state.address;
    },
    returnCity: state => {
      return state.city;
    },
    returnState: state => {
      return state.state;
    },
    returnZip: state => {
      return state.zip;
    },
    returnForeignName: state => {
      return state.foreignCountryName;
    },
    returnForeignProvince: state => {
      return state.foreignCountryProvince;
    },
    returnForeignZip: state => {
      return state.foreignCountryZip;
    },
    returnCalendarYear: state => {
      return state.calendarYear;
    },
    returnQuarterSelected: state => {
      return parseInt(state.reportForThisQuarter);
    },
    returnForm941Line5AColumn2: state => {
      return state.form941Line5AColumn2;
    },
    returnForm941Line5BColumn2: state => {
      return state.form941Line5BColumn2;
    },
    returnForm8974Line12: state => {
      return state.form8974Line12;
    },
    returnScheduleBMonthOneTaxLiability: state => {
      return state.formScheduleBTaxLiabilityMonthOne
    },
    returnScheduleBMonthTwoTaxLiability: state => {
      return state.formScheduleBTaxLiabilityMonthTwo
    },
    returnScheduleBMonthThreeTaxLiability: state => {
      return state.formScheduleBTaxLiabilityMonthThree
    },
    returnScheduleBQuarterTotalTaxLiability: state => {
      return state.formScheduleBTotalQuarterLiability
    },
    returnFormInitiatedMeta: state => {
      return state.formMeta;
    },
    returnPowerAttorneyStatementWorkForms: state => {
      return state.powerAttorneyStatementWorkForms;
    },
    returnCompanyChecklist: state => {
      return state.companyChecklist
    },
    returnConsolidatedTotalCredits: state => {
      /*
      * Return all credits accumulated
      * */
      const total = [];
      const received = [];
      const claimed = [];
      state.companies.forEach(company => {
        if (company.research_and_development.length > 0) {
          company.research_and_development.forEach(credit => {
            total.push(credit.credit_amount);
            received.push(credit.credit_received);
            claimed.push(credit.credit_claimed);
          })
        }
      });

      // Sum
      const totalSum = total.reduce((a, b) => Number.parseFloat(a) + Number.parseFloat(b), 0);
      const receivedSum = received.reduce((a, b) => Number.parseFloat(a) + Number.parseFloat(b), 0);
      const claimedSum = claimed.reduce((a, b) => Number.parseFloat(a) + Number.parseFloat(b), 0);

      return [totalSum.toFixed(2), receivedSum.toFixed(2), claimedSum.toFixed(2)]
    },
    returnCompanyKeyDueDates: state => {
      return state.companyKeyDates
    },
    returnActiveUser: state => {
      return state.user;
    },
    returnAnalyzerYearEnds: state => {
      return state.qualifyingQuestionsClaimYears
    },
    returnYearEndsAsYearsArray: (state, payload) => {
      const yearArr = state.qualifyingQuestionsClaimYears.map(function (element) {
        return element.year
      }); // [ "year", ... ]
      return (Array.isArray(yearArr)) ? yearArr : null;
    },
    getSelectedFinancialTableData: state => {
      return state.qualifyingQuestionsClaimYears;
    },
    returnAllAvailableFinancialData: state => {
      if (state.financialDataSelectedTabYear !== "") {
        const currentTabDataObj = state.qualifyingQuestionsClaimYears.filter((el) => el.year === state.financialDataSelectedTabYear)[0];
        const hasFinancialData = (currentTabDataObj !== undefined) ? (('financial_data' in currentTabDataObj)) ? true : false : 'object is undefined';
        if (hasFinancialData && currentTabDataObj) {
          return state.qualifyingQuestionsClaimYears.filter((el) => el.year === state.financialDataSelectedTabYear)[0].financial_data;
        }
      } else return [];
    },
    returnFinancialTableDataEmployee: state => {
      if (state.financialDataSelectedTabYear !== "") {
        //  console.warn('GETTER returnFinancialTableDataEmployee WITH YEAR ', state.financialDataSelectedTabYear);
        //  console.warnonUpdateFinancialDataRecord('GETTER returnFinancialTableDataEmployee OBJ ', currentTabDataObj);
        //  console.warn('GETTER returnFinancialTableDataEmployee KEY? ', hasFinancialData);
        const currentTabDataObj = state.qualifyingQuestionsClaimYears.filter((el) => el.year === state.financialDataSelectedTabYear)[0];
        // true is Key false is NO KEYonUpdateFinancialDataRecord
        const hasFinancialData = (currentTabDataObj !== undefined) ? (('financial_data' in currentTabDataObj)) ? true : false : 'object is undefined';
        if (hasFinancialData && currentTabDataObj) {
          const fdData = state.qualifyingQuestionsClaimYears.filter(
            (el) => el.year === state.financialDataSelectedTabYear
          )[0].financial_data;

          fdData.forEach(el => {
            (typeof el.activities === 'string') ? el.activities = JSON.parse(el.activities) : '';
          });

          return fdData.filter(elm => elm.selected_type === "employee");
        } else
          return [];
      }
      return [];
    },
    returnFinancialTableDataSupplies: state => {
      const currentTabDataObj = state.qualifyingQuestionsClaimYears.filter((el) => el.year === state.financialDataSelectedTabYear)[0];
      // true is Key false is NO KEY
      const hasFinancialData = (currentTabDataObj !== undefined) ? (('financial_data' in currentTabDataObj)) ? true : false : 'object is undefined';
      if (hasFinancialData && currentTabDataObj) {
        const fdData = state.qualifyingQuestionsClaimYears.filter(
          (el) => el.year === state.financialDataSelectedTabYear
        )[0].financial_data;
        const fdDataFiltered = fdData.filter(elm => elm.selected_type === "supplies");
      } else
        return [];
    },
    returnFinancialTableDataContractors: state => {
      const currentTabDataObj = state.qualifyingQuestionsClaimYears.filter((el) => el.year === state.financialDataSelectedTabYear)[0];
      // true is Key false is NO KEY
      const hasFinancialData = (currentTabDataObj !== undefined) ? (('financial_data' in currentTabDataObj)) ? true : false : 'object is undefined';
      if (hasFinancialData && currentTabDataObj) {
        return state.qualifyingQuestionsClaimYears.filter(
          (el) => el.year === state.financialDataSelectedTabYear
        )[0].financial_data.filter(elm => elm.selected_type === "contractors");
      } else
        return [];
    },
    returnFinancialTableDataServers: state => {
      const currentTabDataObj = state.qualifyingQuestionsClaimYears.filter((el) => el.year === state.financialDataSelectedTabYear)[0];
      // true is Key false is NO KEY
      const hasFinancialData = (currentTabDataObj !== undefined) ? (('financial_data' in currentTabDataObj)) ? true : false : 'object is undefined';
      if (hasFinancialData && currentTabDataObj) {
        return state.qualifyingQuestionsClaimYears.filter(
          (el) => el.year === state.financialDataSelectedTabYear
        )[0].financial_data.filter(elm => elm.selected_type === "server");
      } else
        return [];
    },
    returnActiveTabYearId: state => {
      if (state.financialDataSelectedTabYear !== "") {
        const selectedTabYearIndex = state.qualifyingQuestionsClaimYears.findIndex(obj => obj.year === state.financialDataSelectedTabYear);
        return state.qualifyingQuestionsClaimYears[selectedTabYearIndex].id;
      }
      return null;
    },
    returnCheckForQalifyingQuestionsClaimYears: state => {
      if (state.financialDataSelectedTabYear !== "") {
        const selectedTabYearIndex = state.qualifyingQuestionsClaimYears.findIndex(obj => obj.year === state.financialDataSelectedTabYear);
        const selectedTabYearId = state.qualifyingQuestionsClaimYears[selectedTabYearIndex].id;
        return (state.qualifyingQuestionsClaimYears[selectedTabYearIndex].financial_data.length > 0) ? true : false;
      } else return false
    },
    returnActiveProjectRecord: state => {
      return state.activeProjectRecord;
    },
    returnSlicedRecordsAtIndexGivenArr: state => {
      return state.returnSlicedRecordsAtIndexGivenArr;
    },
    returnSlicedRecordsAtIndexGivenAccumulationValue: state => {
      return state.returnSlicedRecordsAtIndexGivenAccumulation
    }
  },
  mutations: {
    setSelectedMenu: (state, payload) => {
      state.selectedMenu = payload.selected;
    },
    setCompaniesList: (state, payload) => {
      state.companies = payload;
    },
    handleSelectedCompany: (state, payload) => {
      /* Filtering done based on ein payload. Returns a Array with object inside */
      const c = state.companies.filter(c => {
        return c.ein === payload;
      });

      state.company = c[0];

      // Set company R&D
      state.companyRaD = c[0].research_and_development || [];

      //Set company Forms
      state.companyForms = c[0].forms || [];

      //Set company Alerts
      state.allCompanyEvents = c[0].alerts || [];

      state.powerAttorneyStatementWorkForms = c[0].attorneystatements || [];

      state.companyChecklist = c[0].checklists || [];

      if (c[0].keydates !== undefined) {
        state.companyKeyDates = c[0].keydates.reverse() || [];
      } else {
        state.companyKeyDates = c[0].keydates;
      }

      // Reset Claim Years
      state.qualifyingQuestionsClaimYears = [];
      state.financialDataSelectedTabYear = "";

      // Analyzer Resets
      // state.productInformationArr = [];

      // Update Header Name
      document.getElementById('activeName').innerText = state.company.name;
    },
    setCalendarYearCalculation: (state, payload) => {
      // Store date selected to perform calculations on
      state.calculationStartDate = payload.date;
      state.fiscalCalendarCalculations = payload.calculations; /* type Object */
    },
    storeNewCompanySetup: (state, payload) => {
      state.companies.push(payload);

      // Set company R&D blank
      state.companyRaD = [];
      //Set company Forms blank
      state.companyForms = [];
    },
    requestLatestCompanyEvents: (state, payload) => {
      state.allCompanyEvents = payload;
    },
    storeNewSingleCompanyAlert: (state, payload) => {
      state.allCompanyEvents.unshift(payload);
    },
    updateExistingCompanyObject: (state, payload) => {
      // companies
      // company
      state.company = payload;
      const currentCompanyIndex = state.companies.findIndex((obj => obj.id === payload.id));
      state.companies.splice(currentCompanyIndex, 1, payload);
    },
    updateCompanyWithNewCreditAndForm: (state, payload) => {
      //state.company.sorted
      // console.warn('BEFORE updateCompanyWithNewCreditAndForm', typeof state.company.sorted, state.company.sorted);
      // state.company.sorted = JSON.stringify([...JSON.parse(state.company.sorted), payload[0].id]);
      if (state.company.sorted !== null) {
        state.company.sorted = JSON.stringify([...JSON.parse(state.company.sorted), payload[0].id]);
      }
      // console.warn('AFTER updateCompanyWithNewCreditAndForm', state.company.sorted);
      state.companyRaD.push(payload[0]);
      state.companyForms.push(payload[1]);
    },
    updateCompanyFormsWithUpdatedCompany: (state, payload) => {
      // Filter for Form Index,
      // Replace @ index
      const currentFormIndex = state.companyForms.findIndex((obj => obj.id === payload.id));
      state.companyForms.splice(currentFormIndex, 1, payload);
    },
    deleteResearchRecord: (state, payload) => {
      // Remove from the active company sorted array
      // Remove ID from the local array company sortable!
      state.company.sorted = JSON.stringify(JSON.parse(state.company.sorted).filter(arrayItem => arrayItem !== payload));
      // Use payload to remove R&D record from State
      const currentRDIndex = state.companyRaD.findIndex((obj => obj.id === payload));
      state.companyRaD.splice(currentRDIndex, 1);
      // Also remote the Form link
      state.companyForms.splice(currentRDIndex, 1);
    },
    onUpdateResearchAndDevelopmentCredit: (state, payload) => {
      const currentFormIndex = state.companyRaD.findIndex((obj => obj.id === payload.id));
      state.companyRaD.splice(currentFormIndex, 1, payload);
    },
    onDeleteCompany: (state, payload) => {
      const currentCompanyIndex = state.companies.findIndex((obj => obj.id === payload.id));
      state.companies.splice(currentCompanyIndex, 1);
      // Reset State
      state.company = {};
      state.companyRaD = [];
      state.companyForms = [];
      state.creditsAvailable = 0;
      state.creditsClaimed = 0;
      state.creditsReceived = 0;
      state.allCompanyEvents = [];
      // Update Header Name
      document.getElementById('activeName').innerText = 'Please select a Company'
    },
    onDeleteCompanyMessage: (state, payload) => {
      // Delete from state
      const currentEvIndex = state.allCompanyEvents.findIndex((obj => obj.id === payload.id));
      state.allCompanyEvents.splice(currentEvIndex, 1);
    },
    onDeleteCompanyForm: (state, payload) => {
      // Remove file from state
      const currentCompanyIndex = state.companyForms.findIndex((obj => obj.id === payload.id));
      state.companyForms.splice(currentCompanyIndex, 1, payload);
    },
    updateEIN: (state, payload) => {
      state.employerIdentificationNumber = payload.employerIdentificationNumber;
    },
    updateName: (state, payload) => {
      state.name = payload.name;
    },
    updateTradeName: (state, payload) => {
      state.tradeName = payload.tradeName;
    },
    updateAddress: (state, payload) => {
      state.address = payload.address;
    },
    updateCity: (state, payload) => {
      state.city = payload.city;
    },
    updateState: (state, payload) => {
      state.state = payload.state;
    },
    updateZip: (state, payload) => {
      state.zip = payload.zip;
    },
    updateForeignCountryName: (state, payload) => {
      state.foreignCountryName = payload.foreignCountryName;
    },
    updateForeignCountryProvince: (state, payload) => {
      state.foreignCountryProvince = payload.foreignCountryProvince;
    },
    updateForeignCountryZip: (state, payload) => {
      state.foreignCountryZip = payload.foreignCountryZip;
    },
    updateCalendarYear: (state, payload) => {
      state.calendarYear = payload.calendarYear;
    },
    updateQuarterRadio: (state, payload) => {
      state.reportForThisQuarter = parseInt(payload.radioSelected);
    },
    storeForm941Line5AColumn2: (state, payload) => {
      state.form941Line5AColumn2 = parseFloat(payload.amount);
    },
    storeForm941Line5BColumn2: (state, payload) => {
      state.form941Line5BColumn2 = parseFloat(payload.amount);
    },
    storeForm8974Line12: (state, payload) => {
      state.form8974Line12 = parseFloat(payload.amount);
    },
    storeFormScheduleBTaxLiabilityMonthOne: (state, payload) => {
      state.formScheduleBTaxLiabilityMonthOne = parseFloat(payload.amount);
    },
    storeFormScheduleBTaxLiabilityMonthTwo: (state, payload) => {
      state.formScheduleBTaxLiabilityMonthTwo = parseFloat(payload.amount);
    },
    storeFormScheduleBTaxLiabilityMonthThree: (state, payload) => {
      state.formScheduleBTaxLiabilityMonthThree = parseFloat(payload.amount);
    },
    storeFormScheduleBTotalQuarterLiability: (state, payload) => {
      state.formScheduleBTotalQuarterLiability = parseFloat(payload.amount);
    },
    storeFormInitiatedMeta: ((state, payload) => {
      state.formMeta = { ...payload };
    }),
    storeNewPowerAttorneyOrWorkStatementObject: (state, payload) => {
      state.powerAttorneyStatementWorkForms.push(payload);
    },
    deletePowerAttorneyOrWorkStatementObject: (state, payload) => {
      // Delete
      const currentAttorneyIndex = state.powerAttorneyStatementWorkForms.findIndex((obj => obj.id === payload));
      state.powerAttorneyStatementWorkForms.splice(currentAttorneyIndex, 1);
    },
    updateCompanyChecklistItem: async (state, payload) => {

      // console.warn('Item ID ', payload);

      const currentCLItemIndex = state.companyChecklist.findIndex((obj => obj.id === payload));

      // Update Checklist Object
      if (state.companyChecklist[currentCLItemIndex].completed === 0)
        state.companyChecklist[currentCLItemIndex].completed = 1;
      else
        state.companyChecklist[currentCLItemIndex].completed = 0;

      await axios.put(`api/company/checklist/${payload}`, {
        completed: Number.parseInt(state.companyChecklist[currentCLItemIndex].completed)
      });
    },
    onSubmitNewChecklistItem: (state, payload) => {
      state.companyChecklist.push(payload);
    },
    onDeleteChecklistID: (state, payload) => {
      const currentCLIIndex = state.companyChecklist.findIndex((obj => obj.id === payload));
      state.companyChecklist.splice(currentCLIIndex, 1);
    },
    addNewCompanyKeyDueDate: (state, payload) => {
      if (state.companyKeyDates === undefined) {
        state.companyKeyDates = [payload];
      } else {
        state.companyKeyDates.unshift(payload);
      }
    },
    onDeleteCompanyKeyDueDate: (state, payload) => {
      const currentKDDIndex = state.companyKeyDates.findIndex((obj => obj.id === payload));
      state.companyKeyDates.splice(currentKDDIndex, 1);
    },
    onInitialUsersWithAssociations: (state, payload) => {
      state.userNamesAndAssociations = payload;
    },
    onStoreNewUserAndAssociationLink: (state, payload) => {
      //     userNamesAndAssociations
      // Check if User ID Exists
      // If YES, push if NO add new
      const exists = state.userNamesAndAssociations.findIndex((obj => obj.id === 100));
      // 0 = index
      // -1 is NOT FOUND

      if (exists > -1) {
        state.userNamesAndAssociations[exists].association.push(payload.association);
      } else {
        state.userNamesAndAssociations.push({
          id: payload.id,
          name: payload.name,
          associations: [payload.association]
        })
      }

    },
    setActiveUser: (state, payload) => {
      state.user = payload;
    },
    setCompanyAssociation: (state, payload) => {
      state.companyAssociatedTo = payload;
    },
    setAnalyzerYearEnds: (state, payload) => {
      state.qualifyingQuestionsClaimYears.push(...payload); // [{ year: String }...]
    },
    getAnalyzerYearEnds: (state, payload) => {
      // console.warn('Mutation : getAnalyzerYearEnds ', payload);
      // console.warn('Getter : getAnalyzerYearEnds');
      state.qualifyingQuestionsClaimYears = payload; // [{ year: String }...]
    },
    setNewFinancialDataEntryYear: (state, payload) => {
      state.financialDataSelectedTabYear = payload;
    },
    setNewFinancialDataEntry: (state, payload) => {
      const _idx = state.qualifyingQuestionsClaimYears.findIndex(i => i.id === payload.id);
      state.qualifyingQuestionsClaimYears[_idx].financial_data.push(payload.data);
    },
    onUpdateFinancialDataRecord: (state, payload) => {
      // Find relevant object and update through SELECTED YEAR and PAYLOAD RECORD;
      const _idx = state.qualifyingQuestionsClaimYears.findIndex(i => i.year === state.financialDataSelectedTabYear)
      // Update financial_data record with Payload
      const _financial_record_id = state.qualifyingQuestionsClaimYears[_idx].financial_data.findIndex(o => o.id === payload.id);
      state.qualifyingQuestionsClaimYears[_idx].financial_data.splice(_financial_record_id, 1, payload)
    },
    onDeleteFinancialDataRecord: (state, payload) => {
      const _idx = state.qualifyingQuestionsClaimYears.findIndex(i => i.year === state.financialDataSelectedTabYear)
      // Update financial_data record with Payload
      const _financial_record_id = state.qualifyingQuestionsClaimYears[_idx].financial_data.findIndex(o => o.id === payload);
      state.qualifyingQuestionsClaimYears[_idx].financial_data.splice(_financial_record_id, 1)
    },
    onDeleteQualifyingQuestionYear: async (state, payload) => {
      const _idx = state.qualifyingQuestionsClaimYears.findIndex(i => i.year === payload);
      const actualQQId = state.qualifyingQuestionsClaimYears[_idx].id;

      const { status } = await axios.delete(`api/company/analyzer/qq/${actualQQId}`);

      switch (status) {
        case 200:
          state.qualifyingQuestionsClaimYears.splice(_idx, 1);
          break;

        default:
          break;
      }

      // console.warn('onDeleteQualifyingQuestionYear -----');
      // console.warn('onDeleteQualifyingQuestionYear STATUS ', status);
      // console.warn('onDeleteQualifyingQuestionYear FOUND ', _idx, '  ', actualQQId);
      // console.warn('onDeleteQualifyingQuestionYear STATE ', state.qualifyingQuestionsClaimYears);
      // console.warn('onDeleteQualifyingQuestionYear ----------END');
    },
    handleBillingRecordUpdate: (state, payload) => {
      const currentFormIndex = state.companyRaD.findIndex((obj => obj.id === payload.id));
      state.companyRaD.splice(currentFormIndex, 1, payload);
    },
    onNewProjectInformationEntry: (state, payload) => {
      state.activeProjectRecord = payload;
    },
    onUpdateRDDateCheck: (state, payload) => {
      const currentFormIndex = state.companyRaD.findIndex((obj => obj.id === payload.id));
      state.companyRaD[currentFormIndex].date_check = payload.data;
    },
    updateResearchRecord: (state, payload) => {
      const currentFormIndex = state.companyRaD.findIndex((obj => obj.id === payload.id));
      state.companyRaD[currentFormIndex].period = payload.period;
      state.companyRaD[currentFormIndex].credit_amount = payload.formAmount;
      state.companyRaD[currentFormIndex].credit_claimed = payload.claimed;
      state.companyRaD[currentFormIndex].credits_advanced = payload.advanced;
      state.companyRaD[currentFormIndex].credit_received = payload.recieved;
      state.companyRaD[currentFormIndex].date_check = payload.checkDate;
    },
    onTriggerSort: (state, payload) => {
      if (payload === 'period') {
        state.companyRaD.sort((a, b) => (a.period > b.period) ? 1 : -1);
      } else state.companyRaD.sort((a, b) => (a.id > b.id) ? 1 : -1);
    },
    onNewAdditionalFileRecieved: (state, payload) => {
      //! Special Case: When you delete all items from list and submit a new item, that new item 1st URL will not show but if more are added
      //! The filenames will show but if you refresh than the 1st to ...N will then show.
      const currentFormIndex = state.companyForms.findIndex((obj => obj.id === payload.k));
      if (JSON.parse(state.companyForms[currentFormIndex].additional_files) !== null) {
        state.companyForms[currentFormIndex].additional_files = JSON.stringify([...JSON.parse(state.companyForms[currentFormIndex].additional_files), payload.p]);
      } else {
        state.companyForms[currentFormIndex].additional_files = JSON.stringify([payload.p]);
      }
      // console.log('Mutation: onNewAdditionalFileRecieved ', currentFormIndex, ' -- ', state.companyForms);
      // console.log('Mutation: onNewAdditionalFileRecieved ', JSON.parse(state.companyForms[currentFormIndex].additional_files));
    },
    onDeleteAdditionalFileAsync: async (state, payload) => {
      // ! Not deleting the final record from array when last element
      const currentFormIndex = state.companyForms.findIndex((obj => obj.id === payload.fid));
      let parsed = JSON.parse(state.companyForms[currentFormIndex].additional_files);
      parsed.splice(parsed.findIndex(a => a.id === payload.faid), 1);

      // console.warn('Mutation: onDeleteAdditionalFileAsync ', parsed);

      // IF the array becomes empty set to NULL or '' as well as state and DB
      if (parsed.length === 0) {
        state.companyForms[currentFormIndex].additional_files = null;
      } else {
        state.companyForms[currentFormIndex].additional_files = JSON.stringify(parsed);
      }

      const response = await axios.put(`api/company/form-update-additional/${payload.fid}`, { additional_files: state.companyForms[currentFormIndex].additional_files });
      // console.warn(response.data);

    },
    onUpdateSortableList: async (state, payload) => {
      state.company.sorted = JSON.stringify(payload.i);
      state.companyRaD = [...payload.v];
      // Push to update remotely
      await axios.put(`api/company/sorted/${state.company.id}`, { sorted: JSON.stringify(payload.i) });
    },
    returnSlicedRecordsAtIndexGiven: (state, payload) => {

      // state.returnSlicedRecordsAtIndexGivenArr = state.company.research_and_development.slice(1, payload);
      state.returnSlicedRecordsAtIndexGivenArr = [];
      // Clone and filter array only up to N – 1 Records.
      let clone = state.company.research_and_development.slice().filter(e => e.id < payload);
      const cloneLength = (clone.length - 1);
      let calculation = 0;
      let calculationArr = [];
      let lastIndexCalc = 0;
      let counter = 0;

      clone.forEach((el, index) => {
        // console.log('Record ', index, ' claimed amount ', el.credit_claimed);
        state.returnSlicedRecordsAtIndexGivenAccumulation = (parseFloat(el.credit_claimed) + parseFloat(state.returnSlicedRecordsAtIndexGivenAccumulation)).toFixed(2);

        if (el.return_type !== "1120" && el.return_type !== "1120S") {
          // Its a 941/X for calculations
          calculation = (parseFloat(el.credit_claimed) + parseFloat(calculation)).toFixed(2);

          /**
           * Is this the last record in the set? ✅
           * Since this is a 941/X assign the last 1120 record in the array the calculation ✅
           */
          if (index === cloneLength) {
            // console.error('941/X Final record with a running calculation of ', calculation);

            // Update last 1120 record with the up to date calculation value
            state.returnSlicedRecordsAtIndexGivenArr[state.returnSlicedRecordsAtIndexGivenArr.length - 1].CALCULATION = calculation;

            if (counter === 2) {
              state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[1];
              state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculation;
              // console.error('941/X Final record COUNTER = 2');
            }
            if (counter === 3) {
              state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[1];
              state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculationArr[2];
              state.returnSlicedRecordsAtIndexGivenArr[2].CALCULATION = calculation;

              // Check if 1st, 2nd and 3rd records are all 1120

              if (clone[0].return_type === '1120' && clone[1].return_type === '1120' && clone[2].return_type === '1120') {
                state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[0];
                state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculationArr[1];
                state.returnSlicedRecordsAtIndexGivenArr[2].CALCULATION = calculation;
                // console.error('941/X >>(3) 1120s begining<< RECORDs before this where 1120! DO NOT update this calculation value with auto-calc');
              }

              // console.error('941/X Final record COUNTER = 3');
            }
            if (counter === 4) {
              state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[1];
              state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculationArr[2];
              state.returnSlicedRecordsAtIndexGivenArr[2].CALCULATION = calculationArr[3];
              state.returnSlicedRecordsAtIndexGivenArr[3].CALCULATION = calculation;
              // console.error('941/X Final record COUNTER = 4');
            }


          }

        }

        if (el.return_type === "1120" || el.return_type === "1120S") {
          // Update .CALCULATION attached property and push to State array where it will be used to create forms.
          /**
           * CHECKS
           * Is there only 1 1120 existing?
           * IS this and Next Record both 1120?
           * 2+ 1120s exist?
           * IS it the last record?
           * IS THE NEXT 1,2,3,4 RECORDS 1120? IF SO MAKE SURE. Example is OBEN.
           */

          // Increment 1120 counter
          counter++;

          // Atttach CALCULATION and Push record
          // OR
          // Push calculations to array and always use index – 1 since very first element will be useless.
          // TODO A good Case for 1120 .... records.... 1120.....records is ICEKREDIT
          // Will push the 1120 value if greater than 0
          (parseFloat(el.credit_claimed).toFixed(2) > 0) ? calculationArr.push(parseFloat(el.credit_claimed).toFixed(2)) : calculationArr.push(calculation);
          // console.warn('IS 1120/S Amount Claimed ', el.credit_claimed);
          el.CALCULATION = (calculationArr[calculationArr - 1] || 0);
          state.returnSlicedRecordsAtIndexGivenArr.push(el);

          // Output calculation
          // console.warn('1120 with a calculation of ', calculation, ' counter of ', counter, ' calculation array of ', calculationArr, ' array of ', state.returnSlicedRecordsAtIndexGivenArr);
          // console.warn('1120 with a calculation of ', el.CALCULATION, ' counter of ', counter, ' calculation array of ', calculationArr, ' array of ', state.returnSlicedRecordsAtIndexGivenArr);

          /**
           * If Counter > 1 meaning more than (1) 1120 Record
           * Cases for 2,3,4,5 and account for 1120 2nd to last
           */
          if (counter > 1) {

          }

          /**
           * Is this the last record in the set? ✅
           * Since this is a 1120 check if the 1120 has a value to add on if not update the record
           * Check if previous record was an 1120 with Index that way you dont update the calculation if the record before was an 1120
           * Account for counter and how high it is to avoid conflict and update wrong
           */

          // Last record in set ✅
          if (index === cloneLength) {
            // console.error('FINAL 1120 record with a running calculation of ', calculation);
            // console.error('FINAL 1120 record with a running calculation of ', el.CALCULATION);


            // Check 2nd to last record to see if its an 1120
            // If it is an 1120 we make the last element of the array 0 or DB value and updated N-1 with calculation
            // does not exist like only trying to prin (1) 1120 record with no 941s
            if (typeof clone[clone.length - 2] == undefined) {
              if (clone[clone.length - 2].return_type === '1120') {
                state.returnSlicedRecordsAtIndexGivenArr[state.returnSlicedRecordsAtIndexGivenArr.length - 1].CALCULATION = parseFloat(el.credit_claimed).toFixed(2);
                // console.error('RECORD before this was an 1120! DO NOT update this calculation value with auto-calc');
              }
            }

            // TODO MOVED to === 3 since it caused trouble with Seatrec when printing only top 2 records
            // Check if 1st and 2nd record back both were 1120
            // if (clone[clone.length - 2].return_type === '1120' && clone[clone.length - 3].return_type === '1120') {
            //   console.error('(2) RECORDs before this where 1120! DO NOT update this calculation value with auto-calc');
            // }

            // IF the 2nd to last record was not an 1120 and we update the records calculation based on the counter
            // Take into account the counter
            /**
             * If Counter > 1 meaning more than (1) 1120 Record
             * Cases for 2,3,4,5 and account for 1120 2nd to last
             */

            if (counter === 2) {
              state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[1];
              state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculationArr[0];
              // console.error('FINAL 1120 COUNTER = 2');
            }
            if (counter === 3) {
              state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[1];
              state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculationArr[2];
              state.returnSlicedRecordsAtIndexGivenArr[2].CALCULATION = calculation;

              // CHECK: See if current 2nd to last and previous are all 1120
              // Check if 1st and 2nd record back both were 1120
              if (clone[clone.length - 1].return_type === '1120' && clone[clone.length - 2].return_type === '1120' && clone[clone.length - 3].return_type === '1120') {
                state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[0];
                state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculationArr[1];
                state.returnSlicedRecordsAtIndexGivenArr[2].CALCULATION = calculation;
                // console.error('(3) RECORDs before this where 1120! DO NOT update this calculation value with auto-calc');
              }

              // console.error('FINAL 1120 COUNTER = 3');
            }
            if (counter === 4) {
              state.returnSlicedRecordsAtIndexGivenArr[0].CALCULATION = calculationArr[1];
              state.returnSlicedRecordsAtIndexGivenArr[1].CALCULATION = calculationArr[2];
              state.returnSlicedRecordsAtIndexGivenArr[2].CALCULATION = calculationArr[3];
              state.returnSlicedRecordsAtIndexGivenArr[3].CALCULATION = calculation;
              // console.error('FINAL 1120 COUNTER = 4');
            }


          }

          // Reset calculation for next 1120
          calculation = 0;
        }

        // Output the results array
        // TODO If the only record available when printing is an 1120 it will ERROR OUT! FIX THIS!!
        // TODO OBEN IS CAUSING A FEW HICCUPS WITH TOP 3 or TOP 3 + (1) 941
        // TODO SEATREC not printing if only use 1st (2) 1120s

      });

      // console.warn('returnSlicedRecordsAtIndexGiven ', state.returnSlicedRecordsAtIndexGivenArr);
      // console.log(state.returnSlicedRecordsAtIndexGivenArr, '  ', state.returnSlicedRecordsAtIndexGivenArr.length)
      // console.log('Our Records to be printed ', state.returnSlicedRecordsAtIndexGivenArr);
    },
    resetSlicedRecordsAtIndexGivenAccumulation: state => {
      state.returnSlicedRecordsAtIndexGivenAccumulation = 0;
    }
  },
  actions: {
    setSelectedMenu: (context, payload) => {
      context.commit('setSelectedMenu', { selected: parseFloat(payload) })
    },
    setCompaniesList: (context, payload) => {
      context.commit('setCompaniesList', payload);
    },
    handleSelectedCompany: (context, payload) => {
      context.commit('handleSelectedCompany', payload);
    },
    setCalendarYearCalculation: async (context, payload) => {
      const calculations = await axios.post(`/api/company/claim-calculation/${payload.date}/${payload.endDate}`);
      context.commit('setCalendarYearCalculation', { date: payload.date, calculations: calculations.data });
    },
    storeNewCompanySetup: (context, payload) => {
      context.commit('storeNewCompanySetup', payload);
    },
    requestLatestCompanyEvents: async (context) => {
      const requestedEvents = await axios.get('/api/company/events');
      context.commit('requestLatestCompanyEvents', requestedEvents.data);
    },
    requestPaginatedLatestCompanyEvents: async (context, payload) => {
      const nextSetResults = await axios.get(payload);
    },
    storeNewSingleCompanyAlert: (context, payload) => {
      context.commit('storeNewSingleCompanyAlert', payload);
    },
    updateExistingCompanyObject: (context, payload) => {
      context.commit('updateExistingCompanyObject', payload);
    },
    updateCompanyWithNewCreditAndForm: (context, payload) => {
      context.commit('updateCompanyWithNewCreditAndForm', payload);
    },
    updateCompanyFormsWithUpdatedCompany: (context, payload) => {
      context.commit('updateCompanyFormsWithUpdatedCompany', payload); // Form Object
    },
    updateResearchRecord: async (context, payload) => {
      // updateResearchRecord
      /**
       * ASYN PATCH
       * Pass to MUTATE on Success
      */
      // console.log('updateResearchRecord ', payload);

      await axios.patch(`api/company/update/rd/credit`,
        {
          period: payload.period,
          credit_amount: payload.formAmount,
          credit_claimed: payload.claimed,
          credits_advanced: (payload.advanced !== null) ? payload.advanced : 0,
          credit_received: payload.recieved,
          date_check: payload.checkDate,
          id: payload.id
        }
      );

      context.commit('updateResearchRecord', payload);
    },
    deleteResearchRecord: async (context, payload) => {
      await axios.delete(`/api/company/delete-credit/${payload}`);
      context.commit('deleteResearchRecord', payload); // Form Object
    },
    onUpdateResearchAndDevelopmentCreditReceived: async (context, payload) => {
      const record = await axios.put(`/api/company/update-rdc/${payload.id}`, { credit_received: payload.received });
      context.commit('onUpdateResearchAndDevelopmentCredit', record.data); // Form Object
    },
    onUpdateResearchAndDevelopmentCreditAmount: async (context, payload) => {
      const record = await axios.put(`/api/company/update-rdc/${payload.id}`, { credit_amount: payload.amount });
      context.commit('onUpdateResearchAndDevelopmentCredit', record.data); // Form Object
    },
    onUpdateResearchAndDevelopmentCreditClaimed: async (context, payload) => {
      const record = await axios.put(`/api/company/update-rdc/${payload.id}`, { credit_claimed: payload.claimed });
      context.commit('onUpdateResearchAndDevelopmentCredit', record.data); // Form Object
    },
    onDeleteCompany: async (context, payload) => {
      // Delete Request
      await axios.delete(`/api/company/${payload.id}`);
      context.commit('onDeleteCompany', payload);
    },
    onDeleteCompanyMessage: async (context, payload) => {
      await axios.delete(`/api/company/events/${payload.id}`, payload);
      context.commit('onDeleteCompanyMessage', payload); // Form Object
    },
    onDeleteCompanyForm: async (context, payload) => {
      let key = (!('file_one_url' in payload)) ? payload.file_two_url : payload.file_one_url;
      const record = await axios.post(`/api/company/form/${payload.id}`, {
        selected: payload.selected,
        f: key
      });
      context.commit('onDeleteCompanyForm', record.data);
    },
    updateEIN: (context, payload) => {
      context.commit('updateEIN', { employerIdentificationNumber: payload })
    },
    updateName: (context, payload) => {
      context.commit('updateName', { name: payload })
    },
    updateTradeName: (context, payload) => {
      context.commit('updateTradeName', { tradeName: payload })
    },
    updateAddress: (context, payload) => {
      context.commit('updateAddress', { address: payload })
    },
    updateCity: (context, payload) => {
      context.commit('updateCity', { city: payload })
    },
    updateState: (context, payload) => {
      context.commit('updateState', { state: payload })
    },
    updateZip: (context, payload) => {
      context.commit('updateZip', { zip: payload })
    },
    updateForeignCountryName: (context, payload) => {
      context.commit('updateForeignCountryName', { foreignCountryName: payload })
    },
    updateForeignCountryProvince: (context, payload) => {
      context.commit('updateForeignCountryProvince', { foreignCountryProvince: payload })
    },
    updateForeignCountryZip: (context, payload) => {
      context.commit('updateForeignCountryZip', { foreignCountryZip: payload })
    },
    updateCalendarYear: (context, payload) => {
      context.commit('updateCalendarYear', { calendarYear: payload })
    },
    updateQuarterRadio: (context, payload) => {
      context.commit('updateQuarterRadio', { radioSelected: parseInt(payload) })
    },
    storeForm941Line5AColumn2: (context, payload) => {
      context.commit('storeForm941Line5AColumn2', { amount: parseFloat(payload) })
    },
    storeForm941Line5BColumn2: (context, payload) => {
      context.commit('storeForm941Line5BColumn2', { amount: parseFloat(payload) })
    },
    storeForm8974Line12: (context, payload) => {
      context.commit('storeForm8974Line12', { amount: parseFloat(payload) })
    },
    storeFormScheduleBTaxLiabilityMonthOne: (context, payload) => {
      context.commit('storeFormScheduleBTaxLiabilityMonthOne', { amount: parseFloat(payload) })
    },
    storeFormScheduleBTaxLiabilityMonthTwo: (context, payload) => {
      context.commit('storeFormScheduleBTaxLiabilityMonthTwo', { amount: parseFloat(payload) })
    },
    storeFormScheduleBTaxLiabilityMonthThree: (context, payload) => {
      context.commit('storeFormScheduleBTaxLiabilityMonthThree', { amount: parseFloat(payload) })
    },
    storeFormScheduleBTotalQuarterLiability: (context, payload) => {
      context.commit('storeFormScheduleBTotalQuarterLiability', { amount: parseFloat(payload) })
    },
    storeFormInitiatedMeta: (context, payload) => {
      context.commit('storeFormInitiatedMeta', payload) // { id: Number, fileColumn: 1 or 2 : Number }
    },
    storeNewPowerAttorneyOrWorkStatementObject: (context, payload) => {
      context.commit('storeNewPowerAttorneyOrWorkStatementObject', payload)
    },
    deletePowerAttorneyOrWorkStatementObject: async (context, payload) => {
      await axios.delete(`api/company/attorney-work/${payload}`);
      context.commit('deletePowerAttorneyOrWorkStatementObject', payload)
    },
    updateCompanyChecklistItem: (context, payload) => {
      context.commit('updateCompanyChecklistItem', payload)
    },
    onSubmitNewChecklistItem: async (context, payload) => {
      // Post new item
      // Pass on and insert into State @ top api/company/checklist
      const { data } = await axios.post('api/company/checklist', { ...payload });
      context.commit('onSubmitNewChecklistItem', data);
    },
    onDeleteChecklistID: async (context, payload) => {
      await axios.delete(`api/company/checklist/${payload}`);
      context.commit('onDeleteChecklistID', payload);
    },
    addNewCompanyKeyDueDate: (context, payload) => {
      context.commit('addNewCompanyKeyDueDate', payload);
    },
    onDeleteCompanyKeyDueDate: async (context, payload) => {
      await axios.delete(`/api/company/kdd/${payload}`);
      context.commit('onDeleteCompanyKeyDueDate', payload);
    },
    onInitialUsersWithAssociations: (context, payload) => {
      context.commit('onInitialUsersWithAssociations', payload)
    },
    onStoreNewUserAndAssociationLink: (context, payload) => {
      context.commit('onStoreNewUserAndAssociationLink', payload)
    },
    setActiveUser: (context, payload) => {
      context.commit('setActiveUser', payload);
    },
    setCompanyAssociation: (context, payload) => {
      context.commit('setCompanyAssociation', payload);
    },
    setAnalyzerYearEnds: async (context, payload) => { // Creates new POST for Financial Data Tab Date Component
      // qualifyingQuestionsClaimYears
      let records = [];
      await Promise.all(payload.options.map(async el => {
        const { data } = await axios.post(`api/company/analyzer/qq/${el}`, { companyId: payload.cid });
        // Add financial_data key
        data.financial_data = [];
        records.push(data);
      }))
      context.commit('setAnalyzerYearEnds', records);
    },
    getAnalyzerYearEnds: async (context, payload) => {
      // Get all results for the current Company
      const { data } = await axios.get(`api/company/analyzer/qq/${payload}`);
      context.commit('getAnalyzerYearEnds', data);
    },
    setNewFinancialDataEntryYear: (context, payload) => {
      context.commit('setNewFinancialDataEntryYear', payload);
    },
    setNewFinancialDataEntry: async (context, payload) => {
      /**
       * Based on Employee, Supplier, Contractor
       * POST based on ^ and the data
       * Store & Update State
       * ID corresponds to the Qualifying Question ID
       */

      const { data, status } = await axios.post('api/company/analyzer/fd',
        {
          qq_year: payload._year,
          qq_id: payload._qq_id,
          selected_type: payload._selected_type,
          company_id: payload._cid,
          title: payload.title,
          name: payload.name,
          amount: payload.amount,
        });

      if (status === 201) {
        // Add to local state
        context.commit('setNewFinancialDataEntry', { id: payload.id, data });
      }


    },
    onUpdateFinancialDataRecord: async (context, payload) => {
      /**
       * Build PUT object
       */
      let _data = {};

      switch (payload.type) {
        case "name":
          _data.name = payload.data;
          break;
        case "title":
          _data.title = payload.data;
          break;
        case "amount":
          _data.amount = payload.data;
          break;
        case "activities":
          _data.activities = JSON.stringify(payload.data);
          break;
        case "qualifying":
          _data.qualifying_percent = parseFloat(payload.data);
          break;
        case "allocations":
          _data.allocations = payload.data;
          break;
        default:
          break;
      };

      // console.warn('Action : onUpdateFinancialDataRecord ', _data);

      const { data, status } = await axios.put(`api/company/analyzer/fd/${payload.id}`, _data);
      switch (status) {
        case 201:
          context.commit('onUpdateFinancialDataRecord', data);
          break;
        default:
          break;
      }
    },
    onDeleteFinancialDataRecord: async (context, payload) => {
      await axios.delete(`api/company/analyzer/fd/${payload}`);
      context.commit('onDeleteFinancialDataRecord', payload);
    },
    onDeleteQualifyingQuestionYear: (context, payload) => {

      /**
       * Find ID based off payload Date String
       * Send request to delete
       * If 201, remove from STATE
       */
      context.commit('onDeleteQualifyingQuestionYear', payload); // Payload is just a string
    },
    handleBillingRecordUpdate: async (context, payload) => {
      /**
       * PUT
       * Update State
       */
      const { data, status } = axios.put(`/api/company/update-rdc/${payload.id}`, payload.pay)

      if (status === 201) {
        context.commit('handleBillingRecordUpdate', record);
      }

    },
    onNewProjectInformationEntry: async (context, payload) => {

      // console.warn('Action onNewProjectInformationEntry : ', payload.data);

      if (payload.reqType === 'post') {
        const { data } = await axios.post('api/company/analyzer/qp/', payload.data);
        // console.warn('Action onNewProjectInformationEntry POST : ', data);
        context.commit('onNewProjectInformationEntry', data);
      } else if (payload.reqType === 'put') {
        const { data } = await axios.put(`api/company/analyzer/qp/${payload.recordId}`, { projects: payload.data });
        // console.warn('Action onNewProjectInformationEntry PUT : ', data);
        return data;
      }

    },
    onUpdateRDDateCheck: async (context, payload) => {
      await axios.put(`api/company/update-rdc/${payload.id}`, { date_check: payload.data });
      context.commit('onUpdateRDDateCheck', payload);
    },
    onTriggerSort: (context, payload) => {
      context.commit('onTriggerSort', payload);
    },
    onNewAdditionalFileRecieved: (context, payload) => {
      context.commit('onNewAdditionalFileRecieved', payload);
    },
    onDeleteAdditionalFileAsync: (context, payload) => {
      context.commit('onDeleteAdditionalFileAsync', payload);
    },
    onUpdateSortableList: (context, payload) => {
      context.commit('onUpdateSortableList', payload);
    },
    returnSlicedRecordsAtIndexGiven: (context, payload) => {
      context.commit('returnSlicedRecordsAtIndexGiven', payload);
    },
    resetSlicedRecordsAtIndexGivenAccumulation: (context, payload) => {
      context.commit('resetSlicedRecordsAtIndexGivenAccumulation');
    }

  }
})
