<template>
  <div class="row">
    <div class="col-6">
      <div class="form-group">
        <label for="title">Title</label>
        <el-input
          id="title"
          type="text"
          placeholder="Please input"
          v-model="title.input"
          maxlength="75"
          show-word-limit
        />
      </div>
    </div>
    <div class="col-6">
      <div class="form-group">
        <label for="detail">Date</label>
        <flatpickr
          class="minimalMarginTop"
          timeFormat="m-d-Y"
          v-model="yearEndDate.date"
          id="created_at_nec"
        />
      </div>
    </div>
    <div class="col-12">
      <div class="form-group">
        <label for="detail">Detail</label>
        <el-input
          id="detail"
          type="textarea"
          placeholder="Please input"
          v-model="body.input"
          maxlength="255"
          show-word-limit
        />

        <el-button
          type="primary"
          class="d-block mt-3"
          @click="handleNewCompanyEvent"
        >
          Post New Event
        </el-button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import axios from "axios";
import Flatpickr from "./Calendar/Flatpickr";

export default {
  name: "NewEventComponent",
  components: { Flatpickr },
  data() {
    return {
      title: {
        input: "",
        error: false,
      },
      body: {
        input: "",
        error: false,
      },
      yearEndDate: {
        date: "",
      },
    };
  },
  computed: {
    ...mapGetters(["returnCompanyNameAndEID", "returnCurrentActiveCompany"]),
  },
  methods: {
    ...mapActions(["storeNewSingleCompanyAlert"]),
    async handleNewCompanyEvent() {
      const createdAt = document.getElementById("created_at_nec").value;

      if (this.returnCompanyNameAndEID.length !== 0) {
        // console.log('Async handleNewCompanyEvent');
        await axios
          .post("/api/company/events", {
            company_name: this.returnCompanyNameAndEID[0],
            company_ein: this.returnCompanyNameAndEID[1],
            company_id: this.returnCurrentActiveCompany.id,
            created_at: this.returnRearrangedDate(createdAt),
            title: this.title.input,
            body: this.body.input,
          })
          .then((res) => {
            if (res.data.status === 200) {
              // console.log('Post Success ', res);

              // Push new event to store
              this.storeNewSingleCompanyAlert(res.data.data);

              // Reset inputs
              this.title.input =
                this.body.input =
                document.getElementById("created_at_nec").value =
                  "";

              this.$notify({
                title: "Success",
                message: "Event was stored successfully.",
                type: "success",
              });
            } else {
              this.$notify({
                title: "Error",
                message: "Could not store new event. Try again later.",
                type: "error",
              });
              // console.error(res)
            }
          });
      } else {
        this.$notify({
          title: "Error",
          message: "Select a Company before adding new events",
          type: "error",
        });
      }
      return Promise.resolve();
    },
    returnRearrangedDate(date) {
      const blacklist = ["n/a", null, undefined, "undefined", ""];
      if (!blacklist.includes(date)) {
        let d = date.split("-");
        const arranged = `${d[2]}-${d[0]}-${d[1]}`;
        return d[0].length === 4 ? date : arranged;
      } else {
        return Date.now();
      }
    },
  },
};
</script>

<style scoped>
</style>
