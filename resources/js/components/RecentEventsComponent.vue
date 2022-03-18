<template>
  <div>
    <h5 class="font-weight-bolder">Recent Events</h5>
    <section data-placement="parent">

      <section>
        <article v-for="(ev, index) in this.returnActiveCompanyAlerts" :key="index">
          <u><i>{{ returnConvertedDate(ev.created_at) }}</i></u>
          <h6>{{ ev.title }}</h6>
          {{ ev.body }}
          <br>
          <el-button type="text" @click="deleteAlert(ev)" class="text-danger">delete</el-button>
          <hr>
        </article>
      </section>
    </section>

  </div>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";
  import moment from "moment";

  export default {
    name: "RecentEventsComponent",
    data(){
      return {
        companyEvents: [],
        nextPage: {
          url: null,
          empty: false
        },
        prevPage: {
          url: null,
          empty: false
        },
      }
    },
    computed: {
      ...mapGetters(['returnStoredCompanyEvents', 'returnActiveCompanyAlerts'])
    },
    methods: {
      ...mapActions(['requestLatestCompanyEvents', 'requestPaginatedLatestCompanyEvents', 'onDeleteCompanyMessage']),
      deleteAlert(ev) {
        this.onDeleteCompanyMessage(ev);
      },
      returnConvertedDate(timestamp) {
        // new Date(ev.created_at).toDateString()
        // return moment(timestamp).toLocaleString();
        return moment(timestamp).format('MM-DD-YYYY');
      }
    }
  }
</script>

<style scoped>
  [data-placement="parent"] {
    max-height: 20rem;
    overflow-x: hidden;
    overflow-y: scroll;
  }

</style>
