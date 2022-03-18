<template>
  <div class="bg-white p-4">
    <h6>Power of Attorney and Statement of Work Attachments</h6>

    <section>
      <table class="table">
        <thead>
          <tr>
            <th>Filename</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody
          v-for="(form, index) in this.returnPowerAttorneyStatementWorkForms"
          :key="index"
        >
          <tr>
            <td scope="row">
              <a :href="form.file_one_url">
                {{ form.file_one_url.substring(91) }}
              </a>
            </td>
            <td>
              <el-button type="danger" @click="onDelete(form.id)"
                >delete</el-button
              >
            </td>
          </tr>
        </tbody>
      </table>

      <hr />

      <article class="mt-5">
        <el-upload
          class="upload-demo"
          drag
          :action="
            'api/company/attorney-work/' + this.returnCurrentActiveCompany.id
          "
          name="file_upload_one"
          :on-preview="handlePreview"
          :on-remove="handleRemove"
          :on-change="handleChange"
          :on-success="handleSuccess"
        >
          <i class="el-icon-upload"></i>
          <div class="el-upload__text">
            Drop file here or <em>click to upload</em>
          </div>
        </el-upload>
      </article>
    </section>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "POWandSOWComponent",
  computed: {
    ...mapGetters([
      "returnCurrentActiveCompany",
      "returnPowerAttorneyStatementWorkForms",
    ]),
  },
  methods: {
    ...mapActions([
      "storeNewPowerAttorneyOrWorkStatementObject",
      "deletePowerAttorneyOrWorkStatementObject",
    ]),
    handleSuccess(response) {
      /*
       * Store response object
       * Render List
       * */

      // console.warn(' POWandSOW Component : handleSuccess ',response);

      this.storeNewPowerAttorneyOrWorkStatementObject(response.AWDocument);

      this.$notify({
        title: "Success",
        message: "Form was stored successfully.",
        type: "success",
      });
    },
    handleChange(obj1) {},
    handleRemove() {},
    handlePreview() {},
    onDelete(fid) {
      this.deletePowerAttorneyOrWorkStatementObject(fid);

      this.$notify({
        title: "Success",
        message: "Form was deleted successfully.",
        type: "success",
      });
    },
  },
};
</script>

<style scoped>
</style>
