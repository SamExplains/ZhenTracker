<template>
  <div class="bg-white p-4">
    <h6 class="text-primary font-weight-bolder">New User w/ Company</h6>

    <div class="form-group">
      <label for="">Select the Company to assign</label>
      <br>
      <el-dropdown @command="handleCommand">
        <span class="el-dropdown-link">
          Dropdown List<i class="el-icon-arrow-down el-icon--right"></i>
        </span>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item
            v-for="(company, index) in this.returnAllCompanies"
            :command="[company.name, company.id]"
            :key="index">
            {{ company.name }}
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>

    <div class="form-group">
      <label for="">Selected Company</label>
      <el-input disabled :value="assignee.company"/>
    </div>

    <div class="form-group mt-2">
      <label for="">Assign name</label>
      <el-input type="text" v-model="assignee.name" placeholder="Enter a name"/>
    </div>

    <div class="form-group mt-2">
      <label for="">Assign email address</label>
      <el-input type="email" v-model="assignee.email" placeholder="Enter an email address"/>
    </div>

    <div class="form-group mt-2">
      <label for="">Assign password</label>
      <el-input type="password" v-model="assignee.password" placeholder="Enter a password"/>
      <small class="text-primary">This is optional. If no password is assigned, we will use the default 'password'</small>
    </div>

    <el-button type="primary" @click="onCreateUserWithCompanyLink">Create User with Company Link</el-button>

  </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import axios from "axios";

    export default {
        name: "NewUserWithCompanyComponent",
        data(){
            return {
              assignee: {
                  company: '',
                  company_id: '',
                  email: '',
                  password: '',
                  name: ''
              }
            }
        },
        computed: {
            ...mapGetters(['returnAllCompanies'])
        },
        methods: {
            ...mapActions(['onStoreNewUserAndAssociationLink']),
            handleCommand(command) {
                this.assignee.company = command[0];
                this.assignee.company_id = command[1];
            },
            async onCreateUserWithCompanyLink() {
                /*
                * Create & Store User and Association
                * Update State
                * */
                const {data} = await axios.post('api/company/association',
                                                {
                                                    'company': this.assignee.company,
                                                    'company_id': this.assignee.company_id,
                                                    'name': this.assignee.name,
                                                    'password': this.assignee.password,
                                                    'email': this.assignee.email
                                                });

                this.$notify({
                    title: 'Success',
                    message: 'User and Company Link Created',
                    type: 'success'
                });

                // Store in State
                this.onStoreNewUserAndAssociationLink({id: data.id, name:data.name, association: data.association });

                this.assignee.company = this.assignee.name = this.assignee.email = this.assignee.password = '';
            }
        }
    }
</script>

<style scoped>

</style>
