<template>
  <div class="bg-white p-4 fixedHeightScrollable">
    <h6 class="text-primary font-weight-bolder">Accounts & Company Associated
    <small>scroll to see more</small>
    </h6>
    <div class="row" v-for="(user, index) in usersWithAssociations" :key="index">
      <div class="col-6">
        {{ user.name }} <br>
        <b>{{ user.email}}</b>
      </div>
      <div class="col-6">
        <u>
          <b>Assigned to</b>
        </u>
        <p v-for="(assoc, jndex) in user.associations" :key="jndex" >
          {{ assoc.company_name }}
        </p>
      </div>
      <div class="col-12">
        <hr>
      </div>
    </div>
  </div>
</template>

<script>
    import {mapActions} from "vuex";
    import axios from 'axios';

    export default {
    name: "AccountsAndCompanyAssociatedComponent",
    props: {
        env_type: String
    },
    data() {
      return {
        usersWithAssociations: []
      }
    },
    async created() {
      const {data} = await axios.get('api/company/association');

      // Trim 0 -29
      this.usersWithAssociations = data.splice(30);

      // Store in state
      this.onInitialUsersWithAssociations(data)
    },
      methods: {
        ...mapActions(['onInitialUsersWithAssociations'])
      }
  }
</script>

<style lang="scss" scoped>
  .fixedHeightScrollable {
    overflow: scroll;
    max-height: 32rem;
  }
</style>
