<template>
  <section>
    <div class="bg-white p-4 overflow-auto">
      <h6 class="mb-3">Scroll horizontally to view more.</h6>
      <table class="table overflow-scroll" style="width: 150%">
        <thead>
          <tr>
            <th>Form Type</th>
            <th>Quarter</th>
            <th>Year</th>
            <th>Period</th>
            <th>File 1</th>
            <th>File 2</th>
            <th>Additional Attachments</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(form, index) in returnCompanyForms" :key="index">
            <td scope="row" style="width: 2rem">
              {{ form.form_type }}
            </td>
            <td style="width: 2rem">{{ form.quarter }}</td>
            <td style="width: 4rem">{{ form.year }}</td>
            <td style="width: 4rem">{{ form.period }}</td>
            <td style="width: 20rem" class="text-wrap">
              <!-- Show file name -->
              <section
                class="mb-3"
                v-if="
                  form.file_one_url !== null && form.file_one_url !== undefined
                "
              >
                <a :href="form.file_one_url" target="_blank">
                  {{ clipFileName(form.file_one_url) }}
                </a>
              </section>

              <details>
                <summary>
                  <span class="text-primary">File 1 Upload</span>
                </summary>
                <section
                  v-if="
                    form.file_one_url !== null &&
                    form.file_one_url !== undefined
                  "
                >
                  <a :href="form.file_one_url" target="_blank">
                    {{ clipFileName(form.file_one_url) }}
                  </a>
                  <el-button
                    type="text"
                    icon="el-icon-delete"
                    class="ml-5 text-danger"
                    @click="onDeleteF1(form)"
                  />
                </section>

                <i v-else>No file found</i>
                <br />
                <el-collapse>
                  <el-collapse-item title="File Upload" name="1">
                    <el-upload
                      class="upload-demo"
                      drag
                      :action="'api/company/form-upload/' + form.id"
                      name="file_upload_one"
                      :on-preview="handlePreview"
                      :on-remove="handleRemove"
                      :on-change="handleChange(form.id)"
                      :on-success="handleSuccess"
                    >
                      <i class="el-icon-upload"></i>
                      <div class="el-upload__text">
                        Drop file here or <em>click to upload</em>
                      </div>
                      <div class="el-upload__tip" slot="tip">
                        jpg/png files with a size less than 500kb
                      </div>
                    </el-upload>
                  </el-collapse-item>
                </el-collapse>
              </details>
            </td>
            <td
              style="width: 20rem"
              class="text-wrap"
              v-if="
                form.form_type === '941' ||
                form.form_type === '941X' ||
                form.form_type === '1120'
              "
            >
              <section
                class="mb-3"
                v-if="
                  form.file_two_url !== null && form.file_two_url !== undefined
                "
              >
                <a :href="form.file_two_url" target="_blank">
                  {{ clipFileName(form.file_two_url) }}
                </a>
              </section>

              <details>
                <summary>
                  <span class="text-primary">File 2 Upload</span>
                </summary>
                <section
                  v-if="
                    form.file_two_url !== null &&
                    form.file_two_url !== undefined
                  "
                >
                  <a :href="form.file_two_url" target="_blank">
                    {{ clipFileName(form.file_two_url) }}
                  </a>
                  <el-button
                    type="text"
                    icon="el-icon-delete"
                    class="ml-5 text-danger"
                    @click="onDeleteF2(form)"
                  />
                </section>
                <i v-else>No file found</i>
                <br />
                <el-collapse>
                  <el-collapse-item title="File Upload" name="2">
                    <el-upload
                      class="upload-demo"
                      drag
                      :action="'api/company/form-upload/' + form.id"
                      name="file_upload_two"
                      :on-preview="handlePreview"
                      :on-remove="handleRemove"
                      :on-change="handleChange(form.id)"
                      :on-success="handleSuccess"
                    >
                      <i class="el-icon-upload"></i>
                      <div class="el-upload__text">
                        Drop file here or <em>click to upload</em>
                      </div>
                      <div class="el-upload__tip" slot="tip">
                        jpg/png files with a size less than 500kb
                      </div>
                    </el-upload>
                  </el-collapse-item>
                </el-collapse>
              </details>
            </td>
            <td v-else></td>
            <!-- File Upload #3 (Additional Files <Array>) -->
            <td style="width: 20rem" class="text-wrap">
              <details>
                <summary>
                  <span class="text-primary">Additional Files Upload</span>
                </summary>
                <div
                  v-if="
                    form.additional_files !== null &&
                    form.additional_files !== ''
                  "
                >
                  <table class="table">
                    <thead>
                      <tr>
                        <th>File</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(f, fid) in JSON.parse(form.additional_files)"
                        :key="fid"
                      >
                        <td>{{ f.url }} {{ f.id }}</td>
                        <td>
                          <el-button
                            size="mini"
                            type="danger"
                            @click="onDeleteAdditionalFile(form.id, f.id)"
                            >delete</el-button
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div v-else>No additional files found.</div>

                <br />
                <br />

                <el-upload
                  class="upload-demo"
                  drag
                  :action="'api/company/form-upload-additional/' + form.id"
                  name="file_upload_additional"
                  :on-preview="handlePreview"
                  :on-remove="handleRemove"
                  :on-change="handleChange(form.id)"
                  :on-success="handleSuccessAdditional"
                >
                  <i class="el-icon-upload"></i>
                  <div class="el-upload__text">
                    Drop file here or <em>click to upload</em>
                  </div>
                  <div class="el-upload__tip" slot="tip">
                    jpg/png files with a size less than 500kb
                  </div>
                </el-upload>
              </details>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import SelectFormTemplate from "./SelectFormTemplate";

// import * as $ from "jquery";

export default {
  name: "FormsComponent",
  components: { SelectFormTemplate },
  props: {
    ty_8974: String,
    ty_941: String,
    ty_941_url: String,
    ty_941s_url: String,
    ty_941s: String,
    ty_941x_url: String,
    ty_941x: String,
    ty_6765: String,
    ty_6765_url: String,
    ty_3523: String,
    ty_3523_url: String,
  },
  data() {
    return {
      enabledInteractiveForm: true,
    };
  },
  computed: {
    ...mapGetters(["returnCompanyForms"]),
  },
  methods: {
    ...mapActions([
      "updateCompanyFormsWithUpdatedCompany",
      "onDeleteCompanyForm",
      "storeFormInitiatedMeta",
      "onNewAdditionalFileRecieved",
      "onDeleteAdditionalFileAsync",
    ]),
    handlePreview() {},
    handleRemove() {},
    handleChange(file) {},
    handleSuccess(response) {
      // console.log("handleSuccess Response ", response);

      // 201
      // Update store with Object
      // Show success modal
      this.updateCompanyFormsWithUpdatedCompany(response);

      this.$notify({
        title: "Success",
        message: "Form was stored successfully.",
        type: "success",
      });
    },
    handleSuccessAdditional(response) {
      // console.log("handleSuccessAdditional Response ", response);
      this.onNewAdditionalFileRecieved(response);
      this.$notify({
        title: "Success",
        message: "Form was stored successfully.",
        type: "success",
      });
    },
    clipFileName(file) {
      return file !== undefined ? file.substring(76) : "No file found";
    },
    onDeleteF1(form) {
      this.onDeleteCompanyForm({
        id: form.id,
        file_one_url: form.file_one_url.substr(66),
        selected: 1,
      });
    },
    onDeleteF2(form) {
      this.onDeleteCompanyForm({
        id: form.id,
        file_two_url: form.file_two_url.substr(66),
        selected: 2,
      });
    },
    initializeCustomForm(id, fileColumn) {
      // this.enabledInteractiveForm = true;

      // Scroll to
      $("html, body").animate(
        {
          scrollTop: $("#formSelectScrollToPlaceholder").offset().top,
        },
        800,
        function () {
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = $("#formSelectScrollToPlaceholder");
        }
      );

      // Store in state for later use
      this.storeFormInitiatedMeta({ id, fileColumn });
    },
    onDeleteAdditionalFile(formId, fileArrID) {
      // console.log("onDeleteAdditionalFile ", formId, "   ", fileArrID);
      this.onDeleteAdditionalFileAsync({ fid: formId, faid: fileArrID });
    },
  },
};
</script>

<style scoped>
.bg-black {
  background: black;
}
</style>
