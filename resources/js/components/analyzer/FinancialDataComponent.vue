<template>
  <div class="container-fluid">
    <div class="row bg-white p-4">
      <div class="col-12">
        <h5>Financial Data</h5>
        <h6 v-if="this.returnAnalyzerYearEnds.length === 0">
          Please select at least one year under
          <b>Qualifying Questions</b>
        </h6>
      </div>

      <div class="col-12" v-if="this.returnAnalyzerYearEnds.length > 0">
        <el-tabs v-model="activeName" @tab-click="handleClick" type="border-card">
          <el-tab-pane
            v-for="(item, index) in this.returnAnalyzerYearEnds"
            :key="index"
            :label="item.year"
            :name="index.toString()"
          >
            <section>
              <article>
                <h5 class="text-primary">Employees</h5>

                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataEmployee"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name" >
                    <template slot-scope="scope">
                      <!-- <el-input type="input" v-model="scope.row.name" size="small"/> -->
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.name"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.name, 'name')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.title"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.title, 'title')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="amount" label="Amount" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.amount"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.amount, 'amount')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column label="Operations" >
                    <template slot-scope="scope">
                      <!-- Delete -->
                      <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row.id)"
                      >Delete</el-button>
                    </template>
                  </el-table-column>
                </el-table>
              </article>

                          <article>
                <h5 class="text-primary">Supplies</h5>
                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataSupplies"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.name"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.name, 'name')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title" ></el-table-column>
                  <el-table-column prop="amount" label="Amount" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.amount"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.amount, 'amount')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column label="Operations" >
                    <template slot-scope="scope">
                      <!-- Delete -->
                      <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row.id)"
                      >Delete</el-button>
                    </template>
                  </el-table-column>
                </el-table>
              </article>

              <article>
                <h5 class="text-primary">Contractors</h5>
                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataContractors"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.name"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.name, 'name')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title" ></el-table-column>
                  <el-table-column prop="amount" label="Amount" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.amount"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.amount, 'amount')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column label="Operations" >
                    <template slot-scope="scope">
                      <!-- Delete -->
                      <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row.id)"
                      >Delete</el-button>
                    </template>
                  </el-table-column>
                </el-table>
              </article>

              <article>
                <h5 class="text-primary">Servers</h5>
                <el-table
                  class="mb-3"
                  :data="returnFinancialTableDataServers"
                  stripe
                  style="width: 100%"
                >
                  <el-table-column prop="name" label="Name" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.name"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.name, 'name')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="title" label="Title" ></el-table-column>
                  <el-table-column prop="amount" label="Amount" >
                    <template slot-scope="scope">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="basic-addon2"
                          v-model="scope.row.amount"
                        />
                        <div class="input-group-append">
                          <button
                            class="btn btn-outline-secondary"
                            type="button"
                            @click="onUpdateRecord(scope.row.id, scope.row.amount, 'amount')"
                          >
                            <i class="el-icon-edit"></i>
                          </button>
                        </div>
                      </div>
                    </template>
                  </el-table-column>
                  <el-table-column label="Operations" >
                    <template slot-scope="scope">
                      <!-- Delete -->
                      <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row.id)"
                      >Delete</el-button>
                    </template>
                  </el-table-column>
                </el-table>
              </article>

            </section>

            <hr />

            <h5 class="text-primary">Add new entry</h5>

            <el-dropdown @command="handleCommand">
              <span class="el-dropdown-link">
                <b>{{ newEntrySelected || 'Select new entry type' }}</b>
                <i class="el-icon-arrow-down el-icon--right"></i>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item command="employee">New Employee entry</el-dropdown-item>
                <el-dropdown-item command="supplies">New Supplies entry</el-dropdown-item>
                <el-dropdown-item command="contractors">New Contractors entry</el-dropdown-item>
                <el-dropdown-item command="server">New Server entry</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>

            <hr />

            <section v-show="newEntrySelected === 'employee'">
              <h5 class="text-primary">Add New Employees</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th>Employee Name</th>
                    <th>Job Title</th>
                    <th>2018 W-2 Box 1 Wage</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td scope="row">
                      <div class="form-group">
                        <label for>Name</label>
                        <input
                          type="text"
                          v-model="name.value"
                          :class="['form-control', (name.error) ? 'is-invalid' : '']"
                        />
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <label for>Title</label>
                        <input
                          type="text"
                          v-model="title.value"
                          :class="['form-control', (title.error) ? 'is-invalid' : '']"
                        />
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <label for>Amount</label>
                        <input
                          type="text"
                          v-model="amount.value"
                          :class="['form-control', (amount.error) ? 'is-invalid' : '']"
                        />
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </section>

            <section v-show="newEntrySelected === 'supplies'">
              <h6 class="text-primary">Add New Supplies</h6>
              <table class="table">
                <thead>
                  <tr>
                    <th>Account Name</th>
                    <th>Amount</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td scope="row">
                      <input type="text" v-model="name.value"
                      :class="['form-control', (name.error) ? 'is-invalid' : '']"/>
                    </td>
                    <td>
                      <input type="text" v-model="amount.value"
                      :class="['form-control', (amount.error) ? 'is-invalid' : '']"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </section>

            <section v-show="newEntrySelected === 'contractors'">
              <h5 class="text-primary">Add New Contractors</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th>Account Name</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td scope="row">
                      <input type="text" v-model="name.value"
                      :class="['form-control', (name.error) ? 'is-invalid' : '']"/>
                    </td>
                    <td>
                      <input type="text" v-model="amount.value"
                      :class="['form-control', (amount.error) ? 'is-invalid' : '']"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </section>

            <section v-show="newEntrySelected === 'server'">
              <h5 class="text-primary">Add New Server Entry</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th>Account Name</th>
                    <th>Title / Description</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td scope="row">
                      <input type="text" v-model="name.value"
                      :class="['form-control', (name.error) ? 'is-invalid' : '']" />
                    </td>
                    <td>
                      <div class="form-group">
                        <input
                          type="text"
                          v-model="title.value"
                          :class="['form-control', (title.error) ? 'is-invalid' : '']"
                        />
                      </div>
                    </td>
                    <td>
                      <input type="text" v-model="amount.value"
                      :class="['form-control', (amount.error) ? 'is-invalid' : '']"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </section>

            <el-button
              v-if="newEntrySelected"
              type="primary"
              @click="onHandleNewEntry(item, item.id)"
            >Add</el-button>
          </el-tab-pane>
        </el-tabs>

        <hr />
      </div>
    </div>
  </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
  data() {
    return {
      activeName: "first",
      newEntrySelected: "",
      activeTabYear: "",
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
      server: []
    };
  },
  computed: {
    ...mapGetters([
      "returnAnalyzerYearEnds",
      "getSelectedFinancialTableData",
      "returnFinancialTableDataEmployee",
      "returnFinancialTableDataSupplies",
      "returnFinancialTableDataContractors",
      "returnFinancialTableDataServers"
    ]),
  },
  methods: {
    ...mapActions([
      "setNewFinancialDataEntry",
      "setNewFinancialDataEntryYear",
      "onUpdateFinancialDataRecord",
      "onDeleteFinancialDataRecord",
    ]),
    handleClick(tab, event) {
      this.activeTabYear = event.target.innerText || event.explicitOriginalTarget.innerText;
      this.setNewFinancialDataEntryYear(this.activeTabYear);
    },
    handleCommand(command) {
      this.newEntrySelected = command;
    },
    onHandleNewEntry(_item, _itemId) {
      // Send to state based on the selection type

      if (this.validation()) {
        this.setNewFinancialDataEntry({
          id: _itemId,
          _qq_id: _item.id,
          _cid: _item.companyId,
          _selected_type: this.newEntrySelected,
          _year: _item.year,
          name: this.name.value,
          title: this.title.value,
          amount: this.amount.value,
        });

        this.$notify({
          title: "Success",
          message: "New Entry added",
          type: "success",
        });

        this.name.value = this.title.value = this.amount.value = "";

      } else {
        this.$notify({
          title: "Error",
          message: "Check for errors.",
          type: "error",
        });
      }
    },
    validation() {
      let errCount = 0;
      if (this.name.value === "") {
        this.name.error = true;
        errCount++;
      } else this.name.error = false;

      if (this.newEntrySelected === "employee" || this.newEntrySelected === "server") {
        if (this.title.value === "") {
          this.title.error = true;
          errCount++;
        } else this.title.error = false;
      }

      if (this.amount.value === "") {
        this.amount.error = true;
        errCount++;
      } else this.amount.error = false;

      return (errCount === 0) ? true : false;
    },
    handleDelete(index, rowItemId) {
      this.onDeleteFinancialDataRecord(rowItemId);
    },
    onUpdateRecord(itemId, fieldData, fieldType) {
      this.onUpdateFinancialDataRecord({
        id: itemId,
        type: fieldType,
        data: fieldData,
      });
    },
  },
};
</script>

<style scoped>
</style>
