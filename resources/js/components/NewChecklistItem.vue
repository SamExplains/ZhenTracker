<template>
  <div class="no-gutters bg-white p-4">
    <h5 class="font-weight-bolder">New Checklist Item</h5>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label>Checklist description</label>
          <el-input placeholder="Please input" v-model="itemName" show-word-limit maxlength="120"></el-input>
        </div>
      </div>
      <div class="col-12">
        <el-button type="primary" @click="submitNewChecklistItem">Post New Checklist Item</el-button>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "NewChecklistItem",
    data() {
      return {
        itemName: ''
      }
    },
    computed: {
      ...mapGetters(['returnCurrentActiveCompany'])
    },
    methods: {
      ...mapActions(['onSubmitNewChecklistItem']),
      submitNewChecklistItem() {

        if (this.itemName.length && this.returnCurrentActiveCompany !== null) {
          //
          this.onSubmitNewChecklistItem({company_id: this.returnCurrentActiveCompany.id, item: this.itemName, completed: 0});
          this.itemName = '';
        } else {
          this.$notify({
            title: 'Error',
            message: 'Enter a valid Checklist description and select a Company.',
            type: 'error'
          });
        }
      }
    }
  }
</script>

<style scoped>

</style>
