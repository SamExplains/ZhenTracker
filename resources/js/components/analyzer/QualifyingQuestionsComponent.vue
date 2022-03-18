<template>
  <div class="container-fluid">
    <div class="row bg-white p-4">
      <div class="col-6">
        <h4>B. Claim Years</h4>
        <h5>
          Please select the most recent year end(s) for which you want to claim
          credit
        </h5>
        <el-select v-model="selectedOptions" multiple placeholder="Select">
          <el-option
            v-for="item in options"
            :key="item.year"
            :label="item.year"
            :value="item.year"
          ></el-option>
        </el-select>
        <br />
        <el-button @click="onHandleClaimYears" type="primary" class="mt-3"
          >Save selected years</el-button
        >
      </div>

      <div class="col-6">
        <h4>Delete a claim year</h4>
        <h5>Please click the entries you want to delete</h5>
        <div v-for="(option, index) in returnYearEndsAsYearsArray" :key="index">
          <span>{{ option }}</span>
          <el-button
            @click="onhandleDelete(option)"
            type="danger"
            size="mini"
            class="ml-2 mt-3"
            >delete</el-button
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data: function () {
    return {
      options: [
        {
          year: "Jan 2020 - Dec 2021",
        },
        {
          year: "Jan 2019 - Dec 2019",
        },
        {
          year: "Jan 2018 - Dec 2018",
        },
        {
          year: "Jan 2017 - Dec 2017",
        },
        {
          year: "Jan 2016 - Dec 2016",
        },
        {
          year: "Jan 2015 - Dec 2015",
        },
        {
          year: "Jan 2014 - Dec 2014",
        },
        {
          year: "Jan 2013 - Dec 2013",
        },
        {
          year: "Jan 2012 - Dec 2012",
        },
        {
          year: "Jan 2011 - Dec 2011",
        },
        {
          year: "Jan 2010 - Dec 2010",
        },
        {
          year: "Jan 2009 - Dec 2009",
        },
        {
          year: "Jan 2008 - Dec 2008",
        },
        {
          year: "Jan 2007 - Dec 2007",
        },
        {
          year: "Jan 2006 - Dec 2006",
        },
        {
          year: "Jan 2005 - Dec 2005",
        },
        {
          year: "Jan 2004 - Dec 2004",
        },
        {
          year: "Jan 2003 - Dec 2003",
        },
        {
          year: "Jan 2002 - Dec 2002",
        },
        {
          year: "Jan 2001 - Dec 2001",
        },
        {
          year: "Jan 2000 - Dec 2000",
        },
      ],
      selectedOptions: "",
    };
  },
  computed: {
    ...mapGetters([
      "returnAnalyzerYearEnds",
      "returnCurrentActiveCompany",
      "returnYearEndsAsYearsArray",
    ]),
  },
  async created() {
    /**
     * Check if there are any years from the records and prevent additional calls
     */

    //  console.warn('Created: qualifyingQuestionsComponent');

    if ((await this.returnYearEndsAsYearsArray.length) === 0) {
      await this.getAnalyzerYearEnds(this.returnCurrentActiveCompany.id); // Only Searches
    }
    // Should be an array of just the years
    this.selectedOptions = this.returnYearEndsAsYearsArray;
  },
  updated() {
    // console.warn('Updated: qualifyingQuestionsComponent');
  },
  methods: {
    ...mapActions([
      "setAnalyzerYearEnds",
      "getAnalyzerYearEnds",
      "onDeleteQualifyingQuestionYear",
    ]),

    onhandleDelete(dateString) {
      // console.warn('onhandleDelete ', dateString);
      this.onDeleteQualifyingQuestionYear(dateString);
    },
    onHandleClaimYears() {
      let intersection = this.selectedOptions.filter(
        (x) => !this.returnYearEndsAsYearsArray.includes(x)
      );

      if (intersection.length > 0) {
        // Creates new POST for Financial Data Tab Date Component
        this.setAnalyzerYearEnds({
          cid: this.returnCurrentActiveCompany.id,
          options: intersection,
        });

        this.$notify({
          title: "Success",
          message: "Claim years saved",
          type: "success",
        });
      } else {
        this.$notify({
          title: "Warning",
          message: "No new items recognized",
          type: "warning",
        });
      }
    },
  },
};
</script>

