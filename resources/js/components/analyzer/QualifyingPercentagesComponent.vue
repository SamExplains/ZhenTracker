<template>
  <div class="container-fluid">
    <div class="row bg-white p-4">
      <div class="col-12">
        <h5>Qualifying Percentage</h5>
        <h6 v-if="this.returnAnalyzerYearEnds.length === 0">
          Please select at least one year under
          <b>Qualifying Questions</b>
        </h6>
      </div>

      <div class="col-12" v-if="this.returnAnalyzerYearEnds.length > 0">
        <el-tabs
          v-model="activeName"
          @tab-click="handleClick"
          type="border-card"
        >
          <el-tab-pane
            v-for="(item, index) in this.returnAnalyzerYearEnds"
            :key="index"
            :label="item.year"
            :name="index.toString()"
          >
            <section>
              <!-- Project Information -->
              <article class="mb-3">
                <h5 class="text-primary">Qualified Project Information</h5>
                <!-- project.name -->
                <div class="row">
                  <div class="col-12 mb-3">
                    <el-table :data="projectsArr" style="width: 100%">
                      <el-table-column prop="id" label="Hash ID" width="300">
                      </el-table-column>
                      <el-table-column prop="name" label="Name" width="180">
                      </el-table-column>
                      <el-table-column
                        prop="description"
                        label="Description"
                        width="300"
                      >
                      </el-table-column>
                      <el-table-column label="Operations">
                        <template slot-scope="scope">
                          <el-button
                            size="mini"
                            type="danger"
                            @click="
                              handleProjectDelete(
                                scope.$index,
                                scope.row.id,
                                scope.row
                              )
                            "
                            >Delete</el-button
                          >
                        </template>
                      </el-table-column>
                    </el-table>
                  </div>

                  <div class="col-12 mt-3 mb-3">
                    <h5 class="text-primary">New Project Information</h5>
                  </div>

                  <div class="col-6">
                    <input
                      type="text"
                      v-model="project.name"
                      placeholder="Please input project name"
                      :class="[
                        'form-control',
                        project.nameErr ? 'is-invalid' : '',
                      ]"
                    />
                  </div>
                  <div class="col-6">
                    <input
                      type="text"
                      v-model="project.description"
                      placeholder="Please input project description"
                      :class="[
                        'form-control',
                        project.descriptionErr ? 'is-invalid' : '',
                      ]"
                    />
                  </div>
                  <div class="col-12 mt-3">
                    <el-button type="primary" @click="onNewProjectInformation"
                      >Add New Project Information</el-button
                    >
                  </div>
                </div>
              </article>

              <!-- Employees -->
              <article>
                <h5 class="text-primary">Employees</h5>

                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataEmployee"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name">
                    <template slot-scope="scope">{{ scope.row.name }}</template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title">
                    <template slot-scope="scope">{{
                      scope.row.title
                    }}</template>
                  </el-table-column>
                  <el-table-column prop="amount" label="Amount">
                    <template slot-scope="scope">{{
                      scope.row.amount
                    }}</template>
                  </el-table-column>
                  <el-table-column
                    width="300"
                    prop="activities"
                    label="Activities"
                  >
                    <template slot-scope="scope">
                      <el-select
                        v-model="scope.row.activities"
                        multiple
                        placeholder="Select"
                        style="width: 17.5rem"
                      >
                        <el-option
                          v-for="item in activitiesOptions"
                          :key="item"
                          :label="item"
                          :value="item"
                        ></el-option>
                      </el-select>

                      <div>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.activities,
                              'activities'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column
                    width="200"
                    prop="qualifying_percent"
                    label="Qualifying %"
                  >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <el-input-number
                          v-model="scope.row.qualifying_percent"
                          :precision="2"
                          :max="100"
                        ></el-input-number>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.qualifying_percent,
                              'qualifying'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>

                  <!-- Dynamic Allocation Percent -->
                  <el-table-column
                    width="175"
                    v-for="(project, pidx) in projectsArr"
                    :key="pidx"
                    :label="project.name"
                  >
                    <template slot-scope="scope">
                      {{
                        populateProjectElements(
                          scope.row.id,
                          scope.row.qq_id,
                          returnRandomUUID,
                          scope.row.selected_type
                        )
                      }}

                      <div class="input-group">
                        <el-input-number
                          :id="`employee-${scope.row.id}-${pidx}-${returnRandomUUID}`"
                          :precision="2"
                          :max="99.99"
                        ></el-input-number>
                        <button
                          class="btn btn-primary btn-block mt-2"
                          v-if="pidx == 0"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              project.percent,
                              'allocations',
                              `${returnRandomUUID}`,
                              projectsArr.length
                            )
                          "
                        >
                          Update
                        </button>
                        <div v-else style="margin-top: 2.8rem"></div>
                      </div>
                    </template>
                  </el-table-column>
                </el-table>
              </article>

              <!-- Supplies -->
              <article>
                <h5 class="text-primary">Supplies</h5>

                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataSupplies"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name">
                    <template slot-scope="scope">{{ scope.row.name }}</template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title">
                    <template slot-scope="scope">{{
                      scope.row.title
                    }}</template>
                  </el-table-column>
                  <el-table-column prop="amount" label="Amount">
                    <template slot-scope="scope">{{
                      scope.row.amount
                    }}</template>
                  </el-table-column>
                  <el-table-column
                    width="300"
                    prop="activities"
                    label="Activities"
                  >
                    <template slot-scope="scope">
                      <el-select
                        v-model="scope.row.activities"
                        multiple
                        placeholder="Select"
                        style="width: 17.5rem"
                      >
                        <el-option
                          v-for="item in activitiesOptions"
                          :key="item"
                          :label="item"
                          :value="item"
                        ></el-option>
                      </el-select>

                      <div>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.activities,
                              'activities'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column
                    width="200"
                    prop="qualifying_percent"
                    label="Qualifying %"
                  >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <el-input-number
                          v-model="scope.row.qualifying_percent"
                          :precision="2"
                          :max="100"
                        ></el-input-number>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.qualifying_percent,
                              'qualifying'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>

                  <!-- Dynamic Allocation Percent -->
                  <el-table-column
                    width="175"
                    v-for="(project, pidx) in projectsArr"
                    :key="pidx"
                    :label="project.name"
                  >
                    <template slot-scope="scope">
                      {{
                        populateProjectElements(
                          scope.row.id,
                          scope.row.qq_id,
                          returnRandomUUID,
                          scope.row.selected_type
                        )
                      }}

                      <div class="input-group">
                        <el-input-number
                          :id="`employee-${scope.row.id}-${pidx}-${returnRandomUUID}`"
                          :precision="2"
                          :max="99.99"
                        ></el-input-number>
                        <button
                          class="btn btn-primary btn-block mt-2"
                          v-if="pidx == 0"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              project.percent,
                              'allocations',
                              `${returnRandomUUID}`,
                              projectsArr.length
                            )
                          "
                        >
                          Update
                        </button>
                        <div v-else style="margin-top: 2.8rem"></div>
                      </div>
                    </template>
                  </el-table-column>
                </el-table>
              </article>

              <!-- Contractors -->
              <article>
                <h5 class="text-primary">Contractors</h5>

                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataContractors"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name">
                    <template slot-scope="scope">{{ scope.row.name }}</template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title">
                    <template slot-scope="scope">{{
                      scope.row.title
                    }}</template>
                  </el-table-column>
                  <el-table-column prop="amount" label="Amount">
                    <template slot-scope="scope">{{
                      scope.row.amount
                    }}</template>
                  </el-table-column>
                  <el-table-column
                    width="300"
                    prop="activities"
                    label="Activities"
                  >
                    <template slot-scope="scope">
                      <el-select
                        v-model="scope.row.activities"
                        multiple
                        placeholder="Select"
                        style="width: 17.5rem"
                      >
                        <el-option
                          v-for="item in activitiesOptions"
                          :key="item"
                          :label="item"
                          :value="item"
                        ></el-option>
                      </el-select>

                      <div>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.activities,
                              'activities'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column
                    width="200"
                    prop="qualifying_percent"
                    label="Qualifying %"
                  >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <el-input-number
                          v-model="scope.row.qualifying_percent"
                          :precision="2"
                          :max="100"
                        ></el-input-number>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.qualifying_percent,
                              'qualifying'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>

                  <!-- Dynamic Allocation Percent -->
                  <el-table-column
                    width="175"
                    v-for="(project, pidx) in projectsArr"
                    :key="pidx"
                    :label="project.name"
                  >
                    <template slot-scope="scope">
                      {{
                        populateProjectElements(
                          scope.row.id,
                          scope.row.qq_id,
                          returnRandomUUID,
                          scope.row.selected_type
                        )
                      }}

                      <div class="input-group">
                        <el-input-number
                          :id="`employee-${scope.row.id}-${pidx}-${returnRandomUUID}`"
                          :precision="2"
                          :max="99.99"
                        ></el-input-number>
                        <button
                          class="btn btn-primary btn-block mt-2"
                          v-if="pidx == 0"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              project.percent,
                              'allocations',
                              `${returnRandomUUID}`,
                              projectsArr.length
                            )
                          "
                        >
                          Update
                        </button>
                        <div v-else style="margin-top: 2.8rem"></div>
                      </div>
                    </template>
                  </el-table-column>
                </el-table>
              </article>

              <!-- Servers -->
              <article>
                <h5 class="text-primary">Servers</h5>

                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataServers"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name">
                    <template slot-scope="scope">{{ scope.row.name }}</template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title">
                    <template slot-scope="scope">{{
                      scope.row.title
                    }}</template>
                  </el-table-column>
                  <el-table-column prop="amount" label="Amount">
                    <template slot-scope="scope">{{
                      scope.row.amount
                    }}</template>
                  </el-table-column>
                  <el-table-column
                    width="300"
                    prop="activities"
                    label="Activities"
                  >
                    <template slot-scope="scope">
                      <el-select
                        v-model="scope.row.activities"
                        multiple
                        placeholder="Select"
                        style="width: 17.5rem"
                      >
                        <el-option
                          v-for="item in activitiesOptions"
                          :key="item"
                          :label="item"
                          :value="item"
                        ></el-option>
                      </el-select>

                      <div>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.activities,
                              'activities'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column
                    width="200"
                    prop="qualifying_percent"
                    label="Qualifying %"
                  >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <el-input-number
                          v-model="scope.row.qualifying_percent"
                          :precision="2"
                          :max="100"
                        ></el-input-number>
                        <button
                          class="btn btn-outline-secondary btn-block mt-2"
                          type="button"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              scope.row.qualifying_percent,
                              'qualifying'
                            )
                          "
                        >
                          <i class="el-icon-edit"></i>
                        </button>
                      </div>
                    </template>
                  </el-table-column>

                  <!-- Dynamic Allocation Percent -->
                  <el-table-column
                    width="175"
                    v-for="(project, pidx) in projectsArr"
                    :key="pidx"
                    :label="project.name"
                  >
                    <template slot-scope="scope">
                      {{
                        populateProjectElements(
                          scope.row.id,
                          scope.row.qq_id,
                          returnRandomUUID,
                          scope.row.selected_type
                        )
                      }}

                      <div class="input-group">
                        <el-input-number
                          :id="`employee-${scope.row.id}-${pidx}-${returnRandomUUID}`"
                          :precision="2"
                          :max="99.99"
                        ></el-input-number>
                        <button
                          class="btn btn-primary btn-block mt-2"
                          v-if="pidx == 0"
                          @click="
                            onUpdateRecord(
                              scope.row.id,
                              project.percent,
                              'allocations',
                              `${returnRandomUUID}`,
                              projectsArr.length
                            )
                          "
                        >
                          Update
                        </button>
                        <div v-else style="margin-top: 2.8rem"></div>
                      </div>
                    </template>
                  </el-table-column>
                </el-table>
              </article>
            </section>
          </el-tab-pane>
        </el-tabs>

        <hr />
      </div>

      <div class="col-12" v-else>
        Please Select one Year from the available tabs and Enter at least one
        record in Financial Data to continue.
      </div>
    </div>
  </div>
</template>

<script>
import { v4 as uuidv4 } from "uuid";
import { mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      activeName: "first",
      newEntrySelected: "",
      activeTabYear: "",
      selectedActivities: [],
      activitiesOptions: [
        "Prototyping including improvements",
        "Functional requirement definition",
        "Testing and Evaluation",
        "Support Dev Team (cleaning, buildout, QC)",
      ],
      project: {
        name: "",
        nameErr: false,
        description: "",
        descriptionErr: false,
      },
      projectsArr: [],
      projectsRecord: "",
      name: {
        value: "",
        error: "",
      },
      title: {
        value: "",
        error: "",
      },
      amount: {
        value: "",
        error: "",
      },
      employees: [],
      supplies: [],
      contractors: [],
      server: [],
    };
  },
  computed: {
    ...mapGetters([
      "returnAnalyzerYearEnds",
      "getSelectedFinancialTableData",
      "returnFinancialTableDataEmployee",
      "returnFinancialTableDataSupplies",
      "returnFinancialTableDataContractors",
      "returnFinancialTableDataServers",
      "returnActiveTabYearId",
      "returnCurrentActiveCompany",
      "returnCheckForQalifyingQuestionsClaimYears",
      "returnAllAvailableFinancialData",
      "returnActiveProjectRecord",
    ]),
    returnRandomUUID() {
      return uuidv4();
    },
  },
  methods: {
    ...mapActions([
      "setNewFinancialDataEntryYear",
      "onUpdateFinancialDataRecord",
      "onNewProjectInformationEntry",
    ]),
    async returnProjectData() {
      if (this.returnActiveTabYearId) {
        // console.warn('Qualifying Percentage : Created | Getting Project Array Data!');
        const { data, status } = await axios.get(
          `api/company/analyzer/qp/${this.returnActiveTabYearId}`
        );
        // Assign Record
        this.projectsRecord = data[0];
        if (this.projectsRecord !== undefined) {
          this.projectsArr = JSON.parse(data[0].projects) || [];
        } else {
          this.projectsArr = [];
        }
      } else {
        // console.error('Created : QualifyingPercentageComponent QQID returned NULL');
        this.projectsRecord === null;
      }
    },
    handleClick(tab, event) {
      this.activeTabYear =
        event.target.innerText || event.explicitOriginalTarget.innerText;
      this.setNewFinancialDataEntryYear(this.activeTabYear);
      this.returnProjectData();
    },
    handleCommand(command) {
      this.newEntrySelected = command;
    },
    onUpdateRecord(
      recordId,
      fieldData,
      fieldType,
      projectUUID,
      allocationArrLength
    ) {
      /**
       * This accepts inputs to update both Activities and Allocation!
       * Make sure to filter that out when sending the request!
       */
      // console.warn(
      //   "onUpdateRecord Financial Relationship Record ID ",
      //   recordId,
      //   " Data ",
      //   fieldData,
      //   " Type ",
      //   fieldType,
      //   " Unique Element ID ",
      //   projectUUID,
      //   " Array Length ",
      //   allocationArrLength
      // );

      // employee-${RECORD_ID}-${itteration_id[ 0....arr.length-1 ]}-${returnRandomUUID}`
      if (fieldType === "allocations") {
        let toUpdateAllocationsArr = [];
        for (let index = 0; index < allocationArrLength; index++) {
          let _value = parseFloat(
            document.getElementById(
              `employee-${recordId}-${index}-${projectUUID}`
            ).childNodes[2].lastElementChild.value
          )
            ? document.getElementById(
                `employee-${recordId}-${index}-${projectUUID}`
              ).childNodes[2].lastElementChild.value
            : "0";
          toUpdateAllocationsArr.push(_value);
        }

        this.onUpdateFinancialDataRecord({
          id: recordId,
          type: fieldType,
          data: JSON.stringify(toUpdateAllocationsArr),
        });
      } else {
        this.onUpdateFinancialDataRecord({
          id: recordId,
          type: fieldType,
          data: fieldData,
        });
      }

      this.$notify({
        title: "Success",
        message: "Record was updated.",
        type: "success",
      });
    },
    async onNewProjectInformation() {
      let errCount = 0;
      if (this.project.name === "") {
        this.project.nameErr = true;
        errCount++;
      } else this.project.nameErr = false;

      if (this.project.description === "") {
        this.project.descriptionErr = true;
        errCount++;
      } else this.project.descriptionErr = false;

      if (errCount < 1) {
        const newProjectInfo = {
          id: uuidv4(),
          name: this.project.name,
          description: this.project.description,
          percent: "0",
        };

        this.projectsArr;

        // Add on to projects if already exists
        this.projectsArr.length > 0
          ? this.projectsRecord !== undefined &&
            this.projectsRecord !== null &&
            "id" in this.projectsRecord
            ? this.projectsArr.push(newProjectInfo)
            : (this.projectsArr = [newProjectInfo])
          : (this.projectsArr = [newProjectInfo]);

        const record = {
          company_id: this.returnCurrentActiveCompany.id,
          qq_id: this.returnActiveTabYearId,
          projects: JSON.stringify(this.projectsArr),
        };

        if (this.projectsArr.length > 0 && this.projectsRecord !== "") {
          if (
            this.projectsRecord !== undefined &&
            "id" in this.projectsRecord
          ) {
            await this.onNewProjectInformationEntry({
              data: record.projects,
              recordId: this.projectsRecord.id,
              reqType: "put",
            });
          } else {
            await this.onNewProjectInformationEntry({
              data: record,
              reqType: "post",
            });
            // Get record from state and update locally
            this.projectsRecord = this.returnActiveProjectRecord;
          }
        } else {
          await this.onNewProjectInformationEntry({
            data: record,
            reqType: "post",
          });
          // Get record from state and update locally
          this.projectsRecord = this.returnActiveProjectRecord;
        }

        // this.projectsRecord = (this.projectsRecord !== undefined && 'id' in this.projectsRecord) ? await this.onNewProjectInformationEntry({data: record.projects, recordId: this.projectsRecord.id, reqType: 'put'}) : await this.onNewProjectInformationEntry({data: record, reqType: 'post'});

        this.project.name = this.project.description = "";
        this.$notify({
          title: "Success",
          message: "Record was saved.",
          type: "success",
        });
      } else {
        this.$notify({
          title: "Error",
          message: "Check for errors.",
          type: "error",
        });
      }
    },
    async handleProjectDelete(index, rowId, row) {
      this.projectsArr = this.projectsArr.filter((el) => el.id !== rowId);
      const projects = JSON.stringify(this.projectsArr);

      // console.warn('handleProjectDelete Index ', index, 'ID ', rowId, ' Row ', row);
      // console.warn("handleProjectDelete Index ", index, "ID ", rowId);
      // console.warn('handleProjectDelete Updated ', this.projectsArr);
      // console.warn("Updated projects ", projects);

      const response = await this.onNewProjectInformationEntry({
        data: projects,
        recordId: this.projectsRecord.id,
        reqType: "put",
      });
      // console.warn('Delete Response ', response);

      if (response) {
        this.$notify({
          title: "Success",
          message: "Record was deleted.",
          type: "success",
        });
      } else {
        this.$notify({
          title: "Error",
          message: "Record failed to remove.",
          type: "error",
        });
      }
    },
    populateProjectElements(id, qqid, uuid, selectedType) {
      // Update found to be based on the SelectedType
      let found;

      if (selectedType === "employee") {
        found = this.returnFinancialTableDataEmployee.filter(
          (el) => el.id === id
        );
      } else if (selectedType === "server") {
        found = this.returnFinancialTableDataServers.filter(
          (el) => el.id === id
        );
      }

      const exclude = [undefined, null, "undefined", ""];

      if (!exclude.includes(found) && !exclude.includes(found[0])) {
        const parsed = JSON.parse(found[0].allocations) || [];
        // console.warn('Parsed Project Data ', parsed);

        setTimeout(() => {
          for (let index = 0; index < parsed.length; index++) {
            const _identifier = `employee-${id}-${index}-${uuid}`;
            const _element = document.getElementById(_identifier);

            // Extra meseasure for outdated stores arrays which can have more elements than exist.
            if (_element !== null) {
              document.getElementById(
                _identifier
              ).childNodes[2].lastElementChild.value = parsed[index];
            }
          }
        }, 2000);
      }
    },
  },
};
</script>
