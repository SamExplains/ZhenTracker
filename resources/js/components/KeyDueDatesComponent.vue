<template>
  <div class="bg-white p-4 mb-3">
    <h6 class="text-primary font-weight-bolder">Key Due Dates</h6>

    <div style="overflow: scroll; height: 34rem">
      <table class="table">
      <thead>
      <tr>
        <th>Date</th>
        <th>Info.</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(kdd, index) in this.returnCompanyKeyDueDates" :key="index">
        <td scope="row" colspan="5">{{ kdd.date }}</td>
        <td colspan="7">
          <h6 class="font-weight-bolder">
            <u>{{ kdd.title }}</u>
          </h6>
          {{ kdd.description }}
          <br>
          <el-button type="text" class="text-danger float-right" @click="onDeleteKDD(kdd.id)">delete</el-button>
        </td>
      </tr>
      </tbody>
    </table>
    </div>

    <hr>

    <h6 class="text-primary font-weight-bolder">Add New Key Due Date</h6>

    <div class="form-group mt-3">
      <label>Date</label>
      <flatpickr class="negativePadding" timeFormat="m-d-Y" v-model="keyDate" id="kdd_date"/>
      <small class="text-danger" v-show="keyDateError">Select a date</small>
    </div>

    <div class="form-group mt-3">
      <label>Title</label>
      <el-input placeholder="Please input" v-model="title.input" show-word-limit maxlength="125"></el-input>
      <small class="text-danger" v-show="title.error">Enter a title</small>
    </div>

    <div class="form-group mt-3">
      <label>Description</label>
      <el-input placeholder="Please input" v-model="description.input" show-word-limit maxlength="125"></el-input>
      <small class="text-danger" v-show="description.error">Enter a title</small>
    </div>

    <el-button type="primary" @click="onNewKeyDueDateEntry">Add New Key Due Date</el-button>
  </div>
</template>

<script>
  import axios from 'axios';
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "KeyDueDatesComponent",
    data(){
      return {
        keyDate: '',
        keyDateError: false,
        title: {
          input: '',
          error: ''
        },
        description: {
          input: '',
          error: ''
        },
      }
    },
    computed: {
      ...mapGetters(['returnCurrentActiveCompany', 'returnCompanyKeyDueDates'])
    },
    methods: {
      ...mapActions(['addNewCompanyKeyDueDate', 'onDeleteCompanyKeyDueDate']),
      async onNewKeyDueDateEntry() {
        const _d = document.getElementById('kdd_date').value;
        let errCount = 0;

        if (_d.length < 1) {
          this.keyDateError = true;
          errCount++;
        } else this.keyDateError = false;

        if (this.title.input.length < 1) {
          this.title.error = true;
          errCount++;
        } else this.title.error = false;

        if (this.description.input.length < 1) {
          this.description.error = true;
          errCount++;
        } else this.description.error = false;

        if (errCount === 0) {
          const { data } = await axios.post('api/company/kdd', {
            'company_id': this.returnCurrentActiveCompany.id,
            'date': _d,
            'title': this.title.input,
            'description': this.description.input,
          });

          // Add / Store data
          this.addNewCompanyKeyDueDate(data);

          this.$notify({
            title: 'Success',
            message: 'Key Due Date event successfully stored.',
            type: 'success'
          });

        } else {
          this.$notify({
            title: 'Error',
            message: 'Please check for errors.',
            type: 'error'
          });
        }


      },
      onDeleteKDD(kddId) {
        this.onDeleteCompanyKeyDueDate(kddId);
      }
    }
  }
</script>

<style scoped>

  .negativePadding {
    margin-top: -1rem;
  }

</style>
